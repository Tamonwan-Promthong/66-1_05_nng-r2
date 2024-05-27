<?php
session_start();
require_once 'dbConfig.php';

function generateOrderCode($prefix = 'OD', $length = 6) {
    // Set the timezone to Thailand
    date_default_timezone_set('Asia/Bangkok');
    
    // Generate a unique order code based on the current date and time
    $date = date('YmdHis'); // Get current date and time in the format YYYYMMDDHHMMSS
    $characters = '0123456789';
    $max = strlen($characters) - 1;
    $code = $prefix . $date; // Append the current date and time to the prefix

    // Generate random numbers for the rest of the code
    $remainingLength = $length - strlen($code);
    for ($i = 0; $i < $remainingLength; $i++) {
        $code .= $characters[random_int(0, $max)];
    }

    return $code;
}
if(isset($_POST['nameCustomer'], $_POST['addrCustomer'], $_POST['tell'], $_POST['e-mail'], $_FILES['slipimg'],$_POST['messengerId'])) {
    $nameCustomer = $_POST['nameCustomer'];
    $addrCustomer = $_POST['addrCustomer'];
    $tel = $_POST['tell'];
    $email = $_POST['e-mail'];
    $orderCode = generateOrderCode();
    $dmont = date("F");
    $messengerId = $_POST['messengerId'];
    if (!empty($_FILES['slipimg']['tmp_name']) && file_exists($_FILES['slipimg']['tmp_name'])) {
        $slipimg = $_FILES['slipimg']['tmp_name'];
        $imgContent = file_get_contents($slipimg);
        $statusId = 2;
    } else {
        $imgContent = null;
        $statusId = 1;
    }
     
    $COD = ($_POST['gridRadios'] == 'option1') ? 'y' : 'n';

        $stmt = $conn->prepare("INSERT INTO orders (nameCustomer, addrCustomer, tel, email, statusId, slipimg, totalAmount, COD, orderCode, messengerId	,dmonth) 
                                VALUES (:nameCustomer, :addrCustomer, :tel, :email, :statusId, :slipimg, :totalAmount, :COD,:orderCode ,:messengerId	 ,:dmont)");
        $stmt->bindParam(':nameCustomer', $nameCustomer);
        $stmt->bindParam(':addrCustomer', $addrCustomer);
        $stmt->bindParam(':tel', $tel);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':statusId', $statusId);
        $stmt->bindParam(':slipimg', $imgContent, PDO::PARAM_LOB);
        $stmt->bindParam(':totalAmount',  $_SESSION["Sumprice"]); 
        $stmt->bindParam(':COD', $COD);
        $stmt->bindParam(':orderCode', $orderCode);
        $stmt->bindParam(':messengerId', $messengerId); 
        $stmt->bindParam(':dmont', $dmont); 
        if ($stmt->execute()) {
            $strOrderID = $conn->lastInsertId();

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
                    $stmtDetails->bindParam(':total_amount',  $_SESSION["Sumprice"]);
                    $stmtDetails->execute();
                    
                    if ($statusId == 2) {
                        $updateStockStmt = $conn->prepare("UPDATE product SET stock = stock - :qty WHERE productId = :productId");
                        $updateStockStmt->bindParam(':qty', $_SESSION["strQty"][$i]);
                        $updateStockStmt->bindParam(':productId', $_SESSION["strProductID"][$i]);
                        $updateStockStmt->execute();
                        $updateStockStmt = $conn->prepare("UPDATE product SET stockpoint	 = stockpoint	 - :qty WHERE productId = :productId");
                        $updateStockStmt->bindParam(':qty', $_SESSION["strQty"][$i]);
                        $updateStockStmt->bindParam(':productId', $_SESSION["strProductID"][$i]);
                        $updateStockStmt->execute();                 
                    }
                    if ($statusId == 1) {
                        $updateStockStmt = $conn->prepare("UPDATE product SET stockpoint	 = stockpoint	 - :qty WHERE productId = :productId");
                        $updateStockStmt->bindParam(':qty', $_SESSION["strQty"][$i]);
                        $updateStockStmt->bindParam(':productId', $_SESSION["strProductID"][$i]);
                        $updateStockStmt->execute();                 
                    }
                }
            }
            $sToken = "eJzwQ8ACs5xw1JDXJyzd1LHlIjiTHzReBTllS1wZ7AK";
    
          
            $sMessage = "รหัสคำสั่งซื้อ: " . $orderCode . "\n";
            $sMessage .= "ยอดรวม: " . $_SESSION["Sumprice"] . " บาท\n";

            // Initialize cURL
            $chOne = curl_init(); 
            curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
            curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0); 
            curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0); 
            curl_setopt($chOne, CURLOPT_POST, 1); 
            curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
            $headers = array(
                'Content-type: application/x-www-form-urlencoded',
                'Authorization: Bearer '.$sToken.'',
            );
            curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
            curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1); 
            
       
            $result = curl_exec($chOne);
            
             
            curl_close($chOne);
            unset($_SESSION["intLine"]);
            unset($_SESSION["strProductID"]);
            unset($_SESSION["strQty"]);
            


            header("location: listBuying1.php?OrderID=" . $strOrderID);
            exit();
        } else {
            echo "Failed to execute the statement.";
        }
}
?>
