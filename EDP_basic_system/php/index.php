<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f0f0f0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        color: #333;
    }

    .login-container {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        width: 100%;
        max-width: 400px;
        text-align: center;
    }

    .login-header {
        margin-bottom: 1.5rem;
    }

    .login-header h1 {
        font-size: 2rem;
        color: #4CAF50;
        margin: 0;
    }

    .login-form {
        display: flex;
        flex-direction: column;
    }

    .form-group {
        margin-bottom: 1rem;
        text-align: left;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
        color: #555;
    }

    .form-group input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 1rem;
        box-sizing: border-box;
    }

    .form-group input:focus {
        border-color: #4CAF50;
        outline: none;
        box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
    }

    .options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .options label {
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: normal;
    }

    .options a {
        color: #4CAF50;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .options a:hover {
        text-decoration: underline;
    }

    .login-btn {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 0.75rem;
        border-radius: 6px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s;
        width: 100%;
    }

    .login-btn:hover {
        background-color: #45a049;
    }

    .signup-link {
        margin-top: 1rem;
        font-size: 0.9rem;
    }

    .signup-link a {
        color: #4CAF50;
        text-decoration: none;
    }

    .signup-link a:hover {
        text-decoration: underline;
    }
</style>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Login</h1>
        </div>
        <form class="login-form" action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="options">
                <label><input type="checkbox" name="remember"> Remember me</label>
                <a href="https://www.youtube.com/watch?v=DN0G0Lbj6os&list=RDDN0G0Lbj6os&start_radio=1">Forgot password?</a>
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
        <div class="signup-link">
            Don't have an account? <a href="http://localhost/Projects/EDP_BASIC_SYSTEM/php/sign_up.php">Sign up</a>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            <?php if (isset($_SESSION['login_status'])): 
                $status = $_SESSION['login_status']; 
                unset($_SESSION['login_status']);
            ?>
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "timeOut": "3000"
                };
                toastr.<?php echo $status['type']; ?>("<?php echo $status['message']; ?>");
            <?php endif; ?>
        });
    </script>
</body>
</html>
