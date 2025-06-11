<?php
include 'navbar.php'; // session check + navbar
include 'db.php';

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if ($title == "" || $content == "") {
        $error = "Please fill in all fields.";
    } else {
        $stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $content);
        if ($stmt->execute()) {
            $success = "Post created successfully.";
        } else {
            $error = "Error creating post.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Create Post</title>
    <style>
        body { font-family: 'Poppins', sans-serif; background:rgb(246, 247, 248); padding: 20px; }
        .container { max-width: 600px; margin: 40px auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        input, textarea { width: 100%; padding: 12px; margin: 10px 0; border-radius: 8px; border: 1px solid #ccc; font-size: 16px; }
        button { background: rgb(230, 6, 51); color: white; border: none; padding: 12px 25px; border-radius: 8px; cursor: pointer; font-size: 16px; }
        button:hover { background: #b00333; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
<div class="container">
    <h2>Create Post</h2>
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>
    <?php if ($success) echo "<p class='success'>$success</p>"; ?>
    <form method="POST" action="">
        <input type="text" name="title" placeholder="Post Title" required />
        <textarea name="content" rows="5" placeholder="Post Content" required></textarea>
        <button type="submit">Create</button>
    </form>
</div>
</body>
</html>
