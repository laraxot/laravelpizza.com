# Traduzioni del Modulo Activity

## Collegamenti

- [Modulo Lang](../../Lang/docs/module_lang.md) - Documentazione principale sulle traduzioni
- [Regole Generali Traduzioni](../../Xot/docs/translations.md)
- [Activity Module Fixes](../../.cursor/rules/activity-module-fixes.mdc) - Correzioni applicate dicembre 2024

## Struttura

```
Modules/Activity/
└── lang/
    ├── it/
    │   ├── activity.php
    │   ├── stored_event.php
    │   ├── snapshots.php
    │   ├── dashboard.php
    │   ├── log.php
    │   └── snapshot.php
    └── en/
        └── activity.php
```

## Aggiornamenti Dicembre 2024

### Conformità alle Regole Laraxot

I file di traduzione del modulo Activity sono stati aggiornati per conformarsi alle **regole di struttura espansa obbligatoria**:

**Prima (struttura semplificata):**
```php
'fields' => [
    'user' => [
        'label' => 'Utente',
        'name' => 'Nome',
    ],
]
```

**Dopo (struttura espansa conforme):**
```php
'fields' => [
    'user' => [
        'label' => 'Utente',
        'placeholder' => 'Seleziona un utente',
        'help' => 'L\'utente che ha eseguito l\'azione',
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome completo dell\'utente',
        ],
    ],
]
```

### Miglioramenti Implementati

1. **Struttura Espansa Completa**
   - Ogni campo include `label`, `placeholder` e `help`
   - Organizzazione gerarchica per azioni e filtri
   - Messaggi di feedback specifici per ogni azione

2. **Standard di Codifica**
   - Aggiunta `declare(strict_types=1)` in tutti i file
   - Utilizzo sintassi array breve `[]` invece di `array()`
   - Organizzazione coerente delle chiavi

3. **Completezza Funzionale**
   - Azioni con messaggi di successo, errore e conferma
   - Filtri con placeholder e help text appropriati
   - Sezioni di esportazione e configurazione

## Contenuto Principale

Il file `activity.php` contiene le traduzioni per:

### Campi Form (fields)
- **user**: Informazioni utente (nome, email, ruolo)
- **action**: Tipi di azione (created, updated, deleted, viewed, etc.)
- **subject**: Oggetto dell'azione (tipo, ID, nome)
- **description**: Descrizione dell'attività
- **ip_address**: Indirizzo IP dell'utente
- **user_agent**: Informazioni browser/sistema
- **created_at**: Data e ora dell'attività
- **properties**: Proprietà aggiuntive (vecchio/nuovo valore)

### Azioni (actions)
- **view_details**: Visualizzazione dettagli attività
- **export**: Esportazione dati attività
- **clear_old**: Pulizia attività vecchie

### Filtri (filters)
- **user**: Filtro per utente
- **action**: Filtro per tipo azione
- **subject_type**: Filtro per tipo oggetto
- **date_range**: Filtro per intervallo date
- **ip_address**: Filtro per indirizzo IP

### Messaggi e Esportazione
- Messaggi di feedback per operazioni
- Formati di esportazione (CSV, Excel, PDF)
- Colonne personalizzabili per export

## File stored_event.php

Traduzioni specifiche per gli eventi archiviati:

### Campi Specifici
- **event_class**: Classe dell'evento
- **event_properties**: Proprietà dell'evento
- **aggregate_uuid**: UUID dell'aggregato
- **aggregate_version**: Versione dell'aggregato
- **event_version**: Versione dell'evento
- **meta_data**: Metadata aggiuntivi

### Azioni Specializzate
- **replay**: Replay dell'evento
- **export**: Esportazione eventi

## Best Practices Applicate

### Struttura Obbligatoria
```php
'campo_nome' => [
    'label' => 'Etichetta Campo',           // Obbligatorio
    'placeholder' => 'Testo placeholder',   // Obbligatorio
    'help' => 'Testo di aiuto',            // Obbligatorio
],
```

### Azioni Complete
```php
'nome_azione' => [
    'label' => 'Etichetta Azione',
    'success' => 'Messaggio successo',
    'error' => 'Messaggio errore',
    'confirmation' => 'Messaggio conferma',  // Per azioni distruttive
],
```

### Filtri con Aiuto
```php
'nome_filtro' => [
    'label' => 'Etichetta Filtro',
    'placeholder' => 'Placeholder filtro',
    'help' => 'Spiegazione utilizzo filtro',
],
```

## Validazione e Controlli

### Lista di Controllo
- [x] Struttura espansa implementata per tutti i campi
- [x] `declare(strict_types=1)` aggiunto
- [x] Sintassi array breve `[]` utilizzata
- [x] Azioni con messaggi completi (success, error, confirmation)
- [x] Filtri con placeholder e help appropriati
- [x] Organizzazione gerarchica coerente
- [x] Collegamenti bidirezionali con documentazione root

### Errori Corretti
1. **Struttura non espansa**: Risolto con implementazione completa
2. **Mancanza declare(strict_types=1)**: Aggiunto a tutti i file
3. **Sintassi array obsoleta**: Migrata a sintassi moderna
4. **Messaggi azioni incompleti**: Completati con tutti i casi d'uso

## Note per Sviluppi Futuri

1. **Mantenimento Standard**: Seguire sempre la struttura espansa per nuovi campi
2. **Consistenza**: Utilizzare terminologia coerente con altri moduli
3. **Localizzazione**: Considerare traduzioni per altre lingue mantenendo la stessa struttura
4. **Validazione**: Includere controlli automatici per verificare la conformità

## Collegamenti tra versioni di translations.md
* [translations.md](laravel/Modules/Chart/docs/translations.md)
* [translations.md](laravel/Modules/Reporting/docs/translations.md)
* [translations.md](laravel/Modules/Gdpr/docs/translations.md)
* [translations.md](laravel/Modules/Notify/docs/translations.md)
* [translations.md](laravel/Modules/Xot/docs/roadmap/lang/translations.md)
* [translations.md](laravel/Modules/Xot/docs/translations.md)
* [translations.md](laravel/Modules/Dental/docs/translations.md)
* [translations.md](laravel/Modules/User/docs/translations.md)
* [translations.md](laravel/Modules/UI/docs/translations.md)
* [translations.md](laravel/Modules/Lang/docs/packages/translations.md)
* [translations.md](laravel/Modules/Lang/docs/translations.md)
* [translations.md](laravel/Modules/Job/docs/translations.md)
* [translations.md](laravel/Modules/Media/docs/translations.md)
* [translations.md](laravel/Modules/Tenant/docs/translations.md)
* [translations.md](laravel/Modules/Activity/docs/translations.md)
* [translations.md](laravel/Modules/Patient/docs/translations.md)
* [translations.md](laravel/Modules/Cms/docs/translations.md)

