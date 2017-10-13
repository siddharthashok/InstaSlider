<?php
header('Content-Type: application/json');
$url = "https://api.instagram.com/v1/users/".$_GET["user_id"]."/?access_token=".$_GET["access_token"];
echo file_get_contents($url);
