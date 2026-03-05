<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'midterm_email_auth');
define('DB_USER', 'root');
define('DB_PASS', '');

// Email configuration (using PHPMailer)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'imonggmailsir@gmail.com'); // Replace with your Gmail
define('SMTP_PASS', 'imong_passwordpud'); // Replace with your app password
define('FROM_EMAIL', 'imonggmailsir@gmail.com');
define('FROM_NAME', 'Email Auth System');

// Application settings
define('BASE_URL', 'http://localhost/MidtermExam_Email_Auth');
define('OTP_EXPIRY_MINUTES', 5);
?>