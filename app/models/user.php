<?php
class User {
    private $conn;
    private $table_name = "users";
    public $id, $first_name, $last_name, $email, $mobile, $password, $role, $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (first_name, last_name, email, mobile, password, status) VALUES (:first_name, :last_name, :email, :mobile, :password, :status)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":mobile", $this->mobile);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":status", $this->status);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function getProfileByFirstName($firstName) {
    $stmt = $this->db->prepare("
        SELECT p.*, u.first_name, u.last_name 
        FROM profiles p
        JOIN users u ON p.user_id = u.id
        WHERE u.first_name = ?
    ");
    $stmt->execute([$firstName]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
    public function emailExist() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function login() {
        $query = "SELECT * FROM ". $this->table_name ." WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($this->password, $row['password'])) {
                if ($row['status'] == 'Verified') {
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['first_name'] = $row['first_name'];
                    $_SESSION['last_name'] = $row['last_name'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['role'] = $row['role'];

                    return ["success" => true, "message" => "Login successful.", "role" => $row['role']];
                } else {
                    return ["success" => false, "message" => "Please verify your account."];
                }
            } else {
                return ["success" => false, "message" => "Invalid login credentials."];
            }
        } else {
            return ["success" => false, "message" => "Account not found."];
        }
    }
}
?>