<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Error - Email Auth System</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Verification Failed</h2>
            <div class="error-messages">
                <p>❌ Invalid or expired verification link.</p>
                <p>The verification token may have expired or is invalid.</p>
            </div>
            <p class="text-center">
                <a href="<?php echo BASE_URL; ?>/register" class="btn btn-secondary">Register Again</a>
                <a href="<?php echo BASE_URL; ?>/login" class="btn btn-primary">Login</a>
            </p>
        </div>
    </div>
</body>
</html>