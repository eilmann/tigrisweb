<?php
// Include the database connection file
include('../includes/db.php');
include('../includes/session.php');

// Check if the form is submitted for updating
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $formID = $_POST['formID'];
    $formTitle = $_POST['formTitle'];
    $description = $_POST['description'];
    $registrationFee = $_POST['registration_fee'];
    $proofOfPaymentToggle = $_POST['proof_of_payment_toggle'];

    // Update the record in the 'forms' table
    $update_sql = "UPDATE forms SET 
                    formTitle='$formTitle', 
                    description='$description', 
                    registration_fee='$registrationFee', 
                    proof_of_payment_toggle='$proofOfPaymentToggle' 
                    WHERE formID='$formID'";

    if ($conn->query($update_sql) === TRUE) {
        // Redirect to the manage_registration_form.php page after updating
        header("Location: manage_registration_form.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Check if the edit_formID is set in the URL
if (isset($_GET['edit_formID'])) {
    $edit_formID = $_GET['edit_formID'];

    // Query to retrieve data for the selected registration form
    $edit_sql = "SELECT * FROM forms WHERE formID='$edit_formID'";
    $edit_result = $conn->query($edit_sql);

    if ($edit_result->num_rows == 1) {
        $edit_row = $edit_result->fetch_assoc();
    } else {
        echo "Registration form not found!";
        exit();
    }
} else {
    // If edit_formID is not set, redirect to manage_registration_form.php
    header("Location: manage_registration_form.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Registration Form - Admin</title>
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
        <form action="" method="post" class="form">
            <h1>Edit Registration Form</h1>
            <!-- Add form fields for form input (formID, formTitle, description, registration_fee, proof_of_payment_toggle) -->
            <input type="hidden" name="formID" value="<?php echo $edit_row['formID']; ?>">

            <label for="formTitle">Form Title:</label>
            <input type="text" name="formTitle" value="<?php echo $edit_row['formTitle']; ?>" required>

            <label for="description">Description:</label>
            <textarea name="description" rows="4" required><?php echo $edit_row['description']; ?></textarea>

            <label for="registration_fee">Registration Fee:</label>
            <input type="text" name="registration_fee" value="<?php echo $edit_row['registration_fee']; ?>" required>

            <label for="proof_of_payment_toggle">Proof of Payment Toggle:</label>
            <select name="proof_of_payment_toggle" required>
                <option value="0" <?php echo ($edit_row['proof_of_payment_toggle'] == 0) ? 'selected' : ''; ?>>Disabled</option>
                <option value="1" <?php echo ($edit_row['proof_of_payment_toggle'] == 1) ? 'selected' : ''; ?>>Enabled</option>
            </select>

            <button type="submit">Update Registration Form</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 UTHM Tigris E-Sports Website</p>
    </footer>

    <script src="../js/script.js"></script>
</body>
</html>
