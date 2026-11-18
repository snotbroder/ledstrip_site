<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ledstrip | <?= $title ?? '' ?></title>
    <link href="/static/css/output.css" rel="stylesheet">
    <link href="/static/css/styles.css" rel="stylesheet">
    <link rel="shortcut icon" href="/static/assets/favicon.png" type="image/x-icon" />


    <!-- <script src="/static/js/mixhtml.js" defer></script> -->


    <?php require_once ROOT . "/config/_.php"; ?>

</head>

<body>
    <header class="py-2">
        <div class="flex flex-col gap-4 max-w-7xl mx-auto px-4">
            <section class="flex justify-between items-center">
                <a href="/">
                    <img class="w-90" src="/static/assets/ledstrip-logo.svg" alt="Ledstrip Logo">
                </a>

                <div>
                    <p>Utility Menu</p>
                </div>
            </section>
            <section class="py-2">
                <ul class="flex gap-9 items-center">
                    <li class="font-sora text-darkened-blackbean font-medium"><a href="/">Led-strips</a></li>
                    <li class="text-(--light-blackbean)">|</li>
                    <li class="font-sora text-darkened-blackbean font-medium"><a href="/">Controllers</a></li>
                    <li class="text-(--light-blackbean)">|</li>
                    <li class="font-sora text-darkened-blackbean font-medium"><a href="/">Beslag og montering</a></li>
                    <li class="text-(--light-blackbean)">|</li>
                    <li class="font-sora text-darkened-blackbean font-medium"><a href="/">Kontakt os</a></li>


                </ul>
                <p>Dashboard header</p>
            </section>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 my-10">