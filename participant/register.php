<?php
include('../includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $participantID = $_POST['participantID'];
    $participantName = $_POST['participantName'];
    $participantEmail = $_POST['participantEmail'];
    $participantPW = $_POST['participantPW'];

    // Handle profile picture upload
    $targetDir = "../uploads/"; // Create a directory named 'uploads' in your project
    $targetFile = $targetDir . basename($_FILES["participantPic"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["participantPic"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $registrationError = "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        $registrationError = "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["participantPic"]["size"] > 500000) {
        $registrationError = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $registrationError = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $registrationError = "Sorry, your file was not uploaded.";
    } else {
        // If everything is ok, try to upload file
        if (move_uploaded_file($_FILES["participantPic"]["tmp_name"], $targetFile)) {
            // File uploaded successfully, continue with database insert
            $sql = "INSERT INTO participants (participantID, participantName, participantEmail, participantPic, participantPW) 
                    VALUES ('$participantID', '$participantName', '$participantEmail', '$targetFile', '$participantPW')";

            if ($conn->query($sql) === TRUE) {
                // Registration successful, you can redirect to login page or perform other actions
                echo '<script>alert("Registration successfull!"); window.location.href = "login.php";</script>';
                exit();
            } else {
                $registrationError = "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            $registrationError = "Sorry, there was an error uploading your file.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participant Registration</title>
    <link rel="stylesheet" href="../css/general_style.css">

    <script>
        function validatePassword() {
            var password = document.getElementById("participantPW").value;
            var confirmPassword = document.getElementById("confirmPassword").value;

            if (password !== confirmPassword) {
                alert("Passwords do not match");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>

    <header>
        <div class="logo-container">
            <img src="../img/tigris_logo.png" alt="Logo">
            <h1>UTHM Tigris E-Sports Website</h1>
        </div>
    </header>

    <main>
        <form action="register.php" method="post" class="form" enctype="multipart/form-data">
            <label for="participantID">Participant ID:</label>
            <input type="text" name="participantID" required>

            <label for="participantName">Full Name:</label>
            <input type="text" name="participantName" required>

            <label for="participantEmail">Email:</label>
            <input type="email" name="participantEmail" required>

            <label for="participantPic">Profile Picture:</label>
            <input type="file" name="participantPic" accept="image/*" required>

            <label for="participantPW">Password:</label>
            <input type="password" name="participantPW" required>

            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" name="confirmPassword" id="confirmPassword" required>

            <button type="submit">Register</button>

            <p>Already have an account? <a href="login.php">Login</a></p>
        </form>

        <?php
        if (isset($registrationError)) {
            echo '<p class="error">' . $registrationError . '</p>';
        }
        ?>

    </main>

    <footer>
        <p>&copy; 2024 UTHM Tigris E-Sports Website</p>
    </footer>

    <script src="../js/script.js"></script>
</body>
</html>
