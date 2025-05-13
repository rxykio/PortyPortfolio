<?php
require_once __DIR__ . '/../../config/session_timeout.php';
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'user')  {  
    header("Location: /../PortyPortfolio/app/views/auth.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/global.css">
</head>

<body>
<?php include 'sidebar.php'; ?>
    <div class="main-content">
        <h1>Create New Project</h1>
        <form action="<?= BASE_URL ?>store" method="post" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Title" required><br>
            <textarea name="description" placeholder="Description" required></textarea><br>
            <input type="file" name="image" required><br>
            <input type="text" name="link" placeholder="Link"><br>
            <button type="submit">Create</button>
        </form>
    </div>
</body>
</html>
