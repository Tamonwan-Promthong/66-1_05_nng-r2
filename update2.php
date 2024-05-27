<?php
require_once 'dbConfig.php';

if (isset($_POST['updateTracking'])) {
    if (!empty($_POST['orderCheckbox'])) {
        foreach ($_POST['orderCheckbox'] as $orderId) {
       
            $stmt = $conn->prepare("UPDATE orders SET statusId = 7 WHERE orderId = :orderId");
            $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
            $stmt->execute();
        }
        echo "Status updated successfully!";
    }



    header("Location: listBuying1.php");
    exit;
}
?>