# Migrazione Struttura Modulo Cms

## Cambiamenti Strutturali

### 1. Consolidamento Directory
- `View/` → `resources/views/`
- `Routes/` → `routes/`
- `Resources/` → `resources/`
- `Models/` → `app/Models/`
- `Presenters/` → `app/Presenters/`
- `Database/` → `database/`
- `Datas/` → `app/Datas/`
- `Actions/` → `app/Actions/`
- `Config/` → `config/`
- `Http/` → `app/Http/`
- `Providers/` → `app/Providers/`
- `Console/` → `app/Console/`
- `Filament/` → `app/Filament/`

### 2. Consolidamento Documentazione
- `_docs/` → `docs/`
- `docs/` → `docs/`

### 3. Consolidamento Test
- `Tests/` → `tests/`
- `tests/` → `tests/`

### 4. Consolidamento Lingue
- `lang/` → `resources/lang/`

## File di Configurazione
I seguenti file di configurazione verranno consolidati:
- `phpstan.neon.dist` → `.phpstan/phpstan.neon`
- `phpstan-baseline.neon` → `.phpstan/baseline.neon`
- `phpstan_constants.php` → `config/phpstan.php`
- `phpmd.ruleset.xml` → `.phpmd/ruleset.xml`
- `pint.json` → `.pint.json`
- `rector.php` → `.rector.php`
- `.php-cs-fixer.dist.php` → `.php-cs-fixer.php`

## Struttura Finale
```
Modules/Cms/
├── app/
│   ├── Actions/
│   ├── Console/
│   ├── Datas/
│   ├── Filament/
│   ├── Http/
│   ├── Models/
│   ├── Presenters/
│   ├── Providers/
│   └── Services/
├── config/
├── database/
├── docs/
├── resources/
│   ├── lang/
│   ├── views/
│   └── assets/
├── routes/
├── tests/
├── .circleci/
├── .github/
├── .phpstan/
├── .phpmd/
├── .vscode/
├── .editorconfig
├── .gitattributes
├── .gitignore
├── .php-cs-fixer.php
├── .pint.json
├── .rector.php
├── composer.json
├── module.json
├── phpunit.xml.dist
├── README.md
└── testbench.yaml
```

## Note Importanti
1. Tutti i namespace verranno aggiornati di conseguenza
2. I riferimenti nei file di configurazione verranno aggiornati
3. I test verranno aggiornati per riflettere la nuova struttura
4. La documentazione verrà aggiornata per riflettere i cambiamenti

## Timeline
1. Creazione nuova struttura
2. Migrazione file per file
3. Aggiornamento namespace
4. Aggiornamento configurazioni
5. Aggiornamento documentazione
6. Verifica funzionamento
7. Cleanup vecchia struttura

## Rollback
In caso di problemi, è possibile:
1. Mantenere la vecchia struttura come backup
2. Creare un branch di backup
3. Documentare i punti di rollback 