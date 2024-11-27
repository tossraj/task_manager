<?php
class User
{
    private $db;

    public function __construct()
    {
        global $sisdb;
        $this->db = $sisdb;
    }

    // User login functionality
    public function user_login($email, $password)
    {
        $query = "SELECT id, first_name, last_name, email, password, last_login, last_password_change FROM users WHERE email = ? AND password= ? ";
        $user = $this->db->getSingleRow($query, [$email, md5($password)]);

        if (isset($user['id'])) {

            $current_time = new DateTime();
            $last_password_change = new DateTime($user['last_password_change']);
            $interval = $current_time->diff($last_password_change);

            if ($user['last_password_change'] == NULL || $interval->days >= 30) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['update_password'] = true;
                $_SESSION['err_msg'] = "Please change your password, as it's either your first login or your password hasn't been updated in 30 days.";
                header('Location: ' . SITEURL . 'change_password.php');
                exit;
            }

            $update_login_query = "UPDATE users SET last_login = NOW() WHERE id = ?";
            $this->db->update($update_login_query, [$user['id']]);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];

            return true;
        } else {
            return false;
        }
    }

    // Change user's password by user_id
    public function changePassword($userId, $newPassword)
    {
        $hashedPassword = md5($newPassword);
        $query = "UPDATE users SET password = ?, last_password_change = NOW() WHERE id = ?";

        $this->db->update($query, [$hashedPassword, $userId]);

        $_SESSION['err_msg'] = "Password updated successfully!";
        unset($_SESSION['update_password']);
        header('Location: ' . SITEURL . 'dashboard.php');
        exit;
    }

    public function createTask($user_id, $start_time, $stop_time, $notes, $description)
    {
        $taskData = [
            'user_id' => $user_id,
            'start_time' => $start_time,
            'stop_time' => $stop_time,
            'notes' => $notes,
            'description' => $description
        ];

        return $this->db->createWithArray('tasks', $taskData) ? true : false;
    }

    public function getAllTasks() {
        $query = "SELECT * FROM tasks WHERE user_id= ? ";
        $result = $this->db->getMultipleRows($query, [$_SESSION['user_id']]);
        return $result;
    }
}
