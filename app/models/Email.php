<?php
require_once __DIR__ . '/../../core/Model.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email extends Model {

    private function getMailer() {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = SMTP_PORT;

        $mail->setFrom(FROM_EMAIL, FROM_NAME);

        return $mail;
    }

    public function sendVerificationEmail($email, $fullname, $token) {
        try {
            $mail = $this->getMailer();
            $mail->addAddress($email, $fullname);

            $mail->isHTML(true);
            $mail->Subject = 'Email Verification - Email Auth System';
            $verificationLink = BASE_URL . '/verify-email?token=' . $token;

            $mail->Body = "
                <h2>Welcome to Email Auth System, {$fullname}!</h2>
                <p>Please click the link below to verify your email address:</p>
                <a href='{$verificationLink}' style='background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Verify Email</a>
                <p>If the button doesn't work, copy and paste this link into your browser:</p>
                <p>{$verificationLink}</p>
                <p>This link will expire in 24 hours.</p>
            ";

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function sendOTPEmail($email, $fullname, $otp) {
        try {
            $mail = $this->getMailer();
            $mail->addAddress($email, $fullname);

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code - Email Auth System';

            $mail->Body = "
                <h2>Hello {$fullname}!</h2>
                <p>Your OTP code for login is:</p>
                <h1 style='color: #4CAF50; font-size: 32px; letter-spacing: 5px;'>{$otp}</h1>
                <p>This code will expire in " . OTP_EXPIRY_MINUTES . " minutes.</p>
                <p>If you didn't request this code, please ignore this email.</p>
            ";

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>