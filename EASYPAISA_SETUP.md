# EasyPaisa Integration Setup

This document explains how to configure EasyPaisa payment gateway integration in your Laravel e-commerce application.

## Environment Variables

Add the following environment variables to your `.env` file:

```env
# EasyPaisa Configuration
EASYPAISA_USER_ID=your_user_id_here
EASYPAISA_PASSWORD=your_password_here
EASYPAISA_STORE_ID=your_store_id_here
EASYPAISA_CURRENCY_CODE=PKR
EASYPAISA_LANGUAGE=EN
EASYPAISA_API_VERSION=1.0
EASYPAISA_ENVIRONMENT=sandbox
EASYPAISA_SANDBOX_URL=https://sandbox-developer.easypaisa.com.pk/
EASYPAISA_PRODUCTION_URL=https://developer.easypaisa.com.pk/
EASYPAISA_RETURN_URL=https://yourdomain.com/api/payments/easypaisa/return
EASYPAISA_NOTIFY_URL=https://yourdomain.com/api/payments/easypaisa/notify
EASYPAISA_EXPIRY_HOURS=24
EASYPAISA_AUTO_REDIRECT=true
EASYPAISA_PRIVATE_KEY=your_private_key_here
EASYPAISA_PUBLIC_KEY=your_public_key_here
```

## Getting EasyPaisa Credentials

1. **Register as a Merchant**: Visit [EasyPaisa Online Payment Gateway](https://easypaisa.com.pk/online-payment-gateway/) and complete the registration process.

2. **Access Sandbox**: Use the [EasyPaisa Sandbox](https://sandbox-developer.easypaisa.com.pk/) for testing your integration.

3. **Get Credentials**: After registration, you'll receive:
   - User ID
   - Password
   - Store ID

4. **Generate RSA Keys**:
   - Use an online RSA key generator to create a 2048-bit key pair
   - Save the generated Public Key and Private Key in separate text files
   - Upload the Public Key to your EasyPaisa merchant portal

## Configuration Steps

1. **Update Environment Variables**: Replace the placeholder values in your `.env` file with your actual EasyPaisa credentials.

2. **Update URLs**: Make sure to update the `EASYPAISA_RETURN_URL` and `EASYPAISA_NOTIFY_URL` to match your actual domain:
   - For development: `http://localhost:8000/api/payments/easypaisa/return`
   - For production: `https://yourdomain.com/api/payments/easypaisa/return`

3. **Test Integration**: Use the sandbox environment first to test your integration before going live.

## Features Implemented

- ✅ EasyPaisa payment initiation
- ✅ Payment return URL handling
- ✅ Payment notification (IPN) handling
- ✅ Signature verification for security
- ✅ Order status updates
- ✅ Referral commission processing
- ✅ Debug endpoint for testing

## API Endpoints

### Payment Initiation
```
POST /api/payments/easypaisa/initiate
```

### Payment Callbacks
```
POST /api/payments/easypaisa/return
POST /api/payments/easypaisa/notify
```

### Debug (Sandbox Only)
```
GET /api/payments/easypaisa/debug
```

## Testing

1. **Sandbox Testing**: Use the debug endpoint to test your configuration:
   ```
   GET /api/payments/easypaisa/debug
   ```

2. **Test Orders**: Create test orders and verify payment flow works correctly.

3. **Signature Verification**: Ensure all payment responses are properly verified.

## Security Notes

- Always verify signatures on payment responses
- Use HTTPS in production
- Keep your private key secure
- Regularly rotate your credentials
- Monitor payment logs for any suspicious activity

## Troubleshooting

1. **Signature Verification Failed**: Check that your private key matches the public key uploaded to EasyPaisa.

2. **Payment Not Processing**: Verify your return and notify URLs are publicly accessible.

3. **Amount Format Issues**: Ensure amounts are in paisa format (no decimals).

4. **Phone Number Format**: Ensure phone numbers are in Pakistani format (92XXXXXXXXXX).

## Support

For technical support, refer to:
- [EasyPaisa Developer Portal](https://developer.easypaisa.com.pk/)
- [EasyPaisa Sandbox Documentation](https://sandbox-developer.easypaisa.com.pk/)
