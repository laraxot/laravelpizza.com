# Regole di Ereditarietà dei Modelli - Laraxot PTVX

## Principio Fondamentale

**TUTTI i modelli devono estendere il BaseModel del proprio modulo quando possibile, MAI Model direttamente, a meno che non ci siano configurazioni specifiche che richiedono l'estensione diretta.**

## Regola Generale

### ✅ CORRETTO - Estendere BaseModel del Modulo
```php
<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Modules\Sigma\Models\BaseModel;

class Integparam extends BaseModel
{
    protected $fillable = [
        'ente', 'matr', 'conome', 'nome', 'anv2kd', 'anv2ka',
        'anvist', 'anvpar', 'anvimp', 'anvqta', 'anvvoc', 'anvdes'
    ];
}
```

### ❌ ERRATO - Estendere Model Direttamente
```php
<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Model;

class Integparam extends Model // ❌ ERRATO
{
    // ...
}
```

## Motivazioni

### 1. Configurazioni Centralizzate
Il BaseModel di ogni modulo contiene configurazioni standard:
- Connessione database appropriata
- Timestamps configurati correttamente
- Cast comuni per il modulo
- Traits e funzionalità condivise

### 2. Coerenza Architetturale
- Mantiene la separazione tra moduli
- Evita duplicazione di configurazioni
- Garantisce comportamenti consistenti

### 3. Manutenibilità
- Modifiche centralizzate nel BaseModel
- Riduce la duplicazione di codice
- Facilita l'aggiornamento delle configurazioni

## Eccezioni - Quando Estendere Model Direttamente

### 1. Configurazioni Specifiche
Se un modello ha configurazioni che differiscono significativamente dal BaseModel:

```php
class Wstr01lx extends Model
{
    protected $connection = 'generale';
    public $timestamps = false;
    protected $table = 'wstr01f'; // Tabella diversa
    
    // Configurazioni specifiche che non possono essere nel BaseModel
}
```

### 2. Compatibilità Legacy
Quando il modello deve mantenere compatibilità con sistemi esterni che richiedono configurazioni specifiche.

### 3. Modelli di Sistema
Modelli che fanno parte dell'infrastruttura del framework e non del dominio di business.

## Pattern per Moduli

### Modulo Sigma
- **BaseModel**: `Modules\Sigma\Models\BaseModel`
- **Configurazioni**: `$connection = 'generale'`, `$timestamps = false`
- **Cast**: Date, decimali, interi per parametri di integrazione

### Modulo User
- **BaseModel**: `Modules\User\Models\BaseModel`
- **Configurazioni**: `$connection = 'user'`, `$timestamps = true`
- **Traits**: `RelationX`, `Updater`

### Modulo Performance
- **BaseModel**: `Modules\Performance\Models\BaseModel`
- **Configurazioni**: Specifiche per gestione performance
- **Cast**: Date, decimali per valutazioni

## Checklist per Nuovi Modelli

Prima di creare un nuovo modello, verificare:

- [ ] Il modulo ha un BaseModel?
- [ ] Le configurazioni del BaseModel sono appropriate per il nuovo modello?
- [ ] Il modello ha configurazioni specifiche che richiedono l'estensione diretta di Model?
- [ ] Il modello è parte del dominio di business del modulo?

## Esempi di Implementazione

### Modello Standard (Estende BaseModel)
```php
<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Modules\Sigma\Models\BaseModel;

/**
 * @property int $id
 * @property string $ente
 * @property string $matr
 * @property string $conome
 * @property string $nome
 * @property \Carbon\Carbon $anv2kd
 * @property \Carbon\Carbon $anv2ka
 * @property int $anvist
 * @property string $anvpar
 * @property float $anvimp
 * @property float $anvqta
 * @property string $anvvoc
 * @property string $anvdes
 */
class Integparam extends BaseModel
{
    protected $fillable = [
        'ente', 'matr', 'conome', 'nome', 'anv2kd', 'anv2ka',
        'anvist', 'anvpar', 'anvimp', 'anvqta', 'anvvoc', 'anvdes'
    ];
    
    // Cast specifici se necessari (altrimenti ereditati dal BaseModel)
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            // Cast aggiuntivi specifici se necessari
        ]);
    }
}
```

### Modello con Configurazioni Specifiche (Estende Model)
```php
<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Model;

class Wstr01lx extends Model
{
    protected $connection = 'generale';
    public $timestamps = false;
    protected $table = 'wstr01f'; // Tabella specifica
    
    // Configurazioni specifiche che non possono essere nel BaseModel
}
```

## Validazione PHPStan

Tutti i modelli devono passare la validazione PHPStan livello 9+:

```bash
cd /var/www/html/ptvx/laravel
./vendor/bin/phpstan analyse --level=9 --memory-limit=2G Modules/Sigma/app/Models/Integparam.php
```

## Documentazione Aggiornata

Ogni nuovo modello deve essere documentato in:
1. Documentazione del modulo specifico
2. Documentazione root se necessario
3. Aggiornamento delle rules e memories

## Collegamenti
- [Convenzioni Modelli](models.md)
- [Best Practices Laravel](laraxot-conventions.md)
- [Regole Migrazioni](migrations.md)

*Ultimo aggiornamento: giugno 2025* 