<?php
// Include the database connection file
include('../includes/db.php');
include('../includes/session.php');

// Check if the form is submitted for deletion
if (isset($_GET['delete_postID'])) {
    $delete_postID = $_GET['delete_postID'];

    // Delete the record from the 'posts' table
    $delete_sql = "DELETE FROM posts WHERE postID='$delete_postID'";
    $conn->query($delete_sql);
}

// Query to retrieve data from the 'posts' table
$sql = "SELECT * FROM posts";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/tigris_logo.png" type="icon">
    <title>Manage Feed Post - Admin</title>
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
        <h1>Manage Feed Posts</h1>

        <a href="create_feed_post.php" class="create-post-button">Create New Post</a>

        <table>
            <tr>
                <th>Post ID</th>
                <th>Post Title</th>
                <th>Post Date</th>
                <th>Form ID</th>
                <th>Bracket ID</th>
                <th>Schedule ID</th>
                <th>Action</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['postID'] . '</td>';
                    echo '<td>' . $row['postTitle'] . '</td>';
                    echo '<td>' . $row['postDate'] . '</td>';
                    echo '<td>' . $row['formID'] . '</td>';
                    echo '<td>' . $row['bracketID'] . '</td>';
                    echo '<td>' . $row['scheduleID'] . '</td>';
                    echo '<td>
                            <a href="edit_feed_post.php?edit_postID=' . $row['postID'] . '">Edit</a>
                            <a href="?delete_postID=' . $row['postID'] . '" onclick="return confirm(\'Are you sure?\')">Delete</a>
                          </td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="7">No feed posts found.</td></tr>';
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
