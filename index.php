<?php
    session_start();
    $error = [
        'login' => $_SESSION['login_error'] ?? '',
        'register' => $_SESSION['register_error'] ?? '',
    ];
    $activeForm = $_SESSION['active_form'] ?? 'login-form';

    // Clear the errors from the session so they don't persist on refresh
    unset($_SESSION['login_error']);
    unset($_SESSION['register_error']);

    function showerror($error) {
        // Added the "!" before empty
        return !empty($error) ? "<p class='error-message'> $error </p>" : ''; 
    }
    function isActiveForm($formName, $activeForm) {
        return $formName === $activeForm ? 'active' : '';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="container">
        <div class="form-box <?= isActiveForm('login-form', $activeForm) ?>" id="login-form">            <form action="LoginRegister.php" method="POST">
                <h2>Login</h2>
                <?= showerror($error['login']) ?>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
                <p class="message">Not registered? <a href="#" onclick="showForm('register-form')">Create an account</a></p>
            </form>
        </div>
        <div class="form-box <?= isActiveForm('register-form', $activeForm) ?>" id="register-form">
            <form action="LoginRegister.php" method="POST">
                <h2>Register</h2>
                <?= showerror($error['register']) ?>
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="role" required>
                    <option value="">Select Role</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit" name="register">Register</button>
                <p class="message">Already have an account? <a href="#" onclick="showForm('login-form')">Login here</a></p>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>