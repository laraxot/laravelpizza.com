# Spatie Laravel Data Objects

## Introduzione

Spatie Laravel Data è il nostro standard per la gestione dei Data Transfer Objects (DTO). Questo approccio garantisce:
- Tipizzazione stretta
- Validazione integrata
- Immutabilità dei dati
- Serializzazione consistente

## Implementazione Standard

### Struttura Base
```php
declare(strict_types=1);

namespace Modules\Performance\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation;

class PerformanceData extends Data
{
    public function __construct(
        #[Validation('required|string|max:255')]
        public readonly string $nome,
        
        #[Validation('required|numeric|min:0|max:100')]
        public readonly float $punteggio,
        
        #[Validation('nullable|date')]
        public readonly ?Carbon $data_valutazione = null,
    ) {}
}
```

### Best Practices

1. **Immutabilità**
   - Utilizzare sempre `readonly` per le proprietà
   - Implementare metodi `with` per modifiche
   ```php
   public function withPunteggio(float $punteggio): self
   {
       return new self(
           nome: $this->nome,
           punteggio: $punteggio,
           data_valutazione: $this->data_valutazione,
       );
   }
   ```

2. **Validazione**
   - Utilizzare gli attributi Validation
   - Definire regole chiare e specifiche
   - Includere messaggi di errore in italiano

3. **Casting**
   ```php
   protected function casts(): array
   {
       return [
           'data_valutazione' => Carbon::class,
           'punteggio' => 'float',
       ];
   }
   ```

4. **Computed Properties**
   ```php
   public function computed(): array
   {
       return [
           'status' => fn () => $this->calculateStatus(),
       ];
   }
   ```

### Utilizzo con Actions

```php
declare(strict_types=1);

class UpdatePerformanceAction
{
    use QueueableAction;

    public function execute(PerformanceData $data): Performance
    {
        return Performance::create([
            'nome' => $data->nome,
            'punteggio' => $data->punteggio,
            'data_valutazione' => $data->data_valutazione,
        ]);
    }
}
```

### Integrazione con Filament

```php
use Filament\Forms;

class PerformanceResource extends XotBaseResource
{
    public static function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('nome')
                ->required()
                ->string()
                ->maxLength(255),
                
            Forms\Components\TextInput::make('punteggio')
                ->required()
                ->numeric()
                ->min(0)
                ->max(100),
                
            Forms\Components\DatePicker::make('data_valutazione')
                ->nullable(),
        ];
    }
}
```

### Testing

```php
declare(strict_types=1);

class PerformanceDataTest extends TestCase
{
    public function test_creates_valid_performance_data(): void
    {
        $data = new PerformanceData(
            nome: 'Test Performance',
            punteggio: 85.5,
            data_valutazione: now(),
        );

        $this->assertInstanceOf(PerformanceData::class, $data);
        $this->assertEquals('Test Performance', $data->nome);
        $this->assertEquals(85.5, $data->punteggio);
    }

    public function test_validates_punteggio_range(): void
    {
        $this->expectException(ValidationException::class);

        new PerformanceData(
            nome: 'Test',
            punteggio: 101, // Oltre il massimo consentito
        );
    }
}
```

### Trasformazioni

```php
declare(strict_types=1);

class PerformanceData extends Data
{
    public static function fromRequest(Request $request): self
    {
        return new self(
            nome: $request->input('nome'),
            punteggio: (float) $request->input('punteggio'),
            data_valutazione: $request->has('data_valutazione') 
                ? Carbon::parse($request->input('data_valutazione'))
                : null,
        );
    }

    public function toArray(): array
    {
        return [
            'nome' => $this->nome,
            'punteggio' => $this->punteggio,
            'data_valutazione' => $this->data_valutazione?->toDateString(),
        ];
    }
}
```

### Validazione Complessa

```php
declare(strict_types=1);

class PerformanceData extends Data
{
    public static function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'punteggio' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
                new ValidPunteggio(), // Custom rule
            ],
            'data_valutazione' => ['nullable', 'date', 'before_or_equal:today'],
        ];
    }

    public static function messages(): array
    {
        return [
            'punteggio.min' => 'Il punteggio non può essere inferiore a 0',
            'punteggio.max' => 'Il punteggio non può essere superiore a 100',
        ];
    }
}
```

### Nesting e Collezioni

```php
declare(strict_types=1);

class ValutazioneData extends Data
{
    public function __construct(
        public readonly PerformanceData $performance,
        /** @var \Illuminate\Support\Collection<int, CommentoData> */
        public readonly Collection $commenti,
    ) {}

    public static function validate(array $data): array
    {
        return validator($data, [
            'performance' => ['required', 'array'],
            'commenti' => ['array'],
            'commenti.*.testo' => ['required', 'string'],
        ])->validate();
    }
}
