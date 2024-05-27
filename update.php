<?php
require_once 'dbConfig.php';

if (isset($_POST['updateStatusBtn'])) {
  
    if (!empty($_POST['orderCheckbox'])) {
      
        foreach ($_POST['orderCheckbox'] as $orderId) {
          
            $stmt = $conn->prepare("UPDATE orders SET statusId = 7 WHERE orderId = :orderId");
            $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
            $stmt->execute();
        }
        
        // header('Location: some_page.php');
        // exit;
        echo "Status updated successfully!";
    } else {
        echo "No orders selected!";
    }
    header("Location: listBuying1.php");
}
?>
