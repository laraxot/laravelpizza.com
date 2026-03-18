# Conformità PSR-4 nel Progetto

## Introduzione

Lo standard PSR-4 per l'autoloading è cruciale per il corretto funzionamento del progetto. PSR-4 definisce come le classi PHP devono essere organizzate nel filesystem per permettere l'autoloading automatico senza la necessità di `require` o `include`.

## Regole PSR-4 di base

1. **Corrispondenza Namespace-Directory**: Il namespace completo della classe deve corrispondere alla struttura della directory
2. **Base Namespace**: Il namespace base deve essere mappato alla directory base
3. **Un file, una classe**: Ogni file PHP deve contenere una sola classe/interfaccia/trait
4. **Case sensitivity**: Rispettare esattamente la capitalizzazione (PascalCase per classi, kebab-case per directory)

## Configurazione PSR-4 nel progetto

La configurazione dell'autoloading PSR-4 è definita nel file `composer.json`:

```json
"autoload": {
    "psr-4": {
        "App\\": "app/",
        "Modules\\": "Modules/"
    }
}
```

## Struttura corretta dei namespace nei moduli

### Per i moduli Laravel:

1. **Namespace base**: `Modules\NomeModulo\`
2. **Directory base**: `Modules/NomeModulo/app/`
3. **Esempi**:
   - Classe: `Modules\User\Filament\Resources\UserResource`
   - File: `Modules/User/app/Filament/Resources/UserResource.php`

### Errori comuni

#### Namespace errato
```php
// ERRATO ❌
namespace App\Filament\Blocks;  // dentro Modules/UI/app/Filament/Blocks/Page.php

// CORRETTO ✅
namespace Modules\UI\Filament\Blocks;
```

#### Directory duplicata
```
// ERRATO ❌
Modules/User/app/Enums/Enums/LanguageEnum.php

// CORRETTO ✅
Modules/User/app/Enums/LanguageEnum.php
```

#### Namespace non corrispondente alla directory del modulo
```php
// ERRATO ❌
namespace Modules\Core\Models;  // dentro Modules/User/app/Models/User.php

// CORRETTO ✅
namespace Modules\User\Models;
```

## Diagnostica errori PSR-4

Quando si incontra un errore PSR-4:

```
Class Modules\User\Enums\LanguageEnum located in ./Modules/User/app/Enums/Enums/LanguageEnum.php does not comply with psr-4 autoloading standard (rule: Modules\User\ => ./Modules/User/app). Skipping.
```

### Passi per la risoluzione:

1. **Identificare la discrepanza**: Confrontare il namespace dichiarato con il percorso del file
2. **Verificare directory duplicate**: Controllare per percorsi ridondanti come `Enums/Enums/`
3. **Correggere il namespace o il percorso**: Spostare il file o correggere il namespace
4. **Rigenerare autoloader**: Eseguire `composer dump-autoload` dopo le correzioni

## Regole Specifiche per Componenti Blade e Livewire

### Componenti Blade:
- **Namespace**: `Modules\NomeModulo\View\Components`
- **Directory**: `Modules/NomeModulo/View/Components/`
- **Registrazione**: Automatica via `XotBaseServiceProvider`

### Componenti Livewire:
- **Namespace**: `Modules\NomeModulo\Http\Livewire`
- **Directory**: `Modules/NomeModulo/app/Http/Livewire/`
- **Registrazione**: Automatica via `XotBaseServiceProvider`

## Best Practice

1. **Usare namespace completi negli import**: Evitare alias che potrebbero confondere
2. **Mantenere un'unica classe per file**: Facilita la manutenzione e l'autoloading
3. **Rispettare la struttura dei moduli**: Non mescolare codice tra moduli diversi
4. **Verificare regolarmente l'autoloading**: Eseguire controlli periodici di conformità PSR-4
5. **Documentare strutture non standard**: Se ci sono eccezioni, documentarle chiaramente

## Comandi utili

```bash

# Verifica PSR-4
composer dump-autoload --optimize

# Lista classi non conformi
find . -name "*.php" | xargs grep -l "^namespace" | xargs php -l

# Generare classi con namespace corretto
php artisan make:class Modules/NomeModulo/NomeClasse
```

## Riferimenti

- [PSR-4: Autoloader Standard](https://www.php-fig.org/psr/psr-4/)
- [Laravel Modules Structure](https://github.com/nWidart/laravel-modules)
- [Composer Autoloading](https://getcomposer.org/doc/04-schema.md#autoload)
