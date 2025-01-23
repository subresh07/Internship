<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Strength Checker</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">

<?php
function checkPasswordStrength($password) {
    // Initialize variables to track the rule failures
    $errors = [];

    // Rule 1: At least 8 characters long
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    // Rule 2: Contains at least one uppercase letter
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Password must contain at least one uppercase letter.";
    }

    // Rule 3: Contains at least one lowercase letter
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "Password must contain at least one lowercase letter.";
    }

    // Rule 4: Contains at least one digit
    if (!preg_match('/\d/', $password)) {
        $errors[] = "Password must contain at least one digit.";
    }

    // Rule 5: Contains at least one special character
    if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        $errors[] = "Password must contain at least one special character (e.g., !, @, #, $, %, etc.).";
    }

    // Determine the strength of the password
    if (empty($errors)) {
        echo "<div style='background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; border: 1px solid #c3e6cb; margin-top: 20px;'>Password is Strong.</div>";
    } else {
        echo "<div style='background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; border: 1px solid #f5c6cb; margin-top: 20px;'>Password is Moderate or Weak.</div>";
        // Print the errors (rules that the password failed)
        echo "<div style='background-color: #fff3cd; color: #856404; padding: 15px; border-radius: 5px; border: 1px solid #ffeeba; margin-top: 10px;'>";
        echo "Failed Rules:<br>";
        foreach ($errors as $error) {
            echo "- $error<br>";
        }
        echo "</div>";
    }
}
?>

<h1 style="text-align: center; color: #333;">Password Strength Checker</h1>

<!-- Form for User to Input Password -->
<form method="POST" style="max-width: 400px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <label for="password" style="font-size: 14px; margin-right: 10px;">Enter Password:</label>
    <input type="text" name="password" id="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''  ?>" style="width: calc(100% - 20px); padding: 10px; font-size: 14px; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 20px; box-sizing: border-box;" autofocus>
    <input type="submit" value="Check Strength" style="background-color: #4CAF50; color: white; padding: 12px 18px; border: none; border-radius: 5px; font-size: 14px; cursor: pointer; width: 100%;">
</form>

<?php
// Check the password if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['password'])) {
    $password = $_POST['password'];
    checkPasswordStrength($password);
}
?>

</body>
</html>
