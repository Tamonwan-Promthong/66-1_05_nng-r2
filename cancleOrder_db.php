<?php
// Include database configuration
require_once 'dbConfig.php';

// Check if form data is provided
if(isset($_POST['orderId'], $_POST['cancleId'], $_POST['cancleDetail'])) {
    $orderId = $_POST['orderId'];
    $cancleId = $_POST['cancleId'];
    $cancleDetail = $_POST['cancleDetail'];

    
    $stmt = $conn->prepare("INSERT INTO cancleorder (orderId, cancleId, cancleDetail) VALUES (:orderId, :cancleId, :cancleDetail)");

    $stmt->bindParam(':cancleId', $cancleId, PDO::PARAM_INT);
    $stmt->bindParam(':cancleDetail', $cancleDetail, PDO::PARAM_STR);
    $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);

    $result = $stmt->execute();

    // Check if insert was successful
    if($result) {
        // Update statusId in the orders table to 6
        $updateStmt = $conn->prepare("UPDATE orders SET statusId = 6 WHERE orderId = :orderId");
        $updateStmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        $updateResult = $updateStmt->execute();

        if($updateResult) {
            // Return stock of products
            $returnStockStmt = $conn->prepare("UPDATE product p
                                   JOIN orders_detail od ON p.productId = od.productId
                                   SET p.stock = p.stock + od.qty,
                                       p.stockpoint = p.stockpoint + od.qty
                                   WHERE od.orderId = :orderId");

                            $returnStockStmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
                            $returnStockResult = $returnStockStmt->execute();

            if($returnStockResult) {
                echo "Cancellation successful. Status updated to 6. Stock returned.";
            } else {
                echo "successful. Status updated to 6, failed to return stock.";
            }
        } else {
            echo " successful, failed to update status.";
        }
    } else {
        echo "failed.";
    }
} else {
    echo "Form data not provided.";
}
header("location: listBuying1.php");
?>
