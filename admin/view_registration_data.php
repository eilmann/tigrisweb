<?php
// Include the database connection file
include('../includes/db.php');
include('../includes/session.php');

// Check if formID is set in the URL
if (isset($_GET['formID'])) {
    $formID = $_GET['formID'];

    // Query to retrieve data from the 'participant_registrations' table based on formID
    $sql = "SELECT participants.participantID, participants.participantName, participants.participantEmail
            FROM participants
            JOIN participant_registrations ON participants.participantID = participant_registrations.participantID
            WHERE participant_registrations.formID='$formID'";
    $result = $conn->query($sql);
} else {
    // Redirect to the manage_registration_forms.php page if formID is not set
    header("Location: manage_registration_forms.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Registration Data - Admin</title>
    <link rel="stylesheet" href="../css/general_style.css">
</head>
<body>

    <header>
        <div class="logo-container">
            <a href="../admin/dashboard.php">
                <img src="../img/tigris_logo.png" alt="Logo">
            </a>
            <h1>UTHM Tigris E-Sports Website</h1>
        </div>
        <nav>
            <a href="logout.php" class="login-button">Logout</a>
        </nav>
    </header>

    <main class="main-white">
        <h1>View Registration Data</h1>

        <a href="manage_registration_form.php" class="back-button">Back to Manage Forms</a>

        <table>
            <tr>
                <!-- Add appropriate column headers based on the participant_registrations table -->
                <th>Participant ID</th>
                <th>Participant Name</th>
                <th>Email</th>
                <!-- Add other columns as needed -->
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['participantID'] . '</td>';
                    echo '<td>' . $row['participantName'] . '</td>';
                    echo '<td>' . $row['participantEmail'] . '</td>';
                    // Add other columns as needed
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="3">No registration data found.</td></tr>';
            }
            ?>
        </table>
    </main>

    <footer>
        <p>&copy; 2024 UTHM Tigris E-Sports Website</p>
    </footer>

    <script src="../js/script.js"></script>
</body>
</html>
