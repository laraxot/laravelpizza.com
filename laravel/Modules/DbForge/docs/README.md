# Modulo DbForge

## Descrizione

Il modulo DbForge fornisce strumenti avanzati per la gestione e manipolazione del database nel sistema TechPlanner. Questo modulo è progettato per offrire funzionalità di database management attraverso un'interfaccia Filament.

## Caratteristiche

- **Gestione Database**: Strumenti per la gestione avanzata del database
- **Migrazioni**: Supporto per migrazioni complesse e personalizzate
- **Schema Management**: Gestione dello schema del database
- **Query Builder**: Interfaccia per la costruzione di query complesse
- **Backup e Restore**: Funzionalità di backup e ripristino del database

## Struttura del Modulo

```
Modules/DbForge/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Models/
│   ├── Providers/
│   │   ├── DbForgeServiceProvider.php
│   │   └── Filament/
│   │       └── AdminPanelProvider.php
│   └── Services/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── docs/
├── lang/
├── resources/
│   ├── views/
│   └── js/
├── routes/
└── tests/
```

## Installazione

Il modulo è già incluso nel progetto principale. Per attivarlo:

1. Assicurarsi che il modulo sia presente in `Modules/DbForge/`
2. Verificare che i provider siano registrati in `config/app.php`
3. Eseguire le migrazioni: `php artisan migrate`

## Configurazione

### Provider

Il modulo registra automaticamente i seguenti provider:

- `Modules\DbForge\Providers\DbForgeServiceProvider`
- `Modules\DbForge\Providers\Filament\AdminPanelProvider`

### Dipendenze

Il modulo richiede i seguenti moduli:
- Xot (modulo base)
- User (modulo utenti)

## Utilizzo

### Accesso all'Interfaccia

L'interfaccia Filament è accessibile attraverso il pannello di amministrazione del sistema.

### API

Il modulo fornisce API REST per le operazioni di database management.

## Sviluppo

### Test

Eseguire i test con:
```bash
./vendor/bin/pest --no-coverage
```

### Analisi del Codice

Eseguire l'analisi statica con:
```bash
vendor/bin/phpstan analyse
```

### Formattazione

Formattare il codice con:
```bash
vendor/bin/php-cs-fixer fix --allow-risky=yes
```

## Documentazione Tecnica

Per informazioni tecniche dettagliate, consultare i file nella cartella `docs/`.

## Licenza

MIT License - vedere il file LICENSE per i dettagli. 