<?php
class Project {
    private $db;
    
    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=portfolio', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function all() {
        return $this->db->query('SELECT * FROM projects ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM projects WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllByUser($userId) {
        $stmt = $this->db->prepare("SELECT * FROM projects WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->db->prepare('SELECT * FROM projects WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByFirstName($firstName) {
        $stmt = $this->db->prepare("
            SELECT p.*, u.first_name, u.last_name
            FROM projects p
            JOIN users u ON u.id = p.user_id
            WHERE LOWER(u.first_name) = LOWER(?)
        ");
        $stmt->execute([$firstName]);
        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return count($projects) > 0 ? $projects : false;
    }
    public function getByFirstOrLastName($name) {
    $stmt = $this->db->prepare("
        SELECT p.*, u.first_name, u.last_name, u.id as user_id
        FROM projects p
        JOIN users u ON u.id = p.user_id
        WHERE LOWER(u.first_name) = LOWER(?) OR LOWER(u.last_name) = LOWER(?)
    ");
    $stmt->execute([$name, $name]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getByFullName($firstName, $lastName) {
    $stmt = $this->db->prepare("
        SELECT p.*, u.first_name, u.last_name, u.id as user_id
        FROM projects p
        JOIN users u ON u.id = p.user_id
        WHERE LOWER(u.first_name) = LOWER(?) AND LOWER(u.last_name) = LOWER(?)
    ");
    $stmt->execute([$firstName, $lastName]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function create($data, $imageName, $userId) {
        $stmt = $this->db->prepare("INSERT INTO projects (user_id, title, description, image, link) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$userId, $data['title'], $data['description'], $imageName,  $data['link']]);
    }

    public function update($id, $data, $image) {
        $stmt = $this->db->prepare('UPDATE projects SET title = ?, description = ?, image = ?, link = ? WHERE id = ?');
        $stmt->execute([$data['title'], $data['description'], $image, $data['link'], $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare('DELETE FROM projects WHERE id = ?');
        $stmt->execute([$id]);
    }
    public function getProfileByFirstName($firstName) {
        $stmt = $this->db->prepare("
            SELECT u.first_name, u.last_name, p.profile_picture, p.biography, p.description, p.skills
            FROM profiles p
            JOIN users u ON u.id = p.user_id
            WHERE LOWER(u.first_name) = LOWER(?)
            LIMIT 1
        ");
        $stmt->execute([$firstName]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // app/models/Project.php

public function getAllFirstNames() {
    $stmt = $this->db->query("SELECT DISTINCT first_name FROM users WHERE status = 'Verified'");
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

}
