<?php
include('../includes/db.php');
include('../includes/session.php');

// Function to get participant data by participantID
function getParticipantData($participantID) {
    global $conn;
    $sql = "SELECT * FROM participants WHERE participantID='$participantID'";
    $result = $conn->query($sql);
    return ($result->num_rows > 0) ? $result->fetch_assoc() : null;
}

// Check if a participant is logged in
if (!isParticipantLoggedIn()) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$participantID = $_SESSION['participantID'];
$participantData = getParticipantData($participantID);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/tigris_logo.png" type="icon">
    <title>Participant Profile</title>
    <link rel="stylesheet" href="../css/general_style.css">
</head>
<body>

    <header>
        <!-- Place the logo and title on the top left -->
        <div class="logo-container">
            <a href="../client/index.php">
                <img src="../img/tigris_logo.png" alt="Logo">
            </a>
            <h1>UTHM Tigris E-Sports Website</h1>
        </div>
        <nav>
            <?php
                // Check if a participant is logged in
                if (isParticipantLoggedIn()) {
                    $participantID = $_SESSION['participantID'];
                    $participantData = getParticipantData($participantID);
                    
                    echo '<a class="login-button" href="../participant/logout.php">Logout</a>';
                } else {
                    echo '<a class="login-button" href="../participant/login.php">Login</a>';
                }
            ?>   
        </nav>
    </header>

    <main class="form">
        <h1>Player Profile</h1>
        <p><strong>Participant ID:</strong> <?php echo $participantData['participantID']; ?></p>
        <p><strong>Name:</strong> <?php echo $participantData['participantName']; ?></p>
        <p><strong>Email:</strong> <?php echo $participantData['participantEmail']; ?></p>
        <p><strong>Profile Picture:</strong> <img class="profile-page" src="<?php echo $participantData['participantPic']; ?>" alt="Profile Picture" style="height: 300px; width: auto;"></p>
        <!-- Add other fields as needed -->

        <div class="profile-buttons">
            <a class="edit-button" href="edit_profile.php">Edit Profile</a>
            <a class="performance-button" href="view_performance.php">View Performance</a>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 UTHM Tigris E-Sports Website</p>
    </footer>

    <script src="../js/script.js"></script>
</body>
</html>
