<div class="col-md-2 bg-dark text-light">
 <h3 class="my-3 mx-2">Welcome Back, <span style="color: green;"><?php echo $_SESSION['username']; ?></span></h3>

 <!-- Display the user's avatar -->
 <?php
// Function to retrieve the number of posts for a user
 function getUserPostCount($username)
 {
  $postDir = 'posts/';
    // Create an array of all the posts
  $dir = opendir($postDir);
  $postFiles = array();

  while (($file = readdir($dir)) !== false) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'txt') {
      $postFiles[] = $postDir . $file;
    }
  }
  closedir($dir);


  $count = 0;
  foreach ($postFiles as $postFile) {
    $postData = file_get_contents($postFile);
    $lines = explode("\n", $postData);
    $postUsername = trim(str_replace("Username:", "", $lines[0]));
    if ($postUsername === $username) {
      $count++;
    }
  }

  return $count;
}


$avatarDirectory = "avatars/";
$extensions = ['jpg', 'png', 'jpeg', 'gif'];
$avatarFilename = "";

foreach ($extensions as $ext) {
  $tempFilename = $avatarDirectory . $_SESSION['username'] . '.' . $ext;
  if (file_exists($tempFilename)) {
    $avatarFilename = $tempFilename;
    break;
  }
}

if ($avatarFilename != "") {
  echo '<img src="' . $avatarFilename . '" class="ms-2" alt="User Avatar" style="width: 200px; height: 200px;">';
} else {
  echo '<p>No avatar found.</p>';
}

  // Display the number of posts for the logged-in user
$postCount = getUserPostCount($_SESSION['username']);
echo "<p>Number of posts: $postCount</p>";
?>

<form method="post" action="logout.php">
  <!-- BUTTONS -->
  <!-- Logout -->
  <div class="my-3 mb-4">
    <!-- Logout Button -->
    <input class="mx-2 custom-button" type="submit" name="logout" id="logout" value="Logout">
  </div>
</form>
</div>
