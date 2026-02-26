# Export XLS - File di traduzione

Il file `export_xls.php` contiene tutte le etichette e i testi utilizzati per l'esportazione in formato XLS nel modulo Xot.

## Struttura

### Intestazioni
- Etichette per le intestazioni delle colonne
- Formattazione dei titoli
- Nomi dei fogli di lavoro

### Contenuto
- Etichette per i valori delle celle
- Formattazione dei dati
- Messaggi di sistema

## Best Practices

### Organizzazione
- Mantenere una struttura coerente delle chiavi
- Utilizzare nomi descrittivi per le traduzioni
- Raggruppare le traduzioni per contesto

### Manutenzione
- Aggiornare le traduzioni quando si aggiungono nuove funzionalità
- Mantenere la coerenza tra le diverse lingue
- Documentare i cambiamenti significativi

### Utilizzo
```php
// Nel codice
__('xot::export_xls.headers.title')
__('xot::export_xls.content.no_data')
```

## Lingue supportate
- Italiano (it)
- Inglese (en)

## Note per lo sviluppo
- Utilizzare sempre le chiavi di traduzione invece di stringhe hardcoded
- Mantenere le traduzioni sincronizzate tra le diverse lingue
- Aggiungere commenti per spiegare il contesto quando necessario 