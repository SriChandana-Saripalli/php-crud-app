<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
    <style>
        body {
            margin: 0; padding: 0;
            background-color: #FFE99A;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex; justify-content: center; align-items: center;
        }
        .container {
            width: 450px;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            text-align: center;
        }
        h1 { color: #333; margin-bottom: 30px; }
        button {
            margin: 10px;
            padding: 12px 25px;
            background-color: rgb(230, 6, 51);
            color: white; border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover { background-color: #5a54e5; }
        a { text-decoration: none; }
    </style>
</head>
<body>
<div class="container">
    <h1>Welcome to Dashboard</h1>
    <a href="create_post.php"><button>Create Post</button></a>
    <a href="read_posts.php"><button>Read Posts</button></a>
    <a href="update_post.php"><button>Update Post</button></a>
    <a href="delete_post.php"><button>Delete Post</button></a>
    <a href="logout.php"><button>Logout</button></a>
</div>
</body>
</html>
