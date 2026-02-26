# Struttura del Progetto il progetto

## Panoramica

Il progetto il progetto segue una struttura ben definita che separa chiaramente i componenti funzionali (moduli) dai componenti di presentazione (temi). Questa documentazione descrive la struttura corretta del progetto e le convenzioni da seguire.

> ⚠️ **IMPORTANTE**: Tutti i percorsi all'interno dell'applicazione Laravel DEVONO includere il segmento `laravel/`. Ad esempio, il percorso corretto per un file nel tema One è `/var/www/html/base_<nome progetto>/laravel/Themes/One/...` e NON `/var/www/html/base_<nome progetto>/Themes/One/...`

## Struttura Directory Principale

```
/var/www/html/<nome progetto>/
├── laravel/                 # Installazione Laravel (posizione corretta)
│   ├── app/                 # Codice applicativo base
│   ├── config/              # Configurazioni
│   ├── database/            # Migrazioni e seeders
│   ├── Modules/             # Moduli funzionali
│   ├── Themes/              # Temi e componenti UI
│   ├── resources/           # Asset non compilati
│   ├── public/              # Asset compilati e punto d'ingresso web
│   └── ...                  # Altri file e directory Laravel
├── docs/                    # Documentazione del progetto
└── bashscripts/             # Script di automazione
```

## Struttura Moduli

I moduli sono componenti funzionali che implementano la logica di business e vanno posizionati in `/var/www/html/<nome progetto>/laravel/Modules/`:

```
laravel/Modules/
├── Xot/                     # Modulo base con utility
├── Lang/                    # Gestione multilingua
├── User/                    # Gestione utenti
├── Tenant/                  # Supporto multi-tenant
├── Gdpr/                    # Conformità GDPR
└── ...                      # Altri moduli funzionali
```

## Struttura Temi

I temi sono componenti di presentazione che implementano l'interfaccia utente e vanno posizionati in `/var/www/html/<nome progetto>/laravel/Themes/`:

```
laravel/Themes/
└── One/                     # Tema principale ThemeOne
    ├── Resources/
    │   ├── assets/          # File CSS, JS, immagini
    │   ├── views/           # Template Blade
    │   └── lang/            # File di traduzione
    ├── Http/
    │   ├── Controllers/     # Controller specifici del tema
    │   └── Livewire/        # Componenti Livewire
    ├── routes/              # Route specifiche del tema
    └── Config/              # Configurazioni del tema
```

## Struttura Interna dei Moduli

Ogni modulo Laraxot segue questa struttura interna:

```
Modules/NomeModulo/
├── app/                     # Codice del modulo (namespace: Modules\NomeModulo\)
│   ├── Console/             # Comandi Artisan
│   ├── Http/                # Controller, Middleware, Requests
│   ├── Models/              # Modelli Eloquent
│   ├── Providers/           # Service Provider
│   └── ...                  # Altri componenti
├── config/                  # Configurazioni del modulo
├── database/
│   ├── migrations/          # Migrazioni specifiche del modulo
│   └── seeders/             # Seeders specifici del modulo
├── resources/
│   ├── assets/              # Asset specifici del modulo
│   ├── lang/                # Traduzioni
│   └── views/               # Viste Blade
├── routes/                  # Route del modulo
├── composer.json            # Dipendenze del modulo
└── module.json              # Metadati del modulo
```

## Convenzioni Importanti

### Namespace dei Moduli

I moduli Laraxot utilizzano una struttura particolare per i namespace:

- **Struttura fisica**: I file si trovano nella sottodirectory `app/` del modulo
- **Namespace logico**: Nonostante la posizione fisica, il namespace NON include "App"

Esempio:
- File fisico: `Modules/Chart/app/Providers/ChartServiceProvider.php`
- Namespace: `Modules\Chart\Providers\ChartServiceProvider`

### Configurazione Composer

Nel file `composer.json` principale, è fondamentale NON includere:

```json
"autoload": {
    "psr-4": {
        "Modules\\": "Modules/"  // NON includere questa riga
    }
}
```

La configurazione corretta è:

```json
"autoload": {
    "psr-4": {
        "App\\": "app/",
        "Database\\Factories\\": "database/factories/",
        "Database\\Seeders\\": "database/seeders/"
    }
}
```

### Gestione Migrazioni

Tutte le migrazioni sono contenute all'interno dei moduli. Prima di eseguire qualsiasi comando di migrazione, è necessario rimuovere le migrazioni centrali:

```bash
rm -rf database/migrations
```

## Collegamenti Bidirezionali

- [Documentazione Generale](../../../../project_docs/README.md) - Indice della documentazione
- [Convenzioni di Naming](../namespace-conventions.md) - Convenzioni per i namespace
- [Architettura Folio+Volt](../folio_volt_architecture.md) - Architettura frontend
- [Struttura dei Percorsi - Tema One](../../../Themes/One/project_docs/project-paths.md) - Guida dettagliata sui percorsi corretti nel progetto
## Collegamenti tra versioni di struttura-progetto.md
* [struttura-progetto.md](docs/tecnico/struttura/struttura-progetto.md)
* [struttura-progetto.md](docs/tecnico/struttura-progetto.md)
* [struttura-progetto.md](../../../Xot/project_docs/architecture/struttura-progetto.md)

