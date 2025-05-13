<?php
session_start();
require_once 'app/models/Project.php';
require_once 'app/models/Profile.php';
require_once 'config/config.php'; 
class ProjectController {
    public function index() {
        $projectModel = new Project();
        $projects = $projectModel->all();
        include 'app/views/portfolio_public.php';
    }

    public function admin() {
        $userId = $_SESSION['user_id'];
        $projectModel = new Project();
        $projects = $projectModel->getAllByUser($userId);
        include 'app/views/portfolio.php';
    }

    public function create() {
        include 'app/views/create.php';
    }

    public function publicPortfolio($input) {
    $input = str_replace('-', ' ', $input); 
    if (!preg_match('/^[a-zA-Z][a-zA-Z\- ]{0,49}$/', $input)) {
        http_response_code(400);
        die("Invalid name provided.");
    }


    $cleanName = preg_replace('/[^a-zA-Z\- ]/', '', $input);
    $cleanName = substr($cleanName, 0, 50);

    $projectModel = new Project();
    $profileModel = new Profile();

    $parts = explode(' ', $cleanName);
    $firstName = $parts[0] ?? '';
    $lastName = isset($parts[1]) ? $parts[1] : null;

    if ($lastName) {
        $projects = $projectModel->getByFullName($firstName, $lastName);
    } else {
        $projects = $projectModel->getByFirstOrLastName($firstName);
    }

    if (!$projects) {
        die("No user or projects found for '" . htmlspecialchars($cleanName, ENT_QUOTES, 'UTF-8') . "'.");
    }

    $userId = $projects[0]['user_id'] ?? null;

    if ($userId) {
        $profile = $profileModel->getByUserId($userId);
        if ($profile) {
            $profile['first_name'] = $projects[0]['first_name'] ?? '';
            $profile['last_name'] = $projects[0]['last_name'] ?? '';
        }
    } else {
        $profile = [];
    }

    include 'app/views/portfolio_public.php';
}


    public function store() {
        $userId = $_SESSION['user_id'];

        $imageName = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageName = time() . '_' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], 'public/uploads/' . $imageName);
        }

        $projectModel = new Project();
        $projectModel->create($_POST, $imageName, $userId);

        header('Location: ' . BASE_URL . 'admin');
    }

    public function edit($id) {
        $projectModel = new Project();
        $project = $projectModel->getById($id);
        include 'app/views/edit.php';
    }

    public function update($id) {
        $imageName = $_POST['existing_image'];
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageName = time() . '_' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], 'public/uploads/' . $imageName);
        }

        $projectModel = new Project();
        $projectModel->update($id, $_POST, $imageName);
        header('Location: ' . BASE_URL . 'admin');
    }

    public function delete($id) {
        $userId = $_SESSION['user_id'];

        $projectModel = new Project();
        $project = $projectModel->getById($id);

        if ($project['user_id'] != $userId) {
            die("Unauthorized");
        }

        $projectModel->delete($id);
        header('Location: ' . BASE_URL . 'admin');
    }

/////////////////
    public function profile() {
        $userId = $_SESSION['user_id'];
        $profileModel = new Profile();
        $profile = $profileModel->getByUserId($userId);
        include 'app/views/profile_form.php';
    }
    
    public function saveProfile() {
    $userId = $_SESSION['user_id'];
    $profileModel = new Profile();

    // profile picture
    $profilePic = $_POST['existing_picture'] ?? '';
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $profilePic = time() . '_' . basename($_FILES['profile_picture']['name']);
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], 'public/uploads/' . $profilePic);
    }

    // CV file
    $cvFilename = $_POST['existing_cv'] ?? '';
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
        $cvFilename = time() . '_' . basename($_FILES['cv']['name']);
        move_uploaded_file($_FILES['cv']['tmp_name'], 'public/uploads/cv/' . $cvFilename);
    }

    // Save profile
    $profileModel->updateOrCreate($userId, $_POST, $profilePic, $cvFilename);
    header('Location: ' . BASE_URL . 'admin');
}

    
}

