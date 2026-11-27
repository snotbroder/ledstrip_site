<?php
$title = "Katalog";
$active = "katalog";
require_once ROOT . "/config/db.php";
require_once ROOT . "/config/_.php";

/** @var string $product_pk (from the route /dashboard/rediger-produkt/$product_pk) */

// Fetch the product to edit (before the header, so a 404 status can still be set)
// Deleted products can't be edited
$sql = "SELECT * FROM products WHERE product_pk = :product_pk AND product_deleted_at = 0";
$stmt = $_db->prepare($sql);
$stmt->execute([":product_pk" => $product_pk]);
$product = $stmt->fetch();

if (!$product) {
    http_response_code(404);
}
require_once ROOT . "/views/dashboard/dashboard_components/_header.php";

if (!$product) {
?>
    <h1 class="font-sora text-3xl">Produktet findes ikke</h1>
    <a class="cta-secondary" href="/dashboard/katalog">Tilbage til katalog</a>
<?php
    exit;
}

// After the check above, so a missing product doesn't give a warning
$created_at = $product["product_created_at"];
?>

<div class="flex gap-4 justify-between mb-8 items-center">
    <div class="flex flex-col gap-2">
        <h1 class="font-sora text-3xl">Rediger produkt</h1>
        <p>Ret produktoplysninger og lagerantal for <?php _($product["product_name"]); ?>.</p>
    </div>

</div>
<section>
    <form id="form" class="form-dashboard" mix-post="/api/update-product/<?php _($product["product_pk"]); ?>">
        <div class="formparent">
            <div class="flex justify-between">
                <div>
                    <p class="font-medium mb-0.5">Ændringerne gemmes med det samme</p>
                    <p class="small text-(--pure-blackbean)">Ændringerne bliver synlige i webshoppen, når du gemmer og status er sat til Aktiv</p>
                </div>
                <div class="flex gap-4">
                    <a href="/dashboard/katalog" class="cta-secondary">Annuller</a>
                    <button type="button" id="delete-product" class="cta-danger">Slet produkt</button>
                    <button class="cta-primary">Gem ændringer</button>
                </div>
            </div>
        </div>
        <section class="grid grid-cols-8 gap-6">
            <div class="col-start-1 col-end-6">
                <div class="formparent">
                    <h5>Grundoplysninger</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente, laudantium.</p>
                    <div class="formgroup">
                        <label for="product_name">Produktnavn</label>
                        <input required id="product_name" name="product_name" type="text" maxlength="100" placeholder="placeholder" value="<?php _($product["product_name"]); ?>">
                    </div>
                    <div class="grid grid-cols-2 gap-4">

                        <div class="formgroup">
                            <label for="product_type">Type</label>
                            <select required id="product_type" name="product_type">
                                <option value="" disabled>Vælg type</option>
                                <option value="ledstrip" <?php if ($product["product_type"] === "ledstrip") echo "selected"; ?>>Ledstrip</option>
                                <option value="controller" <?php if ($product["product_type"] === "controller") echo "selected"; ?>>Controller</option>
                                <option value="beslag-og-montering" <?php if ($product["product_type"] === "beslag-og-montering") echo "selected"; ?>>Beslag og montering</option>
                            </select>
                        </div>
                        <div class="formgroup">
                            <label for="product_sku">SKU (Varenummer)</label>
                            <!-- disabled: not sent with the form. Changes only if the type is changed -->
                            <input disabled id="product_sku" type="text" value="<?php _($product["product_sku"]); ?>">
                        </div>
                    </div>
                    <div class="formgroup">
                        <label for="product_description">Beskrivelse</label>
                        <textarea id="product_description" name="product_description" maxlength="500" placeholder="placeholder"><?php _($product["product_description"] ?? ""); ?></textarea>
                    </div>
                    <p class="small text-(--darkened-blackbean)">Produkt tilføjet den <?php _(date("d/m/Y, H:i", (int) $created_at)); ?></p>
                </div>

                <div class="formparent">
                    <h5>Tekniske specifikationer</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente, laudantium.</p>
                    <div class="grid grid-cols-3 gap-4">

                        <div class="formgroup">
                            <label for="product_length">Længde (m)</label>
                            <input id="product_length" name="product_length" type="number" step="0.01" min="0" max="99" placeholder="placeholder" value="<?php _($product["product_length"] ?? ""); ?>">
                        </div>
                        <div class="formgroup">
                            <label for="product_voltage">Spænding (V)</label>
                            <input id="product_voltage" name="product_voltage" type="number" step="0.01" min="0" max="999" placeholder="placeholder" value="<?php _($product["product_voltage"] ?? ""); ?>">
                        </div>
                        <div class="formgroup">
                            <label for="product_effect">Effekt (W)</label>
                            <input id="product_effect" name="product_effect" type="number" step="0.01" min="0" max="999" placeholder="placeholder" value="<?php _($product["product_effect"] ?? ""); ?>">
                        </div>
                        <div class="formgroup">
                            <label for="product_environment">Miljø</label>
                            <input id="product_environment" name="product_environment" type="text" maxlength="20" placeholder="placeholder" value="<?php _($product["product_environment"] ?? ""); ?>">
                        </div>
                        <div class="formgroup">
                            <label for="product_diode_mount">Diodemontering</label>
                            <input id="product_diode_mount" name="product_diode_mount" type="text" maxlength="20" placeholder="placeholder" value="<?php _($product["product_diode_mount"] ?? ""); ?>">
                        </div>
                        <div class="formgroup">
                            <label for="product_bit">Bit</label>
                            <input id="product_bit" name="product_bit" type="number" step="0.01" min="0" max="999" placeholder="placeholder" value="<?php _($product["product_bit"] ?? ""); ?>">
                        </div>
                        <div class="formgroup">
                            <label for="product_kelvin">Kelvin</label>
                            <input id="product_kelvin" name="product_kelvin" type="number" step="0.01" min="0" placeholder="placeholder" value="<?php _($product["product_kelvin"] ?? ""); ?>">
                        </div>
                        <div class="formgroup">
                            <label for="product_color">Farve</label>
                            <input id="product_color" name="product_color" type="text" maxlength="100" placeholder="placeholder" value="<?php _($product["product_color"] ?? ""); ?>">
                        </div>
                        <div class="formgroup">
                            <label for="product_ip_class">IP-klasse</label>
                            <input id="product_ip_class" name="product_ip_class" type="number" step="0.01" min="0" max="99" placeholder="placeholder" value="<?php _($product["product_ip_class"] ?? ""); ?>">
                        </div>
                    </div>
                </div>
                <div class="formparent">
                    <h5>Pris og lager</h5>
                    <p>Lorem ipsum dolor sit amet.</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="formgroup">
                            <label for="product_price">Pris</label>
                            <!-- Shown in Danish format, e.g. 10.000,65 -->
                            <input required id="product_price" name="product_price" type="text" inputmode="decimal" pattern="([0-9]{1,3}(\.[0-9]{3})+|[0-9]+)(,[0-9]{1,2})?|[0-9]+\.[0-9]{1,2}" title="Fx 199, 199,95 eller 10.000,65" placeholder="placeholder" value="<?php _(_format_number($product["product_price"])); ?>">
                        </div>
                        <div class="formgroup">
                            <label for="product_status">Status</label>
                            <select required class="select-status" id="product_status" name="product_status">
                                <option value="1" <?php if ((int) $product["product_status"] === 1) echo "selected"; ?>>Aktiv</option>
                                <option value="0" <?php if ((int) $product["product_status"] === 0) echo "selected"; ?>>Inaktiv</option>
                            </select>
                        </div>
                    </div>

                    <div class="formgroup">
                        <label for="product_storage_amount">Lagerantal</label>
                        <input required id="product_storage_amount" name="product_storage_amount" type="number" min="0" placeholder="placeholder" value="<?php _($product["product_storage_amount"]); ?>">
                        <p class="xsmall text-(--pure-blackbean)">Angiv det samlede antal enheder</p>
                    </div>
                </div>
            </div>
            <div class="col-start-6 col-end-9">
                <div class="formparent">
                    <h5>Produktbillede</h5>
                    <p class="small">Upload kun et nyt billede, hvis det nuværende skal udskiftes.</p>
                    <img src="<?php _($product["product_img_path_1"]); ?>" alt="<?php _($product["product_img_desc"] ?? $product["product_name"]); ?>">
                    <div class="formgroup">
                        <label class="hidden" for="product_img_path_1"></label>
                        <input id="product_img_path_1" name="product_img_path_1" type="file" accept=".webp,.png,.jpg,.jpeg,image/webp,image/png,image/jpeg">
                    </div>
                    <div class="formgroup">
                        <label for="product_img_desc">Billedbeskrivelse </label>
                        <input id="product_img_desc" name="product_img_desc" type="text" maxlength="100" placeholder="placeholder" value="<?php _($product["product_img_desc"] ?? ""); ?>">
                        <p class="small text-(--pure-blackbean)">Billedebeskrivelsen placeres under billedet og som meta tekst i billedet</p>
                    </div>
                </div>
                <div class="formparent">
                    <h5>Inden du gemmer</h5>
                    <p class="small text-(--pure-blackbean)">Hvis du skifter type, får produktet et nyt varenummer med den nye types forkortelse.</p>
                    <p class="small text-(--pure-blackbean)">Kontrollér enhederne i de tekniske specifikationer.</p>
                </div>
            </div>
        </section>

    </form>

    <!-- Delete modal: outside the form, so its buttons can never submit it.
         showModal() centers it and darkens the page behind it (::backdrop) -->
    <dialog id="delete-modal" class="modal">
        <h5>Slet produkt?</h5>
        <p>Er du sikker på, at du vil slette <?php _($product["product_name"]); ?>? Produktet fjernes fra kataloget og webshoppen.</p>
        <div class="flex gap-4 justify-end">
            <button type="button" id="delete-modal-cancel" class="cta-secondary">Annuller</button>
            <!-- mix-delete sends the DELETE request -->
            <button type="button" id="delete-modal-confirm" class="cta-danger" mix-delete="/api/delete-product/<?php _($product["product_pk"]); ?>">Ja, slet produkt</button>
        </div>
    </dialog>
</section>

<script>
    // SKU preview: the current SKU for the product's own type, the next free SKU for any other type
    const original_type = "<?php _($product["product_type"]); ?>";
    const original_sku = "<?php _($product["product_sku"]); ?>";
    document.querySelector("#product_type").addEventListener("change", async (e) => {
        const sku_input = document.querySelector("#product_sku");
        if (e.target.value === original_type) {
            sku_input.value = original_sku;
            return;
        }
        const response = await fetch("/api/next-sku?type=" + encodeURIComponent(e.target.value));
        sku_input.value = response.ok ? await response.text() : "";
    });

    // Delete modal
    const delete_modal = document.querySelector("#delete-modal");
    // "Slet produkt" opens the modal
    document.querySelector("#delete-product").addEventListener("click", () => delete_modal.showModal());
    // "Annuller" closes it (Esc also closes it)
    document.querySelector("#delete-modal-cancel").addEventListener("click", () => delete_modal.close());
    // "Ja, slet produkt": mixhtml sends the DELETE, we just close the modal
    document.querySelector("#delete-modal-confirm").addEventListener("click", () => delete_modal.close());
    // Click on the darkened background closes it too
    delete_modal.addEventListener("click", (e) => {
        if (e.target === delete_modal) delete_modal.close();
    });
</script>