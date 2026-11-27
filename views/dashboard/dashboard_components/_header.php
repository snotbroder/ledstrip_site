<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ledstrip | <?= $title ?? '' ?></title>
    <link href="/static/css/output.css" rel="stylesheet">
    <link href="/static/css/styles.css" rel="stylesheet">
    <link rel="shortcut icon" href="/static/assets/favicon.png" type="image/x-icon" />
    <script src="/static/js/mixhtml.js" defer></script>

    <?php require_once ROOT . "/config/_.php"; ?>

</head>

<body class="dashboard">
    <header class="py-2 bg-(--light-eggshell)">
        <div class="flex flex-col gap-1 max-w-7xl mx-auto px-4">
            <section class="flex justify-between items-center">
                <a href="/dashboard" class="flex gap-6 font-bungee text-5xl items-center text-(--pure-blackbean)">
                    <img class="w-20" src="/static/assets/favicon.png" alt="Ledstrip Logo">
                    Dashboard
                </a>

                <div>
                    <p>Utility Menu</p>
                </div>
            </section>
            <section class="py-2">
                <ul class="flex gap-9 items-center bg-(--pure-eggshell) px-6 py-1 rounded-md">
                    <li class="menu-item <?= ($active ?? '') === 'index' ? 'active-link' : '' ?>"><a href="/dashboard">Ordrer</a></li>
                    <li class="text-(--light-blackbean)">|</li>
                    <li class="menu-item <?= ($active ?? '') === 'katalog' ? 'active-link' : '' ?>"><a href="/dashboard/katalog">Katalog</a></li>
                    <li class="text-(--light-blackbean)">|</li>
                    <li class="menu-item <?= ($active ?? '') === 'lagerstatus' ? 'active-link' : '' ?>"><a href="/">Lagerstatus</a></li>
                    <li class="text-(--light-blackbean)">|</li>
                    <li class="menu-item <?= ($active ?? '') === 'brugere' ? 'active-link' : '' ?>"><a href="/">Brugere</a></li>


                </ul>
            </section>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 my-10 ">
        <div id="toast"></div>