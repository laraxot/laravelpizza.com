# Editor File di Traduzione

## Panoramica

L'Editor File di Traduzione è un'interfaccia Filament che permette di visualizzare e modificare tutti i file di traduzione dell'applicazione in modo intuitivo e sicuro.

## Accesso

L'editor è accessibile tramite:
- **Menu di navigazione**: Sistema → File di Traduzione
- **URL diretto**: `/admin/translation-files`

## Funzionalità Principali

### 1. Lista File di Traduzione

La pagina principale mostra:
- **Chiave**: Identificativo univoco del file (es: `user::auth`)
- **Nome File**: Nome del file senza estensione
- **Percorso**: Posizione del file nel filesystem
- **Numero Traduzioni**: Conteggio delle chiavi nel file
- **Ultima Modifica**: Data e ora dell'ultima modifica
- **Dimensione**: Dimensione del file in KB

### 2. Visualizzazione File

Cliccando su un file si apre la vista dettagliata che mostra:
- **Informazioni File**: Metadati completi del file
- **Traduzioni**: Chiavi e valori in formato leggibile
- **Azioni**: Pulsanti per modificare o eliminare

### 3. Modifica Traduzioni

L'editor di modifica offre:
- **Editor Key-Value**: Interfaccia intuitiva per modificare le traduzioni
- **Validazione**: Controllo automatico della sintassi PHP
- **Backup Automatico**: Salvataggio di backup prima delle modifiche
- **Notifiche**: Feedback immediato su successo/errore

## Utilizzo

### Modificare una Traduzione

1. **Accedi** alla lista dei file di traduzione
2. **Clicca** su "Modifica" per il file desiderato
3. **Modifica** le traduzioni nell'editor Key-Value
4. **Salva** le modifiche
5. **Verifica** che le modifiche siano applicate

### Aggiungere una Nuova Traduzione

1. **Apri** il file di traduzione in modalità modifica
2. **Clicca** su "Aggiungi Traduzione"
3. **Inserisci** la chiave e il valore
4. **Salva** le modifiche

### Rimuovere una Traduzione

1. **Apri** il file di traduzione in modalità modifica
2. **Clicca** sull'icona "Rimuovi" accanto alla traduzione
3. **Salva** le modifiche

## Sicurezza

### Backup Automatico

Prima di ogni modifica, il sistema:
- Crea un backup del file originale
- Salva il backup in `storage/app/backups/translations/`
- Usa timestamp per evitare conflitti

### Validazione

Il sistema verifica:
- **Sintassi PHP**: Controllo automatico della validità del codice
- **Struttura Array**: Verifica che il contenuto sia un array valido
- **Permessi File**: Controllo dei permessi di scrittura

### Gestione Errori

In caso di errore:
- **Rollback Automatico**: Ripristino del file originale
- **Notifiche**: Messaggi di errore dettagliati
- **Log**: Registrazione degli errori per debugging

## Best Practices

### 1. Struttura Chiavi

```php
// ✅ Corretto - Struttura gerarchica
return [
    'auth' => [
        'login' => [
            'title' => 'Accedi',
            'email' => 'Indirizzo Email',
        ],
    ],
];

// ❌ Errato - Chiavi piatte
return [
    'auth_login_title' => 'Accedi',
    'auth_login_email' => 'Indirizzo Email',
];
```

### 2. Naming Convention

- **snake_case**: Per tutte le chiavi
- **Gerarchia logica**: Organizzare in gruppi
- **Coerenza**: Mantenere la stessa struttura tra moduli

### 3. Validazione Contenuto

- **Verificare sintassi**: Prima di salvare
- **Testare modifiche**: In ambiente di sviluppo
- **Backup manuale**: Per modifiche critiche

## Troubleshooting

### File Non Modificabile

**Problema**: Impossibile modificare un file
**Soluzione**: 
1. Verificare i permessi del file
2. Controllare che il file non sia in sola lettura
3. Verificare lo spazio su disco

### Errore di Sintassi

**Problema**: Errore "Sintassi PHP non valida"
**Soluzione**:
1. Controllare le virgole mancanti
2. Verificare le parentesi bilanciate
3. Controllare le virgolette

### Cache Non Aggiornata

**Problema**: Le modifiche non si vedono nell'applicazione
**Soluzione**:
1. Pulire la cache: `php artisan cache:clear`
2. Pulire la cache delle traduzioni: `php artisan config:clear`
3. Riavviare il server web

## Comandi Artisan

### Backup Manuale

```bash
php artisan lang:backup
```

### Validazione File

```bash
php artisan lang:validate
```

### Sincronizzazione

```bash
php artisan lang:sync
```

## Collegamenti

- [Translation Standards](./translation-standards.md)
- [Translation System](./translation-system.md)
- [Best Practices](./translation-keys-best-practices.md)
- [File Management](./translation-file-management.md)

## Note per lo Sviluppo

1. **Performance**: I file vengono caricati on-demand
2. **Scalabilità**: Supporto per grandi volumi di traduzioni
3. **Manutenibilità**: Struttura modulare e estendibile
4. **Usabilità**: Interfaccia intuitiva per i traduttori 