import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import Products from '../views/Products.vue';
import ProductDetail from '../views/ProductDetail.vue';
import Cart from '../views/Cart.vue';
import Checkout from '../views/Checkout.vue';
import Login from '../views/auth/Login.vue';
import Register from '../views/auth/Register.vue';
import AdminDashboard from '../views/admin/Dashboard.vue';
import AdminProducts from '../views/admin/Products.vue';
import AdminOrders from '../views/admin/Orders.vue';
import AdminCategories from '../views/admin/Categories.vue';
import AdminReferrals from '../views/admin/Referrals.vue';
import AdminCommissions from '../views/admin/Commissions.vue';
import CustomerDashboard from '../views/CustomerDashboard.vue';
import CustomerOrders from '../views/CustomerOrders.vue';
import OrderSuccess from '../views/OrderSuccess.vue';
import About from '../views/About.vue';
import Contact from '../views/Contact.vue';
import Categories from '../views/Categories.vue';

const routes = [
  // Public routes
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/products',
    name: 'Products',
    component: Products
  },
  {
    path: '/product/:id',
    name: 'ProductDetail',
    component: ProductDetail,
    props: true
  },
  {
    path: '/categories',
    name: 'Categories',
    component: Categories
  },
  {
    path: '/about',
    name: 'About',
    component: About
  },
  {
    path: '/contact',
    name: 'Contact',
    component: Contact
  },
  {
    path: '/cart',
    name: 'Cart',
    component: Cart
  },
  {
    path: '/checkout',
    name: 'Checkout',
    component: Checkout
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/register',
    name: 'Register',
    component: Register
  },
  // Admin routes
  {
    path: '/admin',
    name: 'AdminDashboard',
    component: AdminDashboard,
    meta: { requiresAuth: true, requiresAdmin: true }
  },
  {
    path: '/admin/products',
    name: 'AdminProducts',
    component: AdminProducts,
    meta: { requiresAuth: true, requiresAdmin: true }
  },
  {
    path: '/admin/orders',
    name: 'AdminOrders',
    component: AdminOrders,
    meta: { requiresAuth: true, requiresAdmin: true }
  },
  {
    path: '/admin/categories',
    name: 'AdminCategories',
    component: AdminCategories,
    meta: { requiresAuth: true, requiresAdmin: true }
  },
  {
    path: '/admin/referrals',
    name: 'AdminReferrals',
    component: AdminReferrals,
    meta: { requiresAuth: true, requiresAdmin: true }
  },
  {
    path: '/admin/commissions',
    name: 'AdminCommissions',
    component: AdminCommissions,
    meta: { requiresAuth: true, requiresAdmin: true }
  },
  // Customer routes
  {
    path: '/dashboard',
    name: 'CustomerDashboard',
    component: CustomerDashboard,
    meta: { requiresAuth: true, requiresCustomer: true }
  },
  {
    path: '/referrals',
    name: 'ReferralDashboard',
    component: () => import('../views/ReferralDashboard.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/orders',
    name: 'CustomerOrders',
    component: CustomerOrders,
    meta: { requiresAuth: true, requiresCustomer: true }
  },
  {
    path: '/order-success/:id',
    name: 'OrderSuccess',
    component: OrderSuccess,
    meta: { requiresAuth: true, requiresCustomer: true }
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

// Navigation guards
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token');
  const user = JSON.parse(localStorage.getItem('user') || '{}');
  
  // Redirect admin users to admin panel if they try to access customer routes
  if (token && user.role === 'admin' && to.path !== '/admin' && !to.path.startsWith('/admin/')) {
    // Allow access to public routes
    if (to.path === '/' || to.path === '/products' || to.path.startsWith('/product/') || 
        to.path === '/about' || to.path === '/contact' || to.path === '/categories') {
      next();
    } else {
      next('/admin');
    }
    return;
  }
  
  if (to.meta.requiresAuth && !token) {
    next('/login');
  } else if (to.meta.requiresAdmin && user.role !== 'admin') {
    next('/');
  } else if (to.meta.requiresCustomer && user.role !== 'customer' && user.role !== 'admin') {
    next('/');
  } else {
    next();
  }
});

export default router;
