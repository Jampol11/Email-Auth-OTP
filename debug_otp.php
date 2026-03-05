<?php
// Debug script to test OTP functionality
require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/Model.php';
require_once __DIR__ . '/app/models/User.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Check database timezone
echo "=== Database Timezone Check ===\n";
$stmt = $db->query("SELECT NOW() as db_time, @@session.time_zone as session_timezone");
$result = $stmt->fetch();
echo "Database Time: " . $result['db_time'] . "\n";
echo "Session Timezone: " . $result['session_timezone'] . "\n";

echo "\n=== PHP Time ===\n";
echo "PHP Time: " . date('Y-m-d H:i:s') . "\n";

// Test OTP creation and verification
echo "\n=== OTP Test ===\n";
$userModel = new User();

// Find a test user (you'll need to have a user in the database)
$stmt = $db->query("SELECT id, email FROM users LIMIT 1");
$testUser = $stmt->fetch();

if ($testUser) {
    echo "Testing with user: " . $testUser['email'] . " (ID: " . $testUser['id'] . ")\n";
    
    // Create a test OTP
    $testOTP = '123456';
    echo "Creating test OTP: $testOTP\n";
    
    if ($userModel->createOTP($testUser['id'], $testOTP)) {
        echo "OTP created successfully\n";
        
        // Check what's in the database
        $stmt = $db->prepare("SELECT * FROM otp_codes WHERE user_id = ?");
        $stmt->execute([$testUser['id']]);
        $otpRecord = $stmt->fetch();
        
        if ($otpRecord) {
            echo "OTP in database:\n";
            echo "- Code: " . $otpRecord['otp_code'] . "\n";
            echo "- Expires: " . $otpRecord['expires_at'] . "\n";
            echo "- Created: " . $otpRecord['created_at'] . "\n";
            
            // Test verification
            echo "\nTesting verification...\n";
            if ($userModel->verifyOTP($testUser['id'], $testOTP)) {
                echo "✓ OTP verification SUCCESS\n";
            } else {
                echo "✗ OTP verification FAILED\n";
            }
        } else {
            echo "No OTP found in database after creation!\n";
        }
    } else {
        echo "Failed to create OTP\n";
    }
} else {
    echo "No users found in database. Please create a user first.\n";
}

// Clean up any test OTPs
$stmt = $db->prepare("DELETE FROM otp_codes WHERE otp_code = '123456'");
$stmt->execute();
echo "\nTest cleanup completed.\n";
?>
