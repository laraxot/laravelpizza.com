# Standard di Codice per il progetto

## Principi Fondamentali

Il codice del progetto il progetto **deve** aderire ai seguenti principi fondamentali:

1. **Robustezza**: Funzionamento corretto anche in condizioni impreviste
2. **Solidità**: Struttura manutenibile, scalabile e testabile
3. **Tipizzazione Stretta**: Tipizzazione esplicita di variabili, parametri e valori di ritorno

## Tipizzazione Stretta (Strict Typing)

### Configurazione PHP

Tutti i file PHP **devono** iniziare con:

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\app\Percorso;
```

### Tipizzazione Esplicita

Ogni metodo e funzione **deve** dichiarare:
- Tipo di ogni parametro
- Tipo di ritorno, incluso `void` quando non restituisce valori
- Tipizzazioni nullable quando appropriato (`?string`)

```php
public function getPatientById(int $id): ?Patient
{
    return $this->repository->find($id);
}

public function processData(array $data): void
{
    // Elaborazione senza valore di ritorno
}
```

## Struttura del Codice

- File con responsabilità singola
- Classi, trait e interfaces ben definiti
- Struttura di directory coerente
- Convenzioni di naming di Laravel
- Namespace appropriati

## Modelli

- Proprietà tipizzate con `@property`
- Relazioni con tipi di ritorno espliciti
- Utilizzo di `casts` per garantire i tipi corretti
- Scopes tipizzati

```php
/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property Carbon $created_at
 */
class Patient extends Model
{
    protected $casts = [
        'id' => 'integer',
        'birth_date' => 'date',
        'is_active' => 'boolean',
    ];
    
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
```

## Data Transfer Objects

Utilizzare DTO tipizzati invece di array associativi:

```php
class PatientData
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly ?DateTimeInterface $birthDate = null,
        public readonly bool $isActive = true,
    ) {}
    
    public static function fromArray(array $data): self
    {
        return new self(
            firstName: $data['first_name'],
            lastName: $data['last_name'],
            birthDate: isset($data['birth_date']) ? new DateTime($data['birth_date']) : null,
            isActive: $data['is_active'] ?? true,
        );
    }
}
```

## Validazione

Implementare validazione rigorosa:

```php
class PatientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'is_active' => ['boolean'],
        ];
    }
}
```

## PHPStan

- Utilizzare PHPStan con livello progressivo (obiettivo minimo livello 9)
- Iniziare dal livello 1 per nuovi moduli
- Aumentare il livello solo quando rimangono meno di 100 errori nel livello corrente

## Convenzioni per Filament

### XotBaseResource
- Non definire `navigationIcon` se la classe estende `XotBaseResource`
- Rimuovere `getRelations()` se restituisce array vuoto
- Rimuovere `getPages()` se contiene solo route standard
- `getFormSchema()` deve restituire array associativo con chiavi stringhe

### XotBaseListRecords
- Rimuovere `Actions()` se restituisce solo `createAction`
- `getListTableColumns()` deve restituire array associativo con chiavi stringhe

```php
// Esempio corretto
class MyResource extends XotBaseResource
{
    public static function getFormSchema(): array
    {
        return [
            'title' => Forms\Components\TextInput::make('title'),
            'content' => Forms\Components\RichEditor::make('content'),
        ];
    }
}
```

## Collegamenti tra versioni di standard-codice.md
* [standard-codice.md](docs/standard-codice.md)
* [standard-codice.md](../../../Xot/docs/development/standard-codice.md)

