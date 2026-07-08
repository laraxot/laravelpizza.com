# PrepareEvaluationDataAction

## 📋 Descrizione

Action per preparare i dati di valutazione da un record scheda per logging, report e audit trail.

**Path**: `Modules/Ptv/app/Actions/Scheda/PrepareEvaluationDataAction.php`

## 🎯 Scopo

Estrarre tutti i dati di valutazione necessari da un record `SchedaContract`, inclusi:
- Dati base scheda (matr, cognome, nome, anno, ente, stabi, repar)
- Dati valutatore (se relazione caricata)

## 📝 Utilizzo

```php
use Modules\Ptv\Actions\Scheda\PrepareEvaluationDataAction;

$evaluationData = app(PrepareEvaluationDataAction::class)
    ->execute($record);
```

## 📊 Dati Ritornati

```php
[
    'matr' => '12345',
    'cognome' => 'Rossi',
    'nome' => 'Mario',
    'anno' => 2024,
    'ente' => 'Ente',
    'stabi' => 'STABI001',
    'repar' => 'REPAR001',
    'valutatore_id' => 42,        // null se relazione non caricata
    'valutatore_nome' => 'Nome',   // null se relazione non caricata
]
```

## 🔍 Logica Implementazione

1. Estrae dati base sempre disponibili
2. Verifica se il record è un `Model` (per accesso relazioni)
3. Controlla se relazione `valutatore` esiste ed è caricata
4. Usa `getAttribute()` per accesso sicuro alla relazione
5. Estrae dati valutatore se disponibili

## ✅ Vantaggi

- **Riutilizzabile** - Usabile in qualsiasi contesto di logging
- **Sicuro** - Gestisce correttamente casi null e relazioni non caricate
- **DRY** - Logica centralizzata, evitando duplicazione
- **Testabile** - Facile da testare in isolamento

## 🔗 Collegamenti

- [Email Sending Activity Log](./email-sending-activity-log.md)
- [SendMailByRecord Action](../app/Actions/Scheda/SendMailByRecord.php)
- [GetFilenameBySchedaAction](./get-filename-by-scheda-action.md)

