<?php

// Fetch products from db
require_once ROOT . "/config/db.php";
// Only products that aren't deleted
$sql = "SELECT * FROM products WHERE product_deleted_at = 0 ORDER BY product_pk"; //ASC LIMIT 6
$stmt = $_db->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll();
