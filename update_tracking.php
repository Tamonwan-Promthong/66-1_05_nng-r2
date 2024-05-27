<?php
require_once 'dbConfig.php';

if (isset($_POST['updateTracking'])) {

    if (!empty($_POST['orderCheckbox']) && !empty($_POST['trackingNum'])) {
    
        foreach ($_POST['orderCheckbox'] as $orderId) {
        
            $trackingNum = $_POST['trackingNum'][$orderId];
            
        
            $statusId = 8; 
            $stmt = $conn->prepare("UPDATE orders SET trackingNum = :trackingNum, statusId = :statusId WHERE orderId = :orderId");
            $stmt->bindParam(':trackingNum', $trackingNum, PDO::PARAM_STR);
            $stmt->bindParam(':statusId', $statusId, PDO::PARAM_INT);
            $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
            $stmt->execute();
        }
        
        // header('Location: some_page.php');
        // exit;
        echo "Tracking numbers and status updated successfully!";
    } else {
        echo "No orders selected or tracking numbers provided!";
    }

    header("Location: listBuying1.php");
}
?>
