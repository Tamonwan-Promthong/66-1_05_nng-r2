<?php
require_once 'dbConfig.php';

if(isset($_POST['productCode']) && isset($_POST['productName']) && isset($_POST['price']) && isset($_POST['stock'])  && isset($_POST['categoryId']) && isset($_FILES['img'])) {
    $productName = $_POST['productName'];
    $productCode = $_POST['productCode'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $stockpoint = $_POST['stock'];

    
    $categoryId = $_POST['categoryId'];
    $img = $_FILES['img']['tmp_name']; // Retrieve image data
    $imgContent = file_get_contents($img); // Read image content

    $stmt = $conn->prepare("INSERT INTO product (productName, productCode, price, stock, categoryId, img,stockpoint) 
                        VALUES (:productName, :productCode, :price, :stock, :categoryId, :img, :stockpoint)");

$stmt->bindParam(':productName', $productName, PDO::PARAM_STR);
$stmt->bindParam(':productCode', $productCode, PDO::PARAM_STR);
$stmt->bindParam(':price', $price, PDO::PARAM_INT);
$stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
$stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
$stmt->bindParam(':img', $imgContent, PDO::PARAM_LOB); // B
$stmt->bindParam(':stockpoint', $stockpoint, PDO::PARAM_LOB); // B
    $result = $stmt->execute();

    $conn = null; // close database connection
    header("Location: product.php");
}
?>