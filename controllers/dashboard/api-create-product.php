<?php
require_once ROOT . "/config/db.php";
require_once ROOT . "/config/_.php";

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

// Generate SKU from the selected type, e.g. LED-004 (_.php)
$product_sku = _generate_product_sku($_db, $input["product_type"]);

$product_pk = uuidv4_nodash();

// Save uploaded image, or fall back to the default image when none was uploaded (_.php)
$product_img_path_1 = product_image_default;
if ($input["img_extension"]) {
    $upload_dir = ROOT . "/static/assets/images/products";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0775, true);
    }
    $img_filename = $product_pk . "." . $input["img_extension"];
    move_uploaded_file($_FILES["product_img_path_1"]["tmp_name"], "$upload_dir/$img_filename");
    $product_img_path_1 = "/static/assets/images/products/$img_filename";
}

$product_created_at = time();
$product_deleted_at = 0;

// Insert product into DB
$sql = "INSERT INTO products (
    product_pk, product_name, product_sku, product_price, product_status, product_type,
    product_description, product_img_path_1, product_img_desc, product_storage_amount,
    product_length, product_voltage, product_effect, product_environment, product_diode_mount,
    product_bit, product_kelvin, product_color, product_ip_class, product_created_at, product_deleted_at
) VALUES (
    :product_pk, :product_name, :product_sku, :product_price, :product_status, :product_type,
    :product_description, :product_img_path_1, :product_img_desc, :product_storage_amount,
    :product_length, :product_voltage, :product_effect, :product_environment, :product_diode_mount,
    :product_bit, :product_kelvin, :product_color, :product_ip_class, :product_created_at, :product_deleted_at
)";
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
        ":product_created_at"     => $product_created_at,
        ":product_deleted_at"     => $product_deleted_at,
    ]);
} catch (PDOException $e) {
    error_log("api-create-product: " . $e->getMessage());
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
$message = "Produktet blev oprettet";
?>
<browser mix-update="#toast">
    <?php require_once ROOT . "/views/components/__toast_success.php" ?>
</browser>

<browser mix-function="reset_product_form"></browser>