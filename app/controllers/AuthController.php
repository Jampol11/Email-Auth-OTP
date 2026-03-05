<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Email.php';

class AuthController extends Controller {

    private $userModel;
    private $emailModel;

    public function __construct() {
        $this->userModel = new User();
        $this->emailModel = new Email();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = trim($_POST['fullname']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            // Validation
            $errors = [];
            if (empty($fullname)) $errors[] = "Full name is required";
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
            if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters";
            if ($password !== $confirmPassword) $errors[] = "Passwords do not match";

            // Check if email already exists
            if ($this->userModel->findByEmail($email)) {
                $errors[] = "Email already registered";
            }

            if (empty($errors)) {
                // Create user
                if ($this->userModel->create($fullname, $email, $password)) {
                    $user = $this->userModel->findByEmail($email);

                    // Generate verification token
                    $token = bin2hex(random_bytes(32));

                    // Store verification token
                    $this->userModel->createEmailVerification($user['id'], $token);

                    // Send verification email
                    if ($this->emailModel->sendVerificationEmail($email, $fullname, $token)) {
                        $this->loadView('register_success', ['email' => $email]);
                        return;
                    } else {
                        $errors[] = "Failed to send verification email";
                    }
                } else {
                    $errors[] = "Registration failed";
                }
            }

            $this->loadView('register', ['errors' => $errors, 'old' => $_POST]);
        } else {
            $this->loadView('register');
        }
    }

    public function login() {
        if ($this->isLoggedIn()) {
            $this->redirect('/home');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $errors = [];
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Valid email is required";
            }
            if (empty($password)) {
                $errors[] = "Password is required";
            }

            if (empty($errors)) {
                $user = $this->userModel->validateLogin($email, $password);
                if ($user) {
                    // Generate OTP
                    $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

                    // Store OTP
                    $this->userModel->createOTP($user['id'], $otp);

                    // Send OTP email
                    if ($this->emailModel->sendOTPEmail($user['email'], $user['fullname'], $otp)) {
                        $_SESSION['pending_user_id'] = $user['id'];
                        $this->loadView('otp_verify', ['email' => $user['email']]);
                        return;
                    } else {
                        $errors[] = "Failed to send OTP email";
                    }
                } else {
                    $errors[] = "Invalid email or password, or account not verified";
                }
            }

            $this->loadView('login', ['errors' => $errors, 'old' => $_POST]);
        } else {
            $this->loadView('login');
        }
    }

    public function verifyOTP() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $otp = trim($_POST['otp']);

            if (isset($_SESSION['pending_user_id'])) {
                $userId = $_SESSION['pending_user_id'];

                if ($this->userModel->verifyOTP($userId, $otp)) {
                    // Login successful
                    $_SESSION['user_id'] = $userId;
                    unset($_SESSION['pending_user_id']);
                    $this->redirect('/home');
                } else {
                    // Get user email to display in the form
                    $user = $this->userModel->findById($userId);
                    $this->loadView('otp_verify', ['error' => 'Invalid or expired OTP', 'email' => $user['email']]);
                }
            } else {
                $this->redirect('/login');
            }
        } else {
            $this->redirect('/login');
        }
    }

    public function verifyEmail() {
        if (isset($_GET['token'])) {
            $token = $_GET['token'];

            if ($this->userModel->verifyEmail($token)) {
                $this->loadView('email_verified');
            } else {
                $this->loadView('email_verify_error');
            }
        } else {
            $this->redirect('/');
        }
    }

    public function home() {
        $this->requireLogin();

        $user = $this->userModel->findById($_SESSION['user_id']);
        $this->loadView('home', ['user' => $user]);
    }

    public function logout() {
        session_destroy();
        $this->redirect('/login');
    }
}
?>