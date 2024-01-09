<?php
// Include the database connection file
include('../includes/db.php');
include('../includes/session.php');

// Retrieve the latest formID from the database
$sqlLatestFormID = "SELECT MAX(CAST(SUBSTRING(formID, 3) AS UNSIGNED)) AS latestFormID FROM forms";
$resultLatestFormID = $conn->query($sqlLatestFormID);

$latestFormID = 1; // Default value if there are no forms yet

if ($resultLatestFormID->num_rows > 0) {
    $row = $resultLatestFormID->fetch_assoc();
    $latestFormID = (int)$row['latestFormID'] + 1;
}

// Default value for registration_fee
$defaultRegistrationFee = 0;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $formID = $_POST['formID'];
    $formTitle = $_POST['formTitle'];
    $description = $_POST['description'];
    $registration_fee = isset($_POST['registration_fee']) ? $_POST['registration_fee'] : $defaultRegistrationFee;
    $proof_of_payment_toggle = isset($_POST['proof_of_payment_toggle']) ? 1 : 0;

    // Insert data into the 'forms' table
    $insert_sql = "INSERT INTO forms (`formID`, `formTitle`, `description`, `registration_fee`, `proof_of_payment_toggle`) 
                   VALUES ('$formID', '$formTitle', '$description', $registration_fee, $proof_of_payment_toggle)";

    if ($conn->query($insert_sql) === TRUE) {
        echo '<script>alert("Registration form added successfully!");</script>';
    } else {
        echo '<script>alert("Error: ' . $insert_sql . '<br>' . $conn->error . '");</script>';
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Registration Form - Admin</title>
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

    <main class="admin-main">
        <!-- Admin Registration Form -->
        <form action="create_registration_form.php" method="post" class="form">
            <h1>Create new Registration Form</h1>
            <!-- Add form fields for registration form input (formID, formTitle, description, registration_fee, proof_of_payment_toggle) -->
            <label for="formID">Form ID:</label>
            <input type="text" name="formID" value="FI<?= str_pad($latestFormID, 4, '0', STR_PAD_LEFT); ?>" required>

            <label for="formTitle">Form Title:</label>
            <input type="text" name="formTitle" required>

            <label for="description">Description:</label>
            <textarea name="description" rows="4"></textarea>

            <label for="registration_fee">Registration Fee (RM):</label>
            <input type="text" name="registration_fee" min="0" value="<?= $defaultRegistrationFee ?>">

            <label for="proof_of_payment_toggle">Require Proof of Payment:</label>
            <input type="checkbox" name="proof_of_payment_toggle">

            <!-- Add other form fields -->

            <button type="submit">Submit</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 UTHM Tigris E-Sports Website</p>
    </footer>

    <script src="../js/script.js"></script>
</body>
</html>
