<?php
session_start();

// Read the username from the form submission
$username = $_POST['username'];

// Specify the directory where the files will be saved
$directoryUser = "users/";
$directoryAvatar = "avatars/";

// Create the filename for the user data
$filename = $directoryUser . $username . ".txt";

// Check if the username is already taken
if (file_exists($filename)) {
    // The username is not unique
    $_SESSION['message'] = "The username is already taken. Please choose another one.";
    header("Location: registration.php");
    exit();
} else {
    // Write the form data to the file
    $file = fopen($filename, "w") or die("Unable to open file!");
    fwrite($file, "Gender: " . $_POST['gender'] . "\n");
    fwrite($file, "First Name: " . $_POST['fname'] . "\n");
    fwrite($file, "Last Name: " . $_POST['lname'] . "\n");
    fwrite($file, "Age: " . $_POST['age'] . "\n");
    fwrite($file, "Username: " . $username . "\n");
    fwrite($file, "Password: " . password_hash($_POST['password'], PASSWORD_DEFAULT) . "\n");

    fclose($file);

    // Process the uploaded image
    $imageFile = $_FILES['image']['tmp_name'];
    $imageExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $avatarFilename = $directoryAvatar . $username . '.' . $imageExtension;
    move_uploaded_file($imageFile, $avatarFilename);

    $_SESSION['message'] = "Your registration was successful! Please Login.";
    header("Location: index.php");
    exit();
}

// If there's an error message, display it
if (isset($_SESSION['message'])) {
    echo "<script>alert('{$_SESSION['error']}');</script>";
    // Unset the error message so it doesn't keep showing up on refresh
    unset($_SESSION['message']);
}



?>
