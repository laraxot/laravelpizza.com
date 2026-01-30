# Gestione delle Migrazioni nei Moduli Laraxot

## Importante: Migrazioni Centralizzate nei Moduli

In il progetto, tutte le migrazioni sono gestite all'interno dei moduli Laraxot. Questo approccio è fondamentale per:

1. **Modularità**: Ogni modulo contiene le proprie migrazioni, rendendo il sistema più modulare e portabile
2. **Indipendenza**: I moduli possono essere installati/rimossi senza impattare altri moduli
3. **Versionamento**: Le migrazioni sono versionate insieme al modulo
4. **Manutenibilità**: Più facile gestire e aggiornare le migrazioni per modulo

## Procedura Corretta per le Migrazioni

### 1. Rimozione delle Migrazioni Locali

Prima di eseguire le migrazioni, è **IMPORTANTE** rimuovere le migrazioni locali:

```bash
rm -rf database/migrations
```

Questo è necessario perché:
- Le migrazioni locali potrebbero entrare in conflitto con quelle dei moduli
- I moduli Laraxot gestiscono le proprie migrazioni in modo indipendente
- Evita duplicazioni e potenziali errori di migrazione

### 2. Esecuzione delle Migrazioni

Dopo aver rimosso le migrazioni locali, eseguire:

```bash
php artisan migrate
```

Questo comando:
- Rileverà automaticamente le migrazioni in tutti i moduli attivi
- Eseguirà le migrazioni nell'ordine corretto basato sulle dipendenze
- Gestirà le migrazioni per ogni modulo in modo indipendente

## Struttura delle Migrazioni nei Moduli

Ogni modulo Laraxot contiene le proprie migrazioni in:

```
Modules/[ModuleName]/
└── database/
    └── migrations/
        ├── 2024_01_01_000001_create_module_table.php
        └── ...
```

## Vantaggi di Questo Approccio

1. **Isolamento**: Ogni modulo gestisce il proprio schema del database
2. **Portabilità**: I moduli possono essere riutilizzati in altri progetti
3. **Manutenibilità**: Più facile aggiornare e mantenere le migrazioni
4. **Versionamento**: Le migrazioni sono versionate con il modulo
5. **Dipendenze**: Gestione chiara delle dipendenze tra moduli

## Considerazioni Importanti

1. **Ordine di Esecuzione**: Le migrazioni vengono eseguite nell'ordine corretto basato sulle dipendenze tra moduli
2. **Conflitti**: Evitare di creare migrazioni locali che potrebbero entrare in conflitto con quelle dei moduli
3. **Rollback**: Il rollback delle migrazioni deve essere gestito a livello di modulo
4. **Testing**: Testare sempre le migrazioni in un ambiente di sviluppo prima di applicarle in produzione

## Best Practices

1. **Non Creare Migrazioni Locali**: Tutte le migrazioni devono essere contenute nei moduli
2. **Documentazione**: Documentare sempre le modifiche allo schema del database nei moduli
3. **Versionamento**: Mantenere le migrazioni versionate con il modulo
4. **Testing**: Testare le migrazioni in un ambiente isolato
5. **Backup**: Fare sempre backup del database prima di eseguire migrazioni

## Risoluzione Problemi Comuni

### Problema: Migrazioni Duplicate
```bash

# Soluzione: Rimuovere le migrazioni locali
rm -rf database/migrations
```

### Problema: Conflitti di Dipendenze
```bash

# Soluzione: Verificare l'ordine dei moduli in config/app.php

# Assicurarsi che i moduli base siano caricati prima dei moduli che dipendono da essi
```

### Problema: Rollback Parziale
```bash

# Soluzione: Eseguire il rollback per modulo specifico
php artisan module:migrate-rollback [ModuleName]
```

## Conclusione

La gestione delle migrazioni all'interno dei moduli Laraxot è un aspetto fondamentale dell'architettura di il progetto. Seguire questa struttura garantisce:
- Modularità del sistema
- Manutenibilità del codice
- Portabilità dei moduli
- Gestione efficiente delle dipendenze

