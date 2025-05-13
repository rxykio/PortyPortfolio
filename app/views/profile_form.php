
<?php
require_once __DIR__ . '/../../config/session_timeout.php';
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'user') {  
    header("Location: /../PortyPortfolio/app/views/auth.php");
    exit();
}
?>

<link rel="stylesheet" href="<?= BASE_URL ?>public/css/global.css">
<body>
<?php include 'sidebar.php'?>
<div class="main-content">
<form method="post" action="<?= BASE_URL ?>saveProfile" enctype="multipart/form-data">
    <label>Profile Picture:</label><br>
    <?php if (!empty($profile['profile_picture'])): ?>
        <img src="<?= BASE_URL ?>public/uploads/<?= $profile['profile_picture'] ?>" width="100"><br>
        <input type="hidden" name="existing_picture" value="<?= $profile['profile_picture'] ?>">
    <?php endif; ?>
    <input type="file" name="profile_picture"><br><br>

    <label>Biography:</label><br>
    <textarea name="biography"><?= htmlspecialchars($profile['biography'] ?? '') ?></textarea><br><br>

    <label>Description:</label><br>
    <textarea name="description"><?= htmlspecialchars($profile['description'] ?? '') ?></textarea><br><br>

    <label>Skills (comma-separated):</label><br>
    <input type="text" name="skills" value="<?= htmlspecialchars($profile['skills'] ?? '') ?>"><br><br>
    
    <label>Facebook URL:</label><br>
<input type="url" name="facebook" value="<?= htmlspecialchars($profile['facebook'] ?? '') ?>"><br><br>

<label>Twitter URL:</label><br>
<input type="url" name="twitter" value="<?= htmlspecialchars($profile['twitter'] ?? '') ?>"><br><br>

<label>LinkedIn URL:</label><br>
<input type="url" name="linkedin" value="<?= htmlspecialchars($profile['linkedin'] ?? '') ?>"><br><br>

<label>Instagram URL:</label><br>
<input type="url" name="instagram" value="<?= htmlspecialchars($profile['instagram'] ?? '') ?>"><br><br>

<label>YouTube URL:</label><br>
<input type="url" name="youtube" value="<?= htmlspecialchars($profile['youtube'] ?? '') ?>"><br><br>
  

<label>Upload CV:</label>
<input type="text" name="existing_cv" value="<?= htmlspecialchars($profile['cv_filename'] ?? '') ?> " readonly>
<input type="file" name="cv" accept=".pdf,.doc,.docx">

    <button type="submit">Save Profile</button>
</form>
    </div>
    </body>