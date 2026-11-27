<?php
$title = "Katalog";
$active = "katalog";
require_once ROOT . "/views/dashboard/dashboard_components/_header.php";
?>

<div class="flex gap-4 justify-between mb-8 items-center">
    <div class="flex flex-col gap-2">
        <h1 class="font-sora text-3xl">Opret produkt</h1>
        <p>Tilføj produktoplysninger, specifikationer og lagerantal til kataloget.</p>
    </div>

</div>
<section>
    <form id="form" class="form-dashboard" mix-post="/api/create-product">
        <div class="formparent">
            <div class="flex justify-between">
                <div>
                    <p class="font-medium mb-0.5">Produktet oprettes med det samme</p>
                    <p class="small text-(--pure-blackbean)">Det bliver synligt i webshoppen, når du opretter produktet og status er sat til Aktiv</p>
                </div>
                <div class="flex gap-4">
                    <a href="/dashboard/katalog" class="cta-secondary">Annuller</a>
                    <button class="cta-primary">Opret produkt</button>
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
                        <input required id="product_name" name="product_name" type="text" maxlength="100" placeholder="placeholder">
                    </div>
                    <div class="grid grid-cols-2 gap-4">

                        <div class="formgroup">
                            <label for="product_type">Type</label>
                            <select required id="product_type" name="product_type">
                                <option value="" disabled selected>Vælg type</option>
                                <option value="ledstrip">Ledstrip</option>
                                <option value="controller">Controller</option>
                                <option value="beslag-og-montering">Beslag og montering</option>
                            </select>
                        </div>
                        <div class="formgroup">
                            <label for="product_sku">SKU (Varenummer)</label>
                            <input disabled id="product_sku" type="text" placeholder="Vælg type">
                        </div>
                    </div>
                    <div class="formgroup">
                        <label for="product_description">Beskrivelse</label>
                        <textarea id="product_description" name="product_description" maxlength="500" placeholder="placeholder"></textarea>
                    </div>
                </div>

                <div class="formparent">
                    <h5>Tekniske specifikationer</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente, laudantium.</p>
                    <div class="grid grid-cols-3 gap-4">

                        <div class="formgroup">
                            <label for="product_length">Længde (m)</label>
                            <input id="product_length" name="product_length" type="number" step="0.01" min="0" max="99" placeholder="placeholder">
                        </div>
                        <div class="formgroup">
                            <label for="product_voltage">Spænding (V)</label>
                            <input id="product_voltage" name="product_voltage" type="number" step="0.01" min="0" max="999" placeholder="placeholder">
                        </div>
                        <div class="formgroup">
                            <label for="product_effect">Effekt (W)</label>
                            <input id="product_effect" name="product_effect" type="number" step="0.01" min="0" max="999" placeholder="placeholder">
                        </div>
                        <div class="formgroup">
                            <label for="product_environment">Miljø</label>
                            <input id="product_environment" name="product_environment" type="text" maxlength="20" placeholder="placeholder">
                        </div>
                        <div class="formgroup">
                            <label for="product_diode_mount">Diodemontering</label>
                            <input id="product_diode_mount" name="product_diode_mount" type="text" maxlength="20" placeholder="placeholder">
                        </div>
                        <div class="formgroup">
                            <label for="product_bit">Bit</label>
                            <input id="product_bit" name="product_bit" type="number" step="0.01" min="0" max="999" placeholder="placeholder">
                        </div>
                        <div class="formgroup">
                            <label for="product_kelvin">Kelvin</label>
                            <input id="product_kelvin" name="product_kelvin" type="number" step="0.01" min="0" placeholder="placeholder">
                        </div>
                        <div class="formgroup">
                            <label for="product_color">Farve</label>
                            <input id="product_color" name="product_color" type="text" maxlength="100" placeholder="placeholder">
                        </div>
                        <div class="formgroup">
                            <label for="product_ip_class">IP-klasse</label>
                            <input id="product_ip_class" name="product_ip_class" type="number" step="0.01" min="0" max="99" placeholder="placeholder">
                        </div>
                    </div>
                </div>
                <div class="formparent">
                    <h5>Pris og lager</h5>
                    <p>Lorem ipsum dolor sit amet.</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="formgroup">
                            <label for="product_price">Pris</label>
                            <input required id="product_price" name="product_price" type="text" inputmode="decimal" pattern="([0-9]{1,3}(\.[0-9]{3})+|[0-9]+)(,[0-9]{1,2})?|[0-9]+\.[0-9]{1,2}" title="Fx 199, 199,95 eller 10.000,65" placeholder="placeholder">
                        </div>
                        <div class="formgroup">
                            <label for="product_status">Status</label>
                            <select required class="select-status" id="product_status" name="product_status">
                                <option value="1">Aktiv</option>
                                <option value="0">Inaktiv</option>
                            </select>
                        </div>
                    </div>

                    <div class="formgroup">
                        <label for="product_storage_amount">Lagerantal</label>
                        <input required id="product_storage_amount" name="product_storage_amount" type="number" min="0" placeholder="placeholder">
                        <p class="xsmall text-(--pure-blackbean)">Angiv det samlede antal enheder</p>
                    </div>
                </div>
            </div>
            <div class="col-start-6 col-end-9">
                <div class="formparent">
                    <h5>Produktbillede</h5>
                    <p class="small">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores accusamus quas distinctio sed est numquam.</p>
                    <div class="formgroup">
                        <label class="hidden" for="product_img_path_1"></label>
                        <input id="product_img_path_1" name="product_img_path_1" type="file" accept=".webp,.png,.jpg,.jpeg,image/webp,image/png,image/jpeg">
                    </div>
                    <div class="formgroup">
                        <label for="product_img_desc">Billedbeskrivelse </label>
                        <input id="product_img_desc" name="product_img_desc" type="text" maxlength="100" placeholder="placeholder">
                        <p class="small text-(--pure-blackbean)">Billedebeskrivelsen placeres under billedet og som meta tekst i billedet</p>
                    </div>
                </div>
                <div class="formparent">
                    <h5>Inden du opretter</h5>
                    <p class="small text-(--pure-blackbean)">Brug et unikt varenummer, og kontrollér enhederne i de tekniske specifikationer.</p>
                    <p class="small text-(--pure-blackbean)">Du kan ændre alle oplysninger og tilføje andre billeder senere.</p>
                </div>
            </div>
        </section>

    </form>
</section>

<script>
    // Preview the next SKU when a type is selected (the API sets the real one on submit)
    document.querySelector("#product_type").addEventListener("change", async (e) => {
        const sku_input = document.querySelector("#product_sku");
        const response = await fetch("/api/next-sku?type=" + encodeURIComponent(e.target.value));
        sku_input.value = response.ok ? await response.text() : "";
    });

    // Called by the API after a product is created: <browser mix-function="reset_product_form">
    function reset_product_form() {
        const form = document.querySelector("#form");
        // Empties all inputs, the file input and the textarea, and sets the
        // selects back to their default option ("Vælg type" and "Aktiv")
        form.reset();
        // The SKU preview is filled by JS, so clear it by hand
        document.querySelector("#product_sku").value = "";
        // Back to the top, ready for the next product
        window.scrollTo({ top: 0, behavior: "smooth" });
        document.querySelector("#product_name").focus({ preventScroll: true });
    }
</script>