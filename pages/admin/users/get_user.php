<?php
/**
 * Get User Data API
 * Returns user data for edit/view modals
 */

require_once '../../../includes/init.php';

// Require admin access
requireLogin();
requireRole(['admin']);

// Set JSON response header
header('Content-Type: application/json');

try {
    $user_id = $_GET['id'] ?? 0;
    $detailed = $_GET['detailed'] ?? 0;
    
    if (!$user_id) {
        throw new Exception("User ID is required");
    }
    
    // Get user data
    $user = $db->fetch(
        "SELECT user_id, name, email, role, is_active, created_at, last_login 
         FROM users WHERE user_id = ?",
        [$user_id]
    );
    
    if (!$user) {
        throw new Exception("User not found");
    }
    
    $response = ['success' => true, 'user' => $user];
    
    // If detailed view requested, include additional data
    if ($detailed) {
        // Get user profile
        $profile = $db->fetch(
            "SELECT * FROM user_profiles WHERE user_id = ?",
            [$user_id]
        );
        
        // Get user orders
        $orders = $db->fetchAll(
            "SELECT order_id, order_date, total_price, status 
             FROM orders WHERE user_id = ? 
             ORDER BY order_date DESC LIMIT 10",
            [$user_id]
        );
        
        $response['profile'] = $profile ?: [];
        $response['orders'] = $orders ?: [];
    }
    
    echo json_encode($response);
    
} catch (Exception $e) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
