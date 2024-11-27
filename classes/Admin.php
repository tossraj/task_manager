<?php
class Admin {
    private $db;

    public function __construct() {
        global $sisdb;
        $this->db = $sisdb;
    }

    public function user_login($username, $password) {
        $query = "SELECT id FROM `admin` WHERE username= ? AND password= ? ";
        $admin_user = $this->db->getSingleRow($query, [$username, $password]);
        if(isset($admin_user['id'])) {
            $_SESSION['admin_username'] = $username;
            $_SESSION['admin_id'] = $admin_user['id'];
            return true;
        } else {
            return false;
        }
    }

    public function createUser($firstName, $lastName, $email, $phone, $autoGeneratePassword = true) {
        $password = $autoGeneratePassword ? $this->generateRandomPassword() : 'default_password'; 
        $hashedPassword = md5($password); 
        
        $user_data = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'password' => $hashedPassword,
            'last_login' => date('Y-m-d H:i:s'),
            'last_password_change' => null
        ];
        
        $insert_user = $this->db->createWithArray('users', $user_data);
    
        if ($insert_user) {
            return ['success' => true, 'password' => $password];  
        } else {
            return ['success' => false, 'error' => 'Failed to create user.'];
        }
    }
    
    // Helper method to generate a random password
    private function generateRandomPassword($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $password;
    }

    public function getAllUsers() {
        $query = "SELECT id, first_name, last_name, email, phone FROM users";
        $result = $this->db->getMultipleRows($query);
        return $result;
    }

    public function getAllTasks() {
        $query = "SELECT tasks.*, users.id as uid, CONCAT(users.first_name, users.last_name) as username FROM `tasks` LEFT JOIN users ON users.id = tasks.user_id; ";
        $result = $this->db->getMultipleRows($query);
        return $result;
    }

    // Download task report as CSV
    public function downloadReport() {
        $query = "SELECT start_time, stop_time, notes, description FROM tasks";
        $stmt = $this->db->getMultipleRows($query);
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="tasks_report.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        $file = fopen('php://output', 'w');
        
        fputcsv($file, ['Start Time', 'Stop Time', 'Notes', 'Description']);
        
        foreach ($stmt as $task) {
            fputcsv($file, $task);
        }

        fclose($file);        
        exit();
    }
    
}
?>
