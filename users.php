<?php
session_start();

// Include the header and navigation bar menu
include 'header.php';
include 'menu.php';

$directory = "users/";
$usernames = array();

// Read all filenames in the "users" folder
if ($handle = opendir($directory)) {
  while (false !== ($entry = readdir($handle))) {
    if ($entry != "." && $entry != "..") {
      // Extract the username from the filename. For example "louis.txt" returns "louis"
      $username = pathinfo($entry, PATHINFO_FILENAME);
      $usernames[] = $username;
    }
  }
  closedir($handle);
}
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
        <h1 class="text-center mb-3">Users</h1>
        <?php
        // Display the usernames
        if (count($usernames) > 0) {
          echo "<ul>";
          foreach ($usernames as $username) {
            // Link each username to the userDetails.php page with the username as a GET parameter
            echo "<li class='username pe-4 mb-2 text-center'><a class='username' href='userDetails.php?username=$username'>$username</a></li>";
          }
          echo "</ul>";
        } else {
          echo "No users found.";
        }
        ?>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
