<?php
session_start();

// Include the header and navigation bar menu
include 'header.php';
include 'menu.php';

// Display a message if the username already exist
if (isset($_SESSION['message'])) {
  echo "<script>alert('{$_SESSION['message']}');</script>";
    // Unset the error message so it doesn't keep showing up on refresh
  unset($_SESSION['message']);
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
      if (strpos($line, "Password:") !== false) {
        $storedPassword = trim(str_replace("Password:", "", $line));
        break;
      }
    }

    // Verify the password
    if (password_verify($password, $storedPassword)) {
      // Password matches, start the session
      $_SESSION['loggedin'] = true;
      // Set any other session data you want to store
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
     <div class="col-md-6 mx-5">
      <!-- Content Panel -->
      <h2 class="text-center">Registration</h2>
      <div class="container">
        <div class="row">
          <div class="">
            <form method="post" action="registerUser.php" enctype="multipart/form-data" id="registrationForm">
              <!-- Gender -->
              <div class="my-2">
                <label class="label-font me-2 mb-1" id="genderLabel">Gender:</label>
                <br>
                <div>
                  <input type="radio" name="gender" id="male" value="male" >
                  <label class="label-font me-3" for="male" >Male</label>
                  <input type="radio" name="gender" id="female" value="female" >
                  <label class="label-font" for="female">Female</label>
                </div>
                <br>

                <div>
                  <span></span>
                </div>

              </div>


              <!-- First Name -->
              <div class="my-2">
                <label class="label-font me-2 mb-1" for="fname">First Name:</label>
                <br>
                <input class="form-control mb-3" type="text" name="fname" id="fname" ><span></span>
              </div>


              <!-- Last Name -->
              <div class="my-2">
                <label class="label-font me-2 mb-1" for="lname">Last Name:</label>
                <br>
                <input class="form-control mb-3" type="text" name="lname" id="lname"><span></span>
              </div>

              <!-- Age -->
              <div class="my-2">
                <label class="label-font me-2 mb-1" for="age">Age:</label>
                <br>
                <input class="form-control mb-3" type="number" name="age" id="age"><span></span>
              </div>

              <!-- Username -->
              <div class="my-2">
                <label class="label-font me-2 mb-1" for="usernameRegistration">Username:</label>
                <br>
                <input class="form-control mb-3" type="text" name="username" id="usernameRegistration"><span></span>
              </div>

              <!-- Password -->
              <div class="my-2">
                <label class="label-font me-2 mb-1" for="password">Password:</label>
                <br>
                <input class="form-control mb-3" type="password" name="password" id="password"><span></span>
              </div>

              <!-- Confirm password -->
              <div class="my-2">
                <label class="label-font me-2 mb-1" for="passwordCnf">Password (confirmation):</label>
                <br>
                <input class="form-control mb-4" type="password" name="passwordCnf" id="passwordCnf"><span></span>
              </div>

              <!-- Avatar -->
              <label class="label-font me-2 mb-1" for="image">Select an avatar to upload:</label>
              <br>
              <input class="mb-3" type="file" name="image" id="image">
              <img id="preview" src="" alt="Image preview" style="display: none; width: 200px; height: auto">

              <script>
                document.getElementById('image').addEventListener('change', function(e) {
                 // Get the selected file
                  var file = e.target.files[0];

                 // Ensure it's an image with a .jpg, .jpeg, or .gif extension
                  if (file.type.match('image/jpeg') || file.type.match('image/jpg') || file.type.match('image/gif')) {
                 // Create a file reader
                    var reader = new FileReader();

                  // Set the image file as the source of the image preview
                    reader.onload = function(e) {
                      document.getElementById('preview').src = e.target.result;
                      document.getElementById('preview').style.display = 'block';
                    }

                  // Read the image file as a data URL
                    reader.readAsDataURL(file);
                  } else {
                    alert('Invalid file type. Please select an image file with a .jpg, .jpeg, or .gif extension.');
                  }
                });

              </script>


              <!-- Submit and Reset buttons -->
              <div class="my-4 text-center">
                <input class="mx-4 custom-button-big" type="submit" value="Submit" >
                <input class="mx-4 custom-button-big" type="reset" value="Reset"  id="reset">
                <script>
                  document.getElementById('reset').addEventListener('click', function() {
                    document.getElementById('preview').src = "";
                    document.getElementById('preview').style.display = 'none';
                  });
                </script>
                <button id="realSubmitButton" style="display:none;" type="submit">Submit</button>

              </div>
            </form>
          </div>
        </div>

      </div>

    </div>

    <!-- Confirmation Modal -->
    <!-- THE DISPLAY OF THE MODAL IS MANAGED BY MY CUSTOM.JS -->
    <div id="confirmationModal" class="modal">
      <!-- Modal content -->
      <div class="modal-content">
        <span class="close">X</span>
        <h2>Please confirm you registration</h2>
        <div id="modalContent"></div>
        <br>
        <button id="okButton" class="custom-button">OK</button>
        <br>
        <button id="cancelButton" class="custom-button">Cancel</button>
      </div>
    </div>

    <!-- EMPTY SPACE RIGHT -->
    <div class="col-md-1 text-light">
      <!-- Empty space -->
    </div>
  </div>


  <!-- FOOTER -->
</div>
<?php include 'footer.php'; ?>
</div>
