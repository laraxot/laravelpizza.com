<?php

declare(strict_types=1);

return [
    'title' => 'Cancelación de cuenta',
    'subtitle' => 'Derecho al olvido (art. 17 RGPD)',
    'warning' => 'Advertencia',
    'warning_text' => 'La cancelación no es inmediata y no elimina físicamente los datos: la cuenta se soft-deleted para preservar el audit trail (art. 30 RGPD). Se revocan todos los consentimientos. Los datos personales retenidos se limitan a lo estrictamente necesario para cumplir obligaciones legales.',
    'reason_label' => 'Motivo (opcional)',
    'confirm_label' => 'Para confirmar, escribe :word',
    'confirm_word' => 'cancelar',
    'confirm_placeholder' => 'cancelar',
    'cancel' => 'Editar',
    'submit' => 'Eliminar mi cuenta',
    'success' => 'Cuenta eliminada correctamente.',
    'flash' => [
        'account_deleted' => 'Tu cuenta se ha desactivado y se ha cerrado tu sesión. Tus datos se eliminarán cuando se cierren tus avisos abiertos.',
    ],
    'delete' => [
        'heading' => [
            'title' => 'Cancelación de cuenta',
            'help' => 'Derecho al olvido (art. 17 RGPD)',
        ],
        'warning' => [
            'title' => 'Advertencia',
            'message' => 'La cancelación no es inmediata y no elimina físicamente los datos: la cuenta se soft-deleted para preservar el audit trail (art. 30 RGPD). Se revocan todos los consentimientos. Los datos personales retenidos se limitan a lo estrictamente necesario para cumplir obligaciones legales.',
        ],
        'reason' => [
            'label' => 'Motivo (opcional)',
        ],
        'confirm' => [
            'label' => 'Para confirmar, escribe :word',
            'placeholder' => 'cancelar',
        ],
        'confirm_word' => [
            'label' => 'cancelar',
        ],
        'cancel' => [
            'label' => 'Cancelar',
        ],
        'submit' => [
            'label' => 'Eliminar mi cuenta',
        ],
    ],
];
