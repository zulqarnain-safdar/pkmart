# EcomStore - Vue.js + Laravel E-commerce Application

A modern, full-stack e-commerce application built with Vue.js frontend and Laravel backend API.

## Features

### Frontend (Vue.js)
- 🛍️ **Product Catalog** - Browse products with filtering and search
- 🛒 **Shopping Cart** - Add/remove items with quantity management
- 👤 **User Authentication** - Login/Register with JWT
- 💳 **Checkout Process** - Complete order placement
- 📱 **Responsive Design** - Mobile-first approach with Tailwind CSS
- 🎨 **Modern UI** - Clean, professional design

### Backend (Laravel API)
- 🔐 **JWT Authentication** - Secure API authentication
- 📦 **Product Management** - CRUD operations for products
- 🏷️ **Category Management** - Organize products by categories
- 📋 **Order Management** - Process and track orders
- 👥 **User Management** - Customer and admin roles
- 🗄️ **Database** - SQLite for development, easily configurable for production

### Admin Panel
- 📊 **Dashboard** - Overview of sales and orders
- 🛍️ **Product Management** - Add, edit, delete products
- 📋 **Order Management** - View and update order status
- 🏷️ **Category Management** - Manage product categories
- 👥 **User Management** - Customer administration

## Tech Stack

### Frontend
- **Vue.js 3** - Progressive JavaScript framework
- **Vue Router** - Client-side routing
- **Pinia** - State management
- **Axios** - HTTP client for API calls
- **Tailwind CSS** - Utility-first CSS framework
- **Vite** - Build tool and dev server

### Backend
- **Laravel 11** - PHP web framework
- **JWT Auth** - JSON Web Token authentication
- **Eloquent ORM** - Database ORM
- **SQLite** - Database (configurable)

## Installation

### Prerequisites
- PHP 8.1+
- Composer
- Node.js 16+
- npm or yarn

### Backend Setup

1. **Install PHP dependencies**
   ```bash
   composer install
   ```

2. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

4. **Start Laravel server**
   ```bash
   php artisan serve
   ```

### Frontend Setup

1. **Install Node dependencies**
   ```bash
   npm install
   ```

2. **Start development server**
   ```bash
   npm run dev
   ```

3. **Build for production**
   ```bash
   npm run build
   ```

## Default Credentials

### Admin Account
- **Email:** admin@ecomstore.com
- **Password:** password

### Customer Accounts
- **Email:** john@example.com
- **Password:** password
- **Email:** jane@example.com
- **Password:** password

## API Endpoints

### Authentication
- `POST /api/auth/register` - User registration
- `POST /api/auth/login` - User login
- `POST /api/auth/logout` - User logout
- `GET /api/auth/me` - Get current user

### Products
- `GET /api/products` - List products
- `GET /api/products/{id}` - Get product details
- `GET /api/products/featured` - Get featured products
- `POST /api/products` - Create product (Admin)
- `PUT /api/products/{id}` - Update product (Admin)
- `DELETE /api/products/{id}` - Delete product (Admin)

### Categories
- `GET /api/categories` - List categories
- `GET /api/categories/{id}` - Get category details
- `POST /api/categories` - Create category (Admin)
- `PUT /api/categories/{id}` - Update category (Admin)
- `DELETE /api/categories/{id}` - Delete category (Admin)

### Orders
- `GET /api/orders` - List user orders
- `GET /api/orders/{id}` - Get order details
- `POST /api/orders` - Create order
- `GET /api/admin/orders` - List all orders (Admin)
- `PUT /api/orders/{id}/status` - Update order status (Admin)

## Project Structure

```
ecom-app/
├── app/
│   ├── Http/Controllers/Api/     # API Controllers
│   └── Models/                   # Eloquent Models
├── database/
│   ├── migrations/               # Database migrations
│   └── seeders/                  # Database seeders
├── resources/
│   ├── js/
│   │   ├── components/           # Vue components
│   │   ├── views/                # Vue pages
│   │   ├── stores/               # Pinia stores
│   │   └── services/             # API services
│   └── css/                      # Styles
├── routes/
│   └── api.php                   # API routes
└── public/                       # Public assets
```

## Development

### Running the Application

1. **Start Laravel backend:**
   ```bash
   php artisan serve
   ```
   Backend will be available at `http://localhost:8000`

2. **Start Vue.js frontend:**
   ```bash
   npm run dev
   ```
   Frontend will be available at `http://localhost:5173`

### Database Seeding

The application comes with sample data including:
- 6 product categories
- 12 sample products with live images
- Admin and customer user accounts

To reset the database:
```bash
php artisan migrate:fresh --seed
```

## Features in Detail

### Product Management
- Product catalog with categories
- Search and filtering
- Product details with image gallery
- Stock management
- Featured products

### Shopping Cart
- Add/remove products
- Quantity management
- Persistent cart (localStorage)
- Price calculations

### Order Processing
- Checkout process
- Order tracking
- Admin order management
- Status updates

### Admin Panel
- Dashboard with statistics
- Product management
- Order management
- Category management
- User management

## Customization

### Styling
The application uses Tailwind CSS for styling. You can customize the design by:
- Modifying `resources/css/app.css`
- Updating `tailwind.config.js`
- Using Tailwind utility classes in components

### API Configuration
Update the API base URL in `resources/js/services/api.js`:
```javascript
const API_BASE_URL = 'http://localhost:8000/api';
```

## Production Deployment

### Backend
1. Set up a production database (MySQL/PostgreSQL)
2. Update `.env` with production settings
3. Run `php artisan config:cache`
4. Deploy to your server

### Frontend
1. Build the frontend: `npm run build`
2. Serve the built files from your web server
3. Update API URLs for production

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## Support

For support, please open an issue in the GitHub repository.