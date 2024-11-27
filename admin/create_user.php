<?php
include_once('../classes/init.php');

if (!isset($_SESSION['admin_id'])) {
    header('location: ' . SITEURL . 'admin/login.php');
    $_SESSION['err_msg'] = "Something went wrong";
    exit();
}

if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['email']) && isset($_POST['phone'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $autoGeneratePassword = isset($_POST['autoGeneratePassword']) ? true : false;
    
    $result = $admin->createUser($firstName, $lastName, $email, $phone, $autoGeneratePassword);
    
    if ($result['success']) {  
        // we can send username and password to user using mail.
        $_SESSION['err_msg'] = "User created successfully. Generated Password: " . $result['password'];
        header('Location: ' . SITEURL . 'admin/user_list.php');  
        exit;
    } else {        
        $_SESSION['err_msg'] = $result['error'];
        header('Location: ' . SITEURL . 'admin/user.php');  
        exit;
    }
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
                    <a href="<?php echo SITEURL.'admin/dashboard.php'; ?>"><button type="button" class="list-group-item list-group-item-action">Dashboard</button></a>
                    <a href="<?php echo SITEURL.'admin/create_user.php'; ?>"><button type="button" class="list-group-item list-group-item-action">Create User</button></a>
                    <a href="<?php echo SITEURL.'admin/user_list.php'; ?>"><button type="button" class="list-group-item list-group-item-action">List User</button></a>
                    <a href="<?php echo SITEURL.'admin/task_list.php'; ?>"><button type="button" class="list-group-item list-group-item-action">Task List</button></a>
                    <a href="<?php echo SITEURL.'admin/logout.php'; ?>"><button type="button" class="list-group-item list-group-item-action">Logout</button></a>
                </div>
            </div>
            <div class="col-md-8">
                <h4>Hi, <?php echo $_SESSION['admin_username']; ?></h4>
                <hr />
                <div class="card shadow-sm">
                    <div class="card-body w-100">
                        <h3 class="card-title text-center mb-4">Create New Employee</h3>

                        <?php
                        echo msg();
                        ?>

                        <form action="create_user.php" method="POST">
                            <div class="mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter first name" required>
                            </div>
                            <div class="mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter last name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required>
                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="generatePassword" name="autoGeneratePassword" checked>
                                <label class="form-check-label" for="generatePassword">Auto-generate password</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Create User</button>
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