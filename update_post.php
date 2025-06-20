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

// Search and pagination
$search = $_GET['search'] ?? "";
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

$sql_count = "SELECT COUNT(*) as total FROM posts WHERE title LIKE '%$search%' OR content LIKE '%$search%'";
$total = $conn->query($sql_count)->fetch_assoc()['total'];
$total_pages = ceil($total / $limit);

$sql = "SELECT * FROM posts WHERE title LIKE '%$search%' OR content LIKE '%$search%' ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
$posts = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

$edit_id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Posts</title>
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: url('flower.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .overlay {
            background-color: rgba(255, 255, 255, 0.6);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 950px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #eee;
        }

        input, textarea {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            padding: 8px 16px;
            background: rgb(230, 6, 51);
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 6px;
        }

        button:hover {
            background: #b00333;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        .success {
            color: green;
            margin-top: 10px;
        }

        .pagination {
            margin-top: 30px;
            text-align: center;
        }

        .pagination a {
            margin: 0 5px;
            padding: 5px 10px;
            background: rgb(230, 6, 51);
            color: white;
            border-radius: 6px;
            text-decoration: none;
        }

        .pagination a.active {
            background: #333;
        }
    </style>
</head>
<body>
<div class="overlay">
    <div class="container">

        <h2>All Posts</h2>
        <?php if ($error) echo "<p class='error'>$error</p>"; ?>
        <?php if ($success) echo "<p class='success'>$success</p>"; ?>

        <?php include 'search_form.php'; ?>

        <table>
            <tr><th>ID</th><th>Title</th><th>Content</th><th>Action</th></tr>

            <?php foreach ($posts as $post): ?>
                <?php if ($edit_id === intval($post['id'])): ?>
                    <form method="POST" action="">
                        <tr>
                            <td>
                                <?php echo $post['id']; ?>
                                <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                            </td>
                            <td>
                                <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
                            </td>
                            <td>
                                <textarea name="content" rows="2" required><?php echo htmlspecialchars($post['content']); ?></textarea>
                            </td>
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
                        <td>
                            <a href="update_post.php?edit_id=<?php echo $post['id']; ?>&search=<?php echo urlencode($search); ?>&page=<?php echo $page; ?>">
                                <button type="button">Update</button>
                            </a>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>

        <div class="pagination">
            <?php include 'pagination.php'; ?>
        </div>

    </div>
</div>
</body>
</html>
