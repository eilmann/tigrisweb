<?php
include('../includes/db.php');
include('../includes/session.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $participantID = $_POST['participantID'];
    $participantPW = $_POST['participantPW'];

    // Validate login credentials
    $sql = "SELECT * FROM participants WHERE participantID='$participantID' AND participantPW='$participantPW'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Successful login
        $row = $result->fetch_assoc();
        loginParticipant($row['participantID'], $row['participantName']);
        header("Location: ../client/index.php"); // Redirect to participant homepage
        exit();
    } else {
        $loginError = "Invalid participant ID or password";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participant Login</title>
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
            <label for="participantID">Participant ID:</label>
            <input type="text" name="participantID" required>

            <label for="participantPW">Password:</label>
            <input type="password" name="participantPW" required>

            <button type="submit">Login</button>

            <p>Don't have an account? <a href="register.php">Register as Participant</a></p>
            <p>Admin? <a href="../admin/login.php">Admin Login</a></p>
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
