<?php
// Include the database connection file
include('../includes/db.php');
include('../includes/session.php');

// Retrieve the latest postID from the database
$sqlLatestPostID = "SELECT MAX(CAST(SUBSTRING(postID, 3) AS UNSIGNED)) as latestPostID FROM posts";
$resultLatestPostID = $conn->query($sqlLatestPostID);

$latestPostID = 1; // Default value if there are no posts yet

if ($resultLatestPostID->num_rows > 0) {
    $row = $resultLatestPostID->fetch_assoc();
    $latestPostID = (int)$row['latestPostID'] + 1;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $postID = $_POST['postID'];
    $formID = $_POST['formID'] ?? 'none';  // Use 'none' if not provided
    $bracketID = $_POST['bracketID'] ?? 'none';  // Use 'none' if not provided
    $scheduleID = $_POST['scheduleID'] ?? 'none';  // Use 'none' if not provided
    $postTitle = $_POST['postTitle'];
    $postDate = $_POST['postDate'];
    $postDesc = $_POST['postDesc'];

    // Upload image file if provided
    $postPic = ''; // Default value
    if (isset($_FILES['postPic']) && $_FILES['postPic']['error'] == 0) {
        $targetDir = "../uploads/"; // Adjust the target directory
        $targetFile = $targetDir . basename($_FILES['postPic']['name']);
        move_uploaded_file($_FILES['postPic']['tmp_name'], $targetFile);
        $postPic = $targetFile;
    }

    // Insert data into the 'posts' table
    $sql = "INSERT INTO posts (postID, formID, bracketID, scheduleID, postTitle, postDate, postDesc, postPic) 
            VALUES ('$postID', '$formID', '$bracketID', '$scheduleID', '$postTitle', '$postDate', '$postDesc', '$postPic')";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Post added successfully!"); window.location.href = "manage_feed_post.php";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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
    <link rel="icon" href="../img/tigris_logo.png" type="icon">
    <title>Create Feed Post - Admin</title>
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

    <main>
        <!-- Admin Feed Post Form -->
        <form action="create_feed_post.php" method="post" enctype="multipart/form-data" class="form">
            <h1>Create new Feed Post</h1>
            <!-- Add form fields for post input (postID, formID, bracketID, scheduleID, postTitle, postDate, postDesc, postPic) -->
            <label for="postID">Post ID:</label>
            <input type="text" name="postID" value="PI<?= str_pad($latestPostID, 4, '0', STR_PAD_LEFT); ?>" required>

            <label for="formID">Form ID:</label>
            <input type="text" name="formID" value="none">

            <label for="bracketID">Bracket ID:</label>
            <input type="text" name="bracketID" value="none">

            <label for="scheduleID">Schedule ID:</label>
            <input type="text" name="scheduleID" value="none">

            <label for="postTitle">Post Title:</label>
            <input type="text" name="postTitle" required>

            <label for="postDate">Post Date:</label>
            <input type="date" name="postDate" required>

            <label for="postDesc">Post Description:</label>
            <textarea name="postDesc" rows="4" required></textarea>

            <label for="postPic">Post Picture:</label>
            <input type="file" accept=".jpg, .png" name="postPic">

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
