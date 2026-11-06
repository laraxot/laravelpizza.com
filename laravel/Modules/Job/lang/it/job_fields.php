<?php

declare(strict_types=1);

// Job translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: ≥5% comment lines on files >100 LOC.
// Canon: Modules/Job/docs/wiki — domain i18n only.
// File: lang/it/job_fields.php
return [
    'id' => [
        'label' => 'ID',
        'help' => 'Identificatore univoco del job',
    ],
    'queue' => [
        'label' => 'Coda',
    ],
    'status' => [
        'label' => 'Stato',
    ],
];
