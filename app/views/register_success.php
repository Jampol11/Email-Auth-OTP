<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful - Email Auth System</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Registration Successful!</h2>
            <div class="success-message">
                <p>Thank you for registering! We've sent a verification email to <strong><?php echo htmlspecialchars($email); ?></strong></p>
                <p>Please check your email and click the verification link to activate your account.</p>
                <p><em>Note: Check your spam/junk folder if you don't see the email in your inbox.</em></p>
            </div>
            <p class="text-center">
                <a href="<?php echo BASE_URL; ?>/login" class="btn btn-secondary">Back to Login</a>
            </p>
        </div>
    </div>
</body>
</html>