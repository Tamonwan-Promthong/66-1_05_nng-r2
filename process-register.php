<?php
session_start();
require('dbConfig.php');
$error = array();

// Function to generate a random employee code
function generateEmployeeCode($prefix = 'EMP', $length = 6) {
    $characters = '0123456789';
    $max = strlen($characters) - 1;
    $code = $prefix;

   
    for ($i = strlen($prefix); $i < $length; $i++) {
        $code .= $characters[random_int(0, $max)];
    }

    return $code;
}

if (isset($_POST['reg-user'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    if ($password1 != $password2) {
        array_push($error, "The two passwords do not match");
    }

 
    $stmt = $conn->prepare("SELECT * FROM user_account WHERE username = :username OR email = :email");
    $stmt->execute(array(':username' => $username, ':email' => $email));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        if ($result['username'] === $username) {
            array_push($error, "Username already exists");
        }
        if ($result['email'] === $email) {
            array_push($error, "Email already exists");
        }
    }

    if (count($error) == 0) {
        $password = password_hash($password1, PASSWORD_DEFAULT);

   
        $employeeCode = generateEmployeeCode();


        $stmt = $conn->prepare("INSERT INTO employee (employeeCode, employeeName, email) VALUES (:employeeCode, :employeeName, :email)");
        $stmt->execute(array(':employeeCode' => $employeeCode, ':employeeName' => $name, ':email' => $email));
        
    
        $employeeId = $conn->lastInsertId();
      
 
        $roleId = 1; 
        $stmt = $conn->prepare("INSERT INTO employee_role (employeeId, roleId) VALUES (:employeeId, :roleId)");
        $stmt->execute(array(':employeeId' => $employeeId, ':roleId' => $roleId));

        $stmt = $conn->prepare("INSERT INTO user_account (employeeId, name, username, email, password) VALUES (:employeeId, :name, :username, :email, :password)");
        $stmt->execute(array(':employeeId' => $employeeId, ':name' => $name, ':username' => $username, ':email' => $email, ':password' => $password));
      
        $_SESSION['username'] = $username;
    
        // $_SESSION['success'] = "";
        header('Location: login.php');
        exit();
    }
}
?>
