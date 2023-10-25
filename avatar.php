         <!-- Avatar -->
              <label class="label-font me-2 mb-1" for="image">Select an avatar to upload:</label>
              <br>
              <input type="file" name="image" id="image">
              <!-- Getting the type of message : error or success. It's for the class="" style.css -->
              <span class="<?= isset($_GET['msgType']) ? $_GET['msgType'] : "" ?>">
                <?= isset($_GET['msg']) ? $_GET['msg'] : "" ?>
              </span>
              <br>
              <br>
            </div>
            <!-- Displaying the image -->
            <?php if(isset($_GET['file'])) { ?>
              <img src="<?= $_GET['file'] ?>" alt="image">
            <?php } ?>

            <script>
// // Get the modal
// var modal = document.getElementById("confirmationModal");

// // Get the button that opens the modal
// var btn = document.getElementById("registrationForm");

// // Get the <span> element that closes the modal
// var span = document.getElementsByClassName("close")[0];

// // Get the OK button that closes the modal
// var okButton = document.getElementById("okButton");

// // Get the Cancel button that closes the modal
// var cancelButton = document.getElementById("cancelButton");

// // When the user clicks the button, open the modal 
// btn.addEventListener('submit', function(event) {
//     event.preventDefault();  // Prevent the form from being submitted
//     modal.style.display = "block";
// });

// // When the user clicks on <span> (x), close the modal
// span.onclick = function() {
//     modal.style.display = "none";
// }

// // When the user clicks on OK button, close the modal
// okButton.onclick = function() {
//     modal.style.display = "none";
// }

// // When the user clicks on Cancel button, close the modal
// cancelButton.onclick = function() {
//     modal.style.display = "none";
// }


</script>