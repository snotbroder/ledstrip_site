<?php

/** @var array $product */

// Only show the specs this product has (optional columns can be NULL, e.g. beslag has no voltage)
$specs = [];
if ($product["product_length"] !== null)   $specs[] = _format_number($product["product_length"]) . " m";
if ($product["product_voltage"] !== null)  $specs[] = _format_number($product["product_voltage"]) . " V";
if ($product["product_ip_class"] !== null) $specs[] = "IP" . _format_number($product["product_ip_class"]);
?>

<a href="/dashboard/katalog/rediger-produkt/<?php _($product["product_pk"]); ?>" class="grid grid-cols-6 gap-8 items-center bg-(--light-eggshell) px-4 py-6 border-t border-t-(--darkened-eggshell) last:rounded-b-lg group hover:bg-(--pure-eggshell) cursor-pointer">
    <div class="flex flex-col gap-1 ">
        <p class="font-medium group-hover:text-(--darkened-sea)"><?php _($product["product_name"]); ?></p>
        <div class="flex gap-1">
            <?php foreach ($specs as $index => $spec) : ?>
                <?php if ($index > 0) : ?>
                    <p class="xsmall group-hover:text-(--darkened-sea)">·</p>
                <?php endif; ?>
                <p class="xsmall group-hover:text-(--darkened-sea)"><?php _($spec); ?></p>
            <?php endforeach; ?>
        </div>
    </div>
    <p class="text-(--pure-blackbean) group-hover:text-(--darkened-sea)"><?php _($product["product_sku"]); ?></p>
    <p class="text-(--pure-blackbean) group-hover:text-(--darkened-sea)"><?php _($product["product_type"]); ?></p>
    <p class="text-right text-(--pure-blackbean) group-hover:text-(--darkened-sea)"><?php _(number_format((float) $product["product_price"], 2, ',', '.')); ?></p>

    <p class="w-fit small <?php _($product["product_status"] == 1 ? "tag-active" : "tag-inactive"); ?>"><?php _($product["product_status"] == 1 ? "Aktiv" : "Inaktiv") ?></p>
    <p class="text-(--pure-blackbean) group-hover:text-(--darkened-sea)"><?php _($product["product_storage_amount"]); ?></p>
</a>