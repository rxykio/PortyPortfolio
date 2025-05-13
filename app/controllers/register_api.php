<?php
session_start();
header("Content-Type: application/json");
include_once __DIR__ . "/../../config/db.php";
include_once __DIR__ . "/../models/user.php";

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$data = json_decode(file_get_contents("php://input"), true);



if (empty($data['first_name'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "First Name is Required."]);
    exit();
}
if (empty($data['last_name'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Last Name is Required."]);
    exit();
}
if (empty($data['email'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Email is Required."]);
    exit();
} elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Invalid email format."]);
    exit();
}
if (empty($data['mobile'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Mobile Number is Required."]);
    exit();
} elseif (!preg_match("/^[0-9]{11}$/", $data['mobile'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Mobile format should be ph."]);
    exit();
}
if (empty($data['password'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Password is required."]);
    exit();
} elseif (strlen($data['password']) < 6 ||
    !preg_match("/[a-z]/", $data['password']) ||
    !preg_match("/[A-Z]/", $data['password']) ||
    !preg_match("/[0-9]/", $data['password']) ||
    !preg_match("/[\W_]/", $data['password'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Password must be at least 6 characters long and include uppercase, lowercase, a number, and a special character."]);
    exit();
}
if (empty($data['confirm_password'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Confirm Password is required."]);
    exit();
} elseif ($data['password'] !== $data['confirm_password']) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Password do not match."]);
    exit();
}

$user->first_name = htmlspecialchars(strip_tags(trim($data['first_name'])));
$user->last_name = htmlspecialchars(strip_tags(trim($data['last_name'])));
$user->email = filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL);
$user->mobile = preg_replace('/\D/', '', trim($data['mobile']));
$user->password = trim($data['password']);
$user->status = "Verified";

$user->password = password_hash($user->password, PASSWORD_ARGON2ID);

if ($user->emailExist()) {
    http_response_code(409);
    echo json_encode(["message" => "Email already exists.", "success" => false]);
    exit();
}

if ($user->create()) {
    http_response_code(201);
    echo json_encode(["message" => "User registered successfully.", "success" => true]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Error registering user.", "success" => false]);
}
?>