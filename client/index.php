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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTHM Tigris E-Sports Website</title>
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
                    
                    echo '<a class="profile-link" href="../participant/view_profile.php" style="background-image: url(\'' . $participantData['participantPic'] . '\')"></a>';
                    echo '<a class="login-button" href="../participant/logout.php">Logout</a>';
                } else {
                    echo '<a class="login-button" href="../participant/login.php">Login</a>';
                }
            ?>   
        </nav>
    </header>

    <main>
        <!-- Display events/feed posts here -->
        <?php

        // Query to retrieve feed post data (adjust based on your database structure)
        $sql = "SELECT * FROM posts ORDER BY postDate DESC"; // Order by postDate in descending order
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Display feed posts
            echo '<div class="card-container">'; // New container for grid layout
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<h2>' . $row['postTitle'] . '</h2>';
                echo '<p>' . $row['postDesc'] . '</p>';
                echo '<p>Posted on: ' . $row['postDate'] . '</p>';
                // Display the image if available
                if (!empty($row['postPic'])) {
                    echo '<img src="' . $row['postPic'] . '" alt="Post Image">';
                }

                // Check if a participant is logged in
                if (isParticipantLoggedIn()) {
                    // Add Join Tournament button with formID parameter
                    echo '<a href="../participant/tournament_registration.php?formID=' . $row['formID'] . '">Join Tournament</a>';
                }

                // Add other fields as needed
                echo '</div>';
            }
            echo '</div>'; // Close the container
        } else {
            echo "No feed posts found.";
        }
        ?>
    </main>

    <footer>
        <p>&copy; 2024 UTHM Tigris E-Sports Website</p>
    </footer>

    <script src="../js/script.js"></script>

    <script>
        function viewProfile() {
            // Redirect to the participant's profile page
            window.location.href = "../participant/view_profile.php";
        }
    </script>
</body>
</html>
