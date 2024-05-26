<?php

$xml = file_get_contents("http://radiovox.conectastm.com/api/VkRGU1ZtVlZOVzVRVkRBOStS");
$data = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
$json = json_encode($data);

echo $json;
header('Access-Control-Allow-Origin: *');