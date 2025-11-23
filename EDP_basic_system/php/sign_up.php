<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <title>Sign up</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e8f5e8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }

        .signup-container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        .signup-header {
            margin-bottom: 1.5rem;
        }

        .signup-header h1 {
            font-size: 2.5rem;
            color: #4CAF50;
            margin: 0;
        }

        .signup-form {
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

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #4CAF50;
            outline: none;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 40px;
        }

        .password-wrapper i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #aaa;
            display: none;
        }

        .checkbox-wrap {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .checkbox-wrap input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #4CAF50;
        }

        .signup-btn {
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

        .signup-btn:hover {
            background-color: #45a049;
        }

        .login-link {
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .login-link a {
            color: #4CAF50;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .notification {
            color: #d32f2f;
            font-size: 0.8rem;
            margin-top: 0.25rem;
            display: none;
        }
    </style>
</head>

<body>
    <?php
        require_once "db_functions.php";

        $pdo = connect();

        $fullname = $_POST["fullname"] ?? "";
        $city     = $_POST["city"] ?? "";
        $gender   = $_POST["gender"] ?? "";
        $password = $_POST["password"] ?? "";
        $email    = $_POST["email"] ?? "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (!check_email($pdo, $email)) {
                try {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    insert_input($pdo, $fullname, $city, $gender, $hashed_password, $email);

                    echo "<script>toastr.success('Account successfully created!', 'Success');</script>";
                } catch (PDOException $e) {
                    echo "<script>toastr.error('Failed to create account: " . $e->getMessage() . "', 'Error');</script>";
                }
            } else {
                echo "<script>toastr.error('Email is already in use.', 'Error');</script>";
            }
        }
    ?>

    <div class="signup-container">
        <div class="signup-header">
            <h1>Sign Up</h1>
        </div>
        <form class="signup-form" method="POST" action="#">
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required>
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" id="city" name="city" placeholder="Enter your city" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" name="gender" required>
                    <option value="">Select gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Prefer not to say">Prefer not to say</option>
                </select>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter email address" required>
                <p class="notification" id="email-notification">Must contain e.g @gmail</p>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                    <i class="fa-solid fa-eye icon"></i>
                    <p class="notification pw-notification">Password do not match</p>
                </div>
            </div>
            <div class="form-group">
                <label for="confirm">Confirm Password</label>
                <div class="password-wrapper">
                    <input type="password" id="confirm" placeholder="Re-enter password" required>
                    <i class="fa-solid fa-eye icon"></i>
                    <p class="notification pw-notification">Password do not match</p>
                </div>
            </div>
            <div class="checkbox-wrap">
                <input type="checkbox" id="terms" name="terms" required>
                <span>I agree to the terms & conditions</span>
            </div>
            <button type="submit" class="signup-btn" id="submit-btn" name="submit-btn">Create Account</button>
            <div class="login-link">
                Already have an account? <a href="http://localhost/Projects/EDP_BASIC_SYSTEM/php/">Log in</a>
            </div>
        </form>
    </div>

    <script src="http://localhost/Projects/EDP_BASIC_SYSTEM/js/sign_up.js"></script>
</body>
</html>
