<?php

session_start();
session_unset();

$sMessage = "User logged out:";

$sToken = "eJzwQ8ACs5xw1JDXJyzd1LHlIjiTHzReBTllS1wZ7AK";

$chOne = curl_init(); 


curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0); 
curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0); 
curl_setopt($chOne, CURLOPT_POST, 1); 
curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 


$headers = array(
    'Content-type: application/x-www-form-urlencoded',
    'Authorization: Bearer '.$sToken.''
);
curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1); 


$result = curl_exec($chOne);


session_destroy();


header("Location: login.php");
exit;
?>