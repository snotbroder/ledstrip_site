<?php
// Updates an existing product. Route: /api/update-product/$product_pk
// product_pk, product_created_at and product_deleted_at are never changed here
require_once ROOT . "/config/db.php";
require_once ROOT . "/config/_.php";

/** @var string $product_pk (from the route) */

// Find the product we are editing
// Deleted products can't be updated
$sql = "SELECT product_type, product_sku, product_img_path_1 FROM products WHERE product_pk = :product_pk AND product_deleted_at = 0";
$stmt = $_db->prepare($sql);
$stmt->execute([":product_pk" => $product_pk]);
$existing_product = $stmt->fetch();

if (!$existing_product) {
    http_response_code(404);
    $message = "Produktet findes ikke";
?>
    <browser mix-update="#toast">
        <?php require_once ROOT . "/views/components/__toast_error.php" ?>
    </browser>
<?php
    exit;
}

// Read + validate all fields (_.php)
try {
    $input = _validate_product_input();
} catch (Exception $e) {
    http_response_code(400);
    $message = $e->getMessage();
?>
    <browser mix-update="#toast">
        <?php require_once ROOT . "/views/components/__toast_error.php" ?>
    </browser>
<?php
    exit;
}

// SKU: keep it, unless the type was changed (then the prefix must change too, e.g. LED-004 -> BES-002)
$product_sku = $existing_product["product_sku"];
if ($input["product_type"] !== $existing_product["product_type"]) {
    $product_sku = _generate_product_sku($_db, $input["product_type"]);
}

// Image: keep the current one, unless a new image was uploaded
$product_img_path_1 = $existing_product["product_img_path_1"];
if ($input["img_extension"]) {
    $upload_dir = ROOT . "/static/assets/images/products";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0775, true);
    }
    // time() in the name, so the browser doesn't show the old cached image
    $img_filename = $product_pk . "-" . time() . "." . $input["img_extension"];
    move_uploaded_file($_FILES["product_img_path_1"]["tmp_name"], "$upload_dir/$img_filename");
    $product_img_path_1 = "/static/assets/images/products/$img_filename";

    // Delete the old uploaded image (never the shared default image)
    $old_path = $existing_product["product_img_path_1"];
    if (str_starts_with($old_path, "/static/assets/images/products/") && is_file(ROOT . $old_path)) {
        unlink(ROOT . $old_path);
    }
}

// Update product in DB (created_at and deleted_at are left out on purpose)
$sql = "UPDATE products SET
    product_name           = :product_name,
    product_sku            = :product_sku,
    product_price          = :product_price,
    product_status         = :product_status,
    product_type           = :product_type,
    product_description    = :product_description,
    product_img_path_1     = :product_img_path_1,
    product_img_desc       = :product_img_desc,
    product_storage_amount = :product_storage_amount,
    product_length         = :product_length,
    product_voltage        = :product_voltage,
    product_effect         = :product_effect,
    product_environment    = :product_environment,
    product_diode_mount    = :product_diode_mount,
    product_bit            = :product_bit,
    product_kelvin         = :product_kelvin,
    product_color          = :product_color,
    product_ip_class       = :product_ip_class
WHERE product_pk = :product_pk";
try {
    $stmt = $_db->prepare($sql);
    $stmt->execute([
        ":product_pk"             => $product_pk,
        ":product_name"           => $input["product_name"],
        ":product_sku"            => $product_sku,
        ":product_price"          => $input["product_price"],
        ":product_status"         => $input["product_status"],
        ":product_type"           => $input["product_type"],
        ":product_description"    => $input["product_description"],
        ":product_img_path_1"     => $product_img_path_1,
        ":product_img_desc"       => $input["product_img_desc"],
        ":product_storage_amount" => $input["product_storage_amount"],
        ":product_length"         => $input["product_length"],
        ":product_voltage"        => $input["product_voltage"],
        ":product_effect"         => $input["product_effect"],
        ":product_environment"    => $input["product_environment"],
        ":product_diode_mount"    => $input["product_diode_mount"],
        ":product_bit"            => $input["product_bit"],
        ":product_kelvin"         => $input["product_kelvin"],
        ":product_color"          => $input["product_color"],
        ":product_ip_class"       => $input["product_ip_class"],
    ]);
} catch (PDOException $e) {
    error_log("api-update-product: " . $e->getMessage()); // details in `docker logs ledstrip_site_web`
    http_response_code(500);
    $message = "Produktet kunne ikke gemmes, prøv igen";
?>
    <browser mix-update="#toast">
        <?php require_once ROOT . "/views/components/__toast_error.php" ?>
    </browser>
<?php
    exit;
}
http_response_code(200);
$message = "Produktet blev opdateret";
?>
<browser mix-update="#toast">
    <?php require_once ROOT . "/views/components/__toast_success.php" ?>
</browser>
