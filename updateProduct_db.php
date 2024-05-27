<?php
// Check if form data is provided
if(isset($_POST['productId'])) {
    
    require_once 'dbConfig.php';

    try {
       
        $productId = $_POST['productId'];
        $productCode = $_POST['productCode'];
        $productName = $_POST['productName'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $stockpoint = $_POST['stock'];
        $sizeId = $_POST['sizeId'];
        $categoryId = $_POST['categoryId'];

       
        if(isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        
            $newImgData = file_get_contents($_FILES['img']['tmp_name']);

        
            $stmt = $conn->prepare("UPDATE product SET productCode = :productCode, productName = :productName, price = :price, stock = :stock, sizeId = :sizeId, categoryId = :categoryId, img = :newImgData , stockpoint = :stockpoint WHERE productId = :productId");

            $stmt->bindParam(':newImgData', $newImgData, PDO::PARAM_LOB);
        } else {
    
            $stmt = $conn->prepare("UPDATE product SET productCode = :productCode, productName = :productName, price = :price, stock = :stock, sizeId = :sizeId, categoryId = :categoryId , stockpoint = :stockpoint WHERE productId = :productId");
        }

        $stmt->bindParam(':productCode', $productCode, PDO::PARAM_STR);
        $stmt->bindParam(':productName', $productName, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_INT);
        $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
        $stmt->bindParam(':sizeId', $sizeId, PDO::PARAM_INT);
        $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
        $stmt->bindParam(':stockpoint', $stockpoint, PDO::PARAM_INT); // Add this line to bind stockpoint
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
    
        $result = $stmt->execute();

        if($result) {
            echo "Update successful.";
        } else {
            echo "Update failed.";
        }

        $conn = null;
        
     
        header("Location: product.php");
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Product data not provided.";
}
?>
