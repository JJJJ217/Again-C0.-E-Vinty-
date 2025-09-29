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

## 📋 Features Implemented

### ✅ User Management (F101, F102, F103)
- **User Registration**: Role-based registration (Customer, Staff, Admin)
- **User Authentication**: Secure login/logout with session management
- **Profile Management**: Complete profile editing and account management
- **Password Reset**: Email-based password reset functionality
- **Security Features**: Account lockout, password strength validation, CSRF protection

### 🔧 Core System Features
- **Responsive Design**: Mobile-first responsive layout
- **Role-Based Access Control**: Different interfaces for different user types
- **Security**: Password hashing, input sanitization, SQL injection prevention
- **Session Management**: Secure session handling with timeout
- **Error Handling**: Comprehensive error handling and logging
- **Form Validation**: Client and server-side validation


## 🛠️ Installation & Setup

### Prerequisites
- XAMPP (or similar Apache + MySQL + PHP environment)
- PHP 8.0 or higher
- MySQL 8.0 or higher

### Installation Steps

1. **Clone/Download the project** to your XAMPP htdocs directory:
   ```
   C:\xampp\htdocs\vinty-draft-webpage\
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
- **Email**: admin@evinty.com
- **Password**: admin123

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

## 📊 Database Schema

### Users Table
- `user_id` (Primary Key)
- `name`, `email`, `password`
- `role` (customer, staff, admin)
- `is_active`, `email_verified`
- Timestamps and login tracking

### User Profiles Table
- `profile_id` (Primary Key)
- `user_id` (Foreign Key)
- Address and contact information
- Personal details

### Password Resets Table
- `reset_id` (Primary Key)
- `user_id` (Foreign Key)
- `token`, `expires_at`, `used`

## 🚀 Next Development Phase

### Planned Features (MVP Continuation)
1. **F104 - Product Filtering**: Product catalog with filtering and search
2. **F110 - Shopping Cart**: Add to cart, quantity management
3. **F109 - Shipping & Payment**: Checkout process
4. **Admin Panel**: Product and user management for staff/admin

### Development Roadmap
1. **Phase 2**: Product Management System
2. **Phase 3**: Shopping Cart and Checkout
3. **Phase 4**: Order Management
4. **Phase 5**: Admin Dashboard

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

## 🆘 Support

For technical issues:
1. Check error logs in PHP error log
2. Verify database connection
3. Ensure proper file permissions
4. Check XAMPP service status

---

**Built with ❤️ for vintage lovers**
