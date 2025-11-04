<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\EasyPaisaService;
use App\Services\ReferralService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    protected $easyPaisaService;
    protected $referralService;

    public function __construct(EasyPaisaService $easyPaisaService, ReferralService $referralService)
    {
        $this->easyPaisaService = $easyPaisaService;
        $this->referralService = $referralService;
    }

    /**
     * Initiate EasyPaisa payment
     */
    public function initiateEasyPaisaPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $order = Order::findOrFail($request->order_id);
            
            // Check if order belongs to authenticated user
            if ($order->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to order',
                ], 403);
            }

            // Check if order is in pending status
            if ($order->status !== 'pending' || $order->payment_status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Order is not eligible for payment',
                ], 400);
            }

            // Prepare customer data
            $customerData = [
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => $order->phone,
                'address' => $order->shipping_address,
                'city' => 'Karachi', // You might want to extract this from address
            ];

            // Generate payment request
            $paymentData = $this->easyPaisaService->generatePaymentRequest($order, $customerData);
            
            // Update order with transaction ID and payment method
            $order->update([
                'transaction_id' => $paymentData['transactionId'],
                'payment_method' => 'easypaisa'
            ]);
            
            // Log payment request
            $this->easyPaisaService->logPaymentRequest($paymentData);

            // Initiate payment with EasyPaisa API
            $response = $this->easyPaisaService->initiatePayment($paymentData);

            return response()->json([
                'success' => true,
                'message' => 'Payment request generated successfully',
                'data' => [
                    'payment_url' => $response['paymentUrl'] ?? $this->easyPaisaService->getPaymentUrl(),
                    'payment_data' => $paymentData,
                    'order_id' => $order->id,
                    'transaction_id' => $paymentData['transactionId'],
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('EasyPaisa Payment Initiation Error', [
                'order_id' => $request->order_id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to initiate payment: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle EasyPaisa return URL
     */
    public function handleEasyPaisaReturn(Request $request)
    {
        try {
            $responseData = $request->all();
            
            // Log the response
            $this->easyPaisaService->logPaymentResponse($responseData);

            // Verify required fields are present
            $requiredFields = ['orderId', 'status', 'transactionId', 'orderAmount'];
            foreach ($requiredFields as $field) {
                if (!isset($responseData[$field])) {
                    Log::error('EasyPaisa Return Missing Required Field', [
                        'missing_field' => $field,
                        'request_data' => $responseData
                    ]);
                    return redirect('/checkout?error=invalid_payment_response');
                }
            }

            // Verify the response
            if (!$this->easyPaisaService->verifyResponse($responseData)) {
                Log::warning('EasyPaisa Response Verification Failed', $responseData);
                return redirect('/checkout?error=payment_verification_failed');
            }

            $orderId = $responseData['orderId'];
            $order = Order::where('order_number', $orderId)->first();

            if (!$order) {
                Log::error('Order not found for EasyPaisa return', ['order_number' => $orderId]);
                return redirect('/checkout?error=order_not_found');
            }

            // Check response status
            if ($responseData['status'] === 'SUCCESS') {
                // Payment successful
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'processing'
                ]);

                Log::info('EasyPaisa Payment Successful', [
                    'order_id' => $order->id,
                    'transaction_id' => $responseData['transactionId'],
                    'amount' => $responseData['orderAmount']
                ]);

                // Process referral commissions
                try {
                    $this->referralService->processOrderCommissions($order);
                    Log::info('Referral commissions processed for order', ['order_id' => $order->id]);
                } catch (\Exception $e) {
                    Log::error('Failed to process referral commissions', [
                        'order_id' => $order->id,
                        'error' => $e->getMessage()
                    ]);
                }

                return redirect('/order-success/' . $order->id);
            } else {
                // Payment failed
                $order->update([
                    'payment_status' => 'failed'
                ]);

                Log::warning('EasyPaisa Payment Failed', [
                    'order_id' => $order->id,
                    'status' => $responseData['status'],
                    'message' => $responseData['message'] ?? 'Payment failed'
                ]);

                return redirect('/checkout?error=payment_failed&message=' . urlencode($responseData['message'] ?? 'Payment failed'));
            }

        } catch (\Exception $e) {
            Log::error('EasyPaisa Return Handler Error', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return redirect('/checkout?error=payment_processing_error');
        }
    }

    /**
     * Handle EasyPaisa notification URL (IPN)
     */
    public function handleEasyPaisaNotify(Request $request)
    {
        try {
            $responseData = $request->all();
            
            // Log the notification
            Log::info('EasyPaisa IPN Received', $responseData);

            // Verify the response
            if (!$this->easyPaisaService->verifyResponse($responseData)) {
                Log::warning('EasyPaisa IPN Verification Failed', $responseData);
                return response()->json(['status' => 'error', 'message' => 'Verification failed'], 400);
            }

            // Try to find order by order ID first, then by transaction reference
            $orderId = $responseData['orderId'] ?? null;
            $order = null;
            
            if ($orderId) {
                $order = Order::where('order_number', $orderId)->first();
            }
            
            // If not found by order ID, try transaction reference
            if (!$order && isset($responseData['transactionId'])) {
                $order = Order::where('transaction_id', $responseData['transactionId'])->first();
            }

            if (!$order) {
                Log::error('Order not found for EasyPaisa IPN', [
                    'order_id' => $orderId,
                    'transaction_id' => $responseData['transactionId'] ?? null,
                    'response_data' => $responseData
                ]);
                return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
            }

            // Update order based on response
            if ($responseData['status'] === 'SUCCESS') {
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'processing'
                ]);

                // Process referral commissions
                try {
                    $this->referralService->processOrderCommissions($order);
                    Log::info('Referral commissions processed for order via IPN', ['order_id' => $order->id]);
                } catch (\Exception $e) {
                    Log::error('Failed to process referral commissions via IPN', [
                        'order_id' => $order->id,
                        'error' => $e->getMessage()
                    ]);
                }
            } else {
                $order->update([
                    'payment_status' => 'failed'
                ]);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('EasyPaisa IPN Handler Error', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return response()->json(['status' => 'error', 'message' => 'Processing failed'], 500);
        }
    }

    /**
     * Get payment status
     */
    public function getPaymentStatus(Request $request, $orderId)
    {
        try {
            $order = Order::findOrFail($orderId);
            
            // Check if order belongs to authenticated user
            if ($order->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to order',
                ], 403);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'status' => $order->status,
                    'payment_status' => $order->payment_status,
                    'total_amount' => $order->total_amount,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get payment status: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Debug EasyPaisa configuration and test data
     */
    public function debugEasyPaisaConfig(Request $request)
    {
        try {
            // Only allow in development/sandbox environment
            if (config('easypaisa.environment') !== 'sandbox' && !config('app.debug')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Debug endpoint only available in sandbox/debug mode'
                ], 403);
            }

            $testOrder = (object) [
                'id' => 1,
                'total_amount' => 100.00,
                'order_number' => 'TEST-ORDER-001'
            ];

            $testCustomerData = [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'phone' => '+923001234567',
                'address' => 'Test Address',
                'city' => 'Karachi'
            ];

            // Generate test payment data
            $paymentData = $this->easyPaisaService->generatePaymentRequest($testOrder, $testCustomerData);
            
            // Validate payment data
            $validationErrors = $this->easyPaisaService->validatePaymentData($paymentData);
            
            // Test return URL
            $urlAccessible = $this->easyPaisaService->testReturnUrlAccessibility();

            return response()->json([
                'success' => true,
                'debug_info' => [
                    'environment' => config('easypaisa.environment'),
                    'user_id' => config('easypaisa.user_id'),
                    'store_id' => config('easypaisa.store_id'),
                    'payment_url' => $this->easyPaisaService->getPaymentUrl(),
                    'return_url' => config('easypaisa.return_url'),
                    'notify_url' => config('easypaisa.notify_url'),
                    'test_payment_data' => $paymentData,
                    'validation_errors' => $validationErrors,
                    'return_url_accessible' => $urlAccessible,
                    'signature_generation_test' => [
                        'input_data' => array_diff_key($paymentData, ['signature' => '']),
                        'generated_signature' => $paymentData['signature']
                    ]
                ],
                'recommendations' => [
                    'Ensure return URL is publicly accessible (use ngrok for local testing)',
                    'Verify merchant credentials are correct for sandbox environment',
                    'Check that amount is in paisa format (no decimals)',
                    'Ensure timestamp is a valid Unix timestamp',
                    'Verify signature generation uses HMAC-SHA256 with correct parameters'
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('EasyPaisa Debug Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Debug failed: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
