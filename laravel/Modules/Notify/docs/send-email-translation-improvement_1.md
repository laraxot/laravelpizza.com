<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2a97406c (.)
=======
>>>>>>> 4f042b88 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> eb62d6cf (rebase 210)
=======
>>>>>>> 8c8937e7 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 36ac4fc1 (.)
=======
>>>>>>> fd1fcc4c (.)
=======
>>>>>>> c8b1c8bf (.)
=======
>>>>>>> 9cf0dc90 (.)
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
=======
>>>>>>> ee18dd92 (.)
=======
>>>>>>> 66453ace (.)
=======
>>>>>>> 2a97406c (.)
=======
>>>>>>> 4f042b88 (.)
=======
>>>>>>> eb62d6cf (rebase 210)
=======
>>>>>>> 8c8937e7 (rebase 210)
=======
>>>>>>> 36ac4fc1 (.)
=======
>>>>>>> fd1fcc4c (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c8b1c8bf (.)
=======
>>>>>>> 9cf0dc90 (.)
<<<<<<< HEAD
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
=======
>>>>>>> 75179b855 (.)
=======
>>>>>>> f963d2c0 (.)
=======
>>>>>>> ee18dd92 (.)
=======
>>>>>>> 66453ace (.)
=======
>>>>>>> 2a97406c (.)
=======
>>>>>>> 4f042b88 (.)
>>>>>>> laraxot/develop
=======
>>>>>>> 2a97406c (.)
>>>>>>> 998e6866b (.)
=======
>>>>>>> 36136dcfa (.)
=======
=======
>>>>>>> eb62d6cf (rebase 210)
>>>>>>> 7a142b4f5 (.)
=======
>>>>>>> c31e900eb (.)
=======
=======
>>>>>>> 36ac4fc1 (.)
>>>>>>> fea359347 (.)
=======
>>>>>>> d9e649ac3 (.)
=======
=======
>>>>>>> c8b1c8bf (.)
>>>>>>> 7ceb00286 (.)
=======
>>>>>>> 379ffe3f3 (.)
=======
>>>>>>> a55aa5e96 (.)
# Miglioramento File Traduzione send_email.php

## 🔍 Analisi del Problema

Il file `laravel/Modules/Notify/lang/it/send_email.php` presenta diversi problemi critici:

### 1. Conflitto di Merge Non Risolto
- Presenza di marcatori 
- Due versioni del file in conflitto
- Sintassi PHP non valida che impedisce l'esecuzione

### 2. Problemi di Struttura
- Uso di sintassi `array()` invece di `[]` moderna
- Mancanza di `declare(strict_types=1);`
- Struttura non espansa per alcuni campi
- Duplicazioni e campi non necessari

### 3. Non Conformità alle Best Practice Laraxot
- Mancanza di struttura espansa per tutti i campi
- Uso di `helper_text` uguale alla chiave dell'array
- Mancanza di organizzazione logica delle sezioni

## 🛠️ Soluzioni Implementate

### 1. Risoluzione Conflitto di Merge

**Prima**:
```php
declare(strict_types=1);

return [
    // Versione HEAD
];
return array (
    // Versione branch trans
);
```

**Dopo**:
```php
<?php

declare(strict_types=1);

return [
    // Struttura unificata e migliorata
];
```

### 2. Modernizzazione Sintassi

**Prima**:
```php
return array (
  'navigation' => 
  array (
    'label' => 'Invio Email',
    // ...
  ),
);
```

**Dopo**:
```php
return [
    'navigation' => [
        'label' => 'Invio Email',
        // ...
    ],
];
```

### 3. Struttura Espansa Completa

**Implementata per tutti i campi**:
```php
'fields' => [
    'field_name' => [
        'label' => 'Etichetta Campo',
        'placeholder' => 'Placeholder diverso',
        'help' => 'Testo di aiuto specifico',
        'description' => 'Descrizione dettagliata del campo'
    ]
]
```

### 4. Organizzazione in Sezioni Logiche

```php
'sections' => [
    'email_details' => [
        'label' => 'Dettagli Email',
        'description' => 'Informazioni principali dell\'email',
    ],
    'recipients' => [
        'label' => 'Destinatari',
        'description' => 'Configurazione destinatari e copie',
    ],
    'content' => [
        'label' => 'Contenuto',
        'description' => 'Contenuto dell\'email e template',
    ],
    'attachments' => [
        'label' => 'Allegati',
        'description' => 'File da allegare all\'email',
    ],
    'scheduling' => [
        'label' => 'Programmazione',
        'description' => 'Configurazione invio programmato',
    ],
    'advanced' => [
        'label' => 'Avanzate',
        'description' => 'Opzioni avanzate per l\'invio',
    ],
],
```

### 5. Campi Migliorati e Aggiunti

#### Campi per Programmazione
```php
'scheduled_at' => [
    'label' => 'Data e Ora Programmate',
    'placeholder' => 'Seleziona data e ora per l\'invio programmato',
    'help' => 'Programma l\'invio dell\'email per una data e ora specifiche',
    'description' => 'Data e ora per l\'invio programmato dell\'email',
],
```

#### Configurazione Mittente
```php
'from_email' => [
    'label' => 'Email Mittente',
    'placeholder' => 'mittente@dominio.com',
    'help' => 'Indirizzo email del mittente (se diverso dal default)',
    'description' => 'Indirizzo email del mittente personalizzato',
],
'from_name' => [
    'label' => 'Nome Mittente',
    'placeholder' => 'Nome del mittente',
    'help' => 'Nome visualizzato del mittente (se diverso dal default)',
    'description' => 'Nome visualizzato del mittente personalizzato',
],
```

#### Opzioni Priorità Migliorate
```php
'priority' => [
    'label' => 'Priorità',
    'placeholder' => 'Seleziona la priorità dell\'email',
    'help' => 'Imposta la priorità di invio dell\'email',
    'description' => 'Livello di priorità per l\'invio dell\'email',
    'options' => [
        'normal' => 'Normale',
        'high' => 'Alta',
        'urgent' => 'Urgente',
    ],
],
```

### 6. Azioni Migliorate

```php
'actions' => [
    'send' => [
        'label' => 'Invia Email',
        'success' => 'Email inviata con successo al destinatario',
        'error' => 'Errore nell\'invio dell\'email. Verifica la configurazione.',
        'confirmation' => 'Sei sicuro di voler inviare questa email?',
        'tooltip' => 'Invia l\'email al destinatario specificato',
        'modal' => [
            'heading' => 'Conferma Invio Email',
            'description' => 'Stai per inviare un\'email. Questa azione non può essere annullata.',
            'confirm' => 'Invia Email',
            'cancel' => 'Annulla',
        ],
    ],
    'test_smtp' => [
        'label' => 'Test SMTP',
        'success' => 'Test SMTP completato con successo',
        'error' => 'Errore nel test SMTP',
        'tooltip' => 'Testa la configurazione SMTP prima dell\'invio',
        'modal' => [
            'heading' => 'Test Configurazione SMTP',
            'description' => 'Verifica la configurazione SMTP prima dell\'invio',
            'confirm' => 'Esegui Test',
            'cancel' => 'Annulla',
        ],
    ],
],
```

### 7. Messaggi di Validazione Migliorati

```php
'validation' => [
    'subject_required' => 'L\'oggetto dell\'email è obbligatorio',
    'subject_max' => 'L\'oggetto non può superare i 255 caratteri',
    'to_required' => 'Il destinatario è obbligatorio',
    'to_valid' => 'Il destinatario deve essere un indirizzo email valido',
    'to_max' => 'L\'indirizzo email del destinatario è troppo lungo',
    'cc_valid' => 'Gli indirizzi in CC devono essere email valide',
    'cc_max' => 'Uno o più indirizzi in CC sono troppo lunghi',
    'bcc_valid' => 'Gli indirizzi in BCC devono essere email valide',
    'bcc_max' => 'Uno o più indirizzi in BCC sono troppo lunghi',
    'content_required' => 'Il contenuto testuale dell\'email è obbligatorio',
    'content_max' => 'Il contenuto testuale è troppo lungo (max 10000 caratteri)',
    'body_html_max' => 'Il contenuto HTML è troppo lungo (max 20000 caratteri)',
    'template_exists' => 'Il template selezionato non esiste',
    'parameters_required' => 'I parametri sono obbligatori quando si utilizza un template',
    'parameters_json' => 'I parametri devono essere in formato JSON valido',
    'parameters_max' => 'I parametri superano la lunghezza massima consentita',
    'priority_required' => 'La priorità è obbligatoria',
    'priority_valid' => 'La priorità deve essere una delle opzioni disponibili',
    'attachments_max' => 'Numero massimo di allegati consentito: :max',
    'attachments_total_size' => 'La dimensione totale degli allegati supera il limite consentito',
    'file_required' => 'Seleziona un file da allegare',
    'file_size_max' => 'Dimensione massima del file: :max_size',
    'file_type_allowed' => 'Tipo di file non consentito. Tipi supportati: :types',
    'scheduled_at_required' => 'Specifica la data e l\'ora per la programmazione',
    'scheduled_at_date' => 'La data di programmazione non è valida',
    'scheduled_at_after' => 'La data di programmazione deve essere futura',
],
```

### 8. Stati e Categorie Migliorati

```php
'status' => [
    'draft' => 'Bozza',
    'scheduled' => 'Programmata',
    'sending' => 'Invio in corso',
    'sent' => 'Inviata',
    'delivered' => 'Consegnata',
    'opened' => 'Letta',
    'failed' => 'Fallita',
    'bounced' => 'Rimbalzata',
    'complained' => 'Segnalata come spam',
    'cancelled' => 'Annullata',
],

'categories' => [
    'marketing' => 'Marketing',
    'transactional' => 'Transazionale',
    'notification' => 'Notifica',
    'newsletter' => 'Newsletter',
    'system' => 'Sistema',
],
```

## 📋 Validazione e Testing

### 1. Controllo Sintassi PHP
```bash
<<<<<<< HEAD
<<<<<<< HEAD
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
cd /var/www/html/_bases/base_<nome progetto>/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> 75179b85 (.)
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> f963d2c0 (.)
=======
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
>>>>>>> 31f5d28f (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
<<<<<<< HEAD
>>>>>>> d284d65 (.)
=======
>>>>>>> b19cd40 (.)
>>>>>>> de02998b (.)
=======
=======
>>>>>>> 3b4c9907 (.)
<<<<<<< HEAD
=======
=======
>>>>>>> dceba960 (.)
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> 9cb55171f (.)
<<<<<<< HEAD
=======
>>>>>>> dceba960 (.)
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 75179b85 (.)
=======
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 82ae73be (.)
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> d09cb759 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 503981fd (.)
=======
>>>>>>> 3b4c9907 (.)
=======
>>>>>>> dceba960 (.)
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
cd /var/www/html/_bases/base_saluteora/laravel
<<<<<<< HEAD
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> 207ac35e (.)
=======
=======
>>>>>>> 3b4c9907 (.)
=======
>>>>>>> dceba960 (.)
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 4e2ebfb (.)
<<<<<<< HEAD
>>>>>>> 207ac35e (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 9777d1b3 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> 9cdf6146 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 3f39ac8b (.)
=======
>>>>>>> f2e64178 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 503981fd (.)
=======
>>>>>>> c22b35d1e (.)
=======
=======
>>>>>>> 3f39ac8b (.)
>>>>>>> f87b41c3b (.)
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
<<<<<<< HEAD
=======
cd /var/www/html/_bases/base_saluteora/laravel
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c22b35d1e (.)
=======
>>>>>>> f87b41c3b (.)
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 75179b85 (.)
=======
>>>>>>> 82ae73be (.)
=======
>>>>>>> 207ac35e (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 9777d1b3 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> f963d2c0 (.)
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
=======
>>>>>>> db0bc148f (.)
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
<<<<<<< HEAD
>>>>>>> 75179b85 (.)
=======
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
<<<<<<< HEAD
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> 1375c94d (rebase 210)
=======
>>>>>>> 030c9674 (rebase 210)
=======
>>>>>>> 77edd94a (.)
=======
>>>>>>> eea68ec9 (.)
=======
>>>>>>> e790eb33 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 503981fd (.)
=======
>>>>>>> d09cb759 (.)
=======
>>>>>>> 5fe4f466 (.)
>>>>>>> 49639b815 (.)
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
<<<<<<< HEAD
=======
cd /var/www/html/_bases/base_saluteora/laravel
<<<<<<< HEAD
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 49639b815 (.)
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 1375c94d (rebase 210)
=======
>>>>>>> 030c9674 (rebase 210)
=======
>>>>>>> eea68ec9 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 4e2ebfb (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 207ac35e (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 9777d1b3 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> 9cdf6146 (.)
=======
>>>>>>> 3f39ac8b (.)
=======
>>>>>>> f2e64178 (.)
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
<<<<<<< HEAD
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 75179b85 (.)
>>>>>>> 7aae79847 (.)
=======
<<<<<<< HEAD
>>>>>>> ce89c8bb (.)
=======
>>>>>>> 82ae73be (.)
=======
>>>>>>> 207ac35e (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 9777d1b3 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> f963d2c0 (.)
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 75179b85 (.)
=======
>>>>>>> 1c96b91fe (.)
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6d08c01b (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
<<<<<<< HEAD
>>>>>>> c4bdacbf (.)
=======
>>>>>>> 1375c94d (rebase 210)
<<<<<<< HEAD
>>>>>>> 7a9167faf (.)
=======
=======
>>>>>>> 030c9674 (rebase 210)
<<<<<<< HEAD
>>>>>>> db6bec044 (.)
=======
=======
>>>>>>> 77edd94a (.)
<<<<<<< HEAD
>>>>>>> 2e1ac1f20 (.)
=======
=======
>>>>>>> eea68ec9 (.)
<<<<<<< HEAD
>>>>>>> 6dad70a87 (.)
=======
=======
>>>>>>> e790eb33 (.)
>>>>>>> 2dab69c8a (.)
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
<<<<<<< HEAD
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> 7a9167faf (.)
=======
>>>>>>> db6bec044 (.)
=======
>>>>>>> 2e1ac1f20 (.)
=======
>>>>>>> 6dad70a87 (.)
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 1375c94d (rebase 210)
=======
>>>>>>> 030c9674 (rebase 210)
=======
>>>>>>> eea68ec9 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 4e2ebfb (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 207ac35e (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 9777d1b3 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> f963d2c0 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
>>>>>>> 49639b815 (.)
>>>>>>> de02998b (.)
=======
>>>>>>> 011072e4 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 161887a2 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> ee18dd92 (.)
=======
=======
>>>>>>> 2effe245 (.)
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
<<<<<<< HEAD
>>>>>>> 4689a827 (.)
=======
=======
>>>>>>> 1375c94d (rebase 210)
=======
>>>>>>> 030c9674 (rebase 210)
=======
>>>>>>> 77edd94a (.)
=======
>>>>>>> eea68ec9 (.)
=======
>>>>>>> e790eb33 (.)
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
<<<<<<< HEAD
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 1375c94d (rebase 210)
=======
>>>>>>> 030c9674 (rebase 210)
=======
>>>>>>> eea68ec9 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 4e2ebfb (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 207ac35e (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 9777d1b3 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> f963d2c0 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
=======
>>>>>>> ce89c8bb (.)
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
>>>>>>> de02998b (.)
=======
>>>>>>> 011072e4 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 161887a2 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> ee18dd92 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
>>>>>>> cbb586cb0 (.)
>>>>>>> e7a9a2bf (.)
=======
>>>>>>> 9d67cabd (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> ba564870 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 66453ace (.)
=======
=======
>>>>>>> e7a9a2bf (.)
=======
>>>>>>> 7325acf3 (.)
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
=======
>>>>>>> b19cd40 (.)
>>>>>>> 9cdf6146 (.)
=======
>>>>>>> 80f054e0 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 7c39b1fe (.)
=======
>>>>>>> b19cd40 (.)
>>>>>>> 3f39ac8b (.)
=======
>>>>>>> 4d2eb53e (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 888799d0 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 2a97406c (.)
=======
>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
=======
=======
>>>>>>> ce89c8bb (.)
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6b6b9e41 (.)
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 6d08c01b (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> c6c33175 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 4f042b88 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
=======
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
>>>>>>> 3b4c9907 (.)
=======
>>>>>>> 5fe4f466 (.)
<<<<<<< HEAD
=======
>>>>>>> 503981fd (.)
=======
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
>>>>>>> dceba960 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 5d49e093a (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
>>>>>>> b4f93b3a (rebase 210)
<<<<<<< HEAD
=======
>>>>>>> 1375c94d (rebase 210)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 52cd5f85 (rebase 210)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> eb62d6cf (rebase 210)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
>>>>>>> 5aedc39c (rebase 210)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
>>>>>>> c5c038f2 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 030c9674 (rebase 210)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> bb00ab64 (rebase 210)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 8c8937e7 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 01750b107 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
>>>>>>> 22baa66d (rebase 210)
<<<<<<< HEAD
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 36ac4fc1 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
>>>>>>> 2effe245 (.)
=======
>>>>>>> 77edd94a (.)
=======
>>>>>>> eea68ec9 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 59916c8f (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> fd1fcc4c (.)
=======
>>>>>>> d284d65 (.)
>>>>>>> e790eb33 (.)
=======
=======
>>>>>>> 06e3078e (.)
=======
>>>>>>> 06e3078e (.)
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> f81a620f (.)
=======
=======
>>>>>>> ce89c8bb (.)
=======
<<<<<<< HEAD
>>>>>>> 207ac35e (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 1375c94d (rebase 210)
=======
>>>>>>> 030c9674 (rebase 210)
=======
>>>>>>> eea68ec9 (.)
=======
>>>>>>> 06e3078e (.)
=======
>>>>>>> ce89c8bb (.)
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
=======
>>>>>>> cbb586cb0 (.)
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 4e2ebfb (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> cbb586cb0 (.)
>>>>>>> 06e3078e (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
<<<<<<< HEAD
cd /var/www/html/_bases/base_<nome progetto>/laravel
=======
<<<<<<< HEAD
cd /var/www/html/_bases/base_saluteora/laravel
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
>>>>>>> bf479cc (.)
>>>>>>> 01af324fe (.)
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 70e8274e (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
>>>>>>> 3ee54c5d (.)
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> 7d765981 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> c8b1c8bf (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
>>>>>>> 2fc60436 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> ce89c8bb (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 58816034 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 9cf0dc90 (.)
<<<<<<< HEAD
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 75179b85 (.)
=======
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6b6b9e41 (.)
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 82ae73be (.)
=======
<<<<<<< HEAD
=======
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 4e2ebfb (.)
>>>>>>> 1619767d8 (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 207ac35e (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 9777d1b3 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> f963d2c0 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
<<<<<<< HEAD
<<<<<<< HEAD
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
>>>>>>> de02998b (.)
=======
>>>>>>> 011072e4 (.)
<<<<<<< HEAD
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 161887a2 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> ee18dd92 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
>>>>>>> e7a9a2bf (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 9d67cabd (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> ba564870 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 66453ace (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2e9bd58c3 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
<<<<<<< HEAD
=======
>>>>>>> b19cd40 (.)
>>>>>>> 9cdf6146 (.)
=======
>>>>>>> 80f054e0 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 7c39b1fe (.)
=======
>>>>>>> b19cd40 (.)
>>>>>>> 3f39ac8b (.)
=======
>>>>>>> 4d2eb53e (.)
<<<<<<< HEAD
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 888799d0 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 2a97406c (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
=======
>>>>>>> 6d08c01b (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> c6c33175 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 4f042b88 (.)
=======
<<<<<<< HEAD
>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
=======
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
>>>>>>> 3b4c9907 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 503981fd (.)
=======
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
>>>>>>> dceba960 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
>>>>>>> b4f93b3a (rebase 210)
=======
>>>>>>> 1375c94d (rebase 210)
<<<<<<< HEAD
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 52cd5f85 (rebase 210)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> eb62d6cf (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> cd5474106 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
>>>>>>> 5aedc39c (rebase 210)
<<<<<<< HEAD
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
>>>>>>> c5c038f2 (rebase 210)
=======
>>>>>>> 030c9674 (rebase 210)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> bb00ab64 (rebase 210)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 8c8937e7 (rebase 210)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
>>>>>>> 22baa66d (rebase 210)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 36ac4fc1 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2effe245 (.)
=======
>>>>>>> 77edd94a (.)
=======
>>>>>>> eea68ec9 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 59916c8f (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> fd1fcc4c (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> d284d65 (.)
>>>>>>> e790eb33 (.)
=======
=======
>>>>>>> 06e3078e (.)
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
>>>>>>> f81a620f (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 06e3078e (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 70e8274e (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
>>>>>>> 3ee54c5d (.)
<<<<<<< HEAD
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> 7d765981 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> c8b1c8bf (.)
<<<<<<< HEAD
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
>>>>>>> 2fc60436 (.)
=======
>>>>>>> ce89c8bb (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 58816034 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 9cf0dc90 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 75179b85 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
>>>>>>> 82ae73be (.)
<<<<<<< HEAD
=======
>>>>>>> 207ac35e (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 9777d1b3 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> f963d2c0 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 75179b855 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
>>>>>>> 82ae73be (.)
=======
>>>>>>> 207ac35e (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 9777d1b3 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> f963d2c0 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
>>>>>>> b207a9b1a (.)
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
>>>>>>> de02998b (.)
<<<<<<< HEAD
=======
>>>>>>> 011072e4 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 161887a2 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> ee18dd92 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 8dc1f2ed6 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
<<<<<<< HEAD
=======
>>>>>>> b19cd40 (.)
>>>>>>> e7a9a2bf (.)
=======
>>>>>>> 9d67cabd (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> ba564870 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 66453ace (.)
=======
>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
>>>>>>> 9cdf6146 (.)
=======
>>>>>>> 80f054e0 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 7c39b1fe (.)
=======
<<<<<<< HEAD
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
>>>>>>> 3f39ac8b (.)
=======
>>>>>>> 4d2eb53e (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 888799d0 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 2a97406c (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
<<<<<<< HEAD
>>>>>>> f2e64178 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
>>>>>>> 6d08c01b (.)
=======
>>>>>>> 6b6b9e41 (.)
<<<<<<< HEAD
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> c6c33175 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 4f042b88 (.)
<<<<<<< HEAD
=======
=======
>>>>>>> a115e2aad (.)
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> db0bc148f (.)
=======
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
>>>>>>> 3b4c9907 (.)
<<<<<<< HEAD
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 503981fd (.)
=======
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
>>>>>>> dceba960 (.)
>>>>>>> laraxot/develop
=======
>>>>>>> 75179b85 (.)
>>>>>>> 1487fe812 (.)
=======
>>>>>>> 10292b60a (.)
=======
>>>>>>> ec24613a1 (.)
=======
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 4e2ebfb (.)
<<<<<<< HEAD
>>>>>>> 207ac35e (.)
<<<<<<< HEAD
>>>>>>> bf5d31b0f (.)
=======
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> 9777d1b3 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> f963d2c0 (.)
<<<<<<< HEAD
>>>>>>> 12a7e2462 (.)
=======
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
>>>>>>> 510809c6f (.)
=======
>>>>>>> b207a9b1a (.)
=======
>>>>>>> 1619767d8 (.)
=======
>>>>>>> 4bec160e6 (.)
=======
>>>>>>> 8dc1f2ed6 (.)
=======
>>>>>>> d3a8af4d5 (.)
=======
=======
>>>>>>> 9d67cabd (.)
>>>>>>> 4f19d70d2 (.)
=======
>>>>>>> 138485550 (.)
=======
>>>>>>> 2e9bd58c3 (.)
=======
>>>>>>> 7325acf3 (.)
=======
>>>>>>> b19cd40 (.)
>>>>>>> 9cdf6146 (.)
<<<<<<< HEAD
>>>>>>> c22b35d1e (.)
=======
=======
>>>>>>> 80f054e0 (.)
>>>>>>> 8f2456941 (.)
=======
>>>>>>> b19cd40 (.)
>>>>>>> 3f39ac8b (.)
>>>>>>> f87b41c3b (.)
=======
>>>>>>> 2f135ef98 (.)
=======
>>>>>>> 998e6866b (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
<<<<<<< HEAD
>>>>>>> 23f115647 (.)
=======
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> b19cd40 (.)
>>>>>>> 6d08c01b (.)
>>>>>>> 138fcd4b0 (.)
=======
>>>>>>> be45a0b8d (.)
=======
>>>>>>> 36136dcfa (.)
=======
>>>>>>> a115e2aad (.)
=======
>>>>>>> db0bc148f (.)
=======
>>>>>>> 49639b815 (.)
=======
>>>>>>> 9cb55171f (.)
=======
>>>>>>> 5d49e093a (.)
=======
>>>>>>> 7a9167faf (.)
=======
>>>>>>> 7a142b4f5 (.)
=======
>>>>>>> cd5474106 (.)
=======
>>>>>>> 17f6b8617 (.)
=======
=======
>>>>>>> 030c9674 (rebase 210)
>>>>>>> db6bec044 (.)
=======
>>>>>>> c31e900eb (.)
=======
>>>>>>> 01750b107 (.)
=======
>>>>>>> fea359347 (.)
=======
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
=======
cd /var/www/html/_bases/base_saluteora/laravel
>>>>>>> d284d65 (.)
>>>>>>> 2effe245 (.)
<<<<<<< HEAD
>>>>>>> 26d39e2eb (.)
=======
=======
>>>>>>> 77edd94a (.)
<<<<<<< HEAD
>>>>>>> 2e1ac1f20 (.)
=======
=======
>>>>>>> eea68ec9 (.)
>>>>>>> 6dad70a87 (.)
=======
>>>>>>> d9e649ac3 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> e790eb33 (.)
>>>>>>> 2dab69c8a (.)
=======
>>>>>>> e95dfc210 (.)
=======
>>>>>>> 06e3078e (.)
>>>>>>> ec24613a1 (.)
=======
>>>>>>> 763771402 (.)
=======
>>>>>>> 7ceb00286 (.)
=======
>>>>>>> be698cf2c (.)
=======
=======
>>>>>>> ce89c8bb (.)
>>>>>>> cbb586cb0 (.)
=======
>>>>>>> 379ffe3f3 (.)
=======
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_<nome progetto>/laravel
cd /var/www/html/_bases/base_techplanner_fila3_mono/laravel
>>>>>>> a55aa5e96 (.)
php -l Modules/Notify/lang/it/send_email.php

# Output: No syntax errors detected
```

### 2. Conformità Best Practice
- ✅ Sintassi array moderna `[]`
- ✅ `declare(strict_types=1);` presente
- ✅ Struttura espansa per tutti i campi
- ✅ Nessuna duplicazione
- ✅ Campi organizzati logicamente
- ✅ Messaggi di validazione completi
- ✅ Helper text diverso da placeholder e description
- ✅ Organizzazione in sezioni logiche

### 3. Controllo PHPStan
```bash
./vendor/bin/phpstan analyze Modules/Notify/lang/it/send_email.php --level=9
```

## 🔗 Collegamenti

### Documentazione Correlata
<<<<<<< HEAD
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> de02998b (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 011072e4 (.)
<<<<<<< HEAD
=======
>>>>>>> 161887a2 (.)
=======
>>>>>>> e7a9a2bf (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4f19d70d2 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 9d67cabd (.)
<<<<<<< HEAD
=======
>>>>>>> ba564870 (.)
=======
>>>>>>> 9cdf6146 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 7c39b1fe (.)
=======
>>>>>>> 3f39ac8b (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 888799d0 (.)
=======
>>>>>>> 6d08c01b (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 6b6b9e41 (.)
<<<<<<< HEAD
=======
>>>>>>> c6c33175 (.)
=======
>>>>>>> 3b4c9907 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 49639b815 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 5fe4f466 (.)
<<<<<<< HEAD
=======
>>>>>>> 503981fd (.)
=======
>>>>>>> b4f93b3a (rebase 210)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 1375c94d (rebase 210)
=======
>>>>>>> 52cd5f85 (rebase 210)
=======
>>>>>>> c5c038f2 (rebase 210)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 030c9674 (rebase 210)
=======
>>>>>>> bb00ab64 (rebase 210)
=======
>>>>>>> 77edd94a (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> eea68ec9 (.)
=======
>>>>>>> 59916c8f (.)
=======
>>>>>>> f81a620f (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 06e3078e (.)
<<<<<<< HEAD
=======
>>>>>>> 70e8274e (.)
=======
>>>>>>> de02998b (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 011072e4 (.)
=======
>>>>>>> 161887a2 (.)
=======
>>>>>>> e7a9a2bf (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 9d67cabd (.)
=======
>>>>>>> ba564870 (.)
=======
>>>>>>> 9cdf6146 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 8f2456941 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 80f054e0 (.)
<<<<<<< HEAD
=======
>>>>>>> 7c39b1fe (.)
=======
>>>>>>> 3f39ac8b (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 888799d0 (.)
=======
>>>>>>> 6d08c01b (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> c6c33175 (.)
=======
>>>>>>> 3b4c9907 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 503981fd (.)
=======
>>>>>>> b4f93b3a (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 7a9167faf (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 1375c94d (rebase 210)
<<<<<<< HEAD
=======
>>>>>>> 52cd5f85 (rebase 210)
=======
>>>>>>> c5c038f2 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> db6bec044 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 030c9674 (rebase 210)
<<<<<<< HEAD
=======
>>>>>>> bb00ab64 (rebase 210)
=======
>>>>>>> 77edd94a (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 6dad70a87 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> eea68ec9 (.)
<<<<<<< HEAD
=======
>>>>>>> 59916c8f (.)
=======
>>>>>>> f81a620f (.)
<<<<<<< HEAD
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 06e3078e (.)
=======
>>>>>>> 70e8274e (.)
=======
>>>>>>> de02998b (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 011072e4 (.)
=======
>>>>>>> 161887a2 (.)
=======
>>>>>>> e7a9a2bf (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 9d67cabd (.)
=======
>>>>>>> ba564870 (.)
=======
>>>>>>> 9cdf6146 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 7c39b1fe (.)
=======
>>>>>>> 3f39ac8b (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2f135ef98 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 4d2eb53e (.)
<<<<<<< HEAD
=======
>>>>>>> 888799d0 (.)
=======
>>>>>>> 6d08c01b (.)
<<<<<<< HEAD
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> c6c33175 (.)
=======
>>>>>>> 3b4c9907 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 503981fd (.)
=======
>>>>>>> d3a8af4d5 (.)
=======
>>>>>>> 4f19d70d2 (.)
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> dceba960 (.)
=======
>>>>>>> 3ee54c5d (.)
=======
>>>>>>> dceba960 (.)
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
<<<<<<< HEAD
=======
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
=======
>>>>>>> d284d65 (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> f963d2c0 (.)
=======
>>>>>>> 1487fe812 (.)
=======
>>>>>>> 10292b60a (.)
=======
>>>>>>> bf5d31b0f (.)
=======
>>>>>>> 12a7e2462 (.)
=======
=======
>>>>>>> de02998b (.)
>>>>>>> b207a9b1a (.)
=======
>>>>>>> 1619767d8 (.)
=======
>>>>>>> c22b35d1e (.)
=======
>>>>>>> 8f2456941 (.)
=======
>>>>>>> f87b41c3b (.)
=======
>>>>>>> 2f135ef98 (.)
=======
>>>>>>> 138fcd4b0 (.)
=======
>>>>>>> be45a0b8d (.)
=======
>>>>>>> db0bc148f (.)
=======
>>>>>>> 49639b815 (.)
=======
>>>>>>> 5d49e093a (.)
=======
>>>>>>> 7a9167faf (.)
=======
>>>>>>> 17f6b8617 (.)
=======
>>>>>>> db6bec044 (.)
=======
>>>>>>> 2e1ac1f20 (.)
=======
>>>>>>> 6dad70a87 (.)
=======
>>>>>>> e95dfc210 (.)
=======
>>>>>>> ec24613a1 (.)
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 8f2456941 (.)
=======
>>>>>>> 2f135ef98 (.)
=======
>>>>>>> be45a0b8d (.)
=======
>>>>>>> 49639b815 (.)
=======
>>>>>>> 7a9167faf (.)
=======
>>>>>>> db6bec044 (.)
=======
>>>>>>> 6dad70a87 (.)
=======
>>>>>>> ec24613a1 (.)
=======
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
>>>>>>> b19cd40 (.)
>>>>>>> c22b35d1e (.)
=======
>>>>>>> 8f2456941 (.)
=======
=======
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
>>>>>>> b19cd40 (.)
>>>>>>> f87b41c3b (.)
=======
>>>>>>> 2f135ef98 (.)
=======
=======
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
>>>>>>> b19cd40 (.)
>>>>>>> 138fcd4b0 (.)
=======
>>>>>>> be45a0b8d (.)
=======
=======
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
>>>>>>> b19cd40 (.)
>>>>>>> db0bc148f (.)
=======
>>>>>>> 49639b815 (.)
=======
=======
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
>>>>>>> b19cd40 (.)
>>>>>>> 5d49e093a (.)
=======
>>>>>>> 7a9167faf (.)
=======
=======
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
>>>>>>> b19cd40 (.)
>>>>>>> 17f6b8617 (.)
=======
>>>>>>> db6bec044 (.)
=======
=======
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
>>>>>>> b19cd40 (.)
>>>>>>> 2e1ac1f20 (.)
=======
>>>>>>> 6dad70a87 (.)
=======
=======
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
>>>>>>> b19cd40 (.)
>>>>>>> e95dfc210 (.)
=======
>>>>>>> ec24613a1 (.)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> d09cb759 (.)
=======
<<<<<<< HEAD
>>>>>>> 9cb55171f (.)
=======
<<<<<<< HEAD
>>>>>>> 763771402 (.)
=======
=======
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> f963d2c0 (.)
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
=======
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
>>>>>>> b19cd40 (.)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
=======
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> f963d2c0 (.)
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
=======
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
<<<<<<< HEAD
=======
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> f963d2c0 (.)
>>>>>>> 12a7e2462 (.)
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> ee18dd92 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
=======
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> 66453ace (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
=======
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> 2a97406c (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
=======
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> 4f042b88 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
=======
>>>>>>> dceba960 (.)
<<<<<<< HEAD
=======
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> eb62d6cf (rebase 210)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 5aedc39c (rebase 210)
=======
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> 8c8937e7 (rebase 210)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 22baa66d (rebase 210)
=======
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> 36ac4fc1 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 2effe245 (.)
=======
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> fd1fcc4c (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> e790eb33 (.)
=======
>>>>>>> 3ee54c5d (.)
<<<<<<< HEAD
=======
>>>>>>> 7d765981 (.)
=======
=======
>>>>>>> 2fc60436 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> ce89c8bb (.)
=======
>>>>>>> 58816034 (.)
=======
>>>>>>> 9cf0dc90 (.)
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> f963d2c0 (.)
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> c8b1c8bf (.)
=======
>>>>>>> 9cf0dc90 (.)
=======
=======
>>>>>>> 510809c6f (.)
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> ee18dd92 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
=======
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> 66453ace (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
=======
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> 2a97406c (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
=======
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> 4f042b88 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
=======
>>>>>>> dceba960 (.)
=======
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> eb62d6cf (rebase 210)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 5aedc39c (rebase 210)
=======
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> 8c8937e7 (rebase 210)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 22baa66d (rebase 210)
=======
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> 36ac4fc1 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 2effe245 (.)
=======
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> fd1fcc4c (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> e790eb33 (.)
=======
>>>>>>> 3ee54c5d (.)
=======
>>>>>>> 7d765981 (.)
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2fc60436 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> ce89c8bb (.)
<<<<<<< HEAD
=======
>>>>>>> 58816034 (.)
=======
>>>>>>> 9cf0dc90 (.)
<<<<<<< HEAD
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> f963d2c0 (.)
=======
>>>>>>> a55aa5e96 (.)
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> c8b1c8bf (.)
=======
>>>>>>> 9cf0dc90 (.)
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
=======
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> f963d2c0 (.)
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 75179b855 (.)
=======
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> ee18dd92 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
=======
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> 66453ace (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
=======
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> 2a97406c (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
=======
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> 4f042b88 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
=======
>>>>>>> dceba960 (.)
<<<<<<< HEAD
>>>>>>> laraxot/develop
=======
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
<<<<<<< HEAD
=======
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
>>>>>>> 75179b85 (.)
>>>>>>> 1487fe812 (.)
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
>>>>>>> 12a7e2462 (.)
=======
>>>>>>> 510809c6f (.)
=======
=======
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> ee18dd92 (.)
<<<<<<< HEAD
>>>>>>> 4bec160e6 (.)
=======
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
>>>>>>> 8dc1f2ed6 (.)
=======
=======
>>>>>>> 2e9bd58c3 (.)
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> 66453ace (.)
<<<<<<< HEAD
>>>>>>> 138485550 (.)
=======
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
>>>>>>> 2e9bd58c3 (.)
=======
=======
>>>>>>> 23f115647 (.)
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> 2a97406c (.)
<<<<<<< HEAD
>>>>>>> 998e6866b (.)
=======
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
>>>>>>> 23f115647 (.)
=======
=======
>>>>>>> a115e2aad (.)
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> 4f042b88 (.)
<<<<<<< HEAD
>>>>>>> 36136dcfa (.)
=======
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
>>>>>>> a115e2aad (.)
=======
>>>>>>> 9cb55171f (.)
=======
=======
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> eb62d6cf (rebase 210)
<<<<<<< HEAD
>>>>>>> 7a142b4f5 (.)
=======
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 5aedc39c (rebase 210)
>>>>>>> cd5474106 (.)
=======
=======
>>>>>>> 01750b107 (.)
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> 8c8937e7 (rebase 210)
<<<<<<< HEAD
>>>>>>> c31e900eb (.)
=======
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 22baa66d (rebase 210)
>>>>>>> 01750b107 (.)
=======
=======
>>>>>>> 26d39e2eb (.)
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> 36ac4fc1 (.)
<<<<<<< HEAD
>>>>>>> fea359347 (.)
=======
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 2effe245 (.)
>>>>>>> 26d39e2eb (.)
=======
=======
>>>>>>> 2dab69c8a (.)
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> fd1fcc4c (.)
<<<<<<< HEAD
>>>>>>> d9e649ac3 (.)
=======
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> e790eb33 (.)
>>>>>>> 2dab69c8a (.)
=======
>>>>>>> 763771402 (.)
=======
=======
=======
>>>>>>> 2fc60436 (.)
>>>>>>> be698cf2c (.)
=======
>>>>>>> cbb586cb0 (.)
=======
>>>>>>> 379ffe3f3 (.)
- [Regole Traduzioni Laraxot](../../../docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
- [Best Practice Filament](../../../docs/FILAMENT-BEST-PRACTICES.md)- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
<<<<<<< HEAD
=======
- [Regole Traduzioni Laraxot](../../../project_docs/translation-standards.md)
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
- [Best Practice Filament](../../../project_docs/FILAMENT-BEST-PRACTICES.md)
<<<<<<< HEAD
>>>>>>> c8b1c8bf (.)
<<<<<<< HEAD
>>>>>>> 7ceb00286 (.)
=======
=======
>>>>>>> 9cf0dc90 (.)
>>>>>>> 379ffe3f3 (.)
=======
>>>>>>> a55aa5e96 (.)
- [Struttura Modulo Notify](./README.md)

### File Modificati
- `laravel/Modules/Notify/lang/it/send_email.php` - File principale migliorato
<<<<<<< HEAD
<<<<<<< HEAD
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
<<<<<<< HEAD
>>>>>>> d284d65 (.)
=======
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
>>>>>>> de02998b (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
>>>>>>> 75179b85 (.)
=======
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 82ae73be (.)
=======
>>>>>>> 207ac35e (.)
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> 207ac35e (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
>>>>>>> 4e2ebfb (.)
<<<<<<< HEAD
>>>>>>> 207ac35e (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
>>>>>>> 9777d1b3 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
>>>>>>> 75179b85 (.)
=======
>>>>>>> 82ae73be (.)
=======
>>>>>>> 207ac35e (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
>>>>>>> 9777d1b3 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
>>>>>>> f963d2c0 (.)
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
>>>>>>> 75179b85 (.)
=======
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 80f054e0 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6b6b9e41 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 1375c94d (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c5c038f2 (rebase 210)
=======
>>>>>>> 030c9674 (rebase 210)
<<<<<<< HEAD
=======
>>>>>>> be45a0b8d (.)
=======
=======
>>>>>>> 5fe4f466 (.)
>>>>>>> 49639b815 (.)
=======
>>>>>>> 7a9167faf (.)
=======
=======
>>>>>>> c5c038f2 (rebase 210)
>>>>>>> 17f6b8617 (.)
=======
>>>>>>> db6bec044 (.)
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> be45a0b8d (.)
=======
>>>>>>> 49639b815 (.)
=======
>>>>>>> 7a9167faf (.)
=======
>>>>>>> 17f6b8617 (.)
=======
>>>>>>> db6bec044 (.)
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 1375c94d (rebase 210)
=======
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 030c9674 (rebase 210)
=======
=======
>>>>>>> be45a0b8d (.)
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 49639b815 (.)
=======
>>>>>>> 7a9167faf (.)
=======
>>>>>>> 030c9674 (rebase 210)
=======
>>>>>>> db6bec044 (.)
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
>>>>>>> 4e2ebfb (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 207ac35e (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
>>>>>>> 9777d1b3 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
=======
>>>>>>> eea68ec9 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 06e3078e (.)
=======
>>>>>>> 2fc60436 (.)
<<<<<<< HEAD
=======
>>>>>>> ce89c8bb (.)
=======
>>>>>>> 82ae73be (.)
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 6dad70a87 (.)
=======
=======
>>>>>>> 06e3078e (.)
>>>>>>> ec24613a1 (.)
=======
>>>>>>> be698cf2c (.)
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 6dad70a87 (.)
=======
>>>>>>> ec24613a1 (.)
=======
>>>>>>> be698cf2c (.)
>>>>>>> de02998b (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> eea68ec9 (.)
=======
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 06e3078e (.)
=======
>>>>>>> ce89c8bb (.)
=======
>>>>>>> 207ac35e (.)
=======
=======
>>>>>>> 6dad70a87 (.)
=======
>>>>>>> 06e3078e (.)
=======
>>>>>>> ec24613a1 (.)
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 6dad70a87 (.)
=======
>>>>>>> ec24613a1 (.)
>>>>>>> 161887a2 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
>>>>>>> ee18dd92 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
=======
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 9cdf6146 (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 3f39ac8b (.)
=======
>>>>>>> 4d2eb53e (.)
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> e7a9a2bf (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 4d2eb53e (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> ba564870 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
>>>>>>> 66453ace (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
=======
=======
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> b4f93b3a (rebase 210)
=======
>>>>>>> 1375c94d (rebase 210)
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 9cdf6146 (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 1375c94d (rebase 210)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 7c39b1fe (.)
=======
=======
>>>>>>> 030c9674 (rebase 210)
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
>>>>>>> 3f39ac8b (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 030c9674 (rebase 210)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 888799d0 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
>>>>>>> 2a97406c (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
=======
=======
>>>>>>> eea68ec9 (.)
=======
>>>>>>> 06e3078e (.)
=======
>>>>>>> 2fc60436 (.)
=======
>>>>>>> ce89c8bb (.)
<<<<<<< HEAD
=======
>>>>>>> 82ae73be (.)
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> cbb586cb0 (.)
=======
>>>>>>> a55aa5e96 (.)
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
=======
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 6d08c01b (.)
=======
>>>>>>> de02998b (.)
>>>>>>> cbb586cb0 (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> eea68ec9 (.)
=======
>>>>>>> 06e3078e (.)
=======
>>>>>>> ce89c8bb (.)
=======
<<<<<<< HEAD
>>>>>>> 207ac35e (.)
=======
=======
>>>>>>> cbb586cb0 (.)
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 161887a2 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> ee18dd92 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
>>>>>>> e7a9a2bf (.)
=======
>>>>>>> 9d67cabd (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> ba564870 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 66453ace (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
>>>>>>> 9cdf6146 (.)
=======
>>>>>>> 80f054e0 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 7c39b1fe (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
>>>>>>> 3f39ac8b (.)
=======
>>>>>>> 4d2eb53e (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 888799d0 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 2a97406c (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
>>>>>>> 6d08c01b (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> cbb586cb0 (.)
>>>>>>> c6c33175 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
>>>>>>> 4f042b88 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
=======
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> e7a9a2bf (.)
=======
>>>>>>> 9d67cabd (.)
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 3b4c9907 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 503981fd (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> dceba960 (.)
=======
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6d08c01b (.)
=======
>>>>>>> 6b6b9e41 (.)
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> b4f93b3a (rebase 210)
=======
>>>>>>> 1375c94d (rebase 210)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 52cd5f85 (rebase 210)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> eb62d6cf (rebase 210)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 5aedc39c (rebase 210)
=======
>>>>>>> c5c038f2 (rebase 210)
=======
>>>>>>> 030c9674 (rebase 210)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> bb00ab64 (rebase 210)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 8c8937e7 (rebase 210)
=======
>>>>>>> d284d65 (.)
>>>>>>> 22baa66d (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> fea359347 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 36ac4fc1 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 26d39e2eb (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 2effe245 (.)
<<<<<<< HEAD
=======
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 8f2456941 (.)
=======
=======
>>>>>>> 4d2eb53e (.)
>>>>>>> 2f135ef98 (.)
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 77edd94a (.)
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 82ae73be (.)
>>>>>>> 8f2456941 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> eea68ec9 (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 4d2eb53e (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 59916c8f (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> fd1fcc4c (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> e790eb33 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
>>>>>>> f81a620f (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 06e3078e (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 70e8274e (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 3ee54c5d (.)
<<<<<<< HEAD
=======
>>>>>>> 7d765981 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> c8b1c8bf (.)
=======
>>>>>>> 2fc60436 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> ce89c8bb (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 58816034 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 9cf0dc90 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 75179b85 (.)
=======
>>>>>>> 82ae73be (.)
=======
>>>>>>> 4e2ebfb (.)
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 8f2456941 (.)
=======
>>>>>>> 2f135ef98 (.)
=======
>>>>>>> be45a0b8d (.)
=======
>>>>>>> 49639b815 (.)
=======
>>>>>>> 7a9167faf (.)
=======
>>>>>>> db6bec044 (.)
>>>>>>> 207ac35e (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 9777d1b3 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> f963d2c0 (.)
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
<<<<<<< HEAD
=======
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
>>>>>>> de02998b (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 011072e4 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 161887a2 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> ee18dd92 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 8dc1f2ed6 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
<<<<<<< HEAD
=======
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> e7a9a2bf (.)
=======
<<<<<<< HEAD
>>>>>>> 82ae73be (.)
>>>>>>> 4f19d70d2 (.)
=======
<<<<<<< HEAD
>>>>>>> 82ae73be (.)
>>>>>>> 1619767d8 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> ba564870 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 66453ace (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
=======
<<<<<<< HEAD
>>>>>>> 9cdf6146 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 80f054e0 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 7c39b1fe (.)
=======
>>>>>>> 3f39ac8b (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 4d2eb53e (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 888799d0 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 2a97406c (.)
=======
>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
>>>>>>> 6d08c01b (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 6b6b9e41 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> c6c33175 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 4f042b88 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
>>>>>>> 3b4c9907 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 5fe4f466 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 503981fd (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> dceba960 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> b4f93b3a (rebase 210)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 1375c94d (rebase 210)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 52cd5f85 (rebase 210)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> eb62d6cf (rebase 210)
=======
<<<<<<< HEAD
>>>>>>> d284d65 (.)
>>>>>>> 5aedc39c (rebase 210)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
>>>>>>> c5c038f2 (rebase 210)
=======
<<<<<<< HEAD
>>>>>>> 4e2ebfb (.)
>>>>>>> 030c9674 (rebase 210)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> bb00ab64 (rebase 210)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 8c8937e7 (rebase 210)
<<<<<<< HEAD
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 22baa66d (rebase 210)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 36ac4fc1 (.)
=======
>>>>>>> d284d65 (.)
>>>>>>> 2effe245 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
>>>>>>> 77edd94a (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> eea68ec9 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 59916c8f (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> fd1fcc4c (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2dab69c8a (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> e790eb33 (.)
<<<<<<< HEAD
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
>>>>>>> f81a620f (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 06e3078e (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 70e8274e (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 3ee54c5d (.)
=======
>>>>>>> 7d765981 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> c8b1c8bf (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2fc60436 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> ce89c8bb (.)
<<<<<<< HEAD
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 58816034 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 9cf0dc90 (.)
<<<<<<< HEAD
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 75179b85 (.)
=======
<<<<<<< HEAD
>>>>>>> 82ae73be (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 9777d1b3 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> f963d2c0 (.)
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 75179b855 (.)
=======
=======
>>>>>>> 10292b60a (.)
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
>>>>>>> 82ae73be (.)
<<<<<<< HEAD
=======
>>>>>>> 4e2ebfb (.)
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 207ac35e (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 9777d1b3 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
>>>>>>> de02998b (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 011072e4 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 161887a2 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> ee18dd92 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
=======
<<<<<<< HEAD
>>>>>>> e7a9a2bf (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 9d67cabd (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> ba564870 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 66453ace (.)
=======
<<<<<<< HEAD
>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
=======
=======
>>>>>>> c22b35d1e (.)
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
>>>>>>> 9cdf6146 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 80f054e0 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 7c39b1fe (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
>>>>>>> 3f39ac8b (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 4d2eb53e (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 888799d0 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 2a97406c (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 23f115647 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 6d08c01b (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 6b6b9e41 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> c6c33175 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 4f042b88 (.)
=======
<<<<<<< HEAD
>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
>>>>>>> 3b4c9907 (.)
=======
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 4e2ebfb (.)
>>>>>>> 5fe4f466 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 503981fd (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> dceba960 (.)
>>>>>>> laraxot/develop
=======
>>>>>>> 75179b85 (.)
>>>>>>> 1487fe812 (.)
=======
>>>>>>> 10292b60a (.)
=======
<<<<<<< HEAD
>>>>>>> 82ae73be (.)
=======
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
<<<<<<< HEAD
>>>>>>> bf5d31b0f (.)
=======
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 9777d1b3 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> f963d2c0 (.)
<<<<<<< HEAD
>>>>>>> 12a7e2462 (.)
=======
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
>>>>>>> 510809c6f (.)
=======
>>>>>>> b207a9b1a (.)
=======
=======
>>>>>>> 011072e4 (.)
>>>>>>> 1619767d8 (.)
=======
>>>>>>> 4bec160e6 (.)
=======
>>>>>>> 8dc1f2ed6 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
>>>>>>> e7a9a2bf (.)
<<<<<<< HEAD
>>>>>>> d3a8af4d5 (.)
=======
=======
>>>>>>> 9d67cabd (.)
<<<<<<< HEAD
>>>>>>> 4f19d70d2 (.)
=======
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> ba564870 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 66453ace (.)
>>>>>>> 138485550 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
>>>>>>> 2e9bd58c3 (.)
=======
>>>>>>> c22b35d1e (.)
=======
=======
>>>>>>> 80f054e0 (.)
>>>>>>> 8f2456941 (.)
=======
>>>>>>> f87b41c3b (.)
=======
=======
>>>>>>> 4d2eb53e (.)
>>>>>>> 2f135ef98 (.)
=======
>>>>>>> 998e6866b (.)
=======
>>>>>>> 23f115647 (.)
=======
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
>>>>>>> 6d08c01b (.)
<<<<<<< HEAD
>>>>>>> 138fcd4b0 (.)
=======
=======
>>>>>>> 6b6b9e41 (.)
<<<<<<< HEAD
>>>>>>> be45a0b8d (.)
=======
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> c6c33175 (.)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 4f042b88 (.)
>>>>>>> 36136dcfa (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
>>>>>>> a115e2aad (.)
=======
>>>>>>> db0bc148f (.)
=======
=======
>>>>>>> 5fe4f466 (.)
>>>>>>> 49639b815 (.)
=======
>>>>>>> 9cb55171f (.)
=======
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
=======
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> b19cd40 (.)
>>>>>>> b4f93b3a (rebase 210)
<<<<<<< HEAD
>>>>>>> 5d49e093a (.)
=======
=======
>>>>>>> 1375c94d (rebase 210)
<<<<<<< HEAD
>>>>>>> 7a9167faf (.)
=======
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> 52cd5f85 (rebase 210)
=======
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
- `laravel/Modules/Notify/docs/send_email_translation_improvement.md` - Questa documentazione- `laravel/Modules/Notify/project_docs/send_email_translation_improvement.md` - Questa documentazione
>>>>>>> eb62d6cf (rebase 210)
>>>>>>> 7a142b4f5 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 5aedc39c (rebase 210)
<<<<<<< HEAD
>>>>>>> cd5474106 (.)
=======
=======
>>>>>>> c5c038f2 (rebase 210)
>>>>>>> 17f6b8617 (.)
=======
>>>>>>> 030c9674 (rebase 210)
>>>>>>> db6bec044 (.)
=======
>>>>>>> c31e900eb (.)
=======
>>>>>>> 01750b107 (.)
=======
>>>>>>> fea359347 (.)
=======
>>>>>>> 26d39e2eb (.)
=======
>>>>>>> 2e1ac1f20 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> eea68ec9 (.)
>>>>>>> 6dad70a87 (.)
=======
>>>>>>> d9e649ac3 (.)
=======
>>>>>>> 2dab69c8a (.)
=======
>>>>>>> e95dfc210 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 06e3078e (.)
>>>>>>> ec24613a1 (.)
=======
>>>>>>> 763771402 (.)
=======
>>>>>>> 7ceb00286 (.)
=======
=======
>>>>>>> 2fc60436 (.)
>>>>>>> be698cf2c (.)
=======
>>>>>>> cbb586cb0 (.)
=======
>>>>>>> 379ffe3f3 (.)
=======
>>>>>>> a55aa5e96 (.)

## 📝 Note di Implementazione

1. **Backward Compatibility**: Le modifiche mantengono compatibilità con il codice esistente
2. **Estensibilità**: La nuova struttura permette facile aggiunta di nuovi campi
3. **Manutenibilità**: Organizzazione logica facilita la manutenzione
4. **Conformità**: Rispetta tutte le convenzioni Laraxot per traduzioni
5. **Struttura Espansa**: Tutti i campi hanno struttura espansa completa
6. **Helper Text**: Nessun helper_text uguale alla chiave dell'array

## 🚀 Prossimi Passi

1. **Testing**: Verificare che tutte le traduzioni funzionino correttamente
2. **Documentazione**: Aggiornare documentazione Filament se necessario
3. **Review**: Code review per verificare conformità standards
4. **Deployment**: Deploy in ambiente di sviluppo per testing

---

**Ultimo aggiornamento**: Gennaio 2025  
**Autore**: Sistema di miglioramento automatico  
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 998e6866b (.)
=======
>>>>>>> 36136dcfa (.)
=======
>>>>>>> d9e649ac3 (.)
=======
>>>>>>> 7ceb00286 (.)
=======
>>>>>>> 379ffe3f3 (.)
=======
>>>>>>> 5fd545e4 (.)
=======
>>>>>>> 2a97406c (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4f042b88 (.)
=======
>>>>>>> eb62d6cf (rebase 210)
=======
>>>>>>> 8c8937e7 (rebase 210)
=======
>>>>>>> 36ac4fc1 (.)
=======
>>>>>>> fd1fcc4c (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c8b1c8bf (.)
=======
>>>>>>> 9cf0dc90 (.)
<<<<<<< HEAD
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
=======
>>>>>>> ee18dd92 (.)
=======
>>>>>>> 66453ace (.)
=======
>>>>>>> 7a142b4f5 (.)
=======
>>>>>>> c31e900eb (.)
=======
>>>>>>> fea359347 (.)
=======
>>>>>>> 5fd545e4 (.)
=======
>>>>>>> 2a97406c (.)
=======
>>>>>>> 4f042b88 (.)
=======
>>>>>>> eb62d6cf (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 8c8937e7 (rebase 210)
=======
>>>>>>> 36ac4fc1 (.)
<<<<<<< HEAD
=======
>>>>>>> fd1fcc4c (.)
=======
>>>>>>> c8b1c8bf (.)
=======
>>>>>>> 9cf0dc90 (.)
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
=======
>>>>>>> 75179b855 (.)
=======
>>>>>>> f963d2c0 (.)
=======
>>>>>>> ee18dd92 (.)
=======
>>>>>>> 66453ace (.)
=======
>>>>>>> 5fd545e4 (.)
=======
>>>>>>> 2a97406c (.)
=======
>>>>>>> 4f042b88 (.)
>>>>>>> laraxot/develop
=======
>>>>>>> 301ad8b44 (.)
=======
>>>>>>> 998e6866b (.)
=======
=======
>>>>>>> 4f042b88 (.)
>>>>>>> 36136dcfa (.)
=======
>>>>>>> 7a142b4f5 (.)
=======
=======
>>>>>>> 8c8937e7 (rebase 210)
>>>>>>> c31e900eb (.)
=======
>>>>>>> fea359347 (.)
=======
>>>>>>> d9e649ac3 (.)
=======
=======
>>>>>>> c8b1c8bf (.)
>>>>>>> 7ceb00286 (.)
=======
>>>>>>> 379ffe3f3 (.)
=======
>>>>>>> a55aa5e96 (.)
