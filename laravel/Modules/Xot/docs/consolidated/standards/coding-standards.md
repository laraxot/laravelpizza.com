
# Standard di Codice per il progetto

> **Nota**: Questo documento è correlato a [Convenzioni](../../../project_docs/conventions.md) e [Naming Conventions](../../../project_docs/naming-conventions.md). Per una panoramica completa, consulta tutti i documenti correlati.

Questo documento contiene gli standard di codice specifici per il progetto il progetto. Per le linee guida generali sulla scrittura del codice, consultare la [documentazione del modulo Xot](../CODE-STANDARDS.md).

## Principi Fondamentali in il progetto

Oltre ai principi generali documentati nel modulo Xot, in il progetto aderiamo ai seguenti principi:

1. **Coerenza con l'Architettura Modulare**: Ogni modulo deve seguire la struttura e i pattern definiti
2. **Documentazione Bilingue**: I commenti e la documentazione devono essere in italiano, con terminologia tecnica in inglese
3. **Sicurezza dei Dati Sanitari**: Implementare sempre misure di sicurezza avanzate per la protezione dei dati sensibili

## Regole Specifiche per il progetto

### Moduli Custom

il progetto utilizza diversi moduli personalizzati che richiedono specifiche implementazioni:

1. **Modulo Patient**: 
   - Implementare sempre la validazione ISEE
   - Utilizzare lo stato di gravidanza come flag per i trattamenti disponibili

2. **Modulo Dental**:
   - Le prenotazioni devono sempre essere collegate a un paziente registrato
   - Ogni visita deve avere uno stato tracciabile

3. **Modulo User**:
   - Implementare sempre il controllo multi-ruolo
   - Utilizzare i permessi granulari per l'accesso alle funzionalità

### Filament nel Contesto di il progetto

Nel pannello di amministrazione di il progetto:

1. Le risorse devono essere organizzate in navigazione gerarchica
2. I form devono implementare sempre controlli di autorizzazione basati su ruoli
3. Le azioni di massa devono essere limitate agli utenti amministratori

### Internazionalizzazione

il progetto richiede supporto multilingua per:

1. Interfaccia utente (IT primario, EN secondario)
2. Contenuti informativi per i pazienti
3. Notifiche e comunicazioni

## Migrazione dal Vecchio Sistema

Quando si integra codice dal vecchio sistema, è necessario:

1. Riscrivere completamente utilizzando tipizzazione stretta
2. Documentare l'origine e le modifiche apportate
3. Testare approfonditamente l'integrazione con i moduli esistenti

## Configurazioni Specifiche

il progetto utilizza le seguenti configurazioni personalizzate:

1. File di configurazione per regioni e provincie italiane
2. Configurazioni per integrazione con servizi sanitari nazionali
3. Mappatura codici per prestazioni odontoiatriche

## Audit e Logging

Ogni modifica ai dati sensibili deve essere:

1. Registrata con timestamp e utente che ha effettuato la modifica
2. Accessibile tramite interfaccia di audit per gli amministratori
3. Conservata secondo le normative sulla privacy e gestione dati sanitari

## Principi Fondamentali

Il codice del progetto il progetto **deve** aderire ai seguenti principi fondamentali:# Standard di Codice

# Standard di Codice per il progetto

> **Nota**: Questo documento è correlato a [Convenzioni](../../../project_docs/conventions.md) e [Naming Conventions](../../../project_docs/naming-conventions.md). Per una panoramica completa, consulta tutti i documenti correlati.

Questo documento contiene gli standard di codice specifici per il progetto il progetto. Per le linee guida generali sulla scrittura del codice, consultare la [documentazione del modulo Xot](../CODE-STANDARDS.md).

## Principi Fondamentali in il progetto

Oltre ai principi generali documentati nel modulo Xot, in il progetto aderiamo ai seguenti principi:

1. **Coerenza con l'Architettura Modulare**: Ogni modulo deve seguire la struttura e i pattern definiti
2. **Documentazione Bilingue**: I commenti e la documentazione devono essere in italiano, con terminologia tecnica in inglese
3. **Sicurezza dei Dati Sanitari**: Implementare sempre misure di sicurezza avanzate per la protezione dei dati sensibili

## Regole Specifiche per il progetto

### Moduli Custom

il progetto utilizza diversi moduli personalizzati che richiedono specifiche implementazioni:

1. **Modulo Patient**: 
   - Implementare sempre la validazione ISEE
   - Utilizzare lo stato di gravidanza come flag per i trattamenti disponibili

2. **Modulo Dental**:
   - Le prenotazioni devono sempre essere collegate a un paziente registrato
   - Ogni visita deve avere uno stato tracciabile

3. **Modulo User**:
   - Implementare sempre il controllo multi-ruolo
   - Utilizzare i permessi granulari per l'accesso alle funzionalità

### Filament nel Contesto di il progetto

Nel pannello di amministrazione di il progetto:

1. Le risorse devono essere organizzate in navigazione gerarchica
2. I form devono implementare sempre controlli di autorizzazione basati su ruoli
3. Le azioni di massa devono essere limitate agli utenti amministratori

### Internazionalizzazione

il progetto richiede supporto multilingua per:

1. Interfaccia utente (IT primario, EN secondario)
2. Contenuti informativi per i pazienti
3. Notifiche e comunicazioni

## Migrazione dal Vecchio Sistema

Quando si integra codice dal vecchio sistema, è necessario:

1. Riscrivere completamente utilizzando tipizzazione stretta
2. Documentare l'origine e le modifiche apportate
3. Testare approfonditamente l'integrazione con i moduli esistenti

## Configurazioni Specifiche

il progetto utilizza le seguenti configurazioni personalizzate:

1. File di configurazione per regioni e provincie italiane
2. Configurazioni per integrazione con servizi sanitari nazionali
3. Mappatura codici per prestazioni odontoiatriche

## Audit e Logging

Ogni modifica ai dati sensibili deve essere:

1. Registrata con timestamp e utente che ha effettuato la modifica
2. Accessibile tramite interfaccia di audit per gli amministratori
3. Conservata secondo le normative sulla privacy e gestione dati sanitari

## Principi Fondamentali

Il codice del progetto **deve** aderire ai seguenti principi fondamentali:

1. **Robustezza**: Il codice deve funzionare correttamente anche in condizioni impreviste o avverse
2. **Solidità**: La struttura deve essere manutenibile, scalabile e testabile
3. **Tipizzazione Stretta**: Ogni variabile, parametro e valore di ritorno deve essere esplicitamente tipizzato

Questi principi sono **non negoziabili** e costituiscono la base per uno sviluppo di qualità.

## Tipizzazione Stretta (Strict Typing)

### Configurazione PHP

Tutti i file PHP **devono** iniziare con la dichiarazione di strict types:

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\app\Models;
```

### Tipizzazione Esplicita

Ogni metodo e funzione **deve** dichiarare:
- Il tipo di ogni parametro
- Il tipo di ritorno, incluso `void` quando non restituisce valori
- Tipizzazioni nullable quando appropriato (`?string`)
- Tipizzazioni di unione quando strettamente necessario (`string|int`)

**Esempi corretti:**

```php
public function getPatientById(int $id): ?Patient
{
    return $this->repository->find($id);
}

public function calculateAge(DateTimeInterface $birthDate): int
{
    return $birthDate->diff(new DateTime())->y;
}

public function processData(array $data): void
{
    // Elaborazione senza valore di ritorno
}
```

**Esempi errati (da evitare):**

```php
// ❌ NO: Mancanza di tipizzazione
public function getPatient($id)
{
    return $this->repository->find($id);
}

// ❌ NO: Tipizzazione incompleta
public function savePatient(Patient $patient)
{
    $this->repository->save($patient);
}
```

### Utilizzo di Types e Enums

- Utilizzare **enum** PHP 8.1+ per tutti i valori che rappresentano un insieme limitato di opzioni
- Utilizzare **typed properties** per tutte le proprietà delle classi
- Utilizzare **value objects** per rappresentare concetti di dominio complessi

**Esempio di Enum:**

```php
enum GenderType: string
{
    case FEMALE = 'F';
    case MALE = 'M';
    case OTHER = 'O';
    
    public function label(): string
    {
        return match($this) {
            self::FEMALE => 'Femminile',
            self::MALE => 'Maschile',
            self::OTHER => 'Altro',
        };
    }
}

// Utilizzo
public function setGender(GenderType $gender): void
{
    $this->gender = $gender->value;
}
```

**Esempio di Value Object:**

```php
final class TaxCode
{
    private string $value;
    
    public function __construct(string $taxCode)
    {
        if (!$this->isValid($taxCode)) {
            throw new InvalidArgumentException('Codice fiscale non valido');
        }
        
        $this->value = $taxCode;
    }
    
    public function value(): string
    {
        return $this->value;
    }
    
    private function isValid(string $taxCode): bool
    {
        // Validazione del codice fiscale
        return (bool) preg_match('/^[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9]{3}[A-Z]$/', $taxCode);
    }
}
```

## Robustezza del Codice

### Gestione delle Eccezioni

- Utilizzare eccezioni specifiche per ogni tipo di errore
- Documentare tutte le eccezioni che possono essere lanciate da un metodo
- Gestire le eccezioni al livello appropriato dell'applicazione
- Mai nascondere le eccezioni senza una gestione appropriata

```php
/**
 * Trova un paziente per codice fiscale.
 *
 * @param string $taxCode Il codice fiscale del paziente
 * @return Patient Il paziente trovato
 * @throws PatientNotFoundException Se nessun paziente viene trovato con il codice fiscale specificato
 * @throws InvalidTaxCodeException Se il codice fiscale non è valido
 */
public function findByTaxCode(string $taxCode): Patient
{
    if (!TaxCode::isValid($taxCode)) {
        throw new InvalidTaxCodeException($taxCode);
    }
    
    $patient = $this->repository->findByTaxCode($taxCode);
    
    if ($patient === null) {
        throw new PatientNotFoundException("Nessun paziente trovato con codice fiscale: {$taxCode}");
    }
    
    return $patient;
}
```

### Validazione Input

- Validare **sempre** gli input esterni (richieste HTTP, dati importati, ecc.)
- Utilizzare form request per la validazione nelle richieste HTTP
- Applicare validazione approfondita anche per i dati provenienti dal database

```php
namespace Modules\Patient\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Patient\app\Enums\GenderType;

class StorePatientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tax_code' => ['required', 'string', 'size:16', 'unique:patients,tax_code'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'string', 'in:' . implode(',', array_column(GenderType::cases(), 'value'))],
            'email' => ['required', 'email', 'unique:patients,email'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'size:2'],
            'postal_code' => ['required', 'string', 'size:5'],
            'isee' => ['required', 'numeric', 'min:0'],
            'is_pregnant' => ['boolean'],
        ];
    }
}
```


## Collegamenti Correlati

- [Convenzioni](../../../project_docs/conventions.md)
- [Naming Conventions](../../../project_docs/naming-conventions.md)
- [Documentazione Xot](../CODE-STANDARDS.md)
- [Collegamenti Documentazione](../../../../project_docs/collegamenti-documentazione.md)## Documentazione del Codice

### PHPDoc

Ogni classe, metodo e proprietà **deve** essere documentata con PHPDoc:

```php
/**
 * Classe che rappresenta un paziente nel sistema.
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $tax_code
 * @property \DateTimeInterface $birth_date
 * @property GenderType $gender
 */
class Patient extends Model
{
    /**
     * Calcola l'età del paziente in anni.
     *
     * @return int L'età del paziente in anni
     */
    public function getAge(): int
    {
        return $this->birth_date->diff(new DateTime())->y;
    }
}
```

### Commenti nel Codice

- Utilizzare commenti per spiegare il "perché" non il "cosa"
- Evitare commenti ovvi o ridondanti
- Mantenere i commenti aggiornati con il codice

```php
// ❌ NO: Commento ridondante
$age = $birthDate->diff(new DateTime())->y; // Calcola l'età

// ✅ SI: Commento che spiega il perché
// Utilizziamo DateTimeImmutable per evitare side effects
$now = new DateTimeImmutable();
$age = $birthDate->diff($now)->y;
```

## Testing

### Unit Tests

- Ogni classe deve avere test unitari
- I test devono essere indipendenti e ripetibili
- Utilizzare data providers per testare diversi scenari

```php
namespace Modules\Patient\Tests\Unit;

use Modules\Patient\app\Models\Patient;
use Tests\TestCase;

class PatientTest extends TestCase
{
    /** @test */
    public function it_calculates_age_correctly(): void
    {
        $birthDate = new DateTimeImmutable('1990-01-01');
        $patient = new Patient(['birth_date' => $birthDate]);
        
        $this->assertEquals(33, $patient->getAge());
    }
}
```

### Feature Tests

- Testare i flussi completi delle funzionalità
- Verificare l'interazione tra i componenti
- Testare gli scenari di errore

```php
namespace Modules\Patient\Tests\Feature;

use Modules\Patient\app\Models\Patient;
use Tests\TestCase;

class PatientRegistrationTest extends TestCase
{
    /** @test */
    public function it_registers_a_new_patient(): void
    {
        $response = $this->postJson('/api/patients', [
            'first_name' => 'Mario',
            'last_name' => 'Rossi',
            'tax_code' => 'RSSMRA90A01H501R',
            'birth_date' => '1990-01-01',
            'gender' => 'M',
        ]);
        
        $response->assertCreated();
        $this->assertDatabaseHas('patients', [
            'first_name' => 'Mario',
            'last_name' => 'Rossi',
            'tax_code' => 'RSSMRA90A01H501R',
        ]);
    }
}
```

## Performance

### Query Optimization

- Utilizzare eager loading per evitare N+1 query
- Selezionare solo le colonne necessarie
- Utilizzare indici appropriati

```php
// ❌ NO: N+1 query problem
$patients = Patient::all();
foreach ($patients as $patient) {
    echo $patient->appointments->count();
}

// ✅ SI: Eager loading
$patients = Patient::with('appointments')->get();
foreach ($patients as $patient) {
    echo $patient->appointments->count();
}
```

### Caching

- Utilizzare cache per dati costosi da calcolare
- Implementare cache invalidation appropriata
- Considerare cache a più livelli

```php
public function getStatistics(): array
{
    return Cache::remember('patient-statistics', 3600, function () {
        return [
            'total' => Patient::count(),
            'active' => Patient::where('status', 'active')->count(),
            'average_age' => Patient::avg('age'),
        ];
    });
}
```

## Sicurezza

### Input Validation

- Validare sempre gli input
- Utilizzare prepared statements per le query
- Sanitizzare l'output

```php
// ❌ NO: SQL injection risk
$query = "SELECT * FROM patients WHERE tax_code = '{$taxCode}'";

// ✅ SI: Prepared statement
$query = "SELECT * FROM patients WHERE tax_code = ?";
$statement = $pdo->prepare($query);
$statement->execute([$taxCode]);
```

### Authentication & Authorization

- Utilizzare middleware per l'autenticazione
- Implementare controlli di autorizzazione granulari
- Utilizzare policy per la logica di autorizzazione

```php
class PatientPolicy
{
    public function view(User $user, Patient $patient): bool
    {
        return $user->isAdmin() || $user->id === $patient->user_id;
    }
}
```

## Manutenibilità

### SOLID Principles

- Single Responsibility Principle
- Open/Closed Principle
- Liskov Substitution Principle
- Interface Segregation Principle
- Dependency Inversion Principle

### Design Patterns

- Repository Pattern
- Service Layer
- Factory Pattern
- Strategy Pattern
- Observer Pattern

## Version Control

### Git Workflow

- Utilizzare feature branches
- Scrivere commit messages significativi
- Mantenere la storia pulita

```bash

# ❌ NO: Commit message non descrittivo
git commit -m "fix"

# ✅ SI: Commit message descrittivo
git commit -m "fix: correzione calcolo età paziente"
```

### Code Review

- Richiedere review per ogni PR
- Fornire contesto nella descrizione
- Rispondere ai commenti

## Continuous Integration

### Automated Testing

- Eseguire test automaticamente
- Mantenere coverage alto
- Fail fast

### Code Quality

- Utilizzare PHPStan
- Eseguire PHPCS
- Verificare tipizzazione

## Deployment

### Environment

- Utilizzare variabili d'ambiente
- Mantenere configurazioni separate
- Documentare requisiti

### Monitoring

- Implementare logging
- Monitorare performance
- Alert su errori 

## Collegamenti tra versioni di coding-standards.md
* [coding-standards.md](../../../Xot/project_docs/standards/coding-standards.md)
* [coding-standards.md](../../../Xot/project_docs/conventions/coding-standards.md)

## Collegamenti Correlati

- [Convenzioni](../../../project_docs/conventions.md)
- [Naming Conventions](../../../project_docs/naming-conventions.md)
- [Documentazione Xot](../CODE-STANDARDS.md)
- [Collegamenti Documentazione](../../../../project_docs/collegamenti-documentazione.md)

