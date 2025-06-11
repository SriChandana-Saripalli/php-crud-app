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
    .navbar {
        background-color:#FBE4D6;
        padding: 15px;
        display: flex;
        justify-content: center;
        gap: 20px;
        font-family: 'Poppins', sans-serif;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .navbar a {
        text-decoration: none;
        color: white;
        background-color: rgb(230, 6, 51);
        padding: 10px 20px;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }

    .navbar a:hover {
        background-color:rgb(230, 6, 51);
    }
</style>

<div class="navbar">
    <a href="create_post.php">Create</a>
    <a href="read_post.php">Read</a>
    <a href="update_post.php">Update</a>
    <a href="delete_post.php">Delete</a>
    <a href="logout.php">Logout</a>
</div>
