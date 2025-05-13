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
    <h1>Edit Project</h1>
    <form action="<?= BASE_URL ?>update&id=<?= $project['id'] ?>" method="post" enctype="multipart/form-data">
        <input type="text" name="title" value="<?= $project['title'] ?>" required><br><br>
        <textarea name="description" required><?= $project['description'] ?></textarea><br><br>
        <img src="<?= BASE_URL ?>public/uploads/<?= $project['image'] ?>" width="150"><br>
        <input type="hidden" name="existing_image" value="<?= $project['image'] ?>">
        <input type="file" name="image"><br><br>
        <input type="text" name="link" value="<?= $project['link'] ?>"><br><br>
        <button type="submit">Update</button>
    </form>
</div>
</body>
</html>
