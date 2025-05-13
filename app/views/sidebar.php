<style>
.dashboard-container {
        display: flex;
        min-height: 100vh;
    }

    .sidebar {
        width: 220px;
        background-color: #1f1f1f;
        padding: 20px;
        box-shadow: 2px 0 8px rgba(0, 0, 0, 0.3);
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .sidebar h2 {
        color: #ffffff;
        margin-bottom: 10px;
    }

    .sidebar nav a {
        display: block;
        padding: 10px;
        color: #ffffff;
        background-color: #2c2c2c;
        margin-bottom: 10px;
        border-radius: 6px;
        text-decoration: none;
        transition: background 0.3s;
    }

    .sidebar nav a:hover {
        background-color: #007bff;
    }

</style>
<div class="dashboard-container">
<aside class="sidebar">
        <h2>Admin</h2>
        <nav>
            <a href="<?= BASE_URL ?>admin">Projects</a>
            <a href="<?= BASE_URL ?>profile">Edit Profile</a>
            <a href="<?= BASE_URL ?>create">Add Project</a>
            <a href="/../PortyPortfolio/app/controllers/logout.php">Logout</a>
        </nav>
    </aside>