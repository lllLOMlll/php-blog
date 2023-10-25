$(document).ready(function() {
  let formIsValid = true;
  let isConfirmation = false;  // flag to track if form submission is a confirmation

  let modal = document.getElementById('confirmationModal');
  let okButton = document.getElementById('okButton');
  let cancelButton = document.getElementById('cancelButton');

  $('#registrationForm').submit(function(e) {
    // Bypass validation and modal if this is a confirmation submission
    if(isConfirmation) {
      isConfirmation = false;  // Reset flag
      return;
    }

    formIsValid = true;

    // Gender
    if (!$("input[name='gender']:checked").val()) {
      $('#genderError').remove();
      $('#genderLabel').after('<div id="genderError" style="color: red;">Please select a gender.</div>');
      formIsValid = false;
    } else {
      $('#genderError').remove();
    }

    // First Name
    let firstName = $("#fname").val();
    if (!firstName.match(/^[A-Za-z]+$/)) {
      $('#firstNameError').remove();
      $('label[for="fname"]').after('<div id="firstNameError" style="color: red;">Only letters are allowed.</div>');
      formIsValid = false;
    } else {
      $('#firstNameError').remove();
    }

    // Last Name
    let lastName = $("#lname").val();
    if (!lastName.match(/^[A-Za-z]+$/)) {
      $('#lastNameError').remove();
      $('label[for="lname"]').after('<div id="lastNameError" style="color: red;">Only letters are allowed.</div>');
      formIsValid = false;
    } else {
      $('#lastNameError').remove();
    }

    // Age
    let age = $("#age").val();
    if (age < 12 || age > 110) {
      $('#ageError').remove();
      $('label[for="age"]').after('<div id="ageError" style="color: red;">Age must be between 12 and 110.</div>');
      formIsValid = false;
    } else {
      $('#ageError').remove();
    }

  // Username
    let username = $("#usernameRegistration").val();
    if (username.length < 4 || username.length > 20 || /\s/.test(username)) {
      $('#usernameError').remove();
      $('label[for="usernameRegistration"]').after('<div id="usernameError" style="color: red;">Username must be between 4 and 20 characters long and should not contain spaces.</div>');
      formIsValid = false;
    } else {
      $('#usernameError').remove();
    }


    // Password
    let password = $("#password").val();
    if (!password.match(/^(?=.*[A-Z])(?=.*[\d])(?=.*[^\w\d\s:])([^\s]){8,}$/)) {
      $('#passwordError').remove();
      $('label[for="password"]').after('<div id="passwordError" style="color: red;">Password must have at least 8 characters, 1 uppercase letter, and 1 number or special character.</div>');
      formIsValid = false;
    } else {
      $('#passwordError').remove();
    }

    // Confirmation Password
    let confirm_password = $("#passwordCnf").val();
    if (password !== confirm_password) {
      $('#confirmPasswordError').remove();
      $('label[for="passwordCnf"]').after('<div id="confirmPasswordError" style="color: red;">Password confirmation does not match the password.</div>');
      formIsValid = false;
    } else {
      $('#confirmPasswordError').remove();
    }
    
    // Image Upload
    let image = $("#image").val();
    if (!image) {
      $('#imageError').remove();
      $('label[for="image"]').after('<div id="imageError" style="color: red;">Please upload an image.</div>');
      formIsValid = false;
    } else {
      $('#imageError').remove();
    }

    // Prevent form submission
    e.preventDefault();

    // If form is valid, show the modal
    if (formIsValid) {
      populateModal();
      modal.style.display = "block";
    }
  });

  okButton.onclick = function() {
    modal.style.display = "none";
    isConfirmation = true;  // Set flag to true
    $('#registrationForm').submit();
  };

  cancelButton.onclick = function() {
    modal.style.display = "none";
  };
});

function populateModal() {
  // Get the uploaded image
  let image = $("#image")[0].files[0];
  let imageUrl = URL.createObjectURL(image);

  // Populate modal with user's information and image
  $('#modalContent').html(
    '<p>Gender: ' + $("input[name='gender']:checked").val() + '</p>' +
    '<p>First Name: ' + $('#fname').val() + '</p>' +
    '<p>Last Name: ' + $('#lname').val() + '</p>' +
    '<p>Age: ' + $('#age').val() + '</p>' +
    '<p>Username: ' + $('#usernameRegistration').val() + '</p>' +
    '<img src="' + imageUrl + '" alt="Uploaded Image" style="width: 300px; height: auto;">'
    );
}

