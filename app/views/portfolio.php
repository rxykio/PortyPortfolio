<?php
require_once __DIR__ . '/../../config/session_timeout.php';
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'user') {  
    header("Location: /../PortyPortfolio/app/views/auth.php");
    exit();
}
?>


<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/global.css">
</head>
</style>
<div class="dashboard-container">
<?php include 'sidebar.php'?>

    <main class="main-content">
        <h1>My Projects</h1>
        <div class="projects">
            <?php foreach ($projects as $project): ?>
                <div class="project-card">
                    <img src="<?= BASE_URL ?>public/uploads/<?= $project['image'] ?>" alt="">
                    <h2><?= $project['title'] ?></h2>
                    <p><?= $project['description'] ?></p>
                    <a href="<?= BASE_URL ?>edit&id=<?= $project['id'] ?>">Edit</a> |
                    <a href="<?= BASE_URL ?>delete&id=<?= $project['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</div>
</html>
