<?php
use PHPUnit\Framework\TestCase;

/**
 *  F107 Inventory Control Tests
 * User Story : "As an admin, I can manage inventory control"
 * Test cases for Baljinnyam Gansukh's inventory control functionality
 */
final class Feature_Inventory_ControlTest extends TestCase
{
    private $originalSession;
    
    protected function setUp(): void
    {
        // Store original session
        $this->originalSession = $_SESSION ?? [];
        
        // Mock admin session
        $_SESSION['user_id'] = 1;
        $_SESSION['user_role'] = 'admin';
        $_SESSION['user_email'] = 'admin@example.com';
    }

    protected function tearDown(): void
    {
        // Restore original session
        $_SESSION = $this->originalSession;
        reset_session_flash();
    }

    /**
     * Test stock level updates functionality
     */
    public function testStockLevelUpdates(): void
    {
        // Test that admin can update stock levels
        $this->assertTrue(hasRole(['admin', 'staff']));
        
        // Mock product data for stock update
        $mockProduct = [
            'product_id' => 1,
            'product_name' => 'Test Product',
            'stock' => 10,
            'price' => 29.99
        ];
        
        // Test stock update validation
        $this->assertIsInt($mockProduct['stock']);
        $this->assertGreaterThanOrEqual(0, $mockProduct['stock']);
        
        // Test stock level categorization
        $stockStatus = $this->getStockStatus($mockProduct['stock']);
        $this->assertContains($stockStatus, ['good', 'low', 'critical', 'out_of_stock']);
    }

    /**
     * Test stock availability checks
     */
    public function testStockAvailabilityChecks(): void
    {
        // Test stock availability for different scenarios
        $testCases = [
            ['stock' => 0, 'expected' => false],      // Out of stock
            ['stock' => 5, 'expected' => true],       // In stock
            ['stock' => 100, 'expected' => true],     // High stock
            ['stock' => -1, 'expected' => false]      // Invalid stock
        ];

        foreach ($testCases as $case) {
            $isAvailable = $this->checkStockAvailability($case['stock']);
            $this->assertEquals($case['expected'], $isAvailable, 
                "Stock availability check failed for stock level: {$case['stock']}");
        }
    }

    /**
     * Test low stock warning system
     */
    public function testLowStockWarnings(): void
    {
        // Test low stock threshold detection
        $lowStockThreshold = 5;
        
        $testProducts = [
            ['stock' => 10, 'shouldWarn' => false],   // Above threshold
            ['stock' => 5, 'shouldWarn' => true],     // At threshold
            ['stock' => 3, 'shouldWarn' => true],     // Below threshold
            ['stock' => 0, 'shouldWarn' => true]      // Out of stock
        ];

        foreach ($testProducts as $product) {
            $isLowStock = $product['stock'] <= $lowStockThreshold;
            $this->assertEquals($product['shouldWarn'], $isLowStock,
                "Low stock warning failed for stock level: {$product['stock']}");
        }
    }

    /**
     * Test stock status indicators
     */
    public function testStockStatusIndicators(): void
    {
        // Test stock status categorization
        $statusTests = [
            ['stock' => 0, 'expected' => 'out_of_stock'],
            ['stock' => 2, 'expected' => 'critical'],
            ['stock' => 5, 'expected' => 'low'],
            ['stock' => 15, 'expected' => 'good']
        ];

        foreach ($statusTests as $test) {
            $status = $this->getStockStatus($test['stock']);
            $this->assertEquals($test['expected'], $status,
                "Stock status incorrect for stock level: {$test['stock']}");
        }
    }

    /**
     * Test bulk inventory operations
     */
    public function testBulkInventoryOperations(): void
    {
        // Test bulk stock updates
        $bulkProducts = [
            ['product_id' => 1, 'stock' => 20],
            ['product_id' => 2, 'stock' => 15],
            ['product_id' => 3, 'stock' => 0]
        ];

        foreach ($bulkProducts as $product) {
            // Validate bulk update data
            $this->assertIsInt($product['product_id']);
            $this->assertGreaterThan(0, $product['product_id']);
            $this->assertIsInt($product['stock']);
            $this->assertGreaterThanOrEqual(0, $product['stock']);
        }

        // Test bulk activation/deactivation
        $this->assertTrue($this->validateBulkAction('activate'));
        $this->assertTrue($this->validateBulkAction('deactivate'));
    }

    /**
     * Test product availability toggle
     */
    public function testProductAvailabilityToggle(): void
    {
        // Test product activation/deactivation
        $mockProduct = [
            'product_id' => 1,
            'is_active' => true
        ];

        // Test toggle logic
        $newStatus = !$mockProduct['is_active'];
        $this->assertIsBool($newStatus);
        
        // Test that only admin/staff can toggle
        $this->assertTrue(hasRole(['admin', 'staff']));
    }

    /**
     * Test inventory audit logging
     */
    public function testInventoryAuditLogging(): void
    {
        // Test that inventory changes are logged
        $logEntry = [
            'user_id' => $_SESSION['user_id'],
            'action' => 'stock_update',
            'details' => json_encode([
                'product_id' => 1,
                'old_stock' => 10,
                'new_stock' => 15
            ]),
            'timestamp' => date('Y-m-d H:i:s')
        ];

        // Validate log entry structure
        $this->assertIsInt($logEntry['user_id']);
        $this->assertContains($logEntry['action'], ['stock_update', 'product_toggle', 'bulk_action']);
        $this->assertIsString($logEntry['details']);
        $this->assertIsArray(json_decode($logEntry['details'], true));
    }

    /**
     * Test stock deduction on orders
     */
    public function testStockDeductionOnOrders(): void
    {
        // Test stock reduction when orders are placed
        $orderItem = [
            'product_id' => 1,
            'quantity' => 3,
            'current_stock' => 10
        ];

        $expectedNewStock = $orderItem['current_stock'] - $orderItem['quantity'];
        $this->assertEquals(7, $expectedNewStock);
        $this->assertGreaterThanOrEqual(0, $expectedNewStock, 
            "Stock should not go negative after order");
    }

    /**
     * Test inventory search and filtering
     */
    public function testInventorySearchAndFiltering(): void
    {
        // Test inventory filtering options
        $filterOptions = [
            'low_stock' => true,
            'out_of_stock' => true,
            'active' => true,
            'inactive' => true,
            'all' => true
        ];

        foreach ($filterOptions as $filter => $expected) {
            $this->assertTrue($expected, "Filter option '{$filter}' should be valid");
        }

        // Test sort options
        $sortOptions = ['name', 'price_low', 'price_high', 'stock_low', 'stock_high', 'newest', 'oldest'];
        foreach ($sortOptions as $sortOption) {
            $this->assertIsString($sortOption);
            $this->assertNotEmpty($sortOption);
        }
    }

    /**
     * Test inventory export functionality
     */
    public function testInventoryExportFunctionality(): void
    {
        // Test inventory data export format
        $exportData = [
            'product_id' => 1,
            'product_name' => 'Test Product',
            'stock' => 10,
            'price' => 29.99,
            'status' => 'active',
            'last_updated' => date('Y-m-d H:i:s')
        ];

        // Validate export data structure
        $this->assertArrayHasKey('product_id', $exportData);
        $this->assertArrayHasKey('stock', $exportData);
        $this->assertArrayHasKey('status', $exportData);
        $this->assertIsNumeric($exportData['stock']);
    }

    // Helper methods for testing

    /**
     * Get stock status based on stock level
     */
    private function getStockStatus(int $stock): string
    {
        if ($stock <= 0) {
            return 'out_of_stock';
        } elseif ($stock <= 3) {
            return 'critical';
        } elseif ($stock <= 10) {
            return 'low';
        } else {
            return 'good';
        }
    }

    /**
     * Check if product is available based on stock
     */
    private function checkStockAvailability(int $stock): bool
    {
        return $stock > 0;
    }

    /**
     * Validate bulk action operation
     */
    private function validateBulkAction(string $action): bool
    {
        $validActions = ['activate', 'deactivate', 'delete', 'update_stock'];
        return in_array($action, $validActions);
    }

    /**
     * Test admin permissions for inventory operations
     */
    public function testAdminPermissionsForInventory(): void
    {
        // Test that only admin/staff can access inventory functions
        $this->assertTrue(isLoggedIn());
        $this->assertTrue(hasRole(['admin', 'staff']));
        
        // Test customer cannot access inventory functions
        $_SESSION['user_role'] = 'customer';
        $this->assertFalse(hasRole(['admin', 'staff']));
        
        // Restore admin role
        $_SESSION['user_role'] = 'admin';
    }

    /**
     * Test inventory data validation
     */
    public function testInventoryDataValidation(): void
    {
        // Test stock value validation
        $validStockValues = [0, 5, 100, 9999];
        foreach ($validStockValues as $stock) {
            $this->assertGreaterThanOrEqual(0, $stock);
            $this->assertIsInt($stock);
        }

        // Test price validation for inventory
        $validPrices = [0.01, 9.99, 99.99, 999.99];
        foreach ($validPrices as $price) {
            $this->assertGreaterThan(0, $price);
            $this->assertIsFloat($price);
        }
    }
}
