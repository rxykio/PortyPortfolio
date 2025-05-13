<?php
if (session_status() ==  PHP_SESSION_NONE) {
    session_start();
}

$timeout = 1800;

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeout)) {
    session_unset();
    session_destroy();
    header("Location: /../PortyPortfolio/app/views/auth.php");
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time();
?>