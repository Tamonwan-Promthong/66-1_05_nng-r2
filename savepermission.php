<?php
// Database connection
require_once 'dbConfig.php';

// Function to generate a random employee code
function generateEmployeeCode($prefix = 'EMP', $length = 6) {
    $characters = '0123456789';
    $max = strlen($characters) - 1;
    $code = $prefix;

    // Generate random numbers for the rest of the code
    for ($i = strlen($prefix); $i < $length; $i++) {
        $code .= $characters[random_int(0, $max)];
    }

    return $code;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $employeeName = $_POST["employeeName"];
    $roles = isset($_POST["roles"]) ? $_POST["roles"] : array(); 
    $telEmp = $_POST["telEmp"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  
    $employeeCode = generateEmployeeCode();

    $stmt = $conn->prepare("INSERT INTO user_account (name, email, username, password) VALUES (:name, :email, :username, :password)");
    $stmt->bindParam(':name', $employeeName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->execute();
    $userId = $conn->lastInsertId();
  
    echo "Generated Employee Code: $employeeCode";

    $stmt = $conn->prepare("INSERT INTO employee (employeeName, email, employeeCode, telEmp) VALUES (:employeeName, :email, :employeeCode, :telEmp)");
    $stmt->bindParam(':employeeName', $employeeName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':employeeCode', $employeeCode); 
    $stmt->bindParam(':telEmp', $telEmp); 
    $stmt->execute();
    $employeeId = $conn->lastInsertId(); 

 
    foreach ($roles as $roleId) {
        $stmt = $conn->prepare("INSERT INTO employee_role (employeeId, roleId) VALUES (:employeeId, :roleId)");
        $stmt->bindParam(':employeeId', $employeeId);
        $stmt->bindParam(':roleId', $roleId);
        $stmt->execute();
    }

    
	header("location:permission.php");
    exit();
}
?>
