<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $phone = trim($_POST['phone']);
    $city = trim($_POST['city']);
    $gender = $_POST['gender'];

    // Check password match
    if ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, email, password, phone, city, gender) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $username, $email, $hashedPassword, $phone, $city, $gender);

        if ($stmt->execute()) {
            $success = "User registered successfully. <a href='login.php'>Login now</a>.";
        } else {
            $error = "Error: Username or Email might already exist.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Register</title>
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
        input[type="text"], input[type="password"], input[type="email"], input[type="tel"] {
            width: 90%;
            padding: 12px; margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }
        select {
            width: 95%;
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
        .success { color: green; margin-bottom: 15px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Register</h2>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <?php if (!empty($success)) echo "<p class='success'>$success</p>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required /><br />
        <input type="email" name="email" placeholder="Email Address" required /><br />
        <input type="password" name="password" placeholder="Password" required /><br />
        <input type="password" name="confirm_password" placeholder="Confirm Password" required /><br />
        <input type="tel" name="phone" placeholder="Phone Number" required /><br />
        <input type="text" name="city" placeholder="City" required /><br />
        <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select><br />
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>
</body>
</html>
