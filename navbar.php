<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!-- Navbar HTML -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
<style>
    body {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background: url('flower.jpg') no-repeat center center fixed;
        background-size: cover;
    }

    .navbar-wrapper {
        background-color: rgba(255, 255, 255, 0.85); /* Match overlay look */
        padding: 15px 20px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        border-bottom: 1px solid #ccc;
    }

    .navbar {
        display: flex;
        justify-content: center;
        gap: 20px;
    }

    .navbar a {
        text-decoration: none;
        color: white;
        background-color: rgb(230, 6, 51);
        padding: 10px 20px;
        border-radius: 8px;
        transition: background-color 0.3s ease;
        font-weight: 500;
    }

    .navbar a:hover {
        background-color: #b00333;
    }
</style>

<div class="navbar-wrapper">
    <div class="navbar">
        <a href="create_post.php">Create</a>
        <a href="read_post.php">Read</a>
        <a href="update_post.php">Update</a>
        <a href="delete_post.php">Delete</a>
        <a href="logout.php">Logout</a>
    </div>
</div>
