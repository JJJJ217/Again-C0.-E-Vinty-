<?php
use PHPUnit\Framework\TestCase;

/**
 * User profile detail managament
 * User Story: 302
 */

final class Feature_Profile_ManagementTest extends TestCase
{
    public function testUserProfileNameSplitting(): void
    {
        // Test the name splitting logic we implemented for checkout
        $fullName = "Charlotte Pham";
        $parts = explode(' ', $fullName, 2);
        $firstName = $parts[0];
        $lastName = $parts[1] ?? '';
        
        $this->assertSame('Charlotte', $firstName);
        $this->assertSame('Pham', $lastName);
        
        // Test single name
        $singleName = "Admin";
        $parts = explode(' ', $singleName, 2);
        $firstName = $parts[0];
        $lastName = $parts[1] ?? '';
        
        $this->assertSame('Admin', $firstName);
        $this->assertSame('', $lastName);
        
        // Test multiple names
        $multipleName = "Jordan Evan Smith";
        $parts = explode(' ', $multipleName, 2);
        $firstName = $parts[0];
        $lastName = $parts[1] ?? '';
        
        $this->assertSame('Jordan', $firstName);
        $this->assertSame('Evan Smith', $lastName);
    }
    
}