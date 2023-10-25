<?php
session_start();

// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  echo "<script>alert('You must login to access that page');</script>";
  header('Location: index.php');
  exit();
}



// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  echo "<script>alert('You must login to access that page');</script>";
  header('Location: index.php');
  exit();
}

// Display the status of the password change
if (isset($_SESSION['passwordChangeStatus'])) {
  echo "<script>alert('" . $_SESSION['passwordChangeStatus'] . "');</script>";
  unset($_SESSION['passwordChangeStatus']);
}



// Display a message after updating the password
if (isset($_SESSION['passwordChangeStatus'])) {
  echo "<script>alert('" . $_SESSION['passwordChangeStatus'] . "');</script>";
  unset($_SESSION['passwordChangeStatus']);
}

// Include the header and navigation bar menu
include 'header.php';
include 'menu.php';

// User's text file
$username = $_SESSION['username']; // Make sure you store username in session when user logs in.
$filename = "users/" . $username . ".txt";
$avatarDirectory = "avatars/";

// Initialize user data
$userData = [
  'gender' => '',
  'firstName' => '',
  'lastName' => '',
  'age' => '',
  'avatar' => '',
];

if (file_exists($filename)) {
  $userInfo = file_get_contents($filename);
  $lines = explode("\n", $userInfo);

  foreach ($lines as $line) {
    if (strpos($line, 'Password:') !== false) {
      continue;
    }

    // Extract user data
    if (strpos($line, 'Gender:') !== false) {
      $userData['gender'] = trim(str_replace('Gender:', '', $line));
    } elseif (strpos($line, 'First Name:') !== false) {
      $userData['firstName'] = trim(str_replace('First Name:', '', $line));
    } elseif (strpos($line, 'Last Name:') !== false) {
      $userData['lastName'] = trim(str_replace('Last Name:', '', $line));
    } elseif (strpos($line, 'Age:') !== false) {
      $userData['age'] = trim(str_replace('Age:', '', $line));
    } elseif (strpos($line, 'Avatar:') !== false) {
      $userData['avatar'] = trim(str_replace('Avatar:', '', $line));
    }
  }
}

// Pre-fill the form fields
$genderMaleChecked = $userData['gender'] === 'Male' ? 'checked' : '';
$genderFemaleChecked = $userData['gender'] === 'Female' ? 'checked' : '';
?>

<div class="wrapper">
  <div class="container-fluid content-wrapper">
    <div class="row">
      <div class="col-md-1 text-light">
        <!-- Empty space -->
      </div>

      <?php
      if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        include 'sidebarLogged.php';
      } else {
        include 'sidebarLogin.php';
      }
      ?>

      <div class="col-md-6 mx-5">
        <h1 class="mb-3">Edit Profile Information</h1>
        <div>
          <form method="post" action="upload.php" enctype="multipart/form-data">
            <div class="inputs">
              <label class="label-font mb-1">Gender:</label>
              <br>
              <input type="radio" id="male" name="gender" value="Male" <?= $genderMaleChecked ?>>
              <label class="label-font mb-1" for="male">Male</label>
              <input type="radio" id="female" name="gender" value="Female" <?= $genderFemaleChecked ?>>
              <label class="label-font mb-1" for="female">Female</label>
              <br>
              <br>

              <label class="label-font mb-1">First Name</label>
              <br>
              <input class="input-width" type="text" name="firstName" value="<?= $userData['firstName'] ?>">
              <br>
              <br>

              <label class="mb-1">Last Name</label>
              <br>
              <input class="mb-1" type="text" name="lastName" value="<?= $userData['lastName'] ?>">
              <br>
              <br>

              <label class="label-font mb-1">Age</label>
              <br>
              <input class="mb-1" type="number" name="age" value="<?= $userData['age'] ?>">
              <br>
              <br>

              <label  class="label-font mb-1" for="image">Select an avatar to upload:</label>
              <br>
              <input type="file" name="avatar" id="avatar">
              <br>
              <br>

              <?php if ($userData['avatar'] !== '') { ?>
                <img src="<?= $avatarDirectory . $userData['avatar'] ?>" style="width: 200px; height: auto;" alt="Current Avatar">
              <?php } ?>

              <br>
              <br>
              <input  class="custom-button me-3" type="submit" name="saveProfile" value="Edit & Save">
              <button  class="custom-button me-3" type="button" id="changePasswordButton">Change Password</button>

              <span class="<?= isset($_GET['msgType']) ? $_GET['msgType'] : "" ?>">
                <?= isset($_GET['msg']) ? $_GET['msg'] : "" ?>
              </span>
              <br>
              <br>
            </div>
          </form>
        </div>
      </div>


      <div id="passwordChangeModal" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>
          <h2>Change Password</h2>
          <form method="POST" action="changePassword.php" id="changePasswordForm">
            <input type="hidden" name="username" value="<?= $username ?>">
            <label for="oldPassword">Old Password:</label>
            <input type="password" id="oldPassword" name="oldPassword" required>
            <br>
            <br>
            <label for="newPassword">New Password:</label>
            <input type="password" id="newPassword" name="newPassword" required>
            <br>
            <br>
            <label for="confirmPassword">Confirm New Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>
            <br>
            <br>
            <button class="custom-button" type="submit">Submit</button>
          </form>
        </div>
      </div>

      <script>
        // Get the modal
        var modal = document.getElementById('passwordChangeModal');

// Get the button that opens the modal
        var btn = document.getElementById('changePasswordButton');

// Get the <span> element that closes the modal
        var span = document.getElementsByClassName('close')[0];

// When the user clicks the button, open the modal
        btn.onclick = function() {
          modal.style.display = 'block';
        }

// When the user clicks on <span> (x), close the modal
        span.onclick = function() {
          modal.style.display = 'none';
        }

// When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
          if (event.target == modal) {
            modal.style.display = 'none';
          }
        }

        document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
          var oldPassword = document.getElementById('oldPassword').value;
          var newPassword = document.getElementById('newPassword').value;
          var confirmPassword = document.getElementById('confirmPassword').value;

          if (oldPassword !== newPassword && newPassword === confirmPassword) {
      // Passwords are valid, allow form submission
          } else {
            event.preventDefault();
            if (oldPassword === newPassword) {
              alert('New password must be different from old password.');
            } else if (newPassword !== confirmPassword) {
              alert('New password and confirmation password do not match.');
            }
          }
        });
      </script>

      <div class="col-md-1 text-light">
        <!-- Empty space -->
      </div>
    </div>
  </div>
  <?php include 'footer.php'; ?>
</div>
