<?php

$jsonContent = file_get_contents('products.json');

$products = json_decode($jsonContent, true);

$result = [];

foreach ($products as $product) {
    if ($product['цена'] > 1000) {
        $result[] = $product;
    }
}

header('Content-Type: application/json');
echo json_encode($result);

?>