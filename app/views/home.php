<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Email Auth System</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/style.css">
</head>
<body>
    <div class="container">
        <div class="dashboard-container">
            <header class="dashboard-header">
                <h1>Welcome to Email Auth System</h1>
                <div class="user-info">
                    <span>Welcome, <strong><?php echo htmlspecialchars($user['fullname']); ?></strong>!</span>
                    <a href="<?php echo BASE_URL; ?>/logout" class="btn btn-danger">Logout</a>
                </div>
            </header>

            <div class="dashboard-content">
                <div class="welcome-card">
                    <h2>🎉 Login Successful!</h2>
                    <p>You have successfully logged in using email authentication with OTP verification.</p>
                    <div class="user-details">
                        <h3>Your Account Details:</h3>
                        <ul>
                            <li><strong>Full Name:</strong> <?php echo htmlspecialchars($user['fullname']); ?></li>
                            <li><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></li>
                            <li><strong>Member Since:</strong> <?php echo date('F j, Y', strtotime($user['created_at'])); ?></li>
                            <li><strong>Status:</strong> <span class="status-verified">Verified ✓</span></li>
                        </ul>
                    </div>
                </div>

                <div class="features-card">
                    <h3>System Features Implemented:</h3>
                    <ul class="features-list">
                        <li>✅ User Registration with Email Validation</li>
                        <li>✅ Email Verification System</li>
                        <li>✅ Secure Password Hashing</li>
                        <li>✅ OTP-based Two-Factor Authentication</li>
                        <li>✅ Session Management</li>
                        <li>✅ MVC Architecture</li>
                        <li>✅ SQL Injection Prevention</li>
                        <li>✅ Input Validation</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>