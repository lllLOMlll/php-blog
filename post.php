<?php
session_start();

// Set the timezone to 'America/Montreal'
date_default_timezone_set('America/Montreal');

// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit();
}

// Include the header and navigation bar menu
include 'header.php';
include 'menu.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Get the submitted data
    $title = $_POST['title'];
    $body = $_POST['post'];
    $image = $_FILES['image'];

    // Check if image file is uploaded
    // UPLOAD_ERR_OK = upload with success [0]
    if ($image['error'] === UPLOAD_ERR_OK) {
        // Specify the destination directory for the image
        $imageDir = 'posts/images/';

        // Get the extension of the uploaded file
        $imageExtension = pathinfo($image['name'], PATHINFO_EXTENSION);

        // Change the filename to time.extension
        $newImageName = time() . '.' . $imageExtension;
        $imagePath = $imageDir . $newImageName;

        // Move the uploaded image to the destination directory
        // tmp_name =  a temporary location where PHP stores the file that has been uploaded by the user (before knowing what to do with the file)
        move_uploaded_file($image['tmp_name'], $imagePath);

        // Save the post data in a text file
        $postData = "Username: " . $_SESSION['username'] . "\n";
        $postData .= "Title: $title\n";
        $postData .= "Body: $body\n";
        $postData .= "Image: $imagePath\n";

        // Specify the destination directory for the text file
        $postDir = 'posts/';
        $postFilename = $postDir . $_SESSION['username'] . '_' . time() . '.txt';

        // Save the post data to the text file
        file_put_contents($postFilename, $postData);

        // Redirect back to index.php
        header('Location: index.php');
        exit();
    } else {
        echo "<script>alert('Error uploading image. Please try again.');</script>";
    }
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
             <h1 class="mb-3">Shout Out</h1>

             <div>
                <form method="post" action="post.php" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <div class="inputs">
                        <!-- Title -->
                        <label class="label-font mb-1">Title</label>
                        <br>
                        <input class="input-width" type="text" name="title" id="title">
                        <br>
                        <br>
                        <!-- Post -->
                        <label class="label-font mb-1">Express yourself!</label>
                        <br>
                        <textarea class="input-width input-height" name="post" id="post"></textarea>
                        <br>
                        <br>
                        <!-- Image -->
                        <label class="label-font mb-1" for="image">Select an image to upload:</label>
                        <br>
                        <input type="file" name="image" id="image">
                        <br>
                        <br>
                        <!-- Preview of the image -->
                        <script>
                        document.getElementById('image').addEventListener('change', function(event) {
                            var reader = new FileReader();

                            reader.onload = function(e) {
                                document.getElementById('imagePreview').style.display = 'block';
                                document.getElementById('imagePreview').src = e.target.result;
                            }

                            reader.readAsDataURL(event.target.files[0]);
                        });

                        </script>
                        <img id="imagePreview" src="#" alt="Image Preview" style="display: none; width: 300px; height: auto;" />
                        <br>
                        <input class="custom-button" type="submit" name="submit">
                        <!-- Getting the type of message: error or success. It's for the class="" style.css -->
                        <span class="<?= isset($_GET['msgType']) ? $_GET['msgType'] : "" ?>">
                            <?= isset($_GET['msg']) ? $_GET['msg'] : "" ?>
                        </span>
                        <br>
                        <br>
                    </div>
                </form>
            </div>

            <script>
                function validateForm() {
                    var title = document.getElementById('title').value;
                    var post = document.getElementById('post').value;
                    var image = document.getElementById('image').value;

                    if (title === "") {
                        alert('Title is required.');
                        return false;
                    }

                    if (post === "") {
                        alert('Post body is required.');
                        return false;
                    }

                    if (image === "") {
                        alert('Image is required.');
                        return false;
                    }

        // If everything is filled out, return true to submit the form
                    return true;
                }
            </script>
            <!-- EMPTY SPACE RIGHT -->
            <div class="col-md-1 text-light">
                <!-- Empty space -->
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
