<?php
// Returns the next SKU for a product type as plain text, e.g. LED-004
// this is only for ui purposes: the real SKU is generated again in api-create-product.php on submit
require_once ROOT . "/config/db.php";
require_once ROOT . "/config/_.php";

$product_type = $_GET["type"] ?? "";

header("Content-Type: text/plain; charset=utf-8");

if (!array_key_exists($product_type, product_types)) {
    http_response_code(400);
    exit;
}

echo _generate_product_sku($_db, $product_type);
