# Best Practices per la Gestione dei Percorsi in <nome progetto>

## Struttura Corretta dei Percorsi

Tutti i percorsi nel progetto <nome progetto> **DEVONO** seguire questa struttura:

```
/var/www/html/<nome progetto>/laravel/Modules/{ModuleName}/...
```

## Percorsi Corretti per i Componenti Principali

| Componente | Percorso Corretto |
|------------|-------------------|
| Modelli | `/var/www/html/<nome progetto>/laravel/Modules/{ModuleName}/app/Models/` |
| Controller | `/var/www/html/<nome progetto>/laravel/Modules/{ModuleName}/app/Http/Controllers/` |
| Migrazioni | `/var/www/html/<nome progetto>/laravel/Modules/{ModuleName}/database/migrations/` |
| Seeder | `/var/www/html/<nome progetto>/laravel/Modules/{ModuleName}/database/seeders/` |
| Risorse Filament | `/var/www/html/<nome progetto>/laravel/Modules/{ModuleName}/app/Filament/Resources/` |
| Provider | `/var/www/html/<nome progetto>/laravel/Modules/{ModuleName}/app/Providers/` |
| Viste | `/var/www/html/<nome progetto>/laravel/Modules/{ModuleName}/resources/views/` |

## Percorsi ERRATI da NON Utilizzare Mai

❌ `/var/www/html/<nome progetto>/Modules/{ModuleName}/...`  
❌ `/var/www/html/<nome progetto>/laravel/app/Models/...` (a meno che non sia un modello globale)  
❌ `/var/www/html/Modules/{ModuleName}/...`  

## Utilizzo del PathHelper

Per evitare errori nei percorsi, utilizzare sempre la classe `PathHelper` fornita dal modulo Xot:

```php
use Modules\Xot\Helpers\PathHelper;

// Ottenere il percorso di un modulo
$modulePath = PathHelper::modulePath('Patient');

// Ottenere il percorso dei modelli di un modulo
$modelsPath = PathHelper::modelsPath('Patient');

// Ottenere il percorso delle migrazioni di un modulo
$migrationsPath = PathHelper::migrationsPath('Patient');

// Verificare se un percorso è valido
if (!PathHelper::isValidPath($path)) {
    $correctPath = PathHelper::correctPath($path);
    // Utilizzare $correctPath
}
```

## Comandi di Verifica e Correzione

### Verifica dei Percorsi nel Codice

Per verificare che tutti i percorsi nel codice siano corretti:

```bash
php artisan xot:verify-paths
```

### Correzione Automatica dei Percorsi

Per tentare di correggere automaticamente i percorsi errati:

```bash
php artisan xot:verify-paths --fix
```

### Verifica di un Modulo Specifico

Per verificare solo un modulo specifico:

```bash
php artisan xot:verify-paths --module=Patient
```

## Checklist per la Gestione dei Percorsi

Prima di utilizzare un percorso nel codice:

- [ ] Verificare che il percorso includa `/laravel/` dopo `/<nome progetto>/`
- [ ] Utilizzare `PathHelper` per generare i percorsi quando possibile
- [ ] Verificare la struttura effettiva con `list_dir` prima di operare su file
- [ ] Per i moduli, rispettare sempre la struttura: `/var/www/html/<nome progetto>/laravel/Modules/{ModuleName}/`

## Esempi Pratici

### Esempio 1: Accesso a un Modello

✓ Corretto:
```php
require_once '/var/www/html/<nome progetto>/laravel/Modules/Patient/app/Models/User.php';
```

✗ Errato:
```php
require_once '/var/www/html/<nome progetto>/Modules/Patient/Models/User.php';
```

### Esempio 2: Creazione di una Migrazione

✓ Corretto:
```php
// Utilizzare il comando personalizzato
php artisan xot:make-migration create_doctors_table --module=Patient --create

// Oppure specificare il percorso corretto
$migrationPath = '/var/www/html/<nome progetto>/laravel/Modules/Patient/database/migrations/';
```

✗ Errato:
```php
$migrationPath = '/var/www/html/<nome progetto>/Modules/Patient/Database/Migrations/';
```

### Esempio 3: Accesso a un Seeder

✓ Corretto:
```php
require_once '/var/www/html/<nome progetto>/laravel/Modules/Notify/database/seeders/MailTemplateSeeder.php';
```

✗ Errato:
```php
require_once '/var/www/html/<nome progetto>/Modules/Notify/database/seeders/MailTemplateSeeder.php';
```

## Risoluzione dei Problemi Comuni

### Errore: File non trovato

Se si verifica un errore "File not found", verificare che:

1. Il percorso includa `/laravel/` dopo `/<nome progetto>/`
2. La struttura delle directory sia corretta (ad es. `app/Models` e non solo `Models`)
3. Il file esista effettivamente nella posizione specificata

### Errore: Classe non trovata

Se si verifica un errore "Class not found", verificare che:

1. Il namespace della classe corrisponda alla struttura delle directory
2. Il percorso del file sia corretto
3. L'autoloader di Composer sia aggiornato (`composer dump-autoload`)

## Conclusione

Seguire queste best practices per la gestione dei percorsi è fondamentale per evitare errori nel progetto <nome progetto>. Utilizzare sempre i percorsi corretti e gli strumenti forniti per verificare e correggere eventuali errori.
