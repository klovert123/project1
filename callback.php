<?php
// Decode the JSON response
$response = file_get_contents('php://input');
$logFile = "M_PESAResponse.txt";
$log = fopen($logFile, "a");
fwrite($log, $response);
fclose($log);
?>
