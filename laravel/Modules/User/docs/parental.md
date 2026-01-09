# Guida Approfondita a Tighten/Parental nel Modulo User

## Indice
- [Introduzione](#introduzione)
- [Single Table Inheritance](#single-table-inheritance)
- [Implementazione in il progetto](#implementazione-in-<nome progetto>)
- [Casi d'uso nel Modulo User](#casi-duso-nel-modulo-user)
- [Pattern e Best Practices](#pattern-e-best-practices)
- [Troubleshooting](#troubleshooting)
- [Confronto con altre Soluzioni](#confronto-con-altre-soluzioni)
- [Riferimenti](#riferimenti)
## Introduzione
Tighten/Parental è una libreria Laravel che aggiunge funzionalità di Single Table Inheritance (STI) ad Eloquent, il sistema ORM di Laravel. Questa documentazione spiega come viene utilizzata nel Modulo User di il progetto e come implementarla correttamente nei tuoi modelli.
### Cos'è Tighten/Parental?
[Tighten/Parental](https://github.com/tighten/parental) è una libreria che consente di estendere modelli Eloquent mantenendo il riferimento alla stessa tabella del database. Questo permette di implementare comportamenti specifici in classi derivate senza dover creare tabelle separate per ogni tipo di modello.
### Versione e Compatibilità
```json
"tightenco/parental": "^1.4"
```
Questa versione è compatibile con Laravel 9.x e versioni successive.
## Single Table Inheritance
### Concetto di Base
Il Single Table Inheritance (STI) è un pattern di progettazione che permette di rappresentare una gerarchia di classi utilizzando una singola tabella del database. Questo approccio è utile quando:
1. Hai diversi tipi di entità che condividono molti campi comuni
2. Vuoi evitare join complessi tra tabelle
3. Hai bisogno di polimorfismo a livello di modello
### Come Funziona in Laravel
In un'implementazione tradizionale di Laravel, ogni modello corrisponde a una tabella specifica. Con Parental, invece:
1. Una tabella principale memorizza tutti i record
2. Una colonna "type" (o altra colonna configurabile) identifica il tipo specifico
3. I modelli figli ereditano dal modello padre
4. Quando si recupera un record, viene istanziato automaticamente il modello figlio corretto
## Implementazione in il progetto
### Installazione
Nel progetto il progetto, Tighten/Parental è già installato come dipendenza. Se stai creando un nuovo modulo che necessita di questa funzionalità, puoi verificare l'installazione con:
```bash
composer show tightenco/parental
### Struttura Base dei Modelli
Nel Modulo User, utilizziamo Parental per gestire diversi tipi di utenti. Ecco la struttura di base:
```php
// App\Models\User (modello padre)
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Parental\HasChildren;
class User extends Model
{
    use HasChildren;

    protected $fillable = ['name', 'email', 'password', 'type'];
    // Opzionale: definire alias per i tipi
    protected $childTypes = [
        'admin' => \App\Models\Admin::class,
        'doctor' => \App\Models\Doctor::class,
        'patient' => \App\Models\Patient::class,
    ];
}
// App\Models\Admin (modello figlio)
use Parental\HasParent;
class Admin extends User
    use HasParent;
    // Comportamenti specifici per Admin
    public function canAccessDashboard()
    {
        return true;
    }
### Schema del Database
Per utilizzare Parental, la tabella `users` deve avere una colonna che memorizza il tipo di modello. Per default è `type`, ma può essere personalizzata:
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->string('type')->nullable(); // Colonna fondamentale per Parental
    $table->timestamps();
});
### Personalizzazione della Colonna Type
Se vuoi utilizzare un nome diverso per la colonna che memorizza il tipo:
    protected $childColumn = 'user_type'; // Personalizzazione del nome della colonna
## Casi d'uso nel Modulo User
Nel Modulo User di il progetto, utilizziamo Tighten/Parental per gestire diversi tipi di utenti con comportamenti specifici.
### 1. Gestione dei Ruoli con Modelli Dedicati
Invece di utilizzare un sistema di permessi complesso, possiamo gestire comportamenti specifici per ruolo attraverso modelli dedicati:
// Implementazione reale in il progetto
namespace Modules\User\Models;
class Doctor extends User
    public function appointments()
        return $this->hasMany(Appointment::class);
    public function canPrescribeMedication()
class Patient extends User
    public function medicalRecords()
        return $this->hasMany(MedicalRecord::class);
    public function bookAppointment(Doctor $doctor, $date)
        // Logica per prenotare un appuntamento
### 2. Gestione delle Autorizzazioni
I modelli figli possono implementare logiche di autorizzazione specifiche:
    public function canManageUsers()
// Utilizzo nelle policies
public function update(User $user, SomeModel $model)
    return $user instanceof Admin && $user->canManageUsers();
### 3. Relazioni Tipo-Specifiche
I modelli figli possono definire relazioni specifiche per quel tipo di utente:
    public function specialties()
        return $this->belongsToMany(Specialty::class);
    public function clinics()
        return $this->belongsToMany(Clinic::class);
## Pattern e Best Practices
### 1. Quando Usare Parental vs Spatie/Laravel-Permission
- **Usa Parental quando**:
  - Hai comportamenti completamente diversi per ogni tipo di utente
  - La logica di business è significativamente diversa tra i tipi
  - Vuoi mantenere modelli più puliti con meno condizionali
- **Usa Laravel-Permission quando**:
  - Hai bisogno di permessi granulari e dinamici
  - Gli utenti possono avere più ruoli contemporaneamente
  - I comportamenti sono simili ma con diverse autorizzazioni
In il progetto, spesso combiniamo entrambi gli approcci.
### 2. Combinazione con Trait e Interface
Un pattern efficace è combinare Parental con trait e interface per una migliore organizzazione del codice:
interface CanManageAppointments
    public function scheduleAppointment($patient, $time);
    public function cancelAppointment($appointmentId);
trait ManagesAppointments
    public function scheduleAppointment($patient, $time)
        // Implementazione
    public function cancelAppointment($appointmentId)
class Doctor extends User implements CanManageAppointments
    use HasParent, ManagesAppointments;
### 3. Factory Pattern per Modelli Figli
Quando devi creare nuove istanze, puoi utilizzare un factory pattern:
class UserFactory
    public static function create($type, array $attributes = [])
        $class = "App\\Models\\" . ucfirst($type);

        if (!class_exists($class)) {
            throw new \InvalidArgumentException("User type {$type} not found");
        }
        return new $class($attributes);
// Utilizzo
$doctor = UserFactory::create('doctor', ['name' => 'Dr. Smith']);
## Troubleshooting
### Problemi Comuni e Soluzioni
#### 1. Type non viene impostato automaticamente
**Problema**: Quando crei una nuova istanza di un modello figlio, a volte il campo `type` non viene impostato automaticamente.
**Soluzione**: Sovrascrivere il metodo `boot` nel modello figlio:
    protected static function boot()
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->type)) {
                $model->type = get_class($model);
                // Oppure con alias: $model->type = 'doctor';
            }
        });
#### 2. Problemi con Eager Loading
**Problema**: Le relazioni possono comportarsi in modo imprevisto con i modelli figli.
**Soluzione**: Assicurati di definire le relazioni nel modello corretto e usa `with()` specificando il percorso completo:
// Corretto
$doctors = Doctor::with('specialties')->get();
// Potenzialmente problematico
$users = User::with('specialties')->get(); // Funziona solo se la relazione è definita in User
#### 3. Problemi con Serializzazione
**Problema**: Quando serializzate modelli figli, potreste perdere informazioni sul tipo.
**Soluzione**: Implementare `JsonSerializable` o personalizzare `toArray()`:
    public function toArray()
        $data = parent::toArray();
        $data['user_type'] = 'doctor';
        return $data;
## Confronto con altre Soluzioni
### Parental vs Class Table Inheritance
| Aspetto | Single Table Inheritance (Parental) | Class Table Inheritance |
|---------|-------------------------------------|-------------------------|
| **Struttura DB** | Una tabella per tutti i tipi | Tabella separata per ogni tipo |
| **Performance** | Più veloce (nessun join) | Più lento (join necessari) |
| **Manutenzione** | Più facile (un solo schema) | Più complessa (più schemi) |
| **Spazio** | Può sprecare spazio (campi null) | Più efficiente nello spazio |
| **Flessibilità** | Meno flessibile per campi specifici | Più flessibile per campi specifici |
### Parental vs Laravel Polymorphic Relationships
| Aspetto | Parental | Polymorphic Relationships |
|---------|----------|---------------------------|
| **Uso** | Estendere comportamenti di un modello | Relazioni tra modelli diversi |
| **Complessità** | Bassa | Media-Alta |
| **Performance** | Alta | Media (più join) |
| **Caso d'uso** | Tipi diversi della stessa entità | Relazioni tra entità diverse |
## Riferimenti
- [Documentazione ufficiale di Tighten/Parental](https://github.com/tighten/parental)
- [Laravel Nova Support](https://github.com/tighten/parental#laravel-nova-support)
- [Laravel Documentation - Eloquent ORM](https://laravel.com/docs/10.x/eloquent)
- [Laravel Documentation - Eloquent ORM](https://laravel.com/project_docs/10.x/eloquent)
- [Single Table Inheritance Pattern](https://martinfowler.com/eaaCatalog/singleTableInheritance.html) di Martin Fowler
