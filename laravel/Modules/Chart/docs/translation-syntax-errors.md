# Errori di Sintassi nei File di Traduzione - Chart Module

## Problema Identificato

Sono stati rilevati errori di sintassi PHP in diversi file di traduzione del modulo Chart e altri moduli correlati. Gli errori sono causati da:

1. **Parentesi graffe non bilanciate** - Mancano parentesi di chiusura `]` o `)`
2. **Dichiarazioni `declare(strict_types=1);` posizionate erroneamente** - Dopo l'apertura dell'array
3. **Struttura array non corretta** - Elementi vuoti o malformati

## File Affetti e Correzioni Implementate

### Chart Module ✅ CORRETTO
- `laravel/Modules/Chart/lang/it/chart.php` - Linea 66: Parentesi non bilanciata ✅ RISOLTO
- `laravel/Modules/Chart/lang/it/mixed_chart.php` - Linea 4: `declare()` posizionato erroneamente ✅ RISOLTO

### FormBuilder Module ✅ CORRETTO
- `laravel/Modules/FormBuilder/lang/it/collection_lang.php` - Linea 55: Parentesi non bilanciata ✅ RISOLTO
- `laravel/Modules/FormBuilder/lang/it/field.php` - Linea 51: Parentesi non bilanciata ✅ RISOLTO
- `laravel/Modules/FormBuilder/lang/it/field_option.php` - Linea 72: Parentesi non bilanciata ✅ RISOLTO

### Job Module ✅ CORRETTO
- `laravel/Modules/Job/lang/it/jobs_waiting.php` - Linea 254: Parentesi non bilanciata ✅ RISOLTO

### Lang Module ✅ CORRETTO
- `laravel/Modules/Lang/lang/en/edit_translation_file.php` - Linea 2884: Parentesi non bilanciata ✅ RISOLTO
- `laravel/Modules/Lang/lang/it/translation_file.php` - Linea 87: Parentesi non bilanciata ✅ RISOLTO

### Notify Module ✅ CORRETTO
- `laravel/Modules/Notify/lang/it/send_whats_app.php` - Linea 11: Parentesi non bilanciata ✅ RISOLTO

### UI Module ✅ CORRETTO
- `laravel/Modules/UI/lang/it/s3_test.php` - Linea 103: Parentesi non bilanciata ✅ RISOLTO

## Pattern degli Errori

### Errore 1: declare() posizionato erroneamente
```php
// ❌ ERRATO
<?php 
return [
declare(strict_types=1);
  'navigation' => [...],
);
```

### Errore 2: Parentesi non bilanciate
```php
// ❌ ERRATO
return [
  'fields' => [
    'name' => [
      'label' => 'Name',
    ], // Mancano parentesi di chiusura
);
```

## Soluzioni Implementate

### 1. Correzione Posizionamento declare()
- Spostare `declare(strict_types=1);` subito dopo `<?php`
- Mantenere la struttura corretta del file

### 2. Correzione Parentesi Bilanciate
- Verificare che ogni array abbia la parentesi di chiusura corrispondente
- Controllare la struttura gerarchica degli array

### 3. Struttura Corretta
```php
<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Name',
            'placeholder' => 'Enter name',
            'help' => 'Enter your full name',
        ],
    ],
    'navigation' => [
        'label' => 'Navigation Label',
        'group' => 'Module',
        'icon' => 'heroicon-o-cog',
        'sort' => 50,
    ],
];
```

## Best Practices per File di Traduzione

1. **Struttura Standard**
   - `declare(strict_types=1);` sempre dopo `<?php`
   - Array con sintassi breve `[]`
   - Struttura espansa per campi con `label`, `placeholder`, `help`

2. **Validazione**
   - Controllare parentesi bilanciate
   - Verificare virgole e sintassi
   - Testare con PHPStan livello 9+

3. **Organizzazione**
   - Raggruppare traduzioni per contesto
   - Mantenere coerenza tra moduli
   - Documentare modifiche

## Checklist di Verifica Post-Correzione

- [x] Tutti i file hanno `declare(strict_types=1);` posizionato correttamente
- [x] Tutte le parentesi sono bilanciate
- [x] Struttura array corretta con sintassi breve `[]`
- [x] File testati con PHPStan
- [x] Documentazione aggiornata

## Collegamenti

- [Translation Best Practices](../../docs/translation-best-practices.md)
- [PHPStan Configuration](../../docs/phpstan/configuration.md)
- [Module Documentation Standards](module_documentation_standards.md)

## Ultimo Aggiornamento
2025-01-06 - Correzione errori sintassi file traduzione ✅ COMPLETATO
