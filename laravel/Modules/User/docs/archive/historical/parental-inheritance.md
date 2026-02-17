# Parental: Ereditarietà a Tabella Singola in <nome progetto>

## Indice
- [Introduzione](#introduzione)
- [Concetti Fondamentali](#concetti-fondamentali)
- [Implementazione in <nome progetto>](#implementazione-in-<nome progetto>)
- [Casi d'Uso nel Modulo User](#casi-duso-nel-modulo-user)
- [Comandi Console Generici](#comandi-console-generici)
- [Best Practices](#best-practices)
- [Troubleshooting](#troubleshooting)
- [Riferimenti](#riferimenti)

## Introduzione

Parental è una libreria sviluppata da [Tighten](https://github.com/tighten/parental) che implementa il pattern di **Single Table Inheritance (STI)** in Laravel. Questo documento analizza in dettaglio come utilizzare Parental nel contesto del modulo User di <nome progetto> per gestire diversi tipi di utenti mantenendo un'architettura pulita e performante.

### Cos'è la Single Table Inheritance?

La Single Table Inheritance è un pattern di progettazione che permette di estendere un modello base (genitore) con modelli specializzati (figli) che condividono la stessa tabella nel database. Questo approccio offre diversi vantaggi:

- **Semplicità dello schema database**: una sola tabella per tutti i tipi di entità correlate
- **Prestazioni ottimizzate**: nessun join necessario per recuperare dati specializzati
- **Flessibilità nell'evoluzione del dominio**: facile aggiunta di nuovi tipi specializzati

## Concetti Fondamentali

### 1. Modello Genitore e Modelli Figli

In Parental, definiamo:
- Un **modello genitore** che rappresenta l'entità base (es. `User`)
- Uno o più **modelli figli** che estendono il genitore con comportamenti specifici (es. `Admin`, `Patient`, `Doctor`)

### 2. Trait Principali

Parental fornisce due trait fondamentali:

- **`HasChildren`**: Applicato al modello genitore per permettergli di restituire istanze dei modelli figli appropriati
- **`HasParent`**: Applicato ai modelli figli per permettere loro di utilizzare la tabella del genitore

### 3. Colonna di Tipo

Per distinguere tra i diversi tipi di entità nella stessa tabella, Parental utilizza una colonna di tipo (default: `type`) che memorizza:
- Il nome completo della classe del modello figlio, oppure
- Un alias configurabile più leggibile

## Implementazione in <nome progetto>

### Configurazione Base del Modulo User

Il modulo User di <nome progetto> è progettato per essere **generico e riutilizzabile** in più progetti. La configurazione STI deve essere definita nei moduli specifici del progetto.

#### 1. BaseUser (Modulo User Generico)

```php
namespace Modules\User\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Parental\HasChildren;

abstract class BaseUser extends Authenticatable
{
    use HasChildren;

    /** @var string */
    protected $childColumn = 'type';

    /** @var list<string> */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type', // Campo fondamentale per STI
    ];

    /** @var array<string, class-string> */
    protected $childTypes = [
        // Vuoto per default - deve essere definito nei moduli specifici
    ];
}
```

#### 2. User del Modulo Specifico (es. <nome progetto>)

```php
namespace Modules\<nome progetto>\Models;

use Modules\User\Models\BaseUser;
use Modules\<nome progetto>\Enums\UserTypeEnum;

class User extends BaseUser
{
    /** @var string */
    protected $connection = '<nome progetto>';

    /**
     * Mappatura dei tipi specifici del progetto <nome progetto>
     */
    protected $childTypes = [
        'admin' => Admin::class,
        'doctor' => Doctor::class,
        'patient' => Patient::class,
    ];

    /**
     * Cast per enum del modulo specifico
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'type' => UserTypeEnum::class,
        ]);
    }
}
```

#### 3. Modelli Figli del Modulo Specifico

```php
namespace Modules\<nome progetto>\Models;

use Parental\HasParent;

class Doctor extends User
{
    use HasParent;

    // Comportamenti specifici per Doctor
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}

class Patient extends User
{
    use HasParent;

    // Comportamenti specifici per Patient
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }
}
```

### Principi di Modularità

**CRITICO**: Il modulo User deve rimanere generico e **MAI** dipendere da moduli specifici del progetto. Questo garantisce:

- **Riutilizzabilità**: Il modulo User può essere utilizzato in progetti diversi
- **Manutenibilità**: Modifiche specifiche non influenzano il core generico
- **Testabilità**: Il modulo base può essere testato indipendentemente

## Comandi Console Generici

I comandi console nel modulo User devono essere progettati per funzionare con qualsiasi implementazione STI, senza dipendenze specifiche.

### Pattern Generico per Comandi Console

```php
namespace Modules\User\Console\Commands;

use Illuminate\Console\Command;
use Modules\Xot\Datas\XotData;

class ChangeTypeCommand extends Command
{
    protected $name = 'user:change-type';
    protected $description = 'Change user type based on project configuration';

    public function handle(): void
    {
        $email = $this->ask('User email?');
        $user = XotData::make()->getUserByEmail($email);
        
        if (!$user) {
            $this->error("User not found: {$email}");
            return;
        }

        // Ottieni i tipi disponibili dal modello corrente
        $availableTypes = $this->getAvailableTypes($user);
        
        if (empty($availableTypes)) {
            $this->error('No user types configured for this project.');
            return;
        }

        $currentType = $user->type ?? 'Not set';
        $this->info("Current type: {$currentType}");

        $newType = $this->choice('Select new type:', array_keys($availableTypes));

        $user->type = $newType;
        $user->save();

        $this->info("Type changed to '{$newType}' for {$email}");
    }

    /**
     * Ottieni i tipi disponibili dal modello corrente
     */
    private function getAvailableTypes($user): array
    {
        // Verifica se il modello ha childTypes configurati
        if (isset($user->childTypes) && !empty($user->childTypes)) {
            return $user->childTypes;
        }

        // Fallback: tipi base comuni
        return [
            'admin' => 'Administrator',
            'user' => 'Regular User',
        ];
    }
}
```

### Best Practices per Comandi Generici

1. **Usa Reflection per ispezionare i tipi disponibili**
2. **Fornisci fallback ragionevoli**
3. **Non assumere enum o strutture specifiche**
4. **Documenta chiaramente le dipendenze**

## Best Practices

### 1. Separazione delle Responsabilità

**Modulo User (Generico)**:
- ✅ Definisce l'architettura base STI
- ✅ Fornisce trait e classi base
- ✅ Implementa comandi generici
- ❌ MAI dipendenze da moduli specifici

**Moduli Specifici del Progetto**:
- ✅ Definiscono i tipi specifici del dominio
- ✅ Implementano enum e cast specifici
- ✅ Estendono il comportamento base
- ❌ MAI modificare il modulo User base

### 2. Configurazione Dinamica

Usa configurazioni esterne per definire i tipi:

```php
// config/user_types.php (nel modulo specifico)
return [
    'types' => [
        'admin' => [
            'class' => \Modules\ProjectName\Models\Admin::class,
            'label' => 'Administrator',
            'permissions' => ['*'],
        ],
        'doctor' => [
            'class' => \Modules\ProjectName\Models\Doctor::class,
            'label' => 'Medical Doctor',
            'permissions' => ['medical:*'],
        ],
    ],
];
```

### 3. Testing Strategy

```php
// Test nel modulo User (generico)
class UserTypeCommandTest extends TestCase
{
    /** @test */
    public function it_works_without_specific_types()
    {
        // Test con configurazione base
    }
}

// Test nel modulo specifico
class <nome progetto>UserTypeCommandTest extends TestCase
{
    /** @test */
    public function it_works_with_<nome progetto>_types()
    {
        // Test con tipi specifici di <nome progetto>
    }
}
```

## Troubleshooting

### Problema: "No user types configured"

**Causa**: Il modello User del progetto non ha definito `$childTypes`

**Soluzione**: Verificare che il modello User specifico del progetto definisca i tipi:

```php
class User extends BaseUser
{
    protected $childTypes = [
        'admin' => Admin::class,
        // Altri tipi...
    ];
}
```

### Problema: "Call to undefined method"

**Causa**: Comando che tenta di usare metodi specifici di un enum

**Soluzione**: Rendere il comando generico usando reflection:

```php
$typeValue = is_object($user->type) && method_exists($user->type, 'value') 
    ? $user->type->value 
    : (string) $user->type;
```

## Riferimenti

- [Documentazione Parental](https://github.com/tighten/parental)
- [Laravel Single Table Inheritance](https://laravel.com/docs/eloquent-relationships#polymorphic-relationships)
- [Modulo User - Architettura Base](./user-architecture.md)
- [<nome progetto> - Implementazione STI](../../<nome progetto>/docs/user-types.md)

*Ultimo aggiornamento: Dicembre 2024*
