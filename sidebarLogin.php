<div class="col-md-2 bg-dark text-light">
  <h3 class="my-3 mx-2">Member Login</h3>
  <form method="POST" action="#">
    <!-- Username -->
    <label class="mx-2 mb-1" for="usernameLogin"><strong>Username:</strong></label>
    <br>
    <input class="mx-2 input-width" name="usernameLogin" type="text" id="usernameLogin" />
    <br>
    <br>
    <!-- Password -->
    <label class="mx-2 mb-1" for="passwordLogin"><strong>Password:</strong></label>
    <br>
    <input class="mx-2 input-width" name="password" type="password" id="passwordLogin" />
    <br>
    <br>
    <!-- BUTTONS -->
    <!-- Login -->
    <div class="my-3 mb-4">
      <!-- Login Button -->
      <input class="mx-2 custom-button" type="submit" name="submit" id="submit" value="Login">
      <br>
      <br>
      <!-- Register Button -->
      <a href="registration.php">
        <input class="mx-2 custom-button" type="button" name="register" id="register" value="Register">
      </a>
    </div>
  </form>
</div>
