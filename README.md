# Email-Based Authentication System

A secure web application implementing email-based authentication with OTP verification using PHP and MySQL with MVC architecture.

## Features

- ✅ User Registration with Email Validation
- ✅ Email Verification System
- ✅ Secure Password Hashing (password_hash)
- ✅ OTP-based Two-Factor Authentication
- ✅ Session Management
- ✅ MVC Architecture
- ✅ SQL Injection Prevention (Prepared Statements)
- ✅ Input Validation
- ✅ OTP Expiration (5 minutes)

## Project Structure

```
MidtermExam_Email_Auth/
├── app/
│   ├── controllers/
│   │   └── AuthController.php
│   ├── models/
│   │   ├── User.php
│   │   └── Email.php
│   └── views/
│       ├── register.php
│       ├── register_success.php
│       ├── login.php
│       ├── otp_verify.php
│       ├── email_verified.php
│       ├── email_verify_error.php
│       └── home.php
├── config/
│   └── config.php
├── core/
│   ├── Controller.php
│   ├── Model.php
│   └── Database.php
├── public/
│   └── style.css
├── vendor/ (created by Composer)
├── database.sql
├── composer.json
├── composer.lock
├── index.php
└── README.md
```

## Setup Instructions

### Prerequisites

- XAMPP (or any web server with PHP 7.4+ and MySQL)
- Composer (PHP dependency manager)

### Installation Steps

1. **Clone or Download the Project**
   ```
   Place the project in: C:\xampp\htdocs\MidtermExam_Email_Auth
   ```

2. **Database Setup**
   - Start XAMPP and ensure MySQL is running
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database named `midterm_email_auth`
   - Import the `database.sql` file from the project root

3. **Email Configuration**
   - Open `config/config.php`
   - Update the email settings with your Gmail credentials:
     ```php
     define('SMTP_USER', 'your-email@gmail.com');
     define('SMTP_PASS', 'your-app-password'); // Use App Password, not regular password
     define('FROM_EMAIL', 'your-email@gmail.com');
     define('FROM_NAME', 'Email Auth System');
     ```

   **Important:** For Gmail, you need to:
   - Enable 2-Factor Authentication on your Google account
   - Generate an App Password: https://support.google.com/accounts/answer/185833
   - Use the App Password in the SMTP_PASS configuration

4. **Install Dependencies**
   ```bash
   cd C:\xampp\htdocs\MidtermExam_Email_Auth
   C:\xampp\php\php.exe composer.phar install
   ```

5. **Access the Application**
   - Start Apache and MySQL in XAMPP
   - Open your browser and go to: http://localhost/MidtermExam_Email_Auth

## Usage

1. **Registration**
   - Visit the registration page
   - Fill in your details (Full Name, Email, Password)
   - Check your email for verification link
   - Click the verification link to activate your account

2. **Login**
   - Enter your email and password
   - Check your email for OTP code
   - Enter the 6-digit OTP code
   - Access the home page upon successful verification

## Security Features

- **Password Hashing**: Uses PHP's `password_hash()` and `password_verify()`
- **SQL Injection Prevention**: All queries use prepared statements with PDO
- **Input Validation**: Server-side validation for all form inputs
- **Session Security**: Proper session management
- **OTP Expiration**: OTP codes expire after 5 minutes
- **Email Verification**: Accounts must be verified before login

## Database Tables

### users
- id (Primary Key)
- fullname
- email (Unique)
- password (Hashed)
- is_verified (0/1)
- created_at

### email_verifications
- id (Primary Key)
- user_id (Foreign Key)
- token (Unique)
- created_at

### otp_codes
- id (Primary Key)
- user_id (Foreign Key)
- otp_code
- expires_at

## Technologies Used

- **Backend**: PHP 7.4+
- **Database**: MySQL
- **Architecture**: MVC (Custom Implementation)
- **Email**: PHPMailer
- **Styling**: CSS3
- **Security**: PDO, Prepared Statements, Password Hashing

## Troubleshooting

### Email Not Sending
- Verify Gmail credentials in `config/config.php`
- Ensure you're using an App Password, not your regular password
- Check spam/junk folder
- Verify SMTP settings

### Database Connection Issues
- Ensure MySQL is running in XAMPP
- Verify database name and credentials in `config/config.php`
- Check if `database.sql` was imported correctly

### 404 Errors
- Ensure Apache rewrite module is enabled
- Check file permissions
- Verify the project is in the correct directory

## License

This project is for educational purposes as part of a midterm examination.
=======
# Email-Auth-OTP