# Standard per le Traduzioni

Questo documento definisce gli standard e le best practices per la gestione delle traduzioni all'interno dei moduli di <nome progetto>, con particolare attenzione al modulo Notify.

## Struttura delle Cartelle

Le traduzioni devono essere organizzate nelle seguenti cartelle:

```
/Modules/[ModuleName]/lang/
  ├── en/                 # Traduzioni inglesi
  │   └── *.php           # File di traduzione inglesi
  └── it/                 # Traduzioni italiane
      └── *.php           # File di traduzione italiani
```

## Convenzioni di Naming per i File di Traduzione

### Regole Fondamentali

1. **Nomi in snake_case**: Tutti i file di traduzione devono utilizzare il formato `snake_case.php`
2. **Nomi Semantici**: I nomi devono riflettere il contesto o la risorsa a cui si riferiscono
3. **Nomi Coerenti**: Lo stesso file deve esistere in tutte le lingue supportate
4. **Evitare Acronimi nel Nome del File**: Scrivere per esteso (es. `send_aws_email.php` invece di `send_a_w_s_email.php`)

### Esempi Corretti

✅ `send_sms.php` (non `send_s_m_s.php`)
✅ `send_aws_email.php` (non `send_a_w_s_email.php`)
✅ `send_whatsapp.php` (non `send_whats_app.php`)

## Struttura dei File di Traduzione

### Formato Standard

```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Nome Risorsa',
    ],
    'navigation' => [
        'name' => 'Nome nel Menu',
        'plural' => 'Nome Plurale',
        'group' => [
            'name' => 'Nome Gruppo',
            'description' => 'Descrizione del gruppo',
        ],
        'label' => 'Etichetta Menu',
        'icon' => 'icona-risorsa',
        'sort' => 50, // Ordine nel menu
    ],
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'helper_text' => 'Testo di aiuto',
        ],
        // Altri campi...
    ],
    'actions' => [
        'send' => 'Invia',
        'cancel' => 'Annulla',
        // Altre azioni...
    ],
    'messages' => [
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore',
        // Altri messaggi...
    ],
];
```

### Regole per le Chiavi di Traduzione

1. **Struttura Gerarchica**: Utilizzare una struttura nidificata per organizzare le traduzioni
2. **Chiavi in snake_case**: Tutte le chiavi devono essere in `snake_case`
3. **Evitare Stringhe Piatte**: Non utilizzare un array piatto di traduzioni
4. **Consistenza tra Lingue**: Le stesse chiavi devono esistere in tutte le lingue

## Utilizzo delle Traduzioni

### In Filament

```php
// Corretto
protected static ?string $navigationLabel = null; // Usa il LangServiceProvider

// Errato
protected static ?string $navigationLabel = 'Invio SMS'; // Hardcoded
```

### In Blade

```php
// Corretto
{{ __('notify::send_sms.fields.to.label') }}

// Errato
{{ __('notify::send_sms.to') }}
```

## Gestione delle Traduzioni Mancanti

1. **Completezza**: Assicurarsi che tutte le chiavi esistano in tutte le lingue
2. **Fallback**: Configurare correttamente il fallback alla lingua predefinita
3. **Monitoraggio**: Implementare un sistema per identificare le traduzioni mancanti

## Processo di Aggiornamento

1. **Sincronizzazione**: Mantenere sincronizzate le traduzioni tra le diverse lingue
2. **Revisione**: Rivedere periodicamente le traduzioni per consistenza e qualità
3. **Automazione**: Utilizzare strumenti per facilitare la gestione delle traduzioni

## Errori Comuni da Evitare

1. **Nomi File Errati**: `send_s_m_s.php` invece di `send_sms.php`
2. **File Senza Nome**: `.php` (file senza nome)
3. **Traduzioni Incomplete**: File con solo alcune chiavi
4. **Inconsistenza tra Lingue**: File che esistono solo in alcune lingue
5. **Stringhe Hardcoded**: Testo hardcoded invece di utilizzare le traduzioni

## Strumenti Utili

1. **Laravel Translation Manager**: Per gestire e sincronizzare le traduzioni
2. **Laravel Lang**: Per traduzioni comuni di Laravel
3. **Script Personalizzati**: Per verificare la completezza e consistenza delle traduzioni
