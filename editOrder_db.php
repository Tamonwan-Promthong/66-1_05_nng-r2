<?php

session_start();


if (!isset($_GET["id"]) || !isset($_GET["orderId"])) {
   
    echo "Error: Product ID or Order ID is missing.";
    exit;
}


if (!isset($_SESSION["intLine"])) {
    $_SESSION["intLine"] = 0;
    $_SESSION["strProductID"] = array();
    $_SESSION["strQty"] = array();
}

$key = array_search($_GET["id"], $_SESSION["strProductID"]);
if ($key !== false) {

    $_SESSION["strQty"][$key]++;
} else {

    $_SESSION["intLine"]++;
    $intNewLine = $_SESSION["intLine"];
    $_SESSION["strProductID"][$intNewLine] = $_GET["id"];
    $_SESSION["strQty"][$intNewLine] = 1;
}

$redirectUrl = "editBuying.php";
if ($_GET["orderId"] != "") {
  
    $redirectUrl .= "?id=" . $_GET["orderId"];
}


header("Location: $redirectUrl");
exit; 
?>
