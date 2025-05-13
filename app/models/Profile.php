<?php
class Profile {
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=portfolio', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getByUserId($userId) {
    $stmt = $this->db->prepare("SELECT * FROM profiles WHERE user_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    public function updateOrCreate($userId, $data, $profilePic, $cvFilename = null) {
    $existing = $this->getByUserId($userId);
    if ($existing) {
        $stmt = $this->db->prepare("UPDATE profiles 
            SET biography = ?, description = ?, skills = ?, profile_picture = ?, cv_filename = ?, facebook = ?, twitter = ?, linkedin = ?, instagram = ?, youtube = ?
            WHERE user_id = ?");
        $stmt->execute([
            $data['biography'], $data['description'], $data['skills'], $profilePic, $cvFilename,
            $data['facebook'], $data['twitter'], $data['linkedin'], $data['instagram'], $data['youtube'],
            $userId
        ]);
    } else {
        $stmt = $this->db->prepare("INSERT INTO profiles 
            (user_id, biography, description, skills, profile_picture, cv_filename, facebook, twitter, linkedin, instagram, youtube) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $userId, $data['biography'], $data['description'], $data['skills'], $profilePic, $cvFilename,
            $data['facebook'], $data['twitter'], $data['linkedin'], $data['instagram'], $data['youtube']
        ]);
    }
}



}
