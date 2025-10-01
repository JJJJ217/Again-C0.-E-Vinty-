# 🛍️ Again&Co - Vintage E-Commerce Platform

A complete PHP/MySQL e-commerce platform for vintage and retro items, featuring user management, product catalogs, shopping cart, checkout system, and comprehensive admin dashboard.

![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)

## 🚀 Project Overview

**Again&Co** is a comprehensive e-commerce platform designed for vintage item sales. The system supports multiple user roles (Customer, Staff, Admin) and provides a complete shopping experience from product browsing to order completion.

### Tech Stack
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Backend**: PHP 8.0+
- **Database**: MySQL 8.0+
- **Local Development**: XAMPP (Apache + MySQL)

## 👥 Team & Feature Assignments
- **Registration & Login**: Jiaming Huang
- **Profile management**: Charlotte Pham
- **Manipulate users**: Jiaming Huang
- **Product filtering**: Thea Ngo
- **Product search**: Thea Ngo
- **Product catalogs**: Charlotte Pham
- **Inventory control**: Baljinnyam Gansukh
- **Order status**: Baljinnyam Gansukh
- **Shipping & Payment**: Michael Sutjiato
- **Shopping cart**: Michael Sutjiato

### 🔧 Core System Features
- **Responsive Design**: Mobile-first responsive layout
- **Role-Based Access Control**: Different interfaces for different user types
- **Security**: Password hashing, input sanitization, SQL injection prevention
- **Session Management**: Secure session handling with timeout
- **Error Handling**: Comprehensive error handling and logging
- **Form Validation**: Client and server-side validation
## 🗂️ Project Structure

```
├── assets/
│   ├── css/
│   │   └── style.css          # Main stylesheet
│   ├── js/
│   │   └── main.js            # Client-side JavaScript
│   └── images/                # Image assets
├── config/
│   ├── config.php             # Application configuration
│   └── database.php           # Database connection class
├── database/
│   └── schema.sql             # Database schema and sample data
├── includes/
│   ├── functions.php          # Utility functions
│   ├── header.php             # Site header template
│   ├── footer.php             # Site footer template
│   ├── init.php               # Application bootstrap
│   └── session.php            # Session management
├── pages/
│   ├── auth/
│   │   ├── login.php          # User login page
│   │   ├── register.php       # User registration page
│   │   ├── logout.php         # Logout handler
│   │   ├── forgot-password.php # Password reset request
│   │   └── reset-password.php  # Password reset completion
│   ├── user/
│   │   └── profile.php        # User profile management
│   └── admin/                 # Admin panel (future implementation)
└── index.php                  # Homepage
```
## 👥 Team Members & Code Responsibilities

### Feature Ownership
- **Registration & Login**: Jiaming Huang (`pages/authentication/`, session management)
- **Profile Management**: Charlotte Pham (`pages/user/profile.php`, user data handling)
- **User Management**: Jiaming Huang (`pages/admin/users/`, `api/admin.php`)
- **Product Filtering & Search**: Thea Ngo (search functionality, filter components)
- **Product Catalogs**: Charlotte Pham (product display, catalog management)
- **Inventory Control**: Baljinnyam Gansukh (stock management, inventory tracking)
- **Order Status**: Baljinnyam Gansukh (order tracking, status updates)
- **Shipping & Payment**: Michael Sutjiato (payment processing, shipping logic)
- **Shopping Cart**: Michael Sutjiato (`user/cart.php`, `api/cart.php`)

### Directory Structure by Responsibility
```
├── pages/authentication/    # Jiaming Huang - User auth system
├── pages/user/profile.php   # Charlotte Pham - Profile management  
├── pages/admin/users/       # Jiaming Huang - User administration
├── pages/admin/products/    # Charlotte Pham & Baljinnyam Gansukh
├── user/cart.php           # Michael Sutjiato - Shopping cart
├── api/cart.php            # Michael Sutjiato - Cart API
├── api/admin.php           # Jiaming Huang - Admin API
└── tests/                  # Individual member tests
    ├── accountManagmentTest      # Jiaming Huang
    ├── profileManagementTest     # Charlotte Pham  
    └── userAuthTest             # Jiaming Huang
```

## 🛠️ Installation & Setup

### Prerequisites
- XAMPP (or similar Apache + MySQL + PHP environment)
- PHP 8.0 or higher
- MySQL 8.0 or higher

### Installation Steps

1. **Download XAMPP:** ```https://www.apachefriends.org/download.html```

1. **Clone/Download the project** and put to your XAMPP htdocs directory:
   ```
   C:\xampp\htdocs\Again-C0.-E-Vinty-
   ```

2. **Start XAMPP Services**:
   - Start Apache
   - Start MySQL

3. **Create Database**:
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database named `evinty_ecommerce`
   - Import the database schema from `database/schema.sql`

4. **Configure Database Connection**:
   - Edit `config/config.php` if needed
   - Default settings work with standard XAMPP installation

5. **Access the Application**:
   - Open browser and navigate to: `http://localhost/vinty-draft-webpage`

## 🧪 Testing

### Demo Accounts
The system includes a default admin account:
- **Email**: admin@evinty.com/admin@mail.com
- **Password**: admin123/Admin123

### Test User Registration
1. Navigate to the registration page
2. Create accounts with different roles (Customer, Staff, Admin)
3. Test login functionality
4. Test password reset functionality

### Feature Testing Checklist
- [ ] User registration with all roles
- [ ] User login and logout
- [ ] Profile management and editing
- [ ] Password reset via email
- [ ] Form validation (client and server-side)
- [ ] Session management and timeout
- [ ] Role-based access control

## 🔐 Security Features

- **Password Security**: BCrypt hashing, strength validation
- **Account Security**: Login attempt limiting, temporary lockouts
- **Session Security**: Secure session management, CSRF tokens
- **Input Validation**: Comprehensive sanitization and validation
- **SQL Injection Prevention**: Prepared statements throughout

## 🔧 Configuration

### Email Settings
Configure email settings in `config/config.php` for password reset functionality:
- Update `SITE_EMAIL` with your email address
- Configure SMTP settings if needed

### Development vs Production
- Disable error reporting in production
- Update database credentials
- Configure proper email settings
- Set appropriate file permissions

## 📝 API Endpoints (Future)

The application is designed to support AJAX functionality:
- `/api/cart.php` - Shopping cart operations
- `/api/search.php` - Product search
- `/api/user.php` - User management

## 🤝 Contributing

1. Follow PSR-12 coding standards for PHP
2. Use meaningful commit messages
3. Test all functionality before committing
4. Update documentation for new features

## 📜 License

This project is developed for educational purposes as part of an e-commerce website assignment.

**Team Members & Responsibilities:**
- **Jiaming Huang**: Registration & Login, User Management
- **Charlotte Pham**: Profile Management, Product Catalogs  
- **Thea Ngo**: Product Filtering & Search
- **Baljinnyam Gansukh**: Inventory Control, Order Status
- **Michael Sutjiato**: Shopping Cart, Shipping & Payment

## 🆘 Support

For technical issues:
1. Check error logs in PHP error log
2. Verify database connection
3. Ensure proper file permissions
4. Check XAMPP service status

---

**Built with ❤️ for vintage lovers by the Again&Co Team**
