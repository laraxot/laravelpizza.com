<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Env',
        'plural' => 'Env',
        'group' => [
            'name' => 'Admin',
        ],
        'label' => 'Ambiente',
        'icon' => 'heroicon-o-home',
        'sort' => 94,
    ],
    'pages' => [
        'health_check_results' => [
            'buttons' => [
                'refresh' => 'Refresh',
            ],
            'heading' => 'Application Health',
            'navigation' => [
                'group' => 'Settings',
                'label' => 'Application Health',
            ],
            'notifications' => [
                'check_results' => 'Check results from',
            ],
        ],
    ],
    'label' => 'Env',
    'plural_label' => 'Env (Plurale)',
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'app_url' => [
            'label' => 'URL applicazione',
            'placeholder' => 'http://localhost',
            'helper_text' => 'Richiesto per upload file e altre configurazioni interne (APP_URL).',
            'description' => '',
        ],
        'debugbar_enabled' => [
            'label' => 'Debugbar attiva',
            'placeholder' => '',
            'helper_text' => 'Attiva/disattiva la modalità debug per aiutare a diagnosticare errori.',
            'description' => '',
        ],
        'google_maps_api_key' => [
            'label' => 'Google Maps API key',
            'placeholder' => 'AIzaSyAuB_...',
            'helper_text' => 'Chiave API di Google Maps (GOOGLE_MAPS_API_KEY).',
            'description' => '',
        ],
        'telegram_bot_token' => [
            'label' => 'Telegram bot token',
            'placeholder' => 'AIzaSyAuB_...',
            'helper_text' => 'Token del bot Telegram (TELEGRAM_BOT_TOKEN).',
            'description' => '',
        ],
        'sms_driver' => [
            'label' => 'Driver SMS',
            'placeholder' => '',
            'helper_text' => 'Driver SMS usato da SmsActionFactory (config sms.default). Le credenziali del driver scelto (es. NETFUN_TOKEN) devono essere già presenti nel .env.',
            'description' => '',
        ],
        'netfun_token' => [
            'label' => 'Netfun token',
            'placeholder' => 'Token API Netfun (sms.drivers.netfun.token)',
            'helper_text' => 'Valore corrente di NETFUN_TOKEN nel .env — usato solo quando Driver SMS = Netfun.',
            'description' => '',
        ],
        'mail_mailer' => [
            'label' => 'Driver mail',
            'placeholder' => '',
            'helper_text' => 'Driver usato da config(\'mail.default\') (MAIL_MAILER). Le credenziali del driver scelto devono essere già presenti nel .env.',
            'description' => '',
        ],
        'mail_host' => [
            'label' => 'Mail host',
            'placeholder' => 'smtp.esempio.it',
            'helper_text' => 'Valore corrente di MAIL_HOST nel .env — usato solo quando Driver mail = SMTP.',
            'description' => '',
        ],
        'mail_port' => [
            'label' => 'Mail port',
            'placeholder' => '587',
            'helper_text' => 'Valore corrente di MAIL_PORT nel .env — usato solo quando Driver mail = SMTP.',
            'description' => '',
        ],
        'mail_encryption' => [
            'label' => 'Crittografia mail',
            'placeholder' => '',
            'helper_text' => 'Valore corrente di MAIL_ENCRYPTION nel .env — usato solo quando Driver mail = SMTP.',
            'description' => '',
        ],
        'mail_username' => [
            'label' => 'Mail username',
            'placeholder' => 'utente@esempio.it',
            'helper_text' => 'Valore corrente di MAIL_USERNAME nel .env — usato solo quando Driver mail = SMTP.',
            'description' => '',
        ],
        'mail_password' => [
            'label' => 'Mail password',
            'placeholder' => 'Password SMTP',
            'helper_text' => 'Valore corrente di MAIL_PASSWORD nel .env — usato solo quando Driver mail = SMTP. Visibile in chiaro, come gli altri campi-segreto di questa pagina.',
            'description' => '',
        ],
        'mail_from_address' => [
            'label' => 'Mittente: indirizzo',
            'placeholder' => 'noreply@esempio.it',
            'helper_text' => 'Valore corrente di MAIL_FROM_ADDRESS nel .env — indirizzo email che compare come mittente (From) di ogni mail inviata, con qualunque Driver mail.',
            'description' => '',
        ],
        'mail_from_name' => [
            'label' => 'Mittente: nome',
            'placeholder' => 'Quaeris',
            'helper_text' => 'Valore corrente di MAIL_FROM_NAME nel .env — nome che compare accanto all\'indirizzo mittente. Se nel .env vale ${APP_NAME} qui vedi il nome già risolto: lasciandolo invariato la riga non viene riscritta.',
            'description' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Env',
        ],
        'edit' => [
            'label' => 'Modifica Env',
        ],
        'delete' => [
            'label' => 'Elimina Env',
        ],
        'save' => [
            'label' => 'save',
            'icon' => 'save',
            'tooltip' => 'save',
        ],
    ],
    'title' => 'Ambiente',
    'sections' => [
        'General' => [
            'label' => 'Generale',
            'heading' => 'Generale',
        ],
        'SMS' => [
            'label' => 'SMS',
            'heading' => 'SMS',
        ],
        'Mail' => [
            'label' => 'Mail',
            'heading' => 'Mail',
        ],
    ],
];
