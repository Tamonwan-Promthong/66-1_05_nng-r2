<?php
session_start();
require('dbConfig.php');

if(isset($_POST['login-user'])) {
    $usernamelogin = $_POST['usernamelogin'];
    $passwordlogin = $_POST['passwordlogin']; 

 
    if(empty($usernamelogin) || empty($passwordlogin)) {
        $_SESSION['error'] = "Username and password are required";
        header('Location: login.php');
        exit();
    }


    $stmt = $conn->prepare("SELECT * FROM user_account WHERE username = ?");
    $stmt->execute([$usernamelogin]);


    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify password
    if($row && password_verify($passwordlogin, $row['password'])) {
    
        function getLowStockProducts($conn) {
            $sql = "SELECT productName, stock FROM product WHERE stock = 0 OR stock < 10";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        function getStatusId7Count($conn)
    {
        $statusId_7 = 7;
        $stmt = $conn->prepare("SELECT COUNT(*) AS total_items FROM orders WHERE statusId = ?");
        $stmt->execute([$statusId_7]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_items'];
    }

    $lowStockProducts = getLowStockProducts($conn);

  
    $statusId7Count = getStatusId7Count($conn);

        // Line Notify token
        $sToken = "eJzwQ8ACs5xw1JDXJyzd1LHlIjiTHzReBTllS1wZ7AK";

      
        $sMessage = "รายการสินค้าใกล้หมด/หมด\n"; 
        $orderNumber = 1;

       
        $sMessage = ""; 

        $sMessage .= "Username login: " . $usernamelogin . "เข้าใช้ระบบ\n";
        $sMessage .= "เข้าใช้ระบบ\n";
        $sMessage .= "รายการสินค้าใกล้หมด/หมด\n";
        foreach ($lowStockProducts as $product) {
            $sMessage .= "ลำดับที่: " . $orderNumber . "\n";
            $sMessage .= "ชื่อสินค้า: " . $product['productName'] . "\n";
            $sMessage .= "จำนวนคงเหลือ: " . $product['stock'] . "\n\n";
            
    
            $orderNumber++;
        }
        $sMessage .= "ยังไม่ถูกจัดส่ง: " . $statusId7Count . "\n";
       
        

   
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

        $_SESSION['username'] = $usernamelogin;
        $_SESSION['loggedin'] = true; 

        // Check user's role
        $stmtRole = $conn->prepare("SELECT roleId FROM employee_role WHERE employeeId = ?");
        $stmtRole->execute([$row['employeeId']]);
        $roleId = $stmtRole->fetchColumn();

        $_SESSION['roleId'] = $roleId; 

        if($roleId == 1  || $roleId == 3) {
            header('Location: index.php');
            exit();
        } else if( $roleId == 2 ){
            header('Location: product.php');
            exit();
        }
        else if( $roleId == 4 ){
            header('Location: listBuying1.php');
            exit();
        } 
        else{
          
            $_SESSION['error'] = "You are not authorized to access this page";
            header('Location: unauthorized.php'); 
            exit();
        }
    } else {
   
        $_SESSION['error'] = "Wrong username/password";
        header('Location: login.php');
        exit();
    }

} else {
    header('Location: login.php');
    exit();
}
?>
