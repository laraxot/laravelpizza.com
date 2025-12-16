<?php

declare(strict_types=1);

return [
    'backend' => [
        'access' => [
            'users' => [
                'activate' => 'Ενεργοποίησε',
                'change_password' => 'Άλλαξε κωδικό',
                'deactivate' => 'Απενεργοποίησε',
                'delete_permanently' => 'Διέγραψε μόνιμα',
                'login_as' => 'Συνδέσου σαν :user',
                'resend_email' => 'Ξαναστείλε email επιβεβαίωσης',
                'restore_user' => 'Επαναφορά χρήστη',
            ],
        ],
    ],
    'emails' => [
        'auth' => [
            'confirm_account' => 'Επιβεβαίωσε τον λογαριασμό',
            'reset_password' => 'Επαναφορά κωδικού',
        ],
    ],
    'general' => [
        'cancel' => 'Άκυρο',
        'crud' => [
            'create' => 'Δημιουργία',
            'delete' => 'Διαγραφή',
            'edit' => 'Διαμόρφωση',
            'update' => 'Ανανέωση',
            'view' => 'Προβολή',
        ],
        'save' => 'Αποθήκευση',
        'view' => 'Προβολή',
    ],
];
