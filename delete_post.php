<?php
include 'navbar.php';
include 'db.php';

$error = $success = "";

// Deletion logic
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

// Pagination + search
$search = $_GET['search'] ?? "";
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

$count_sql = "SELECT COUNT(*) as total FROM posts WHERE title LIKE '%$search%' OR content LIKE '%$search%'";
$total = $conn->query($count_sql)->fetch_assoc()['total'];
$total_pages = ceil($total / $limit);

$sql = "SELECT * FROM posts WHERE title LIKE '%$search%' OR content LIKE '%$search%' ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Delete Posts</title>
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
            text-align: center;
            margin-top: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
        a.delete-btn {
            background: rgb(230, 6, 51);
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
        }
        a.delete-btn:hover {
            background: #b00333;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
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
        <h2>Delete Posts</h2>

        <?php if ($error) echo "<p class='error'>$error</p>"; ?>
        <?php if ($success) echo "<p class='success'>$success</p>"; ?>

        <?php include 'search_form.php'; ?>

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
                            <td>
                                <a class="delete-btn" href="delete_post.php?id=<?php echo $post['id']; ?>&search=<?php echo urlencode($search); ?>&page=<?php echo $page; ?>" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <div class="pagination">
            <?php include 'pagination.php'; ?>
        </div>
    </div>
</div>
</body>
</html>
