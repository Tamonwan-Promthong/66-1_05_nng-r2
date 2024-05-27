<?php
session_start();
require_once 'dbConfig.php';
function generateOrderCode($prefix = 'OD', $length = 6) {

    $date = date('YmdHis'); 
    $characters = '0123456789';
    $max = strlen($characters) - 1;
    $code = $prefix . $date; 

    for ($i = strlen($code); $i < $length; $i++) {
        $code .= $characters[random_int(0, $max)];
    }

    return $code;
}
if(isset($_POST['nameCustomer']) && isset($_POST['addrCustomer']) && isset($_POST['tell']) && isset($_POST['e-mail']) && isset($_POST['total']) && isset($_FILES['slipimg'])) {
  
    $nameCustomer = $_POST['nameCustomer'];
    $addrCustomer = $_POST['addrCustomer']; 
    $tel = $_POST['tell'];
    $email = $_POST['e-mail']; 
    $totalAmount = $_POST['total']; 
    $orderCode = generateOrderCode();
  //check รูปสลิป
    if (!empty($_FILES['slipimg']['tmp_name']) && file_exists($_FILES['slipimg']['tmp_name'])) {
        $slipimg = $_FILES['slipimg']['tmp_name']; 
        $imgContent = file_get_contents($slipimg); 
        $statusId = 2; 
    } else {
        $imgContent = null; 
        $statusId = 1; 
    }

 
    $COD = ($_POST['gridRadios'] == 'option1') ? 'y' : 'n'; 
    $messenger = "J&T";

    
    $stmt = $conn->prepare("INSERT INTO orders (nameCustomer, addrCustomer, tel, email, statusId, slipimg, totalAmount, COD, orderCode, messenger) 
                            VALUES (:nameCustomer, :addrCustomer, :tel, :email, :statusId, :slipimg, :totalAmount, :COD, :orderCode, :messenger)");
    
    // Bind parameters
    $stmt->bindParam(':nameCustomer', $nameCustomer);
    $stmt->bindParam(':addrCustomer', $addrCustomer);
    $stmt->bindParam(':tel', $tel);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':statusId', $statusId); 
    $stmt->bindParam(':slipimg', $imgContent, PDO::PARAM_LOB); 
    $stmt->bindParam(':totalAmount', $totalAmount); 
    $stmt->bindParam(':COD', $COD); 
    $stmt->bindParam(':orderCode', $orderCode);
    $stmt->bindParam(':messenger', $messenger); 
    
        if ($stmt->execute()) {
            $strOrderID = $conn->lastInsertId();

            // If COD is y, change statusId to 2
            if ($COD == 'y') {
                $statusId = 2;
                $updateStatusStmt = $conn->prepare("UPDATE orders SET statusId = :statusId WHERE orderId = :orderId");
                $updateStatusStmt->bindParam(':statusId', $statusId);
                $updateStatusStmt->bindParam(':orderId', $strOrderID);
                $updateStatusStmt->execute();
            }

          
            for ($i = 0; $i <= (int)$_SESSION["intLine"]; $i++) {
                if ($_SESSION["strProductID"][$i] != "") {
                   
                    $stmtDetails = $conn->prepare("INSERT INTO orders_detail (orderId, productId, qty, total_amount)
                                            VALUES (:orderId, :productId, :qty, :total_amount)");
                    $stmtDetails->bindParam(':orderId', $strOrderID); 
                    $stmtDetails->bindParam(':productId', $_SESSION["strProductID"][$i]);
                    $stmtDetails->bindParam(':qty', $_SESSION["strQty"][$i]);
                    $stmtDetails->bindParam(':total_amount', $totalAmount); 
                    $stmtDetails->execute();
                    
            
                    if ($statusId == 2) {
                        $updateStockStmt = $conn->prepare("UPDATE product SET stock = stock - :qty WHERE productId = :productId");
                        $updateStockStmt->bindParam(':qty', $_SESSION["strQty"][$i]);
                        $updateStockStmt->bindParam(':productId', $_SESSION["strProductID"][$i]);
                        $updateStockStmt->execute();
                    }
                }
            }

            session_destroy();
            
            exit();
        } else {
        
            echo "Failed to execute the statement.";
        }
    } 

?>
