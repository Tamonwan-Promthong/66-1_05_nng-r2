<?php
// Check if product ID is provided in the request
if(isset($_GET['id'])) {
    // Include database configuration
    require_once 'dbConfig.php';
    
    try {
        // Prepare DELETE statement
        $stmt = $conn->prepare("DELETE FROM product WHERE productId = :productId");

        
        $stmt->bindParam(':productId', $_GET['id'], PDO::PARAM_INT);

        // Execute the deletion query
        $result = $stmt->execute();

        
        if($result) {
            echo "Product deleted successfully.";
        } else {
            echo "Failed to delete product.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    
    $conn = null;

    
    header("Location: product.php");
} else {
    echo "Product ID not provided.";
}
?>
