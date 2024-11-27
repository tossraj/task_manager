<?php
include_once('../classes/init.php');

// Handle login
if(!isset($_SESSION['admin_id'])) {
    header('location: '.SITEURL.'admin/login.php');
    $_SESSION['err_msg'] = "Something went wrong";
    exit();
}

if(isset($_GET['download_tasks'])) {
    $admin->downloadReport();
}

$tasks = $admin->getAllTasks();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page with See Password Eye</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">User List</h3>
                        
                        <?php
                        msg();
                        ?>

                        <!-- Button to Add New User -->
                        <div class="mb-3">
                            <a href="<?php echo SITEURL; ?>admin/task_list.php?download_tasks=true" class="btn btn-primary">Download All Tasks</a>
                        </div>

                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>User Name</th>
                                    <th>Notes</th>
                                    <th>Start Time</th>
                                    <th>Stop Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($tasks)): ?>
                                    <?php foreach ($tasks as $task): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($task['id']); ?></td>
                                            <td><?php echo htmlspecialchars($task['username']).' ('.$task['uid'].')'; ?></td>
                                            <td><?php echo htmlspecialchars($task['notes']); ?></td>
                                            <td><?php echo htmlspecialchars($task['start_time']); ?></td>
                                            <td><?php echo htmlspecialchars($task['stop_time']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No Tasks found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

</body>

</html>