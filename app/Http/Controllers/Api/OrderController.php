<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ReferralCode;
use App\Services\ReferralService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    protected $referralService;

    public function __construct(ReferralService $referralService)
    {
        $this->referralService = $referralService;
    }
    public function index()
    {
        $user = Auth::user();
        
        $orders = Order::with('items.product')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

    public function show($id)
    {
        $user = Auth::user();
        
        $order = Order::with('items.product')
            ->where('user_id', $user->id)
            ->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string',
            'billing_address' => 'required|string',
            'phone' => 'required|string',
            'notes' => 'nullable|string',
            'total_amount' => 'required|numeric|min:0',
            'tax_amount' => 'required|numeric|min:0',
            'shipping_amount' => 'required|numeric|min:0',
            'referral_code_used' => 'nullable|string|size:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        
        // Check if user is admin
        if ($user->role === 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Admin users cannot place orders',
            ], 403);
        }

        DB::beginTransaction();

        try {
            $subtotal = 0;
            $orderItems = [];
            $referrerId = null;

            // Process referral code if provided
            if ($request->referral_code_used) {
                $referralCode = ReferralCode::where('code', $request->referral_code_used)
                                           ->where('is_active', true)
                                           ->first();
                
                if ($referralCode && $referralCode->isValid() && $referralCode->user_id !== $user->id) {
                    $referrerId = $referralCode->user_id;
                }
            }

            // Calculate subtotal and validate stock
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                
                if (!$product || $product->stock_quantity < $item['quantity']) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Insufficient stock for product: ' . ($product ? $product->name : 'Unknown'),
                    ], 400);
                }

                $itemTotal = $product->price * $item['quantity'];
                $subtotal += $itemTotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal,
                ];
            }

            // Generate order number
            $orderNumber = 'ORD-' . strtoupper(uniqid());

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => $orderNumber,
                'total_amount' => $request->total_amount,
                'tax_amount' => $request->tax_amount,
                'shipping_amount' => $request->shipping_amount,
                'shipping_address' => $request->shipping_address,
                'billing_address' => $request->billing_address,
                'phone' => $request->phone,
                'notes' => $request->notes,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method ?? 'card',
                'referral_code_used' => $request->referral_code_used,
                'referrer_id' => $referrerId,
            ]);

            // Create order items and update stock
            foreach ($orderItems as $item) {
                $item['order_id'] = $order->id;
                OrderItem::create($item);
                
                // Update product stock
                $product = Product::find($item['product_id']);
                $product->decrement('stock_quantity', $item['quantity']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => $order->load('items.product'),
            ], 201);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Error creating order: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Process commissions when payment is completed
     */
    public function processCommissions(Order $order)
    {
        try {
            $success = $this->referralService->processOrderCommissions($order);
            
            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Commissions processed successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to process commissions'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing commissions: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }

        $order->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully',
            'data' => $order,
        ]);
    }

    public function adminIndex()
    {
        $orders = Order::with(['user', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }
}