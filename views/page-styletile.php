<?php
$title = "Styletile";
// $active = "index";
require_once ROOT . "/views/components/_header.php";
?>
<section class="m-4">
    <h1 class="font-bungee text-(--darkened-blackbean)!">Heading 1</h1>
    <h2 class="font-bungee">Heading 2</h2>
    <h3 class="font-bungee">Heading 3</h3>
    <h4 class="font-sora">Heading 4</h4>
    <h5 class="font-sora">Heading 5</h5>
    <p>Paragraph</p>
    <p class="small">Small paragraph</p>
    <p class="xsmall">Extra small paragraph</p>
</section>

<section class="m-4 flex flex-col gap-2">
    <div class="flex gap-2">
        <div class="colorbox bg-(--darkened-sea)"></div>
        <div class="colorbox bg-(--pure-sea)"></div>
        <div class="colorbox bg-(--light-sea)"></div>
    </div>
    <div class="flex gap-2">
        <div class="colorbox bg-(--darkened-blackbean)"></div>
        <div class="colorbox bg-(--pure-blackbean)"></div>
        <div class="colorbox bg-(--light-blackbean)"></div>
    </div>
    <div class="flex gap-2">
        <div class="colorbox bg-(--darkened-eggshell)"></div>
        <div class="colorbox border border-(--light-blackbean) bg-(--pure-eggshell)"></div>
        <div class="colorbox border border-(--light-blackbean) bg-(--light-eggshell)"></div>
    </div>
    <div class="flex gap-2">
        <div class="colorbox bg-(--system-failure)"></div>
        <div class="colorbox bg-(--system-success)"></div>
        <div class="colorbox bg-(--system-warning)"></div>
        <div class="colorbox bg-(--system-inform)"></div>
    </div>
</section>