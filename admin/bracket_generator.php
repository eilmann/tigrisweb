<?php
// Include the database connection file
include('../includes/db.php');
include('../includes/session.php');

// Query to retrieve existing formIDs
$sqlFormIDs = "SELECT formID FROM forms";
$resultFormIDs = $conn->query($sqlFormIDs);

// Array to store formIDs
$formIDs = array();

if ($resultFormIDs->num_rows > 0) {
    while ($row = $resultFormIDs->fetch_assoc()) {
        $formIDs[] = $row['formID'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bracket Generator - Admin</title>
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
    <h1>Bracket Generator</h1>

    <!-- Form to select formID and tournament format -->
    <form class="form" method="post" id="bracketForm">
        <label for="formID">Select FormID:</label>
        <select name="formID" id="formID" required>
            <?php foreach ($formIDs as $formID) {
                echo "<option value=\"$formID\">$formID</option>";
            } ?>
        </select>
        <p></p>
        <label for="tournamentFormat">Select Tournament Format:</label>
        <select name="tournamentFormat" id="tournamentFormat" required>
            <option value="single_elimination">Single Elimination</option>
            <option value="double_elimination">Double Elimination</option>
        </select>

        <button type="submit" id="generateButton">Generate Bracket</button>
    </form>
</main>


<footer>
    <p>&copy; 2024 UTHM Tigris E-Sports Website</p>
</footer>

<script src="../js/script.js"></script>
<script>
    document.getElementById('bracketForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        var form = this;
        var tournamentFormat = form.elements['tournamentFormat'].value;

        if (tournamentFormat === 'single_elimination') {
            form.action = 'single_elimination_bracket.php'; // Set the action for single elimination
        } else if (tournamentFormat === 'double_elimination') {
            form.action = 'double_elimination_bracket.php'; // Set the action for double elimination
        }

        form.submit(); // Submit the form with the updated action
    });
</script>
</body>
</html>
