<?php
$title = "Katalog";
$active = "katalog";
require_once ROOT . "/views/dashboard/dashboard_components/_header.php";

require_once ROOT . "/controllers/api-get-products.php";
?>


<div class="flex gap-4 justify-between mb-8 items-center">
    <div class="flex flex-col gap-2">
        <h1 class="font-sora text-3xl">Katalog</h1>
        <p>Se produkter og redigér eller opret nye</p>
    </div>
    <a class="cta-primary" href="/dashboard/katalog/opret-produkt">+ Opret produkt</a>
</div>

<section class="border border-(--darkened-eggshell) rounded-lg">
    <div class="grid grid-cols-6 gap-8 bg-(--pure-eggshell) p-4 rounded-t-lg">
        <p class="text-(--darkened-blackbean) font-medium">Produkt</p>
        <p class="text-(--darkened-blackbean) font-medium">Sku</p>
        <p class="text-(--darkened-blackbean) font-medium">Type</p>
        <p class="text-right text-(--darkened-blackbean) font-medium">Pris</p>
        <p class="text-(--darkened-blackbean) font-medium">Status</p>
        <p class="text-(--darkened-blackbean) font-medium">Antal</p>
    </div>

    <section class="flex flex-col ">
        <?php if ($products) {
            foreach ($products as $product) {
                require ROOT . '/views/dashboard/dashboard_components/__product-card.php';
            }
        } else {
        ?> <p>Ingen produkter i katalog</p>
        <?php
        } ?>
    </section>
</section>