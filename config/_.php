<?php

// ##############################
function _($text)
{
    echo htmlspecialchars($text);
}

// ##############################
// Danish number format without trailing zeros: 16.00 -> 16, 6.70 -> 6,7, 10000.65 -> 10.000,65
// Returns "" for null, so it is safe for optional columns
function _format_number($value)
{
    if ($value === null || $value === "") {
        return "";
    }
    $formatted = number_format((float) $value, 2, ",", ".");
    return rtrim(rtrim($formatted, "0"), ",");
}

// ##############################
// Stolen from https://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid
function uuidv4_nodash()
{
    $data = random_bytes(16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

    return vsprintf('%s%s%s%s%s%s%s%s', str_split(bin2hex($data), 4));
}

// ##############################
define("review_body_min", 5);
define("review_body_max", 500);
function _validate_review_body()
{
    $review_body = $_POST["review_body"] ?? "";
    $review_body = trim($review_body);
    if (strlen($review_body) < review_body_min) {
        throw new Exception("Review must be at least " . review_body_min . " characters long", 400);
    }
    if (strlen($review_body) > review_body_max) {
        throw new Exception("Review must be max " . review_body_max . " characters long", 400);
    }
    return $review_body;
}

// ##############################
// Product type: value must be one of the allowed <option> values
// The key is the <option> value, the value is the SKU prefix
define("product_types", [
    "ledstrip"            => "LED",
    "controller"          => "CON",
    "beslag-og-montering" => "BES",
]);
function _validate_product_type()
{
    $product_type = trim($_POST["product_type"] ?? "");
    if (!array_key_exists($product_type, product_types)) {
        throw new Exception("Vælg venligst en gyldig produkttype", 400);
    }
    return $product_type;
}

// ##############################
// Pass $required = false for optional fields: an empty field then returns null
function _validate_decimal($field, $label, $required = true)
{
    $value = trim($_POST[$field] ?? "");
    $value = str_replace(" ", "", $value);

    if ($value === "") {
        if ($required) {
            throw new Exception("Udfyld venligst feltet: $label", 400);
        }
        return null;
    }

    if (str_contains($value, ",")) {
        // Danish: "." = thousands, "," = decimals -> 10.000,65 becomes 10000.65
        $value = str_replace(".", "", $value);
        $value = str_replace(",", ".", $value);
    } elseif (preg_match('/^\d{1,3}(\.\d{3})+$/', $value)) {
        // Only thousands separators, no decimals -> 10.000 becomes 10000
        $value = str_replace(".", "", $value);
    }

    if (!is_numeric($value) || $value < 0) {
        throw new Exception("$label skal være et positivt tal", 400);
    }
    return round((float) $value, 2);
}

// ##############################
// Optional text field: returns the trimmed text, or null when left empty
function _optional_text($field)
{
    $value = trim($_POST[$field] ?? "");
    return $value === "" ? null : $value;
}

// ##############################
// Product image: only webp, png and jpg/jpeg
// The key is the real file type (read from the file's content), the value is the extension it is saved with
define("product_image_types", [
    "image/webp" => "webp",
    "image/png"  => "png",
    "image/jpeg" => "jpg",
]);
define("product_image_extensions", ["webp", "png", "jpg", "jpeg"]);
define("product_image_max_size", 2 * 1024 * 1024); // 2 MB (PHP's default upload_max_filesize)
define("product_image_default", "/static/assets/images/product-default.webp"); // used when no image is uploaded

// Returns the extension to save the file with, e.g. "png"
// Returns null when no image was uploaded (the product then gets product_image_default)
function _validate_product_image()
{
    $image = $_FILES["product_img_path_1"] ?? null;

    if (!$image || $image["error"] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($image["error"] === UPLOAD_ERR_INI_SIZE || $image["error"] === UPLOAD_ERR_FORM_SIZE) {
        throw new Exception("Billedet må max være 2 MB", 400);
    }
    if ($image["error"] !== UPLOAD_ERR_OK) {
        throw new Exception("Billedet kunne ikke uploades, prøv igen", 400);
    }
    if ($image["size"] > product_image_max_size) {
        throw new Exception("Billedet må max være 2 MB", 400);
    }

    // 1. The filename must end in an allowed extension
    $extension = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
    if (!in_array($extension, product_image_extensions, true)) {
        throw new Exception("Billedet skal være webp, png eller jpg", 400);
    }

    // 2. The file's actual content must be an allowed image type
    //    (stops e.g. a php file renamed to .png)
    $mime_type = (new finfo(FILEINFO_MIME_TYPE))->file($image["tmp_name"]);
    if (!array_key_exists($mime_type, product_image_types)) {
        throw new Exception("Billedet skal være webp, png eller jpg", 400);
    }

    // Save with the extension that matches the content, not the one the user sent
    return product_image_types[$mime_type];
}

// ##############################
// Generates the next SKU for a product type, e.g. LED-001, LED-002, CON-001
// Looks up the highest existing number for that prefix (also soft-deleted products,
// so an SKU is never reused) and adds 1
function _generate_product_sku($db, $product_type)
{
    $prefix = product_types[$product_type];

    // "LED-" is 4 characters, so the number starts at position 5
    $sql = "SELECT MAX(CAST(SUBSTRING(product_sku, 5) AS UNSIGNED)) AS max_number
            FROM products
            WHERE product_sku LIKE :prefix";
    $stmt = $db->prepare($sql);
    $stmt->execute([":prefix" => $prefix . "-%"]);
    $max_number = (int) $stmt->fetch()["max_number"];

    $next_number = $max_number + 1;
    return $prefix . "-" . str_pad($next_number, 3, "0", STR_PAD_LEFT);
}

// ##############################
// Product status: 1 = aktiv, 0 = inaktiv
define("product_statuses", ["0", "1"]);
function _validate_product_status()
{
    $product_status = $_POST["product_status"] ?? "";
    if (!in_array($product_status, product_statuses, true)) {
        throw new Exception("Vælg venligst en gyldig status", 400);
    }
    return (int) $product_status;
}

// ##############################
// Required text field: returns the trimmed text
function _validate_required_text($field, $label)
{
    $value = trim($_POST[$field] ?? "");
    if ($value === "") {
        throw new Exception("Udfyld venligst feltet: $label", 400);
    }
    return $value;
}

// ##############################
// Storage amount: required whole number, 0 or more
function _validate_storage_amount()
{
    $value = trim($_POST["product_storage_amount"] ?? "");
    if ($value === "") {
        throw new Exception("Udfyld venligst feltet: Lagerantal", 400);
    }
    if (!ctype_digit($value)) {
        throw new Exception("Lagerantal skal være et helt tal (0 eller mere)", 400);
    }
    return (int) $value;
}

// ##############################
// All product fields from the create/edit product form, used by
// api-create-product.php and api-update-product.php
// Returns the validated values (keys = column names), throws an Exception on the first error
// "img_extension" is null when no new image was uploaded
function _validate_product_input()
{
    return [
        // Required (the fields with the required attribute in the form)
        "product_name"           => _validate_required_text("product_name", "Produktnavn"),
        "product_type"           => _validate_product_type(),
        "product_price"          => _validate_decimal("product_price", "Pris"),
        "product_status"         => _validate_product_status(),
        "product_storage_amount" => _validate_storage_amount(),

        // Optional text: null when left empty
        "product_description"    => _optional_text("product_description"),
        "product_img_desc"       => _optional_text("product_img_desc"),
        "product_environment"    => _optional_text("product_environment"),
        "product_diode_mount"    => _optional_text("product_diode_mount"),
        "product_color"          => _optional_text("product_color"),

        // Tekniske specifikationer: optional, decimals allowed, null when left empty
        "product_length"         => _validate_decimal("product_length", "Længde", false),
        "product_voltage"        => _validate_decimal("product_voltage", "Spænding", false),
        "product_effect"         => _validate_decimal("product_effect", "Effekt", false),
        "product_bit"            => _validate_decimal("product_bit", "Bit", false),
        "product_kelvin"         => _validate_decimal("product_kelvin", "Kelvin", false),
        "product_ip_class"       => _validate_decimal("product_ip_class", "IP-klasse", false),

        // Image: optional
        "img_extension"          => _validate_product_image(),
    ];
}
