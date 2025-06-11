<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = trim($_POST['username_or_email']);
    $password = $_POST['password'];

    // Allow login via either username or email
    $stmt = $conn->prepare("SELECT id, username, email, password, phone, city, gender FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $input, $input);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['phone'] = $user['phone'];
        $_SESSION['city'] = $user['city'];
        $_SESSION['gender'] = $user['gender'];

        header("Location: navbar.php");
        exit();
    } else {
        $error = "Invalid username/email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
    <style>
        body {
            margin: 0; padding: 0;
            background-color:#FBE4D6;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex; justify-content: center; align-items: center;
        }
        .container {
            width: 400px;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            text-align: center;
        }
        h2 { color: #333; margin-bottom: 25px; }
        input[type="text"], input[type="password"] {
            width: 90%;
            padding: 12px; margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }
        button {
            padding: 12px 25px;
            background-color: rgb(230, 6, 51);
            color: white; border: none; border-radius: 8px;
            cursor: pointer; font-size: 16px;
        }
        p { margin-top: 15px; font-size: 14px; }
        a { color: #6c63ff; text-decoration: none; font-weight: 500; }
        .error { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="username_or_email" placeholder="Username or Email" required /><br />
        <input type="password" name="password" placeholder="Password" required /><br />
        <button type="submit">Login</button>
    </form>
    <p>Not registered? <a href="register.php">Register here</a></p>
</div>
</body>
</html>
