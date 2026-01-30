# Guida Completa a Tighten/Parental per Base

![Tighten/Parental Logo](https://raw.githubusercontent.com/tighten/parental/main/parental-banner.png)

## Indice
- [Introduzione](#introduzione)
- [Concetti Fondamentali](#concetti-fondamentali)
- [Installazione e Setup](#installazione-e-setup)
- [Implementazione Avanzata](#implementazione-avanzata)
- [Integrazioni con Altri Pacchetti](#integrazioni-con-altri-pacchetti)
- [Ottimizzazione e Performance](#ottimizzazione-e-performance)
- [Casi d'Uso in Base](#casi-duso-in-base)
- [Testing dei Modelli STI](#testing-dei-modelli-sti)
- [Migrazioni e Deployment](#migrazioni-e-deployment)
- [FAQ](#faq)
- [Riferimenti](#riferimenti)

## Introduzione

### Cos'è Tighten/Parental?

[Tighten/Parental](https://github.com/tighten/parental) è una libreria per Laravel che implementa il pattern "Single Table Inheritance" (STI) nel contesto di Eloquent, l'ORM di Laravel. Permette di estendere i modelli mantenendo il riferimento alla stessa tabella del database.

### Perché Usare Parental in Base?

Nel contesto di Base, Parental viene utilizzato principalmente per:

1. **Gestione delle tipologie di utenti** - Medici, pazienti, amministratori con comportamenti diversi
2. **Pulizia del codice** - Evitare codice condizionale basato su tipi di utente
3. **Performance ottimizzate** - Evitare join complessi tra tabelle per diversi tipi di entità
4. **Mantenere la semplicità dello schema** - Una singola tabella invece di tabelle multiple correlate

### Storia e Versioning

Tighten/Parental è mantenuto da [Tighten Co](https://tighten.co/), una società di sviluppo software specializzata in Laravel. La libreria è disponibile come open source sotto licenza MIT. La versione attualmente utilizzata in Base è la 1.4.x.

## Concetti Fondamentali

### Single Table Inheritance

Single Table Inheritance (STI) è un pattern di progettazione che consente di rappresentare una gerarchia di classi in un database relazionale utilizzando una singola tabella. Ogni record nella tabella include un campo discriminatore che identifica a quale classe della gerarchia appartiene.

Questo pattern è particolarmente utile quando:

1. Si ha una gerarchia di classi con molti attributi comuni
2. Le differenze tra le sottoclassi sono limitate
3. Si vuole evitare di utilizzare join per recuperare i dati di base
4. Si preferisce la semplicità e la performance rispetto alla normalizzazione completa

### Come Funziona Parental

Parental implementa STI in Laravel attraverso due trait principali:

1. **HasChildren** - Utilizzato nel modello padre (es. `User`)
2. **HasParent** - Utilizzato nei modelli figli (es. `Doctor`, `Patient`)

Il flusso di funzionamento è il seguente:

1. Quando si crea un'istanza di un modello figlio, viene memorizzato nella tabella del padre
2. La colonna discriminatrice (default: `type`) viene impostata con il nome della classe
3. Quando si interroga il modello padre, Parental restituisce automaticamente istanze dei modelli figli appropriati

## Installazione e Setup

### Requisiti

Per utilizzare Parental nel progetto Base:

- Laravel 9.x o superiore
- PHP 8.0 o superiore

### Installazione via Composer

Parental è già installato in Base, ma in caso di nuova installazione:

```bash
composer require tightenco/parental
```

### Configurazione di Base

#### 1. Modifica del modello padre

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Parental\HasChildren;

class User extends Model
{
    use HasChildren;
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'type', // Importante: colonna discriminatrice
    ];
}
```

#### 2. Creazione dei modelli figli

```php
namespace App\Models;

use Parental\HasParent;

class Admin extends User
{
    use HasParent;
    
    // Metodi specifici per Admin
}

class Doctor extends User
{
    use HasParent;
    
    // Metodi specifici per Doctor
}

class Patient extends User
{
    use HasParent;
    
    // Metodi specifici per Patient
}
```

#### 3. Migrazione per la tabella

```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->string('type')->nullable(); // Colonna discriminatrice
    $table->timestamps();
});
```

### Personalizzazione

#### Personalizzare la colonna discriminatrice

Se desideri utilizzare un nome diverso da "type" per la colonna discriminatrice:

```php
class User extends Model
{
    use HasChildren;
    
    protected $childColumn = 'user_type';
}
```

#### Utilizzare alias per i tipi

Per memorizzare stringhe più brevi invece di nomi di classe completi:

```php
class User extends Model
{
    use HasChildren;
    
    protected $childTypes = [
        'admin' => Admin::class,
        'doctor' => Doctor::class,
        'patient' => Patient::class
    ];
}
```

## Implementazione Avanzata

### Gestione delle Migrazioni

Quando si lavora con STI, potrebbe essere necessario aggiungere attributi specifici per determinati tipi:

```php
Schema::create('users', function (Blueprint $table) {
    // Campi comuni
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->string('type')->nullable();
    $table->timestamps();
    
    // Campi specifici per Doctor
    $table->string('specialization')->nullable();
    $table->string('license_number')->nullable();
    
    // Campi specifici per Patient
    $table->date('birth_date')->nullable();
    $table->string('blood_type')->nullable();
});
```

### Utilizzo dei Cast

Per gestire i campi specifici in modo sicuro:

```php
class Doctor extends User
{
    use HasParent;
    
    // Assicurati che questi attributi siano usati solo da Doctor
    protected $casts = [
        'specialization' => 'string',
        'license_number' => 'string',
    ];
    
    // Evita l'accesso a questi campi da altri tipi
    public function getSpecializationAttribute($value)
    {
        if ($this->type !== 'doctor' && $this->type !== Doctor::class) {
            return null;
        }
        
        return $value;
    }
}
```

### Utilizzo di Model Events

Gli eventi del modello funzionano normalmente con i modelli STI:

```php
class Doctor extends User
{
    use HasParent;
    
    protected static function booted()
    {
        parent::booted();
        
        static::created(function ($doctor) {
            // Logica da eseguire quando viene creato un Doctor
            Notification::send(User::admins()->get(), new NewDoctorRegistered($doctor));
        });
    }
}
```

### Factory per i Modelli STI

Per utilizzare Laravel Factory con modelli STI:

```php
namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{
    protected $model = Doctor::class;
    
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'type' => 'doctor', // o Doctor::class se non usi alias
            'specialization' => $this->faker->randomElement(['Cardiology', 'Neurology', 'Pediatrics']),
            'license_number' => $this->faker->unique()->numerify('LIC-####'),
        ];
    }
}
```

## Integrazioni con Altri Pacchetti

### Laravel Nova

Parental include il supporto per Laravel Nova. Per utilizzarlo, registra il provider in `NovaServiceProvider`:

```php
class NovaServiceProvider extends NovaApplicationServiceProvider
{
    public function boot()
    {
        parent::boot();
        
        $this->app->register(\Parental\Providers\NovaResourceProvider::class);
    }
}
```

### Laravel Filament

Per Filament, puoi utilizzare un approccio simile creando risorse separate ma correlate:

```php
// UserResource.php
class UserResource extends Resource
{
    protected static ?string $model = User::class;
    
    public static function getEloquentQuery(): Builder
    {
        // Importante: esclude i record che sono di tipi specifici
        return parent::getEloquentQuery()
            ->whereNotIn('type', ['doctor', 'patient', 'admin']);
    }
}

// DoctorResource.php
class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;
    
    // Configurazione specifica per Doctor
}
```

### Spatie/Laravel-Permission

Parental funziona bene con Spatie/Laravel-Permission, permettendo di combinare ereditarietà con permessi granulari:

```php
class Doctor extends User
{
    use HasParent;
    
    protected static function booted()
    {
        parent::booted();
        
        static::created(function ($doctor) {
            // Assegna automaticamente il ruolo "doctor"
            $doctor->assignRole('doctor');
        });
    }
}
```

## Ottimizzazione e Performance

### Considerazioni sulle Performance

L'utilizzo di STI ha pro e contro in termini di performance:

**Vantaggi**:
- Meno join di tabelle
- Query più semplici
- Caricamento più veloce per modelli semplici

**Svantaggi**:
- Tabelle potenzialmente molto larghe
- Spazio sprecato per campi null
- Possibili problemi di indice con tabelle molto grandi

### Ottimizzazione degli Indici

Per migliorare le performance:

```php
Schema::create('users', function (Blueprint $table) {
    // ...campi base...
    $table->string('type')->nullable();
    
    // Crea indici appropriati
    $table->index('type'); // Fondamentale per STI
    $table->index(['type', 'email']); // Per query comuni
});
```

### Caching

Implementa strategie di caching per migliorare le performance:

```php
class User extends Model
{
    use HasChildren;
    
    public static function findByEmail($email)
    {
        return Cache::remember("user_email_{$email}", now()->addHour(), function () use ($email) {
            return static::where('email', $email)->first();
        });
    }
}
```

## Casi d'Uso in Base

### Gestione Utenti nel Portale Dentistico

In Base, utilizziamo Parental per gestire i diversi tipi di utenti del portale:

1. **DentalDoctor** - Odontoiatra con funzionalità specifiche
   - Gestione appuntamenti
   - Prescrizioni mediche
   - Storico pazienti

2. **Patient** - Paziente con esigenze specifiche
   - Prenotazione visite
   - Storico visite
   - Documenti sanitari

3. **Admin** - Amministratore del sistema
   - Gestione utenti
   - Reportistica
   - Configurazione sistema

### Implementazione Concreta

```php
// Esempio reale di implementazione in Base

class DentalDoctor extends User
{
    use HasParent;
    
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }
    
    public function availableTimeSlots($date)
    {
        // Logica per calcolare gli slot disponibili
        return TimeSlot::available($this, $date);
    }
    
    public function clinics()
    {
        return $this->belongsToMany(Clinic::class);
    }
}

class Patient extends User
{
    use HasParent;
    
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }
    
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }
    
    public function bookAppointment(DentalDoctor $doctor, $date, $timeSlot)
    {
        return Appointment::create([
            'doctor_id' => $doctor->id,
            'patient_id' => $this->id,
            'date' => $date,
            'time_slot' => $timeSlot,
            'status' => 'scheduled'
        ]);
    }
}
```

## Testing dei Modelli STI

### Strategie di Test Efficaci

Quando si testano modelli che utilizzano STI, è importante verificare:

1. La corretta istanziazione dei tipi
2. Il comportamento dei metodi specifici per tipo
3. Il corretto funzionamento delle query polimorfiche

### Esempi di Test

```php
class ParentalModelTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_returns_the_correct_model_type_when_fetching_from_database()
    {
        $doctor = Doctor::create([
            'name' => 'Dr. Smith',
            'email' => 'doctor@example.com',
            'password' => bcrypt('password'),
        ]);
        
        $patient = Patient::create([
            'name' => 'John Doe',
            'email' => 'patient@example.com',
            'password' => bcrypt('password'),
        ]);
        
        // Verifica che vengano restituiti i tipi corretti
        $fetchedUser1 = User::find($doctor->id);
        $fetchedUser2 = User::find($patient->id);
        
        $this->assertInstanceOf(Doctor::class, $fetchedUser1);
        $this->assertInstanceOf(Patient::class, $fetchedUser2);
    }
    
    /** @test */
    public function child_specific_methods_work_correctly()
    {
        $doctor = Doctor::create([
            'name' => 'Dr. Smith',
            'email' => 'doctor@example.com',
            'password' => bcrypt('password'),
            'specialization' => 'Dental Surgery',
        ]);
        
        $fetchedDoctor = User::find($doctor->id);
        
        // Verifica che i metodi specifici funzionino
        $this->assertEquals('Dental Surgery', $fetchedDoctor->specialization);
        $this->assertTrue(method_exists($fetchedDoctor, 'availableTimeSlots'));
    }
}
```

## Migrazioni e Deployment

### Strategia di Migrazione

Quando si aggiungono nuovi tipi di modelli in una applicazione esistente:

1. Aggiungere la colonna type se non esiste già
2. Aggiornare i record esistenti con il tipo appropriato
3. Creare nuovi modelli figli

```php
// In una migrazione
Schema::table('users', function (Blueprint $table) {
    if (!Schema::hasColumn('users', 'type')) {
        $table->string('type')->nullable()->after('id');
    }
});

// Aggiornare i record esistenti
DB::table('users')->whereNull('type')->update(['type' => User::class]);
DB::table('users')->where('is_admin', true)->update(['type' => Admin::class]);
```

### Considerazioni per il Deployment

Durante il deployment di modifiche che coinvolgono STI:

1. Fai backup del database prima della migrazione
2. Utilizza transazioni per le migrazioni complesse
3. Considera la possibilità di eseguire la migrazione in più fasi
4. Testa la migrazione in un ambiente di staging prima della produzione

## FAQ

### Domande Frequenti

#### Come gestire attributi specifici per tipo?

**R:** Puoi dichiarare attributi nel modello figlio con getter e setter personalizzati che verificano il tipo prima di accedere a campi specifici.

#### Posso avere più livelli di ereditarietà?

**R:** Sì, Parental supporta l'ereditarietà multilivello, ad esempio `User -> Doctor -> Specialist`.

#### Come funziona Parental con le relazioni Eloquent?

**R:** Le relazioni funzionano normalmente. Puoi definire relazioni specifiche nei modelli figli che utilizzeranno la stessa tabella del modello padre.

#### È possibile convertire un record da un tipo all'altro?

**R:** Sì, semplicemente aggiornando la colonna `type` a un nuovo valore valido:

```php
$patient = Patient::find(1);
$patient->type = 'doctor'; // o Doctor::class
$patient->save();

// Ora devi recuperare nuovamente l'istanza per ottenere il nuovo tipo
$doctor = User::find(1); // Sarà un'istanza di Doctor
```

## Riferimenti

- [Documentazione ufficiale di Tighten/Parental](https://github.com/tighten/parental)
- [Laravel Documentation](https://laravel.com/docs)
- [Single Table Inheritance Pattern](https://martinfowler.com/eaaCatalog/singleTableInheritance.html) di Martin Fowler
- [Modulo User di Base](../laravel/Modules/User/docs/parental.md)
- [Laravel Nova Documentation](https://nova.laravel.com/docs)
- [Eloquent ORM Documentation](https://laravel.com/docs/eloquent) 
