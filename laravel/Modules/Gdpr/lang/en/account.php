<?php

declare(strict_types=1);

return [
    'title' => 'Account cancellation',
    'subtitle' => 'Right to erasure (art. 17 GDPR)',
    'warning' => 'Warning',
    'warning_text' => 'Cancellation is not immediate and does not physically delete data: the account is soft-deleted to preserve the audit trail (art. 30 GDPR). All consents are revoked. Retained personal data is limited to what is strictly necessary to comply with legal obligations.',
    'reason_label' => 'Reason (optional)',
    'confirm_label' => 'To confirm, type :word',
    'confirm_word' => 'delete',
    'confirm_placeholder' => 'delete',
    'cancel' => 'Cancel',
    'submit' => 'Delete my account',
    'success' => 'Account deleted successfully.',
    'flash' => [
        'account_deleted' => 'Your account has been deactivated and you have been signed out. Your data will be deleted once your open reports are closed.',
    ],
    'delete' => [
        'heading' => [
            'title' => 'Account cancellation',
            'help' => 'Right to erasure (art. 17 GDPR)',
        ],
        'warning' => [
            'title' => 'Warning',
            'message' => 'Cancellation is not immediate and does not physically delete data: the account is soft-deleted to preserve the audit trail (art. 30 GDPR). All consents are revoked. Retained personal data is limited to what is strictly necessary to comply with legal obligations.',
        ],
        'reason' => [
            'label' => 'Reason (optional)',
        ],
        'confirm' => [
            'label' => 'To confirm, type :word',
            'placeholder' => 'delete',
        ],
        'confirm_word' => [
            'label' => 'delete',
        ],
        'cancel' => [
            'label' => 'Cancel',
        ],
        'submit' => [
            'label' => 'Delete my account',
        ],
    ],
];
