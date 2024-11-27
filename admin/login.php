<?php
include_once('../classes/init.php');

// Handle login
if(isset($_POST['username']) && isset($_POST['password'])) {
  $login = $admin->user_login($_POST['username'], $_POST['password']);
  if($login) {
    header('location: '.SITEURL.'admin/dashboard.php');
    exit;
  } else {
    header('location: '.SITEURL.'admin/login.php');
    $_SESSION['err_msg'] = "Login credentials are invalid.";
  }
  exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page with See Password Eye</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Optional: Font Awesome for the eye icon -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h3 class="card-title text-center mb-4">Admin Login</h3>
            <?php msg(); ?> <!-- Display error message here -->
            <form action="" method="POST"> <!-- Corrected the action attribute -->
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
              </div>
              <div class="mb-3 position-relative">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                <i class="fas fa-eye position-absolute top-50 end-0 translate-middle-y pe-3" id="togglePassword" style="cursor: pointer;"></i>
              </div>
              <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap 5 JS, Popper.js, and Font Awesome -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

  <!-- JavaScript for password toggle -->
  <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
     
      const type = passwordField.type === 'password' ? 'text' : 'password';
      passwordField.type = type;

     
      this.classList.toggle('fa-eye-slash');
    });
  </script>
</body>

</html>
