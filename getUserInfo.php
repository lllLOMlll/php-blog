<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $filename = "users/" . $username . ".txt";
    $avatarDirectory = "avatars/";

    if (file_exists($filename)) {
      $userInfo = file_get_contents($filename);
      $lines = explode("\n", $userInfo);

      foreach ($lines as $line) {
        // strpos() is a built-in PHP function used to find the position of the first occurrence of a substring within a string. It stands for "string position"
        if (strpos($line, 'Password:') !== false) {
          continue; // Skip the line containing the password
        }
        echo "<p class='black-and-red'>$line</p>";
      }

      // Get the avatar filename without extension
      $avatarFilename = pathinfo($username, PATHINFO_FILENAME);
      // Construct the full path to the avatar file
      $avatarPath = $avatarDirectory . $avatarFilename;

      // Display the avatar image
      echo "<img src='$avatarPath' style='width: 200px; height: auto;' alt='Avatar' class='avatar'>";
    } else {
      echo "User not found.";
    }
  }
}
?>

