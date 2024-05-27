<?php

session_start();

unset($_SESSION["intLine"]);
unset($_SESSION["strProductID"]);
unset($_SESSION["strQty"]);


header("Location: buying.php");
exit(); 
?>