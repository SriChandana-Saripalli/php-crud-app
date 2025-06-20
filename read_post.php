<?php
include 'navbar.php';
include 'db.php';

$search = $_GET['search'] ?? "";
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

// Total post count
$sql_count = "SELECT COUNT(*) as total FROM posts WHERE title LIKE '%$search%' OR content LIKE '%$search%'";
$total = $conn->query($sql_count)->fetch_assoc()['total'];
$total_pages = ceil($total / $limit);

// Fetch posts
$sql = "SELECT * FROM posts WHERE title LIKE '%$search%' OR content LIKE '%$search%' ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Read Posts</title>
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: url('flower.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .overlay {
            background-color: rgba(255, 255, 255, 0.6); /* white with slight opacity */
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 850px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        h2 {
            margin-top: 0;
            text-align: center;
        }

        .post {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }

        .post:last-child {
            border-bottom: none;
        }

        .post h3 {
            margin: 0 0 8px 0;
        }

        .post p {
            margin: 0;
            color: #555;
        }

        .post small {
            color: #888;
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

            <?php include 'search_form.php'; ?>

            <?php if ($result->num_rows == 0): ?>
                <p>No posts found.</p>
            <?php else: ?>
                <?php while($post = $result->fetch_assoc()): ?>
                    <div class="post">
                        <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                        <small>Created at: <?php echo $post['created_at']; ?></small>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>

            <div class="pagination">
                <?php include 'pagination.php'; ?>
            </div>
        </div>
    </div>
</body>
</html>
