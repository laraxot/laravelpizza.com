<?php

declare(strict_types=1);

// Job translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// Canon: Modules/Job/docs/wiki — domain i18n only.

return merge_translation_files(__DIR__.'/job_meta.php', __DIR__.'/job_actions.php',
);
