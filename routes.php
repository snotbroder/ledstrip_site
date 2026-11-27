<?php

require_once __DIR__ . '/router.php';
define('ROOT', __DIR__);

//always set session alive
session_start();
date_default_timezone_set("Europe/Copenhagen");

// Views
get('/', 'views/page-index.php');
get('/styletile', 'views/page-styletile.php');

// Dashboard Views
get('/dashboard', 'views/dashboard/page-index-dashboard.php');
get('/dashboard/katalog', 'views/dashboard/page-catalogue-dashboard.php');
get('/dashboard/katalog/opret-produkt', 'views/dashboard/page-add-product-dashboard.php');
get('/dashboard/katalog/rediger-produkt/$product_pk', 'views/dashboard/page-edit-product-dashboard.php');

// API
get('/api/next-sku', 'controllers/dashboard/api-get-next-sku.php');
post('/api/create-product', 'controllers/dashboard/api-create-product.php');
post('/api/update-product/$product_pk', 'controllers/dashboard/api-update-product.php');
delete('/api/delete-product/$product_pk', 'controllers/dashboard/api-delete-product.php');

// Test routes
get('/items/$category', 'pages/page-items.php');
get('/items/$category/size/$size', 'pages/page-items.php');
