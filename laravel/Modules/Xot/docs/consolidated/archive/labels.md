# Labels - File di traduzione

Il file `labels.php` contiene tutte le etichette e i testi utilizzati nel modulo Xot.

## Struttura

### General
Contiene le etichette generali utilizzate in tutto il modulo:
- Azioni
- Stati
- Pulsanti
- Elementi di navigazione

### Backend
Contiene le etichette specifiche per il backend:

#### Dashboard
- Liste di registrazione
- Gestione pagamenti
- Liste ordini

#### Voucher
- Gestione voucher
- Creazione voucher
- Campi tabella

#### Takeaway
- Impostazioni SMS
- Gestione clienti
- Gestione abbonati
- Gestione ordini
- Gestione prelievi
- Gestione crediti SMS
- Gestione broadcast SMS
- Gestione commissioni
- Impostazioni galleria
- Gestione ricevute
- Gestione prenotazioni tavoli

## Best Practices

### Organizzazione
- Mantenere una struttura gerarchica chiara
- Raggruppare le etichette per contesto
- Utilizzare nomi descrittivi per le chiavi

### Manutenzione
- Aggiornare le traduzioni quando si aggiungono nuove funzionalità
- Mantenere la coerenza tra le diverse lingue
- Documentare i cambiamenti significativi

### Utilizzo
```php
// Nel codice
__('xot::labels.general.actions')
__('xot::labels.backend.dashboard.order_list')
```

## Esempio di struttura

```php
return [
    'general' => [
        'actions' => 'Action',
        'buttons' => [
            'save' => 'Save',
            'update' => 'Update',
        ],
    ],
    'backend' => [
        'dashboard' => [
            'order_list' => 'Order List',
        ],
    ],
];
```

## Lingue supportate
- Inglese (en)
- Italiano (it)

## Note per lo sviluppo
- Utilizzare sempre le chiavi di traduzione invece di stringhe hardcoded
- Mantenere le traduzioni sincronizzate tra le diverse lingue
- Aggiungere commenti per spiegare il contesto quando necessario 