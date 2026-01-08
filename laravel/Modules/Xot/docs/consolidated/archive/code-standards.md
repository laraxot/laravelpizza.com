# Standard di Codice

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

namespace Modules\Patient\Models;
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
namespace Modules\Patient\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Patient\Enums\GenderType;

class StorePatientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'string', 'in:' . implode(',', array_column(GenderType::cases(), 'value'))],
            'tax_code' => ['required', 'string', 'size:16', 'unique:patients,tax_code'],
            'pregnancy_week' => ['nullable', 'integer', 'min:1', 'max:45'],
        ];
    }
}
```

### Controlli Difensivi

- Implementare controlli precondizionali all'inizio dei metodi
- Utilizzare guardie per evitare esecuzioni indesiderate
- Verificare sempre lo stato del sistema prima di operazioni critiche

## Regole Filament

### Risorse

Tutte le risorse Filament devono:

1. Estendere `XotBaseResource` invece di `Filament\Resources\Resource`
2. Gestire correttamente le azioni nella tabella:
   - Se `getTableActions` restituisce solo ViewAction, EditAction e DeleteAction, deve essere rimosso
   - In caso contrario, deve includere `...parent::getTableActions()`
   - Se `getTableBulkActions` restituisce solo DeleteBulkAction, deve essere rimosso
   - In caso contrario, deve includere `...parent::getTableBulkActions()`
3. Non utilizzare mai `->label('')` direttamente, gestire le label tramite file di traduzione

**Esempio corretto:**

```php
public function getTableActions(): array
{
    return [
        Action::make('custom')
            ->label(__('module::actions.custom'))
            ->icon('heroicon-o-bolt')
            ->action(fn (Model $record) => $this->customAction($record)),
            
        ...parent::getTableActions(),
    ];
}
```

## Collegamenti alla Documentazione Specifica

- [Standard di Codice nel Progetto](../../../../project_docs/standard-codice.md) 
