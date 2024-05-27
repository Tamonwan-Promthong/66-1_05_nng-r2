<?php
// Include database configuration
require_once 'dbConfig.php';

// Check if form data is provided
if(isset($_POST['orderId'], $_POST['cancleId'], $_POST['bankId'], $_POST['accountNum'], $_POST['refundDetail'],$_FILES['slipRefund'])) {
    $orderId = $_POST['orderId'];
    $cancleId = $_POST['cancleId'];
    $bankId = $_POST['bankId'];
    $accountNum = $_POST['accountNum'];
    $refundDetail = $_POST['refundDetail'];

    
    if (!empty($_FILES['slipRefund']['tmp_name']) && file_exists($_FILES['slipRefund']['tmp_name'])) {
        $slipRefund = $_FILES['slipRefund']['tmp_name']; 
        $imgContent = file_get_contents($slipRefund); 

       

        $statusId = 9;

      
        $stmt = $conn->prepare("INSERT INTO refundorder (orderId, cancleId, bankId, accountNum, refundDetail, slipRefund, statusId) VALUES (:orderId, :cancleId, :bankId, :accountNum, :refundDetail, :slipRefund, :statusId)");
        $stmt->bindParam(':orderId', $orderId);
        $stmt->bindParam(':cancleId', $cancleId);
        $stmt->bindParam(':bankId', $bankId);
        $stmt->bindParam(':accountNum', $accountNum);
        $stmt->bindParam(':refundDetail', $refundDetail);
        $stmt->bindParam(':slipRefund', $imgContent, PDO::PARAM_LOB); 
        $stmt->bindParam(':statusId', $statusId);

        // Execute the statement
        if ($stmt->execute()) {
           
            $updateStmt = $conn->prepare("UPDATE orders SET statusId = :statusId WHERE orderId = :orderId");
            $updateStmt->bindParam(':statusId', $statusId);
            $updateStmt->bindParam(':orderId', $orderId);
            $updateStmt->execute();
            $returnStockStmt = $conn->prepare("UPDATE product p
                                   JOIN orders_detail od ON p.productId = od.productId
                                   SET p.stock = p.stock + od.qty,
                                       p.stockpoint = p.stockpoint + od.qty
                                   WHERE od.orderId = :orderId");

                            $returnStockStmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
                            $returnStockResult = $returnStockStmt->execute();
        } else {
            echo "Error ";
        }
    } 
    header("Location: listBuying1.php");
}
?>
