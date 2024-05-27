<?php
// Start the session
session_start();

if(isset($_GET['orderId']) && isset($_GET['productId'])) {
  
    $orderId = $_GET['orderId'];
    $productId = $_GET['productId'];

    require_once 'dbConfig.php';

 
    $stmt = $conn->prepare("DELETE FROM orders_detail WHERE orderId = :orderId AND productId = :productId");
    $stmt->bindParam(':orderId', $orderId);
    $stmt->bindParam(':productId', $productId);
    $stmt->execute();

    header("Location: editBuying.php?id=$orderId");
    exit();
} else {
   
    header("Location: index.php");
    exit();
}
?>
