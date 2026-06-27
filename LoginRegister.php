<?php
session_start();
require_once 'config.php';

// --- REGISTER LOGIC ---
if(isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $checkEmail = $conn->query("SELECT email FROM users WHERE email = '$email'");
    if($checkEmail->num_rows > 0) {
        $_SESSION["register_error"] = "Email already registered!";
        $_SESSION["active_form"] = "register-form";
    } else {
        $conn->query("INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')");
        // Automatically switch back to login form after successful registration
        $_SESSION["active_form"] = "login-form"; 
    }
    header("Location: index.php");
    exit();
}

// --- LOGIN LOGIC ---
if(isset($_POST["login"])) {
    $email = $conn->real_escape_string($_POST["email"]);
    $password = $_POST["password"];

    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
    
    if($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify the hashed password
        if(password_verify($password, $user["password"])) {
            $_SESSION["name"] = $user["name"];
            $_SESSION["email"] = $user["email"];
            
            // Redirect based on role
            if($user["role"] == "admin") {
                header("Location: admin_page.php");
            } else {
                header("Location: user_page.php");
            }
            exit();
        }
    }
    
    // If the email isn't found OR the password doesn't match:
    $_SESSION["login_error"] = "Incorrect email or password!";
    $_SESSION["active_form"] = "login-form";
    header("Location: index.php");
    exit();
}
?>