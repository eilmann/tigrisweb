<?php
// Include the database connection file
include('../includes/db.php');
include('../includes/session.php');

// Check if a participant is logged in
if (!isParticipantLoggedIn()) {
    // Redirect to the login page if not logged in
    header("Location: ../participant/login.php");
    exit();
}

// Check if the formID is provided in the URL
if (isset($_GET['formID'])) {
    $formID = $_GET['formID'];

    // Query to retrieve registration form details based on formID
    $formDetailsSql = "SELECT * FROM forms WHERE formID = '$formID'";
    $formDetailsResult = $conn->query($formDetailsSql);

    if ($formDetailsResult->num_rows > 0) {
        // Fetch the registration form details
        $formDetails = $formDetailsResult->fetch_assoc();

        // Display the registration form details
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="icon" href="../img/tigris_logo.png" type="icon">
            <title>Tournament Registration</title>
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
                <nav>
                    <a class="login-button" href="../participant/logout.php">Logout</a>
                </nav>
            </header>

            <main>
                <div class="form">
                    <h1>' . $formDetails['formTitle'] . '</h1>
                    <p>' . $formDetails['description'] . '</p>
                    <p>Registration Fee: RM' . $formDetails['registration_fee'] . '</p>';
                    $participantID = $_SESSION['participantID'];
                    $participantName = $_SESSION['participantName'];

                    // Check if proof of payment is enabled
                    if ($formDetails['proof_of_payment_toggle'] == 1) {
                        echo '<p>Proof of Payment is required.</p>';
                        // Add HTML form field for proof of payment upload
                        echo '<form action="process_registration.php?formID=' . $formID . '" method="post" enctype="multipart/form-data">';
                        echo '<label for="participantID">Participant ID:</label>';
                        echo '<input type="text" name="participantID" placeholder="Enter your Participant ID" required>';
                        echo '<label for="participantName">Participant Name:</label>';
                        echo '<input type="text" name="participantName" value="' . $participantName . '" readonly>';
                        echo '<label for="proofOfPayment">Proof of Payment (PDF only):</label>';
                        echo '<input type="file" name="proofOfPayment" accept=".pdf" required>';
                        echo '<input type="hidden" name="MAX_FILE_SIZE" value="10485760">'; // Max file size (10 MB)
                        echo '<input type="submit" name="submit" value="Submit Registration">';
                        echo '</form>';
                    } else {
                        echo '<form action="process_registration.php?formID=' . $formID . '" method="post" enctype="multipart/form-data">';
                        echo '<p>There is no registration fee for this tournament.</p>';
                        // Display form fields for participant input
                        echo '<label for="participantID">Participant ID:</label>';
                        echo '<input type="text" name="participantID" value="' . $participantID . '" readonly>';
                        echo '<label for="participantName">Participant Name:</label>';
                        echo '<input type="text" name="participantName" value="' . $participantName . '" readonly>';
                        // Add additional form fields for participant input based on your requirements
                        // ...
                        echo '<button type="submit">Submit Registration</button>';
                        echo '</form>';
                    }
                echo '</div>
            </main>

            <footer>
                <p>&copy; 2024 UTHM Tigris E-Sports Website</p>
            </footer>

        </body>
        </html>';
    } else {
        echo "Registration form not found.";
    }
} else {
    echo "FormID not provided in the URL.";
}

// Close the database connection
$conn->close();
?>
