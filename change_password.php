<?php
include_once('classes/init.php');

// Handle login
if (!isset($_SESSION['user_id'])) {
    header('location: ' . SITEURL . 'index.php');
    $_SESSION['err_msg'] = "Something went wrong";
    exit();
}

$userId = $_SESSION['user_id'];

// Check if the form is submitted
if (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Check if passwords match
    if ($newPassword !== $confirmPassword) {
        $_SESSION['err_msg'] = "Passwords do not match.";
        header('Location: ' . SITEURL . 'change_password.php');
        exit;
    }

    // Change the password
    $user->changePassword($userId, $newPassword);
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
            <div class="col-md-6 mx-auto">
                <h4>Hi, <?php echo $_SESSION['user_name']; ?></h4>
                <hr />
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Change Password</h3>
                        <?php
                        // Display error message if exists
                        if (isset($_SESSION['err_msg'])) {
                            echo '<div class="alert alert-warning">' . $_SESSION['err_msg'] . '</div>';
                            unset($_SESSION['err_msg']);
                        }
                        ?>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Update Password</button>
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

</body>

</html>