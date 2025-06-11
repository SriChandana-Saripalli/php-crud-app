<?php
include 'navbar.php'; 
include 'db.php';

$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Read Posts</title>
    <style>
        body { font-family: 'Poppins', sans-serif; background:rgb(249, 248, 247); padding: 20px; }
        .container { max-width: 800px; margin: 40px auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .post { border-bottom: 1px solid #ddd; padding: 15px 0; }
        .post:last-child { border-bottom: none; }
        .post h3 { margin: 0 0 8px 0; }
        .post p { margin: 0; color: #555; }
        .post small { color: #888; }
    </style>
</head>
<body>
<div class="container">
    <h2>All Posts</h2>
    <?php if ($result->num_rows == 0): ?>
        <p>No posts available.</p>
    <?php else: ?>
        <?php while($post = $result->fetch_assoc()): ?>
            <div class="post">
                <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                <small>Created at: <?php echo $post['created_at']; ?></small>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>
</body>
</html>
