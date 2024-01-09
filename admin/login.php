<?php
include('../includes/db.php');
include('../includes/session.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminID = $_POST['adminID'];
    $adminPW = $_POST['adminPW'];

    // Validate login credentials
    $sql = "SELECT * FROM admins WHERE adminID='$adminID' AND adminPW='$adminPW'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Successful login
        $row = $result ->fetch_assoc();
        loginAdmin($row['adminID'], $row['adminName']);
        header("Location: dashboard.php"); // Redirect to admin dashboard
        exit();
    } else {
        $loginError = "Invalid admin ID or password";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../css/general_style.css">
</head>
<body>

    <header>
        <div class="logo-container">
            <a href="../client/index.php">
                <img src="../img/tigris_logo.png" alt="Logo">
            </a>
            <h1>UTHM Tigris E-Sports Website</h1>
        </div>
    </header>

    <main>
        <form action="login.php" method="post" class="form">
            <label for="adminID">Admin ID:</label>
            <input type="text" name="adminID" required>

            <label for="adminPW">Password:</label>
            <input type="password" name="adminPW" required>

            <button type="submit">Login</button>

            <p>Not an admin? <a href="../client/index.php">Go back to main page</a></p>

        </form>

        <?php
        if (isset($loginError)) {
            echo '<p class="error">' . $loginError . '</p>';
        }
        ?>

    </main>

    <footer>
        <p>&copy; 2024 UTHM Tigris E-Sports Website</p>
    </footer>

    <script src="../js/script.js"></script>
</body>
</html>
