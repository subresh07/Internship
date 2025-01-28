<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Strength Checker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            font-size: 14px;
            margin-bottom: 10px;
            display: block;
        }
        input[type="text"], input[type="submit"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .message {
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .strong {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .moderate {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .failed-rules {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Password Strength Checker</h1>

        <!-- Password Input Form -->
        <form method="POST">
            <label for="password">Enter Password:</label>
            <input type="text" id="password" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>" autofocus>
            <input type="submit" value="Check Strength">
        </form>

        <?php
        
        function checkPasswordStrength($password) {
            $errors = [];

            // Password rules
            if (strlen($password) < 8) {
                $errors[] = "Password must be at least 8 characters long.";
            }
            if (!preg_match('/[A-Z]/', $password)) {
                $errors[] = "Put at least one uppercase letter.";
            }
            if (!preg_match('/[a-z]/', $password)) {
                $errors[] = "Put least one lowercase letter.";
            }
            if (!preg_match('/\d/', $password)) {
                $errors[] = "Put at least one digit.";
            }
            if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
                $errors[] = "Put at least one special character (e.g., !, @, #, $, %, etc.).";
            }

           
            if (empty($errors)) {
                echo "<div class='message strong'>Password is Strong.</div>";
            } else {
                echo "<div class='message moderate'>Password is  Weak.</div>";
                echo "<div class='failed-rules'><strong>Consider:</strong><br>";
                foreach ($errors as $error) {
                    echo "- $error<br>";
                }
                echo "</div>";
            }
        }

        
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['password'])) {
            $password = $_POST['password'];
            checkPasswordStrength($password);
        }
        ?>
    </div>
</body>
</html>
