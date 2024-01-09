<?php
include('../includes/db.php');
include('../includes/session.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Dashboard</title>
    <link rel="stylesheet" href="../css/general_style.css">
</head>
<body>

    <header>
        <div class="logo-container">
            <a href="../admin/dashboard.php">
                <img src="../img/tigris_logo.png" alt="Logo">
            </a>
            <h1>Administrator Dashboard</h1>
        </div>

        <nav>
            <a href="logout.php" class="login-button">Logout</a>
        </nav>
    </header>

    <main>
        <!-- Display greeting message -->

        <div>
        <?php
        if (isAdminLoggedIn()) {
            echo '<p class="greeting-message">Hello, ' . $_SESSION['adminID'] . '!</p>';
        }
        ?>

        </div>

        <div class="dashboard-buttons">
            <a href="manage_feed_post.php" class="dashboard-button">Manage Feed Post</a>
            <a href="manage_registration_form.php" class="dashboard-button">Manage Registration Form</a>
            <a href="bracket_generator.php" class="dashboard-button">Bracket Generator</a>
            <a href="schedule_generator.php" class="dashboard-button">Schedule Generator</a>
            <a href="participant_performance.php" class="dashboard-button">Participant Performance</a>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 UTHM Tigris E-Sports Website</p>
    </footer>

    <script src="../js/script.js"></script>
</body>
</html>
