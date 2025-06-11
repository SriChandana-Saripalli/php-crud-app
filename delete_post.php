<?php
include 'navbar.php';
include 'db.php';

$error = $success = "";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $success = "Post deleted successfully.";
    } else {
        $error = "Error deleting post.";
    }
}

$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Delete Posts</title>
    <style>
        body { font-family: 'Poppins', sans-serif; background:rgb(251, 250, 249); padding: 20px; }
        .container { max-width: 800px; margin: 40px auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #f0f0f0; }
        a.delete-btn {
            background: rgb(230, 6, 51);
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        a.delete-btn:hover { background: #b00333; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
<div class="container">
    <h2>Delete Posts</h2>
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>
    <?php if ($success) echo "<p class='success'>$success</p>"; ?>

    <?php if ($result->num_rows == 0): ?>
        <p>No posts found.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr><th>ID</th><th>Title</th><th>Created At</th><th>Action</th></tr>
            </thead>
            <tbody>
                <?php while($post = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $post['id']; ?></td>
                        <td><?php echo htmlspecialchars($post['title']); ?></td>
                        <td><?php echo $post['created_at']; ?></td>
                        <td><a class="delete-btn" href="delete_post.php?id=<?php echo $post['id']; ?>" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
