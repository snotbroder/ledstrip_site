<?php

/** @var string $message **/ ?>

<div class="rounded-sm bg-(--system-failure) p-6 my-4 text-(--pure-eggshell) shadow-md flex gap-4 items-center">
    <div class="w-8"><img src="/static/assets/icons/alert-circle-eggshell.svg" alt="Alert circle"></div>
    <?php if (isset($message)) : ?>
        <p class=" text-(--pure-eggsehll)"><?php _($message); ?></p>
    <?php else : ?>
        <p class="text-(--pure-eggsehll)">An unknown error occurred.</p>
    <?php endif; ?>
</div>