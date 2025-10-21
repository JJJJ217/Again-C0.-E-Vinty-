<?php
/**
 * Site Header
 * Navigation and user authentication status
 */

$current_user = getCurrentUser();
?>

<header class="header">
    <div class="container">
        <div class="header-top">
            <a href="/" class="logo">
                Again&Co
            </a>
            
            <div class="user-menu">
                <?php if (isLoggedIn()): ?>
                    <span>Welcome, <?= htmlspecialchars($current_user['name']) ?></span>
                    
                    <?php if (hasRole('admin')): ?>
                        <a href="/pages/admin/dashboard.php">Admin Panel</a>
                    <?php elseif (hasRole('staff')): ?>
                        <a href="/pages/admin/dashboard.php">Staff Panel</a>
                    <?php endif; ?>
                    
                    <a href="/pages/user/profile.php">My Account</a>
                    <a href="/pages/user/orders.php">My Orders</a>
                    <a href="/pages/user/cart.php" class="cart-link">
                        Cart <span class="cart-count"><?= getCartCount() ?></span>
                    </a>
                    <a href="/pages/authentication/logout.php">Logout</a>
                <?php else: ?>
                    <a href="/pages/authentication/login.php">Login</a>
                    <a href="/pages/authentication/registeration.php">Register</a>
                <?php endif; ?>
            </div>
        </div>
        
        <nav class="main-nav">
            <ul class="nav-list">
                <li><a href="/" <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'class="active"' : '' ?>>Home</a></li>
                <li><a href="/pages/products/catalog.php">Products</a></li>
                <li><a href="/pages/products/catalog.php?category=Clothing">Clothing</a></li>
                <li><a href="/pages/products/catalog.php?category=Accessories">Accessories</a></li>
                <li><a href="/pages/products/catalog.php?category=Music">Music</a></li>
                <li><a href="/pages/about.php">About</a></li>
                <li><a href="/pages/contact.php">Contact</a></li>
            </ul>
        </nav>
        
        <!-- Search Bar -->
        <div class="search-container mt-2">
            <form action="/pages/products/catalog.php" method="GET" class="search-form">
                <div class="search-input-group">
                    <input type="text" 
                           name="search" 
                           id="search-input"
                           class="form-control" 
                           placeholder="Search for vintage items..." 
                           value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
            <div id="search-results" class="search-results" style="display: none;"></div>
        </div>
    </div>
</header>
