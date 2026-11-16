<?php

require_once __DIR__ . '/router.php';
define('ROOT', __DIR__);

//always set session alive
session_start();
// Views
get('/', 'views/page-index.php');
get('/styletile', 'views/page-styletile.php');

// Dashboard Views
get('/dashboard', 'views/dashboard/page-index-dashboard.php');

// Test routes
get('/items/$category', 'pages/page-items.php');
get('/items/$category/size/$size', 'pages/page-items.php');
