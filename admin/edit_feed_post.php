<?php
// Include the database connection file
include('../includes/db.php');
include('../includes/session.php');

// Check if the form is submitted for updating
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postID = $_POST['postID'];
    $postTitle = $_POST['postTitle'];
    $postDate = $_POST['postDate'];
    $formID = $_POST['formID'];
    $bracketID = $_POST['bracketID'];
    $scheduleID = $_POST['scheduleID'];
    $postDesc = $_POST['postDesc'];

    // Update the record in the 'posts' table
    $update_sql = "UPDATE posts SET 
                    postTitle='$postTitle', 
                    postDate='$postDate', 
                    formID='$formID', 
                    bracketID='$bracketID', 
                    scheduleID='$scheduleID',
                    postDesc='$postDesc'
                    WHERE postID='$postID'";

    if ($conn->query($update_sql) === TRUE) {
        // Handle file upload for newPostPic
        if (isset($_FILES['newPostPic']) && $_FILES['newPostPic']['error'] == 0) {
            // Delete the existing file
            unlink($edit_row['postPic']);

            // Upload the new file
            $targetDir = "../uploads/"; // Adjust the target directory
            $targetFile = $targetDir . basename($_FILES['newPostPic']['name']);
            move_uploaded_file($_FILES['newPostPic']['tmp_name'], $targetFile);

            // Update the postPic in the database
            $update_pic_sql = "UPDATE posts SET postPic='$targetFile' WHERE postID='$postID'";
            $conn->query($update_pic_sql);
        }

        // Redirect to the manage_feed_post.php page after updating
        header("Location: manage_feed_post.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Check if the edit_postID is set in the URL
if (isset($_GET['edit_postID'])) {
    $edit_postID = $_GET['edit_postID'];

    // Query to retrieve data for the selected feed post
    $edit_sql = "SELECT * FROM posts WHERE postID='$edit_postID'";
    $edit_result = $conn->query($edit_sql);

    if ($edit_result->num_rows == 1) {
        $edit_row = $edit_result->fetch_assoc();
    } else {
        echo "Feed post not found!";
        exit();
    }
} else {
    // If edit_postID is not set, redirect to manage_feed_post.php
    header("Location: manage_feed_post.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Feed Post - Admin</title>
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
        <!-- Admin Feed Post Form -->
        <form action="" method="post" enctype="multipart/form-data" class="form">
            <h1>Edit Feed Post</h1>
            <!-- Add form fields for post input (postID, formID, bracketID, scheduleID, postTitle, postDate, postDesc, postPic) -->
            <input type="hidden" name="postID" value="<?php echo $edit_row['postID']; ?>">

            <label for="formID">Form ID:</label>
            <input type="text" name="formID" value="<?php echo $edit_row['formID']; ?>">

            <label for="bracketID">Bracket ID:</label>
            <input type="text" name="bracketID" value="<?php echo $edit_row['bracketID']; ?>">

            <label for="scheduleID">Schedule ID:</label>
            <input type="text" name="scheduleID" value="<?php echo $edit_row['scheduleID']; ?>">

            <label for="postTitle">Post Title:</label>
            <input type="text" name="postTitle" value="<?php echo $edit_row['postTitle']; ?>" required>

            <label for="postDate">Post Date:</label>
            <input type="date" name="postDate" value="<?php echo $edit_row['postDate']; ?>" required>

            <label for="postDesc">Post Description:</label>
            <textarea name="postDesc" rows="4" required><?php echo $edit_row['postDesc']; ?></textarea>

            <label for="postPic">Current Post Picture:</label>
            <img src="<?php echo $edit_row['postPic']; ?>" alt="Current Post Picture" style="max-width: 300px; margin-bottom: 10px;">
            <label for="newPostPic">New Post Picture:</label>
            <input type="file" accept=".jpg, .png" name="newPostPic">

            <button type="submit">Update Feed Post</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 UTHM Tigris E-Sports Website</p>
    </footer>

    <script src="../js/script.js"></script>
</body>
</html>
