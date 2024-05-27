<?php
// Include database configuration file
require_once 'dbConfig.php';

if(isset($_GET['employeeId'])) {
    
    $employeeId = $_GET['employeeId'];


    $stmt = $conn->prepare("DELETE FROM employee WHERE employeeId = :employeeId");
    $stmt->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
    $stmt->execute();

    // Then delete the order
    $stmt = $conn->prepare("DELETE FROM employee_role WHERE employeeId = :employeeId");
    $stmt->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
    $stmt->execute();


    header("Location: permission.php"); 
    exit();
} 
?>

