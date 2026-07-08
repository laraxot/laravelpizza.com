# Struttura delle Directory nei Moduli Laraxot PTVX

## Due Regole Fondamentali

### Regola #1: Codice dell'Applicazione in APP
**Tutto il codice PHP dell'applicazione DEVE essere posizionato all'interno della directory `app` del modulo.**

### Regola #2: File di Supporto FUORI da APP
**I file di configurazione, rotte, localizzazione e database DEVONO rimanere nella radice del modulo.**

## Esempi

### Codice dell'Applicazione (DEVE essere in app/)

❌ **ERRATO:**
```
Modules/Rating/Enums/SupportedLocale.php
Modules/Rating/Http/Controllers/RatingController.php
Modules/Rating/Models/Rating.php
```

✅ **CORRETTO:**
```
Modules/Rating/app/Enums/SupportedLocale.php
Modules/Rating/app/Http/Controllers/RatingController.php
Modules/Rating/app/Models/Rating.php
```

### File di Supporto (DEVONO rimanere fuori da app/)

❌ **ERRATO:**
```
Modules/Rating/app/config/rating.php
Modules/Rating/app/routes/web.php
Modules/Rating/app/lang/it/rating.php
Modules/Rating/app/database/migrations/create_ratings_table.php
```

✅ **CORRETTO:**
```
Modules/Rating/config/rating.php
Modules/Rating/routes/web.php
Modules/Rating/lang/it/rating.php
Modules/Rating/database/migrations/create_ratings_table.php
```

## Eccezioni Consentite (NON spostare in app/)

I seguenti file PHP devono rimanere al di fuori della directory `app`:

- `config/`: File di configurazione
- `database/`: Migrazioni, seeder e factories
- `routes/`: Route del modulo
- `resources/`: Risorse frontend (viste Blade)
- `lang/`: File di localizzazione e traduzioni
- `docs/`: Documentazione del modulo
- `.vscode/`: File di configurazione dell'editor
- `.php-cs-fixer.*`: File di configurazione per PHP-CS-Fixer
- `phpstan*.php`: File di configurazione per PHPStan

## Struttura Completa Corretta

```
Modules/NomeModulo/
├── app/                    # TUTTO il codice dell'applicazione
│   ├── Actions/            # Azioni (QueueableAction)
│   ├── Datas/              # Data Objects (Spatie Laravel Data)
│   ├── Enums/              # Enumerazioni
│   ├── Http/               # HTTP Controllers, Middleware, ecc.
│   ├── Models/             # Modelli Eloquent
│   ├── Providers/          # Service Providers
│   └── ...                 # Altri componenti dell'applicazione
├── config/                 # NON spostare in app/
├── database/               # NON spostare in app/
├── lang/                   # NON spostare in app/
├── routes/                 # NON spostare in app/
└── resources/              # NON spostare in app/
```

## Verifica Della Struttura

Per verificare che non ci siano file dell'applicazione nella radice del modulo:

```bash
./bashscripts/check_before_phpstan.sh NomeModulo
```

## Correzione Automatica

Per correggere automaticamente la struttura (sposta solo i file dell'applicazione in app/, lascia i file di supporto dove sono):

```bash
./bashscripts/fix_directory_structure.sh NomeModulo
```

## Ricorda

- Se vedi `Modules/Rating/lang/it/rating.php`, è **corretto** e non deve essere spostato in app/
- Se vedi `Modules/Rating/Http/Controllers/RatingController.php`, è **errato** e deve essere spostato in app/Http/Controllers/

## Script di Verifica

Prima di eseguire PHPStan o fare commit del codice, eseguire questo controllo:

```bash
find Modules/NomeModulo -type f -name "*.php" | grep -v "/app/" | grep -v "/config/" | grep -v "/database/" | grep -v "/routes/" | grep -v "/resources/" | grep -v "/docs/"
```

Se il comando restituisce dei file, devono essere spostati nella directory `app` appropriata. 