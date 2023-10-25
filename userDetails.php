<?php
session_start();

// Include the header and navigation bar menu
include 'header.php';
include 'menu.php';
?>


<!-- Division for the sidebar and the content -->
<div class="wrapper">
  <div class="container-fluid content-wrapper">
    <!-- EMPTY SPACE LEFT -->
    <div class="row">
      <div class="col-md-1 text-light">
        <!-- Empty space -->
      </div>

      <!-- *************************************  SIDEBAR ************************************* -->
      <?php
      // Include the sidebar
      if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        include 'sidebarLogged.php';
      } else {
        include 'sidebarLogin.php';
      }
      ?>

      <!-- CONTENT -->
      <div class="col-md-6">
        <!-- Content Panel -->
        <h1 class="text-center mb-3">User Information</h1>

<?php
// Get the username from the GET parameters
if (isset($_GET['username'])) {
  $username = $_GET['username'];
  $filename = "users/" . $username . ".txt";
  $avatarDirectory = "avatars/";

  if (file_exists($filename)) {
    $userInfo = file_get_contents($filename);
    $lines = explode("\n", $userInfo);

    foreach ($lines as $line) {
      // Skip the line containing the password
      if (strpos($line, 'Password:') !== false) {
        continue;
      }
      echo "<p class='text-center user-details'>$line</p>";
    }

    // Get the avatar filename without extension
    $avatarFilename = pathinfo($username, PATHINFO_FILENAME);
    // Construct the full path to the avatar file
    $avatarPath = $avatarDirectory . $avatarFilename;

    // Display the avatar image
    echo "<br>";
    echo "<h4 class='text-center'>User's avatar: </h4><br>";
    echo "<div style='display: flex; justify-content: center; align-items: center;'>
        <img src='$avatarPath' style='width: 200px; height: auto;' alt='Avatar' class='avatar'>
      </div>";

  } else {
    echo "User not found.";
  }
} else {
  echo "No user selected.";
}
?>

  
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>