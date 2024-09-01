<?php
$url = "https://www.google.com";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CAINFO, "D:\\xampp_mac\\apache\\bin\\curl-ca-bundle.crt");

$response = curl_exec($ch);
if ($response === false) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    echo 'Operation completed without any errors';
}
curl_close($ch);
?>
