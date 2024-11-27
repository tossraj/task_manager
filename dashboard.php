<?php
include_once('classes/init.php');

// Handle login
if(!isset($_SESSION['user_id'])) {
    header('location: '.SITEURL.'index.php');
    $_SESSION['err_msg'] = "Something went wrong";
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
      <div class="col-md-4">
        <div class="list-group">
            <a href="<?php echo SITEURL.'dashboard.php'; ?>"><button type="button" class="list-group-item list-group-item-action">Dashboard</button></a>
            <a href="<?php echo SITEURL.'submit_task.php'; ?>"><button type="button" class="list-group-item list-group-item-action">Submit Task</button></a>
            <a href="<?php echo SITEURL.'task_list.php'; ?>"><button type="button" class="list-group-item list-group-item-action">Task List</button></a>
            <a href="<?php echo SITEURL.'logout.php'; ?>"><button type="button" class="list-group-item list-group-item-action">Logout</button></a>
        </div>
      </div>
      <div class="col-md-8">
        <h4>Hi, <?php echo $_SESSION['user_name']; ?></h4>
        <hr / >
        Coming Soon ...
      </div>
    </div>
  </div>
  <!-- Bootstrap 5 JS, Popper.js, and Font Awesome -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

</body>

</html>
