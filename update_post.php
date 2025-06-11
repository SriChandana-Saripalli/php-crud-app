<?php
include 'navbar.php';
include 'db.php';

$error = $success = "";

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if ($title == "" || $content == "") {
        $error = "Please fill all fields.";
    } else {
        $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        $stmt->bind_param("ssi", $title, $content, $id);
        if ($stmt->execute()) {
            $success = "Post updated successfully.";
        } else {
            $error = "Error updating post.";
        }
    }
}

// Fetch posts
$posts = [];
$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}

// Edit mode
$edit_id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Posts</title>
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f9f9f9; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #eee; }
        input, textarea { width: 100%; padding: 8px; font-size: 14px; }
        button { padding: 8px 16px; background: rgb(230, 6, 51); color: white; border: none; cursor: pointer; border-radius: 6px; }
        button:hover { background: #b00333; }
        .error { color: red; margin-top: 10px; }
        .success { color: green; margin-top: 10px; }
    </style>
</head>
<body>

<h2>All Posts</h2>

<?php if ($error) echo "<p class='error'>$error</p>"; ?>
<?php if ($success) echo "<p class='success'>$success</p>"; ?>

<table>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Content</th>
        <th>Action</th>
    </tr>

    <?php foreach ($posts as $post): ?>
        <?php if ($edit_id === intval($post['id'])): ?>
            <form method="POST" action="">
                <tr>
                    <td><?php echo $post['id']; ?>
                        <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                    </td>
                    <td><input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required></td>
                    <td><textarea name="content" rows="2" required><?php echo htmlspecialchars($post['content']); ?></textarea></td>
                    <td>
                        <button type="submit" name="update">Save</button>
                        <a href="update_post.php"><button type="button">Cancel</button></a>
                    </td>
                </tr>
            </form>
        <?php else: ?>
            <tr>
                <td><?php echo $post['id']; ?></td>
                <td><?php echo htmlspecialchars($post['title']); ?></td>
                <td><?php echo htmlspecialchars($post['content']); ?></td>
                <td><a href="update_post.php?edit_id=<?php echo $post['id']; ?>"><button type="button">Update</button></a></td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
</table>

</body>
</html>
