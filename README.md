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
- **Cloud Deployment**: Microsoft Azure (App Service, MySQL Database)

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

## 🗂️ Project Structure

```
Again-C0.-E-Vinty-/
├── api/                       # API endpoints (cart, admin operations)
├── assets/                    # Frontend assets
│   ├── css/style.css         # Main stylesheet
│   └── js/main.js            # Client-side JavaScript
├── config/                    # Application configuration
│   ├── config.php            # App settings & DB config
│   └── database.php          # Database connection
├── database/                  # Database
│   └── schema.sql            # Schema & sample data
├── includes/                  # Shared components
│   ├── init.php              # Bootstrap
│   ├── session.php           # Session management
│   ├── functions.php         # Utility functions
│   ├── header.php            # Header template
│   └── footer.php            # Footer template
├── pages/                     # Page routes
│   ├── authentication/       # Login, register, password reset
│   ├── products/             # Catalog, search, detail
│   ├── user/                 # Profile, orders, cart
│   ├── checkout/             # Checkout & payment
│   ├── admin/                # Admin dashboard & management
│   ├── about.php             # About page
│   └── contact.php           # Contact page
├── tests/                     # Unit & feature tests
├── logs/                      # Application logs
├── index.php                  # Entry point
└── router.php                 # URL routing logic
```
## 👥 Team Members & Code Responsibilities

### Feature Ownership
| Feature | Owner | Location |
|---------|-------|----------|
| Registration & Login | Jiaming Huang | `pages/authentication/` |
| Profile Management | Charlotte Pham | `pages/user/` |
| User Management | Jiaming Huang | `pages/admin/users/` |
| Product Catalog | Charlotte Pham | `pages/products/` |
| Search & Filtering | Thea Ngo | `pages/products/` |
| Shopping Cart | Michael Sutjiato | `pages/checkout/` |
| Checkout & Payment | Michael Sutjiato | `pages/checkout/` |
| Inventory Control | Baljinnyam Gansukh | `pages/admin/products/` |
| Order Management | Baljinnyam Gansukh | `pages/admin/orders/` |

## 🔧 Configuration and Installation Steps

1. **Download XAMPP:** ```https://www.apachefriends.org/download.html```

2. **Clone/Download the project** and put to your XAMPP htdocs directory:
   ```
   C:\xampp\htdocs\Again-C0.-E-Vinty-
   ```

3. **Start XAMPP Services**:
   - Start Apache
   - Start MySQL

4. **Configure Database Connection**:
   - Copy `config.sample.php` → `config.php` in the `config/` folder
   - Copy `database.sample.php` → `database.php` in the `config/` folder
   - Default settings (for local development):
     - Host: `127.0.0.1` | User: `root` | Password: `` (empty) | Database: `evinty_ecommerce` | Port: `3306`

5. **Create Database**:
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Create database: `evinty_ecommerce`
   - Import `database/schema.sql` to load tables and sample data

6. **Access the Application**:
   - Open browser and navigate to: `http://localhost/Again-C0.-E-Vinty-`

7. **PHP Development Server (Alternative access to the web)**:
   - Navigate to project directory: `cd /path/to/Again-C0.-E-Vinty-`
   - Start server: `php -S localhost:8000`
   - Access website: `http://localhost:8000`
   - Stop server: `Ctrl + C`
   - if database connection failed: check the port is on `3306`

## 🧪 Testing

### Demo Accounts
| Role | Email | Password |
|------|-------|----------|
| Admin | admin@evinty.com | admin123 |
| Admin | admin@mail.com | Admin123 |

### Test Cases
- [ ] User registration with different roles
- [ ] Login & logout functionality
- [ ] Profile management and editing
- [ ] Password reset functionality
- [ ] Form validation (client & server-side)
- [ ] Product search & filtering
- [ ] Shopping cart operations
- [ ] Checkout & payment flow
- [ ] Admin dashboard access & operations
- [ ] Session management & timeout

## 🔐 Security Features

- **Password Security**: BCrypt hashing, strength validation
- **Account Security**: Login attempt limiting, temporary lockouts
- **Session Security**: Secure session management, CSRF tokens
- **Input Validation**: Comprehensive sanitization and validation
- **SQL Injection Prevention**: Prepared statements throughout

### 🔧 Core System Features
- **Role-Based Access Control**: Different interfaces for different user types
- **Security**: Password hashing, input sanitization, SQL injection prevention
- **Session Management**: Secure session handling with timeout
- **Error Handling**: Comprehensive error handling and logging
- **Form Validation**: Client and server-side validation

## 🤝 Contributing

1. Follow PSR-12 coding standards for PHP
2. Use meaningful commit messages
3. Test all functionality before committing
4. Update documentation for new features

## 📜 License

This project is developed for educational purposes as part of an e-commerce website assignment.

## 🆘 Support

For technical issues:
1. Check error logs in PHP error log
2. Verify database connection
3. Ensure proper file permissions
4. Check XAMPP service status

---

**Built with ❤️ for vintage lovers by the Again&Co Team.**
