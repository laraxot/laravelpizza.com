<?php

declare(strict_types=1);

return [
    'title' => 'Cancellazione account',
    'subtitle' => 'Diritto alla cancellazione (art. 17 GDPR)',
    'warning' => 'Attenzione',
    'warning_text' => 'La cancellazione non e\' immediata e non elimina fisicamente i dati: l\'account viene soft-deleted per conservare l\'audit trail (art. 30 GDPR). Tutti i consensi vengono revocati. I dati personali trattenuti sono quelli strettamente necessari per adempiere a obblighi di legge.',
    'reason_label' => 'Motivazione (opzionale)',
    'confirm_label' => 'Per confermare, scrivi :word',
    'confirm_word' => 'cancella',
    'confirm_placeholder' => 'cancella',
    'cancel' => 'Annulla',
    'submit' => 'Cancella il mio account',
    'success' => 'Account cancellato correttamente.',
    'flash' => [
        'account_deleted' => 'Il tuo account è stato disattivato e sei uscito dal servizio. I tuoi dati saranno cancellati quando le tue segnalazioni aperte saranno chiuse.',
    ],
    'delete' => [
        'heading' => [
            'title' => 'Cancellazione account',
            'help' => 'Diritto alla cancellazione (art. 17 GDPR)',
        ],
        'warning' => [
            'title' => 'Attenzione',
            'message' => 'La cancellazione non e\' immediata e non elimina fisicamente i dati: l\'account viene soft-deleted per conservare l\'audit trail (art. 30 GDPR). Tutti i consensi vengono revocati. I dati personali trattenuti sono quelli strettamente necessari per adempiere a obblighi di legge.',
        ],
        'reason' => [
            'label' => 'Motivazione (opzionale)',
        ],
        'confirm' => [
            'label' => 'Per confermare, scrivi :word',
            'placeholder' => 'cancella',
        ],
        'confirm_word' => [
            'label' => 'cancella',
        ],
        'cancel' => [
            'label' => 'Annulla',
        ],
        'submit' => [
            'label' => 'Cancella il mio account',
        ],
    ],
];
