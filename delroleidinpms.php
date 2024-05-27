<?php
// Include database configuration file
require_once 'dbConfig.php';


if(isset($_GET['employeeId']) && isset($_GET['roleId'])) {

    $employeeId = $_GET['employeeId'];
    $roleId = $_GET['roleId'];

    // Prepare and execute deletion query
    $stmt = $conn->prepare("DELETE FROM employee_role WHERE employeeId = :employeeId AND roleId = :roleId");
    $stmt->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
    $stmt->bindParam(':roleId', $roleId, PDO::PARAM_INT);
    $stmt->execute();

  
    header("Location: editPermission.php?employeeId=$employeeId");
    exit();
}
?>
