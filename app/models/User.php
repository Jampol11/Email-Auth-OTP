<?php
require_once __DIR__ . '/../../core/Model.php';

class User extends Model {

    public function create($fullname, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$fullname, $email, $hashedPassword]);
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function verifyEmail($token) {
        $stmt = $this->db->prepare("SELECT user_id FROM email_verifications WHERE token = ?");
        $stmt->execute([$token]);
        $result = $stmt->fetch();

        if ($result) {
            // Update user as verified
            $stmt = $this->db->prepare("UPDATE users SET is_verified = 1 WHERE id = ?");
            $stmt->execute([$result['user_id']]);

            // Delete the verification token
            $stmt = $this->db->prepare("DELETE FROM email_verifications WHERE token = ?");
            $stmt->execute([$token]);

            return true;
        }
        return false;
    }

    public function createEmailVerification($userId, $token) {
        $stmt = $this->db->prepare("INSERT INTO email_verifications (user_id, token) VALUES (?, ?)");
        return $stmt->execute([$userId, $token]);
    }

    public function createOTP($userId, $otp) {
        // Delete any existing OTP for this user
        $stmt = $this->db->prepare("DELETE FROM otp_codes WHERE user_id = ?");
        $stmt->execute([$userId]);

        // Use database's own timestamp function to avoid timezone issues
        $stmt = $this->db->prepare("INSERT INTO otp_codes (user_id, otp_code, expires_at) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL " . OTP_EXPIRY_MINUTES . " MINUTE))");
        $result = $stmt->execute([$userId, $otp]);
        
        // Debug: Log what was actually stored
        $stmt = $this->db->prepare("SELECT * FROM otp_codes WHERE user_id = ? ORDER BY id DESC LIMIT 1");
        $stmt->execute([$userId]);
        $storedOTP = $stmt->fetch();
        
        error_log("Creating OTP - User ID: $userId, OTP: $otp");
        if ($storedOTP) {
            error_log("OTP Stored - Code: {$storedOTP['otp_code']}, Expires: {$storedOTP['expires_at']}, DB NOW: " . date('Y-m-d H:i:s'));
        }
        
        return $result;
    }

    public function verifyOTP($userId, $otp) {
        // Debug: Log the verification attempt
        error_log("OTP Verification - User ID: $userId, OTP: $otp");
        
        $stmt = $this->db->prepare("SELECT * FROM otp_codes WHERE user_id = ? AND otp_code = ? AND expires_at > NOW()");
        $stmt->execute([$userId, $otp]);
        $result = $stmt->fetch();
        
        // Debug: Log the query result
        error_log("OTP Query Result: " . ($result ? "Found OTP" : "No matching OTP found"));
        if ($result) {
            error_log("OTP Details - ID: {$result['id']}, Code: {$result['otp_code']}, Expires: {$result['expires_at']}, Current: " . date('Y-m-d H:i:s'));
        }

        if ($result) {
            // Delete the OTP after successful verification
            $stmt = $this->db->prepare("DELETE FROM otp_codes WHERE id = ?");
            $stmt->execute([$result['id']]);
            return true;
        }
        return false;
    }

    public function validateLogin($email, $password) {
        $user = $this->findByEmail($email);
        if ($user && password_verify($password, $user['password']) && $user['is_verified'] == 1) {
            return $user;
        }
        return false;
    }
}
?>