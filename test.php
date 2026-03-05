<?php
// Test file to verify setup
require_once 'config/config.php';
require_once 'core/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    echo "<h2>✅ Database Connection Successful!</h2>";
    echo "<p>Connected to database: " . DB_NAME . "</p>";

    // Test if tables exist
    $tables = ['users', 'email_verifications', 'otp_codes'];
    foreach ($tables as $table) {
        $stmt = $db->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "<p>✅ Table '$table' exists</p>";
        } else {
            echo "<p>❌ Table '$table' does not exist</p>";
        }
    }

    echo "<h3>Setup Complete!</h3>";
    echo "<p>You can now access the application at: <a href='" . BASE_URL . "'>" . BASE_URL . "</a></p>";

} catch (Exception $e) {
    echo "<h2>❌ Setup Error</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
    echo "<p>Please check your database configuration and ensure the database exists.</p>";
}
?>