<?php
session_start();


// Include the header and navigation bar menu
include 'header.php';
include 'menu.php';

// Set the timezone to 'America/Montreal'
date_default_timezone_set('America/Montreal');

// Display the message after the profile is updated
if (isset($_GET['msg'], $_GET['msgType'])) {
  $message = htmlspecialchars($_GET['msg']);
  $messageType = htmlspecialchars($_GET['msgType']);
}

// Display a message after updating the password
if (isset($_SESSION['passwordChangeStatus'])) {
  echo "<script>alert('" . $_SESSION['passwordChangeStatus'] . "');</script>";
  unset($_SESSION['passwordChangeStatus']);
}


// Function to get and Display the post
function getPosts()
{
  $postDir = 'posts/';
  // Create an array of all the posts
  $dir = opendir($postDir);
  $postFiles = array();

  while (($file = readdir($dir)) !== false) {
    // "." and ".." = special entry. "." = current directory   ".." = parent directory
    if ($file !== "." && $file !== ".." && pathinfo($file, PATHINFO_EXTENSION) === 'txt') {
      $postFiles[] = $postDir . $file;
    }
  }
  closedir($dir);


  // Create an array of file paths and their modification times
  $files = [];
  foreach ($postFiles as $file) {
    $files[$file] = filemtime($file);
  }

  // Sort the files array by modification time in descending order
  arsort($files);

  // Get the sorted list of file paths
  $postFiles = array_keys($files);


  foreach ($postFiles as $postFile) {
    // Read the post data from the text file
    $postData = file_get_contents($postFile);

    // Extract the post details
    $lines = explode("\n", $postData);
    // Removing "Username" --> Replacing it by ""
    $username = trim(str_replace("Username:", "", $lines[0]));
    $title = trim(str_replace("Title:", "", $lines[1]));
    $body = trim(str_replace("Body:", "", $lines[2]));
    $imagePath = trim(str_replace("Image:", "", $lines[3]));
    // Get the file modification time
    $timestamp = filemtime($postFile); 

        // Display the post
    echo "<div>";
    echo "<h2><span style='color:green'>$title</span></h2>";
    echo "<p class='postby-post'>Posted by: <span style='color:green'>$username</span></p>";
    echo "<p class='date-post'>Posted at: " . "<span style='color:green'>" . date('Y-m-d H:i:s', $timestamp) . "</span></p>";
    echo "<p class='body-post'>$body</p>";
    echo "<div style='text-align:center;'><img src='./$imagePath' alt='post-image' style='width: 300px; height: auto;'></div>";


    echo "</div><hr>";
  }
}


// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  // Get the username and password from the form
  $username = $_POST['usernameLogin'];
  $password = $_POST['password'];

  // Check if the user exists and the password matches
  $filename = "users/" . $username . ".txt";
  if (file_exists($filename)) {
    $userInfo = file_get_contents($filename);
    // Split the user information into an array of lines
    $lines = explode("\n", $userInfo);

    // Extract the stored password from the user information
    $storedPassword = "";
    foreach ($lines as $line) {
      // strpos() function in PHP is used to find the position of the first occurrence of a substring in a string.
      if (strpos($line, "Password:") !== false) {
        $storedPassword = trim(str_replace("Password:", "", $line));
        break;
      }
    }

    // Verify the password
    if (password_verify($password, $storedPassword)) {
      // Password matches, start the session
      $_SESSION['loggedin'] = true;
      $_SESSION['username'] = $username;
      // Redirect to the logged-in page or perform any other desired actions
      header("Location: index.php");
      exit();
    } else {
      // Password doesn't match
      echo "<script>alert('Invalid username or password. Please try again.');</script>";
    }
  } else {
    // User doesn't exist
    echo "<script>alert('Invalid username or password. Please try again.');</script>";
  }
}

// Display the message after registration
if (isset($_SESSION['message'])) {
  echo "<script>alert('{$_SESSION['message']}');</script>";
  // Unset the error message so it doesn't keep showing up on refresh
  unset($_SESSION['message']);
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
        <!-- Posts blog -->
        <h1 class="text-center mg-3">Post</h1>
        <div class="ms-5">
          <!-- Display message after updating profile -->
          <?php if (isset($message, $messageType)): ?>
            <script>
              alert("<?php echo $messageType . ': ' . $message; ?>");
            </script>
          <?php endif; ?>
          <?php
          // Display the list of posts
          getPosts();
          ?>
        </div>
      </div>

      <!-- EMPTY SPACE RIGHT -->
      <div class="col-md-1 text-light">
        <!-- Empty space -->
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>
