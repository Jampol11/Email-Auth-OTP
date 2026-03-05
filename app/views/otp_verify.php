<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification - Email Auth System</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>OTP Verification</h2>

            <?php if (isset($error)): ?>
                <div class="error-messages">
                    <p><?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>

            <div class="info-message">
                <p>We've sent a 6-digit OTP code to <strong><?php echo htmlspecialchars($email); ?></strong></p>
                <p>Please enter the code below to complete your login.</p>
                <p><em>The code will expire in <?php echo OTP_EXPIRY_MINUTES; ?> minutes.</em></p>
            </div>

            <form method="POST" action="<?php echo BASE_URL; ?>/verify-otp">
                <div class="form-group">
                    <label for="otp">Enter OTP Code:</label>
                    <input type="text" id="otp" name="otp" required maxlength="6" pattern="[0-9]{6}"
                           placeholder="000000" style="text-align: center; font-size: 24px; letter-spacing: 5px;">
                </div>

                <button type="submit" class="btn btn-primary">Verify OTP</button>
            </form>

            <p class="text-center">
                <a href="<?php echo BASE_URL; ?>/login" class="btn btn-secondary">Back to Login</a>
            </p>
        </div>
    </div>

    <script>
        // Auto-focus the OTP input
        document.getElementById('otp').focus();

        // Allow only numbers in OTP input
        document.getElementById('otp').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>
</html>