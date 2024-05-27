<?php
ob_start();
session_start();
require('dbConfig.php');

if (!isset($_GET["id"])) {
    // Handle the case when the product ID is not provided in the URL
    $_SESSION['error'] = 'กรุณาเลือกสินค้า!';
    header('location: index.php'); // Redirect to the homepage or another appropriate page
    exit;
}

$id = $_GET["id"];

if (!isset($_SESSION["intLine"])) {
    $_SESSION["intLine"] = 0;
    $_SESSION["strProductID"][0] = $id; //รหัสสินค้า
    $_SESSION["strQty"][0] = 1; //จำนวนสินค้า
    header("location: cart.php?id=$id"); // Redirect with the product ID
} else {
    $key = array_search($id, $_SESSION["strProductID"]);
    if ($key !== false) {
        $_SESSION["strQty"][$key] -= 1;
    } else {
        $_SESSION["intLine"] += 1;
        $intNewLine = $_SESSION["intLine"];
        $_SESSION["strProductID"][$intNewLine] = $id;
        $_SESSION["strQty"][$intNewLine] = 1;
    }
    header("location: cart.php?id=$id"); // Redirect with the product ID
}
?>
