# Sincronizzazione Traduzioni Temi

## Panoramica

Questo documento descrive il processo di sincronizzazione delle traduzioni per i temi One e Two del progetto .
Questo documento descrive il processo di sincronizzazione delle traduzioni per i temi One e Two del progetto <nome progetto>.
Questo documento descrive il processo di sincronizzazione delle traduzioni per i temi One e Two del progetto .
Questo documento descrive il processo di sincronizzazione delle traduzioni per i temi One e Two del progetto <nome progetto>.
Questo documento descrive il processo di sincronizzazione delle traduzioni per i temi One e Two del progetto .
Questo documento descrive il processo di sincronizzazione delle traduzioni per i temi One e Two del progetto <nome progetto>.

## Struttura dei Temi

### Tema One
- **Percorso**: `/laravel/Themes/One/lang/`
- **Lingue supportate**: `it/`, `en/`, `de/`
- **File di traduzione**: 12 file per lingua (aggiornato)

### Tema Two
- **Percorso**: `/laravel/Themes/Two/lang/`
- **Lingue supportate**: `it/`, `en/`, `de/`
- **File di traduzione**: 12 file per lingua (aggiornato)

## File di Traduzione

Entrambi i temi contengono i seguenti file di traduzione:

1. `auth.php` - Autenticazione e registrazione
2. `password-reset.php` - Reset password
3. `appointment.php` - Gestione appuntamenti (aggiornato con sezione fields)
4. `appointment_states.php` - Stati degli appuntamenti
5. `doctor.php` - Gestione dottori
6. `opening_hours.php` - Orari di apertura
7. `patient_states.php` - Stati del paziente
8. `txt.php` - Testi generali (corretto per multilingua, aggiornato con sezione report)
9. `widgets.php` - Widget Filament (nuovo)
10. `doctor_states.php` - Stati del dottore
11. `patient.php` - Gestione pazienti
12. `studio.php` - Gestione studi

## Correzioni Applicate (2025-01-06)

### 1. Problema: Traduzione mancante `pub_theme::appointment.fields.state.label`

**Causa**: Il file `appointment/item.blade.php` cercava una traduzione che non esisteva.

**Soluzione**: Aggiunta sezione `fields` completa in tutti i file `appointment.php`:
- `laravel/Themes/One/lang/it/appointment.php`
- `laravel/Themes/One/lang/en/appointment.php`
- `laravel/Themes/One/lang/de/appointment.php`

### 2. Problema: Traduzioni in italiano nei file inglesi e tedeschi

**Causa**: I file `txt.php` in inglese e tedesco contenevano ancora traduzioni in italiano.

**Soluzione**: Corrette tutte le traduzioni:
- `laravel/Themes/One/lang/en/txt.php` - Traduzioni in inglese
- `laravel/Themes/One/lang/de/txt.php` - Traduzioni in tedesco

### 3. Problema: Sezione fields mancante in appointment.php

**Causa**: I file `appointment.php` non avevano la sezione `fields` necessaria per i form.

**Soluzione**: Aggiunta sezione completa con tutti i campi:
- `state` - Stato appuntamento
- `date` - Data
- `time` - Orario
- `notes` - Note
- `patient` - Paziente
- `doctor` - Dottore
- `studio` - Studio
- `service` - Servizio
- `duration` - Durata
- `emergency` - Emergenza

### 4. Problema: Testo hardcoded in italiano per i referti (2025-01-06)

**Causa**: Il file `appointment/item.blade.php` conteneva testo hardcoded in italiano per la sezione referti:
- "Il tuo referto è pronto!"
- "Scarica referto!"

**Soluzione**:
1. Aggiunta sezione `report` in tutti i file `txt.php`:
   - `laravel/Themes/One/lang/it/txt.php`
   - `laravel/Themes/One/lang/en/txt.php`
   - `laravel/Themes/One/lang/de/txt.php`

2. Aggiornato il template Blade per usare le traduzioni:
   - Sostituito testo hardcoded con `@lang('pub_theme::txt.report.ready_title')`
   - Sostituito testo hardcoded con `@lang('pub_theme::txt.report.download_button')`

**Traduzioni aggiunte**:
```php
'report' => [
    'ready_title' => 'Il tuo referto è pronto!', // IT
    'ready_title' => 'Your report is ready!',     // EN
    'ready_title' => 'Ihr Bericht ist bereit!',   // DE
    'download_button' => 'Scarica referto!',      // IT
    'download_button' => 'Download report!',      // EN
    'download_button' => 'Bericht herunterladen!', // DE
],
```

## Struttura Standard per File di Traduzione

### Sintassi Array Breve
```php
<?php

declare(strict_types=1);

return [
    'section' => [
        'key' => [
            'label' => 'Label',
            'placeholder' => 'Placeholder',
            'help' => 'Help text',
        ],
    ],
];
```

### Sezione Fields Completa
Ogni file che gestisce form deve avere una sezione `fields` con:
- `label` - Etichetta del campo
- `placeholder` - Testo placeholder
- `help` - Testo di aiuto

### Sezione Report (Nuova)
Per la gestione dei referti, aggiungere sezione `report` in `txt.php`:
- `ready_title` - Titolo quando il referto è pronto
- `download_button` - Testo del pulsante di download

## Regole di Sincronizzazione

### 1. Coerenza Strutturale
- Tutti i file devono avere la stessa struttura
- Se un file ha una sezione, tutti i file nelle altre lingue devono averla
- Mantenere l'ordine delle chiavi identico

### 2. Traduzioni Semantiche
- Non tradurre letteralmente, ma semanticamente
- Considerare il contesto sanitario
- Mantenere la professionalità del linguaggio

### 3. Sintassi Standard
- Utilizzare sempre `declare(strict_types=1);`
- Utilizzare sempre sintassi array breve `[]`
- Organizzare gerarchicamente le traduzioni

### 4. Controlli Qualità
- Verificare che non ci siano traduzioni hardcoded
- Controllare che tutte le lingue abbiano le stesse sezioni
- Validare la coerenza terminologica

### 5. Multilingua Obbligatorio
- **MAI** usare testo hardcoded in qualsiasi lingua
- **SEMPRE** usare `@lang()` o `{{ __('') }}` per tutti i testi
- **SEMPRE** aggiungere traduzioni per tutte le lingue supportate

## Processo di Aggiornamento

### Fase 1: Identificazione
1. Cercare errori di traduzione nei log
2. Verificare file Blade per riferimenti `@lang()`
3. Controllare coerenza tra file di traduzione
4. Cercare testo hardcoded nelle view

### Fase 2: Correzione
1. Aggiungere sezioni mancanti
2. Correggere traduzioni errate
3. Mantenere coerenza strutturale
4. Sostituire testo hardcoded con traduzioni

### Fase 3: Validazione
1. Testare tutte le lingue
2. Verificare che non ci siano errori
3. Aggiornare documentazione

## File di Riferimento

### Template Standard
```php
<?php

declare(strict_types=1);

return [
    'section' => [
        'key' => [
            'label' => 'Label',
            'placeholder' => 'Placeholder',
            'help' => 'Help text',
            'tooltip' => 'Tooltip text',
        ],
    ],
    'actions' => [
        'action_name' => [
            'label' => 'Action Label',
            'success' => 'Success message',
            'error' => 'Error message',
        ],
    ],
    'messages' => [
        'message_key' => 'Message text',
    ],
    'report' => [
        'ready_title' => 'Report ready message',
        'download_button' => 'Download button text',
    ],
];
```

## Note Importanti

1. **Mai rimuovere**: Non eliminare mai traduzioni esistenti
2. **Solo aggiungere**: Aggiungere o migliorare traduzioni
3. **Coerenza**: Mantenere coerenza tra tutte le lingue
4. **Documentazione**: Aggiornare sempre la documentazione
5. **Multilingua**: Mai usare testo hardcoded, sempre traduzioni

## Collegamenti

- [Theme Widget Translations](theme-widget-translations.md)
- [Translation Helper Text Standards](translation-helper-text-standards.md)
- [Modules/<nome modulo>/docs/translation_quality_standards.md](../laravel/Modules/<nome modulo>/docs/translation_quality_standards.md)
- [Modules/<nome progetto>/docs/translation_quality_standards.md](../laravel/Modules/<nome progetto>/docs/translation_quality_standards.md)
- [Modules/<nome modulo>/docs/translation_quality_standards.md](../laravel/Modules/<nome modulo>/docs/translation_quality_standards.md)
- [Modules/<nome progetto>/docs/translation_quality_standards.md](../laravel/Modules/<nome progetto>/docs/translation_quality_standards.md)
- [Modules/<nome modulo>/docs/translation_quality_standards.md](../laravel/Modules/<nome modulo>/docs/translation_quality_standards.md)
- [Modules/<nome progetto>/docs/translation_quality_standards.md](../laravel/Modules/<nome progetto>/docs/translation_quality_standards.md)

---

**Ultimo aggiornamento**: 2025-01-06
**Versione**: 2.2
**Autore**: AI Assistant
