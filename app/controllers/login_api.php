<?php
session_start();
header("Content-Type: application/json");
include_once __DIR__ . "/../../config/db.php";
include_once __DIR__ . "/../models/user.php";

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$data = json_decode(file_get_contents("php://input"), true);

if ($data === null || !isset($data['email']) || !isset($data['password'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Invalid input."]);
    exit();
}

$user->email = filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL);
$user->password = trim($data['password']);

if (!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Invalid email format."]);
    exit();
}

$result = $user->login();

if ($result['success']) {
    http_response_code(200);
    echo json_encode($result);
} else {
    http_response_code(401);
    echo json_encode($result);
}
?>