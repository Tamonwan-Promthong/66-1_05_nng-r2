<?php

require_once 'dbConfig.php';


if(isset($_POST['employeeId'])) {
    // Retrieve employeeId from POST data
    $employeeId = $_POST['employeeId'];
    
 
    $telEmP= $_POST['telEmP'];
 
    $email = $_POST['email'];
    $employeeName = $_POST['employeeName'];

 
    $stmt = $conn->prepare("UPDATE employee SET telEmp = :telEmp, email = :email, employeeName = :employeeName WHERE employeeId = :employeeId");
    $stmt->bindParam(':employeeId', $employeeId);
    $stmt->bindParam(':telEmp', $telEmP);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':employeeName', $employeeName);
    $stmt->execute();
    
  
    if(isset($_POST["roles"]) && is_array($_POST["roles"])) {
      
        foreach ($_POST["roles"] as $roleId) {
            $stmt = $conn->prepare("INSERT INTO employee_role (employeeId, roleId) VALUES (:employeeId, :roleId)");
            $stmt->bindParam(':employeeId', $employeeId);
            $stmt->bindParam(':roleId', $roleId);
            $stmt->execute();
        }
        echo "Roles updated successfully.";
    } else {
        echo "No roles selected.";
    }
    
  
    header("Location: permission.php");
    exit(); 
} else {
   
    exit("Employee ID is not provided.");
}
?>
