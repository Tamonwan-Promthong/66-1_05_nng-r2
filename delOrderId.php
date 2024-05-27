<?php

require_once 'dbConfig.php';


if(isset($_GET['id'])) {

    $orderId = $_GET['id'];

   
    $stmt = $conn->prepare("DELETE FROM orders_detail WHERE orderId = :orderId");
    $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $stmt->execute();


    $stmt = $conn->prepare("DELETE FROM orders WHERE orderId = :orderId");
    $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $stmt->execute();


    header("Location: listBuying1.php"); 
    exit();
} else {
    header("Location: error.php"); 
    exit();
}
?>
