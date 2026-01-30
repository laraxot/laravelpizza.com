# Parental: Guida Completa all'Ereditarietà a Tabella Singola in il progetto

## Indice
- [Introduzione](#introduzione)
- [Concetti Fondamentali](#concetti-fondamentali)
- [Vantaggi e Svantaggi](#vantaggi-e-svantaggi)
- [Implementazione in il progetto](#implementazione-in-<nome progetto>)
- [Casi d'Uso Pratici](#casi-duso-pratici)
- [Integrazione con Altri Componenti](#integrazione-con-altri-componenti)
- [Migrazione da Architetture Esistenti](#migrazione-da-architetture-esistenti)
- [Best Practices](#best-practices)
- [FAQ](#faq)
- [Riferimenti](#riferimenti)

## Introduzione

### Cos'è Parental?

**Parental** è una libreria sviluppata da Tighten che implementa il pattern di **Single Table Inheritance (STI)** in applicazioni Laravel. Questa libreria permette di estendere modelli Eloquent mantenendo tutti i dati in un'unica tabella, facilitando l'implementazione di gerarchie di classi senza la complessità di gestire più tabelle correlate.

### Cos'è la Single Table Inheritance?

La Single Table Inheritance è un pattern architetturale che consente di mappare una gerarchia di classi su una singola tabella del database. Ogni record nella tabella include una colonna "discriminatore" che identifica a quale classe specifica appartiene.

Questo pattern offre un equilibrio tra la semplicità di una singola tabella e la flessibilità di un modello a oggetti ricco, permettendo di:

- Mantenere uno schema database semplice
- Evitare join costosi tra tabelle
- Implementare comportamenti specializzati in sottoclassi

## Concetti Fondamentali

### Architettura di Parental

Parental si basa su due trait principali:

1. **`HasChildren`**: Applicato al modello base (genitore)
   - Gestisce la conversione automatica dei record nel tipo appropriato
   - Configura la colonna discriminatore e gli alias dei tipi
   - Modifica il comportamento delle query per restituire i tipi corretti

2. **`HasParent`**: Applicato ai modelli specializzati (figli)
   - Configura il modello per utilizzare la tabella del genitore
   - Gestisce correttamente le chiavi esterne e i nomi delle relazioni
   - Mantiene la coerenza dei nomi delle tabelle e delle convenzioni

### Funzionamento Interno

Quando si utilizza Parental:

1. I modelli figli ereditano dal modello genitore ma operano sulla stessa tabella
2. Quando si crea un'istanza di un modello figlio, viene automaticamente impostata la colonna tipo
3. Quando si recuperano record, Parental converte automaticamente i risultati nel tipo appropriato

```
┌─────────────────────────────────┐
│ Tabella 'users'                 │
├─────┬──────────┬───────┬────────┤
│ id  │ name     │ email │ type   │
├─────┼──────────┼───────┼────────┤
│ 1   │ Mario    │ ...   │ admin  │
│ 2   │ Giulia   │ ...   │ patient│
│ 3   │ Roberto  │ ...   │ doctor │
└─────┴──────────┴───────┴────────┘
        ▲           ▲        ▲
        │           │        │
┌───────┴───────┐   │        │
│ User (Parent) │   │        │
└───────────────┘   │        │
        ▲           │        │
        │           │        │
┌───────┴───────┐   │        │
│ HasChildren   │   │        │
└───────────────┘   │        │
                    │        │
┌───────────────────┴──┐     │
│ Admin (Child)        │     │
├─────────────────────┐│     │
│ HasParent           ││     │
└─────────────────────┘│     │
                       │     │
┌──────────────────────┴─┐   │
│ Patient (Child)        │   │
├────────────────────────┤   │
│ HasParent              │   │
└────────────────────────┘   │
                             │
┌──────────────────────────┐ │
│ Doctor (Child)           │ │
├──────────────────────────┤ │
│ HasParent                │ │
└──────────────────────────┘ │
                             │
                             │
      Colonna discriminatrice
```

## Vantaggi e Svantaggi

### Vantaggi

1. **Semplicità dello Schema Database**
   - Una sola tabella da gestire per tutti i tipi correlati
   - Migrazioni più semplici e meno rischiose
   - Backup e ripristino più efficienti

2. **Performance Ottimizzate**
   - Nessun join necessario per accedere ai dati di tutti i tipi
   - Query più veloci per operazioni che coinvolgono più tipi
   - Indici più efficaci su una singola tabella

3. **Flessibilità del Dominio**
   - Facile aggiunta di nuovi tipi specializzati
   - Comportamenti polimorfici naturali
   - Evoluzione graduale del modello di dominio

4. **Semplicità Implementativa**
   - Meno codice da scrivere e mantenere
   - Relazioni più semplici da gestire
   - Meno duplicazione di logica comune

### Svantaggi

1. **Potenziale Spreco di Spazio**
   - Campi non utilizzati da tutti i tipi (nullable)
   - Possibile frammentazione dei dati
   - Crescita non uniforme della tabella

2. **Limitazioni di Schema**
   - Tutti i tipi devono condividere lo stesso schema base
   - Vincoli di integrità più complessi da implementare
   - Potenziali problemi con tipi molto diversi tra loro

3. **Complessità di Query Specifiche**
   - Filtri aggiuntivi necessari per query specifiche per tipo
   - Potenziale impatto sugli indici
   - Maggiore complessità per analisi dati specifiche

4. **Gestione della Migrazione**
   - Difficoltà nel passare da/a un'architettura multi-tabella
   - Complessità nella gestione di dati storici
   - Potenziali problemi di compatibilità

## Implementazione in il progetto

### Installazione e Configurazione

1. **Installazione della libreria**:
   ```bash
   composer require tightenco/parental
   ```

2. **Configurazione della tabella**:
   ```php
   Schema::create('users', function (Blueprint $table) {
       $table->id();
       $table->string('name');
       $table->string('email')->unique();
       $table->timestamp('email_verified_at')->nullable();
       $table->string('password');
       $table->string('type')->nullable(); // Colonna discriminatrice
       $table->rememberToken();
       $table->timestamps();
       
       // Campi specifici per diversi tipi di utenti
       $table->string('codice_fiscale')->nullable();
       $table->date('data_nascita')->nullable();
       $table->string('numero_iscrizione_albo')->nullable();
       // ...altri campi specifici
   });
   ```

3. **Modello Base (Genitore)**:
   ```php
   namespace Modules\User\Models;

   use Illuminate\Foundation\Auth\User as Authenticatable;
   use Parental\HasChildren;

   class User extends Authenticatable
   {
       use HasChildren;

       protected $fillable = [
           'name',
           'email',
           'password',
           'type'
       ];

       // Opzionale: definire alias per i tipi
       protected $childTypes = [
           'admin' => \Modules\User\Models\Admin::class,
           'patient' => \Modules\User\Models\Patient::class,
           'doctor' => \Modules\User\Models\Doctor::class,
       ];
       
       // Opzionale: personalizzare il nome della colonna discriminatrice
       // protected $childColumn = 'user_type';
   }
   ```

4. **Modelli Specializzati (Figli)**:
   ```php
   namespace Modules\User\Models;

   use Parental\HasParent;

   class Admin extends User
   {
       use HasParent;

       // Metodi e proprietà specifici
       public function canAccessDashboard()
       {
           return true;
       }
   }

   class Patient extends User
   {
       use HasParent;

       // Attributi fillable specifici
       protected $fillable = [
           'codice_fiscale',
           'data_nascita'
       ];
       
       // Metodi specifici
       public function isEligible()
       {
           // Logica specifica per i pazienti
       }
   }
   ```

### Integrazione con l'Architettura di il progetto

In il progetto, Parental si integra perfettamente con:

1. **Sistema Modulare**:
   - Ogni modulo può definire i propri tipi specializzati
   - I modelli figli possono essere distribuiti nei moduli appropriati
   - Mantenimento della coerenza attraverso il modello base comune

2. **Pattern Repository**:
   - Repository specializzati per tipi specifici
   - Query ottimizzate per casi d'uso specifici
   - Astrazione della logica di accesso ai dati

3. **Sistema di Autorizzazioni**:
   - Controlli di autorizzazione basati sul tipo
   - Integrazione con Gates e Policies
   - Gestione granulare dei permessi

## Casi d'Uso Pratici

### 1. Sistema Utenti Multi-Ruolo

il progetto implementa diversi tipi di utenti con comportamenti specifici:

```php
// Creazione di utenti specializzati
$admin = Admin::create([...]);
$patient = Patient::create([...]);
$doctor = Doctor::create([...]);

// Recupero polimorfico
$users = User::all(); // Restituisce una collezione di Admin, Patient, Doctor, ecc.

// Filtraggio per tipo
$patients = User::where('type', 'patient')->get();

// Comportamenti specifici
$users->each(function ($user) {
    if ($user instanceof Patient) {
        $user->sendAppointmentReminder();
    } elseif ($user instanceof Doctor) {
        $user->updateAvailability();
    }
});
```

### 2. Gestione Documenti Specializzati

```php
// Modello base
class Document extends Model
{
    use HasChildren;
    
    protected $childTypes = [
        'medical_record' => MedicalRecord::class,
        'prescription' => Prescription::class,
        'consent_form' => ConsentForm::class,
    ];
}

// Modelli specializzati
class MedicalRecord extends Document
{
    use HasParent;
    
    public function generateSummary()
    {
        // Logica specifica
    }
}

class Prescription extends Document
{
    use HasParent;
    
    public function validateDosage()
    {
        // Logica specifica
    }
}
```

### 3. Sistema di Notifiche Flessibile

```php
class Notification extends Model
{
    use HasChildren;
    
    protected $childTypes = [
        'email' => EmailNotification::class,
        'sms' => SmsNotification::class,
        'push' => PushNotification::class,
    ];
    
    public function send()
    {
        // Implementazione base
    }
}

class EmailNotification extends Notification
{
    use HasParent;
    
    public function send()
    {
        // Implementazione specifica per email
    }
}
```

## Integrazione con Altri Componenti

### Laravel Nova

Per utilizzare Parental con Laravel Nova:

```php
// In NovaServiceProvider.php
public function boot()
{
    parent::boot();
    
    $this->app->register(\Parental\Providers\NovaResourceProvider::class);
}
```

### Filament

Per Filament, è necessario gestire manualmente la conversione dei tipi:

```php
// In un Resource Filament
public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()->where('type', 'patient');
}
```

### API Resources

Le API Resources funzionano perfettamente con i modelli Parental:

```php
class UserResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'type' => $this->type,
        ];
        
        if ($this instanceof Patient) {
            $data['medical_records_count'] = $this->medicalRecords()->count();
        }
        
        return $data;
    }
}
```

## Migrazione da Architetture Esistenti

### Da Modello Singolo con Campo Tipo

Se si utilizza già un campo tipo per distinguere diversi tipi di utenti:

1. **Installare Parental**
2. **Aggiungere i trait appropriati**
3. **Creare i modelli figli**
4. **Aggiornare la logica esistente**

### Da Tabelle Multiple

Per migrare da un'architettura con tabelle separate:

1. **Creare una nuova tabella unificata**
2. **Migrare i dati dalle tabelle separate**
3. **Implementare i modelli con Parental**
4. **Aggiornare le relazioni e le query**

## Best Practices

### 1. Progettazione dello Schema

- **Identificare attributi comuni vs. specifici**:
  - Attributi utilizzati da tutti i tipi: colonne regolari
  - Attributi specifici per tipo: colonne nullable
  - Attributi molto specifici: considerare JSON o relazioni

- **Bilanciare la densità della tabella**:
  - Evitare tabelle con troppe colonne null
  - Considerare la frequenza di accesso ai dati
  - Valutare l'impatto sulle performance

### 2. Organizzazione del Codice

- **Struttura dei modelli**:
  ```
  Modules/
  ├── User/
  │   ├── Models/
  │   │   ├── User.php (Parent)
  │   │   ├── Admin.php (Child)
  │   │   └── ...
  ├── Patient/
  │   ├── Models/
  │   │   ├── Patient.php (Child)
  │   │   └── ...
  ├── Doctor/
  │   ├── Models/
  │   │   ├── Doctor.php (Child)
  │   │   └── ...
  ```

- **Separazione delle responsabilità**:
  - Logica comune nel modello genitore
  - Comportamenti specifici nei modelli figli
  - Utilizzo di trait per comportamenti condivisi tra alcuni tipi

### 3. Query Ottimizzate

- **Indici appropriati**:
  ```php
  Schema::table('users', function (Blueprint $table) {
      $table->index('type');
      $table->index(['type', 'created_at']);
  });
  ```

- **Eager Loading selettivo**:
  ```php
  $users = User::with(['roles', 'permissions'])
      ->get()
      ->each(function ($user) {
          if ($user instanceof Patient) {
              $user->load('medicalRecords');
          }
      });
  ```

- **Scope globali per tipi specifici**:
  ```php
  class Patient extends User
  {
      use HasParent;
      
      protected static function booted()
      {
          static::addGlobalScope('patient_data', function (Builder $builder) {
              $builder->with('medicalRecords');
          });
      }
  }
  ```

## FAQ

### 1. Quando dovrei usare Parental invece di tabelle separate?

Parental è ideale quando:
- I diversi tipi condividono la maggior parte degli attributi
- Si desidera evitare join frequenti
- La logica di business richiede polimorfismo a livello di modello
- Si prevede un'evoluzione graduale dei tipi

### 2. Come gestire attributi molto diversi tra i tipi?

Opzioni:
- Utilizzare colonne nullable (approccio più semplice)
- Utilizzare colonne JSON per attributi molto specifici
- Considerare un approccio ibrido con alcune tabelle correlate per dati molto specializzati

### 3. Parental impatta le performance?

- **Impatto positivo**: Elimina la necessità di join
- **Impatto neutro**: La conversione dei tipi ha un overhead minimo
- **Considerazioni**: Monitorare la crescita della tabella e l'utilizzo degli indici

### 4. Come gestire le migrazioni con Parental?

- Aggiungere nuovi campi come nullable
- Utilizzare migrazioni incrementali
- Considerare l'impatto sui dati esistenti
- Testare accuratamente le migrazioni in ambiente di staging

## Riferimenti

- [Documentazione ufficiale di Parental](https://github.com/tighten/parental)
- [Articolo: "Single Table Inheritance in Laravel with Parental"](https://tighten.com/blog/single-table-inheritance-in-laravel-with-parental/)
- [Pattern di progettazione: Single Table Inheritance](https://martinfowler.com/eaaCatalog/singleTableInheritance.html)
- [Confronto con Class Table Inheritance](https://martinfowler.com/eaaCatalog/classTableInheritance.html)
- [Confronto con Concrete Table Inheritance](https://martinfowler.com/eaaCatalog/concreteTableInheritance.html)
