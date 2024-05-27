<?php
require_once 'dbConfig.php';

if(isset($_POST['categoryName'])) {
    $categoryName = $_POST['categoryName'];
    $stmt = $conn->prepare("INSERT INTO category (categoryName) 
                            VALUES (:categoryName)");

    $stmt->bindParam(':categoryName', $categoryName, PDO::PARAM_STR);
   

    $result = $stmt->execute();

    $conn = null; // close database connection
    header("Location: addProduct.php");
}
?>