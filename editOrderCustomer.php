<?php
session_start();
// Include database configuration
require_once 'dbConfig.php';

if(isset($_POST['orderId'])) {
 
    $orderId = $_POST['orderId'];
    $nameCustomer = $_POST['nameCustomer'];
    $tel = $_POST['tel'];
    $addrCustomer = $_POST['addrCustomer'];
    $email = $_POST['e-mail'];
 
    $totalAmount = $_POST['total'];

 
    if(isset($_SESSION["intLine"])) {
        $intLine = (int)$_SESSION["intLine"];
    } else {
        $intLine = 0; 
    }

    // File upload handling
    if(isset($_FILES['slipimg']) && $_FILES['slipimg']['error'] === UPLOAD_ERR_OK) {

        $slipimg = file_get_contents($_FILES['slipimg']['tmp_name']);

        $stmt = $conn->prepare("UPDATE orders SET statusId = 2, slipimg = :slipimg WHERE orderId = :orderId");
        $stmt->bindParam(':slipimg', $slipimg);
        $stmt->bindParam(':orderId', $orderId);
        $stmt->execute();
    
        // Update product stock
        for ($i = 0; $i <= $intLine; $i++) {
            if (isset($_SESSION["strProductID"][$i]) && $_SESSION["strProductID"][$i] != "") {
                $productId = $_SESSION["strProductID"][$i];
                $qty = $_SESSION["strQty"][$i];
    
                $updateStockStmt = $conn->prepare("UPDATE product SET stock = stock - :qty WHERE productId = :productId");
                $updateStockStmt->bindParam(':qty', $qty);
                $updateStockStmt->bindParam(':productId', $productId);
                $updateStockStmt->execute();
            }
        }
    } else {

        $stmt = $conn->prepare("SELECT slipimg FROM orders WHERE orderId = :orderId");
        $stmt->bindParam(':orderId', $orderId);
        $stmt->execute();
        $existingSlip = $stmt->fetch(PDO::FETCH_ASSOC);
        $slipimg = $existingSlip['slipimg'];
    }
    


    $stmt = $conn->prepare("UPDATE orders SET nameCustomer = :nameCustomer, tel = :tel, addrCustomer = :addrCustomer, email = :email, slipimg = :slipimg, totalAmount = :totalAmount WHERE orderId = :orderId");
    $stmt->bindParam(':nameCustomer', $nameCustomer, PDO::PARAM_STR);
    $stmt->bindParam(':tel', $tel, PDO::PARAM_STR);
    $stmt->bindParam(':addrCustomer', $addrCustomer, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':slipimg', $slipimg, PDO::PARAM_LOB); 
    $stmt->bindParam(':totalAmount', $totalAmount, PDO::PARAM_INT); 
    $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);

    $strOrderID = $orderId;
    echo  $strOrderID;
    for ($i = 0; $i <= $intLine; $i++) {
        if (isset($_SESSION["strProductID"][$i]) && $_SESSION["strProductID"][$i] != "") {
            $productId = $_SESSION["strProductID"][$i];
            $qty = $_SESSION["strQty"][$i];
    
            $stmtCheck = $conn->prepare("SELECT * FROM orders_detail WHERE orderId = :orderId AND productId = :productId");
            $stmtCheck->bindParam(':orderId', $strOrderID);
            $stmtCheck->bindParam(':productId', $productId);
            $stmtCheck->execute();
            $existingDetail = $stmtCheck->fetch(PDO::FETCH_ASSOC);
    
            if ($existingDetail) {
               
                $newQty = $existingDetail['qty'] + $qty; 
                $stmtUpdate = $conn->prepare("UPDATE orders_detail SET qty = :qty WHERE orderId = :orderId AND productId = :productId");
                $stmtUpdate->bindParam(':qty', $newQty);
                $stmtUpdate->bindParam(':orderId', $strOrderID);
                $stmtUpdate->bindParam(':productId', $productId);
                $stmtUpdate->execute();
            } else {
               
                $stmtInsert = $conn->prepare("INSERT INTO orders_detail (orderId, productId, qty, total_amount)
                                        VALUES (:orderId, :productId, :qty, :total_amount)");
                $stmtInsert->bindParam(':orderId', $strOrderID); 
                $stmtInsert->bindParam(':productId', $productId);
                $stmtInsert->bindParam(':qty', $qty);
                $stmtInsert->bindParam(':total_amount', $totalAmount); 
                $stmtInsert->execute();
            }
        }
    }

  
    $result = $stmt->execute();

    if($result) {
        echo "Update successful.";
        // header("Location: listBuying1.php");
    } else {
        echo "Update failed.";
    }

 

} else {
    echo "Order ID not provided.";
}
header("location: listBuying1.php");

// Close database connection
$conn = null;
?>
