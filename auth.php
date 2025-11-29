<?php
require 'db.php';

session_start();

function validatePassword($password) {
    if (strlen($password) < 8) {
        return "Password must be at least 8 characters long.";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        return "Password must contain at least one uppercase letter.";
    }
    if (!preg_match('/[a-z]/', $password)) {
        return "Password must contain at least one lowercase letter.";
    }
    if (!preg_match('/[0-9]/', $password)) {
        return "Password must contain at least one number.";
    }
    if (!preg_match('/[\W_]/', $password)) {
        return "Password must contain at least one special character.";
    }
    return true;
}

function registerUser($username, $email, $password) {
    global $pdo;
    
    $validation = validatePassword($password);
    if ($validation !== true) {
        return $validation;
    }
    
    // Check if user exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) {
        return "Username or email already exists.";
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $email, $hash])) {
        return true;
    }
    return "Registration failed.";
}

function checkLockout($username) {
    global $pdo;
    $ip = $_SERVER['REMOTE_ADDR'];
    
    // Count failed attempts in the last 30 minutes
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM login_attempts WHERE username = ? AND is_success = 0 AND attempt_time > (NOW() - INTERVAL 30 MINUTE)");
    $stmt->execute([$username]);
    $failed_attempts = $stmt->fetchColumn();

    if ($failed_attempts >= 3) {
        return true; // Locked out
    }
    return false;
}

function logAttempt($username, $success) {
    global $pdo;
    $ip = $_SERVER['REMOTE_ADDR'];
    $stmt = $pdo->prepare("INSERT INTO login_attempts (username, ip_address, is_success) VALUES (?, ?, ?)");
    $stmt->execute([$username, $ip, $success ? 1 : 0]);
}

function loginUser($username, $password) {
    global $pdo;

    if (checkLockout($username)) {
        return "Account locked for 30 minutes due to multiple failed attempts.";
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        logAttempt($username, true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        return true;
    } else {
        logAttempt($username, false);
        return "Invalid username or password.";
    }
}
?>
