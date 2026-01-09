# Standardizzazione Traduzioni Modulo Notify

## Panoramica delle Problematiche

Durante l'analisi del codice è emerso che numerosi file di traduzione nel modulo Notify non rispettano gli standard definiti per . Questo documento riassume i problemi identificati e le strategie di correzione implementate.

## Standard Violati

1. **Naming dei File**
   - Alcuni file utilizzano convenzioni di naming non conformi
   - Esempio: `send_whats_app.php` invece di `send_whatsapp.php`
   - Regola: i termini composti come "WhatsApp" devono essere trattati come un'unica parola in snake_case

2. **Struttura dei File**
   - Numerosi file mancano della dichiarazione `declare(strict_types=1);`
   - Manca spesso la sezione `resource` obbligatoria
   - Le strutture gerarchiche sono incomplete rispetto agli standard richiesti

3. **Messaggi da Tradurre**
   - I messaggi utilizzano strutture incoerenti
   - Mancano spesso elementi importanti come placeholder, helper_text, tooltip

## Standardizzazione Implementata

### Documenti di Riferimento
- [Regole di Naming per i File di Traduzione](../../Notify/docs/TRANSLATION_FILE_NAMING_RULES.md)
- [Guida alla Struttura dei File di Traduzione](../../Notify/docs/TRANSLATION_FILE_STRUCTURE_GUIDE.md)
- [Progresso della Standardizzazione](../../Notify/docs/TRANSLATION_STANDARDS_PROGRESS.md)

### Struttura Standard Richiesta

```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Nome Risorsa',
        'plural' => 'Nome Risorse',
    ],
    'navigation' => [
        'name' => 'Nome Menu',
        'plural' => 'Nome Menu Plurale',
        'group' => [
            'name' => 'Gruppo Menu',
            'description' => 'Descrizione del gruppo',
        ],
        'label' => 'Etichetta Menu',
        'icon' => 'heroicon-o-icon-name',
        'sort' => 10, // Ordine nel menu
    ],
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Testo placeholder',
            'helper_text' => 'Testo di aiuto',
        ],
    ],
    'actions' => [
        'action_name' => [
            'label' => 'Etichetta Azione',
            'tooltip' => 'Descrizione tooltip',
            'success_message' => 'Messaggio di successo',
            'error_message' => 'Messaggio di errore',
        ],
    ],
    'messages' => [
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore',
        'confirmation' => 'Sei sicuro di voler continuare?',
    ],
];
```

## Piano di Standardizzazione

1. **Fase 1: Documentazione e Mappatura**
   - ✅ Creazione della documentazione di riferimento
   - ✅ Identificazione di tutti i file non conformi
   - ✅ Definizione degli standard di correzione

2. **Fase 2: Implementazione Prioritaria**
   - ✅ Correzione dei file con naming errato
   - ✅ Standardizzazione dei file più utilizzati
   - ⏳ Aggiornamento progressivo di tutti i file

3. **Fase 3: Verifica e Validazione**
   - ⏳ Controllo dei riferimenti nel codice
   - ⏳ Test di funzionalità con i nuovi file
   - ⏳ Validazione della coerenza tra le lingue

## Impatto della Standardizzazione

La corretta implementazione degli standard di traduzione garantisce:
- Coerenza nell'interfaccia utente
- Facilità di manutenzione
- Miglior supporto per la localizzazione
- Conformità alle best practice di Laravel e 

## Collegamenti alla Documentazione

- [Regole Generali per le Traduzioni](./TRANSLATION_KEYS_RULES.md)
- [Best Practices per le Traduzioni](./TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Convenzioni di Traduzione nel Modulo Notify](../../Notify/docs/TRANSLATION_CONVENTIONS.md)
