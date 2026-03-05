<?php
// Start session
session_start();

// Include configuration
require_once 'config/config.php';

// Autoload classes
spl_autoload_register(function ($className) {
    $paths = [
        'core/' . $className . '.php',
        'app/controllers/' . $className . '.php',
        'app/models/' . $className . '.php'
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Simple routing
$request = $_SERVER['REQUEST_URI'];
$basePath = '/MidtermExam_Email_Auth';
$request = str_replace($basePath, '', $request);
$request = explode('?', $request)[0];
$request = trim($request, '/');

// Default route
if (empty($request)) {
    $request = 'login';
}

$authController = new AuthController();

switch ($request) {
    case '':
    case 'login':
        $authController->login();
        break;
    case 'register':
        $authController->register();
        break;
    case 'verify-email':
        $authController->verifyEmail();
        break;
    case 'verify-otp':
        $authController->verifyOTP();
        break;
    case 'home':
        $authController->home();
        break;
    case 'logout':
        $authController->logout();
        break;
    default:
        // 404 - redirect to login
        header("Location: " . BASE_URL . "/login");
        exit();
}
?>