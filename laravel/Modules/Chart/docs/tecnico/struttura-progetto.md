# Struttura del Progetto il progetto

## Struttura delle Directory

```
/var/www/html/<nome progetto>/
├── docs/                     # Documentazione del progetto
├── laravel/                  # Installazione Laravel (percorso corretto)
│   ├── app/                  # Core application code
│   ├── bootstrap/            # Framework bootstrap files
│   ├── config/               # Configuration files
│   ├── database/             # Database migrations and seeds
│   ├── Modules/              # Moduli Laravel installati
│   │   ├── Xot/              # Modulo Core per utility e configurazioni base
│   │   ├── Patient/          # Modulo per gestione pazienti e anagrafica
│   │   ├── Dental/           # Modulo per gestione visite e trattamenti
│   │   ├── ISEE/             # Modulo per validazione economica
│   │   ├── UI/               # Componenti UI per Filament
│   │   ├── User/             # Gestione utenti e permessi
│   │   ├── Tenant/           # Gestione multitenant
│   │   └── GDPR/             # Gestione consensi e privacy
│   ├── public/               # Web server document root
│   ├── resources/            # Views, assets, and language files
│   ├── routes/               # Route definitions
│   ├── storage/              # Logs, cache, uploaded files (ensure proper permissions)
│   ├── tests/                # Automated tests
│   ├── vendor/               # Composer dependencies
│   ├── .env                  # Environment variables
│   ├── composer.json         # Composer dependencies and scripts
│   └── package.json          # NPM dependencies
└── .cursor/                  # Configurazioni IDE
    └── rules/                # Regole per l'ambiente di sviluppo
```

## Note Importanti

1. **Percorso Laravel**: L'installazione Laravel deve essere posizionata in `/var/www/html/<nome progetto>/laravel` e non in altra directory. Questo è fondamentale per il corretto funzionamento del progetto.

2. **Struttura Modulare**: Tutti i moduli custom devono essere creati nella directory `laravel/Modules/` seguendo le convenzioni di nwidart/laravel-modules.

3. **Integrazione Moduli Laraxot**: I moduli Laraxot verranno integrati tramite git subtree in `laravel/Modules/`.

## Comandi di Installazione

```bash

# 1. Installare Laravel Installer globalmente
composer global require laravel/installer -W

# 2. Creare nuovo progetto Laravel nella directory corretta
laravel new laravel

# 3. Entrare nella directory del progetto
cd laravel

# 4. Installare Laravel Modules
composer require nwidart/laravel-modules
```

## Struttura del Database

### Migrazioni

In il progetto, tutte le migrazioni sono gestite all'interno dei moduli Laraxot. La struttura è la seguente:

```
/var/www/html/<nome progetto>/laravel/
├── Modules/           # Contiene i moduli Laraxot
│   └── [ModuleName]/  # Ogni modulo contiene le proprie migrazioni
│       └── database/
│           └── migrations/
│               └── *.php
└── database/         # Directory per factory e seeder
    ├── factories/
    └── seeders/
```

**IMPORTANTE**: Non creare migrazioni nella directory `database/migrations` del progetto principale. Tutte le migrazioni devono essere contenute nei rispettivi moduli.

### Connessioni Database

Il progetto utilizza due connessioni database principali:
- `mysql`: Connessione principale per l'applicazione
- `xot`: Connessione specifica per i moduli Laraxot

## Collegamenti tra versioni di struttura-progetto.md
* [struttura-progetto.md](docs/tecnico/struttura/struttura-progetto.md)
* [struttura-progetto.md](docs/tecnico/struttura-progetto.md)
* [struttura-progetto.md](laravel/Modules/Xot/docs/architecture/struttura-progetto.md)

