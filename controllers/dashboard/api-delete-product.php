<?php
// Soft deletes a product. Route: DELETE /api/delete-product/$product_pk
// The row stays in the DB with product_deleted_at = the time it was deleted,
// so its SKU is never given to a new product
require_once ROOT . "/config/db.php";
require_once ROOT . "/config/_.php";

/** @var string $product_pk (from the route) */

try {
    // "AND product_deleted_at = 0": deleting an already deleted product does nothing
    $sql = "UPDATE products SET product_deleted_at = :product_deleted_at
            WHERE product_pk = :product_pk AND product_deleted_at = 0";
    $stmt = $_db->prepare($sql);
    $stmt->execute([
        ":product_deleted_at" => time(),
        ":product_pk"         => $product_pk,
    ]);
} catch (PDOException $e) {
    error_log("api-delete-product: " . $e->getMessage()); // details in `docker logs ledstrip_site_web`
    http_response_code(500);
    $message = "Produktet kunne ikke slettes, prøv igen";
?>
    <browser mix-update="#toast">
        <?php require_once ROOT . "/views/components/__toast_error.php" ?>
    </browser>
<?php
    exit;
}

// No row changed = the product doesn't exist or is already deleted
if ($stmt->rowCount() === 0) {
    http_response_code(404);
    $message = "Produktet findes ikke eller er allerede slettet";
?>
    <browser mix-update="#toast">
        <?php require_once ROOT . "/views/components/__toast_error.php" ?>
    </browser>
<?php
    exit;
}

http_response_code(200);
$message = "Produktet blev slettet";
?>
<browser mix-update="#toast">
    <?php require_once ROOT . "/views/components/__toast_success.php" ?>
</browser>
<browser mix-update="#form">
    <div class="formparent">
        <h1>Produktet er slettet</h1>
        <a class="cta-primary" href="/dashboard/katalog">Tilbage til katalog</a>
    </div>
</browser>
