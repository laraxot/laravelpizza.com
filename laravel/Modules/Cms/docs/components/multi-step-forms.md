# Form Multi-Step nel Modulo CMS

## Introduzione

Questa guida spiega come implementare form multi-step nel modulo CMS utilizzando Laravel Volt e Folio. I form multi-step sono utili per raccogliere grandi quantità di dati in modo organizzato e user-friendly.

## Setup Iniziale

### 1. Installazione Dipendenze
```bash
composer require livewire/volt laravel/folio
php artisan volt:install
```

### 2. Struttura Database
```php
// Esempio di migrazione per un form multi-step
public function up()
{
    Schema::create('form_submissions', function (Blueprint $table) {
        $table->id();
        $table->string('step_1_field');
        $table->string('step_2_field');
        $table->jsonb('additional_data')->nullable();
        $table->timestamps();
    });
}
```

## Implementazione

### 1. Modello Base
```php
namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    protected $fillable = [
        'step_1_field',
        'step_2_field',
        'additional_data',
    ];

    protected $casts = [
        'additional_data' => 'array',
    ];
}
```

### 2. Componenti Volt

#### Step 1: Informazioni Base
```php
<?php

use function Livewire\Volt\{state, rules};

state([
    'step_1_field' => '',
]);

rules([
    'step_1_field' => 'required|min:3',
]);

$saveAndContinue = function () {
    $this->validate();
    
    session(['step_1_data' => [
        'step_1_field' => $this->step_1_field,
    ]]);
    
    return redirect()->route('form.step2');
};
?>

<div>
    <form wire:submit="saveAndContinue">
        <x-cms::input-field
            wire:model="step_1_field"
            label="Campo Step 1"
        />
        
        <x-cms::button type="submit">
            Continua
        </x-cms::button>
    </form>
</div>
```

#### Step 2: Informazioni Aggiuntive
```php
<?php

use function Livewire\Volt\{state, rules};

state([
    'step_2_field' => '',
]);

rules([
    'step_2_field' => 'required|min:3',
]);

$saveAndContinue = function () {
    $this->validate();
    
    session(['step_2_data' => [
        'step_2_field' => $this->step_2_field,
    ]]);
    
    return redirect()->route('form.review');
};

$goBack = function () {
    return redirect()->route('form.step1');
};
?>

<div>
    <form wire:submit="saveAndContinue">
        <x-cms::input-field
            wire:model="step_2_field"
            label="Campo Step 2"
        />
        
        <div class="flex justify-between">
            <x-cms::button
                type="button"
                wire:click="goBack"
                variant="secondary"
            >
                Indietro
            </x-cms::button>
            
            <x-cms::button type="submit">
                Continua
            </x-cms::button>
        </div>
    </form>
</div>
```

#### Review e Invio
```php
<?php

use function Livewire\Volt\{state};
use Modules\Cms\Models\FormSubmission;

state([
    'step_1_data' => null,
    'step_2_data' => null,
]);

$mount = function () {
    $this->step_1_data = session('step_1_data', []);
    $this->step_2_data = session('step_2_data', []);
    
    if (empty($this->step_1_data) || empty($this->step_2_data)) {
        return redirect()->route('form.step1');
    }
};

$submit = function () {
    $submission = FormSubmission::create([
        'step_1_field' => $this->step_1_data['step_1_field'],
        'step_2_field' => $this->step_2_data['step_2_field'],
    ]);
    
    session()->forget(['step_1_data', 'step_2_data']);
    
    return redirect()->route('form.confirmation');
};

$goBack = function () {
    return redirect()->route('form.step2');
};
?>

<div>
    <div class="review-section">
        <h3>Rivedi i Dati</h3>
        
        <div class="mt-4">
            <h4>Step 1</h4>
            <p>{{ $step_1_data['step_1_field'] }}</p>
        </div>
        
        <div class="mt-4">
            <h4>Step 2</h4>
            <p>{{ $step_2_data['step_2_field'] }}</p>
        </div>
        
        <div class="flex justify-between mt-6">
            <x-cms::button
                type="button"
                wire:click="goBack"
                variant="secondary"
            >
                Indietro
            </x-cms::button>
            
            <x-cms::button
                type="button"
                wire:click="submit"
                variant="primary"
            >
                Invia
            </x-cms::button>
        </div>
    </div>
</div>
```

## Routing con Folio

### 1. Struttura delle Route
```
resources/
  └─ views/
      └─ pages/
          └─ forms/
              ├─ step1.blade.php
              ├─ step2.blade.php
              ├─ review.blade.php
              └─ confirmation.blade.php
```

### 2. Configurazione delle Pagine
```php
// resources/views/pages/forms/step1.blade.php
<?php

use function Laravel\Folio\{name, middleware};

name('form.step1');
middleware(['web', 'auth']);
?>

<x-layouts.form>
    <livewire:form-step1 />
</x-layouts.form>
```

## Validazione e Sicurezza

### 1. Middleware di Protezione
```php
namespace Modules\Cms\Http\Middleware;

class EnsureFormStepCompleted
{
    public function handle($request, $next)
    {
        $currentStep = $request->route()->getName();
        $sessionData = session()->all();
        
        if ($currentStep === 'form.step2' && empty($sessionData['step_1_data'])) {
            return redirect()->route('form.step1');
        }
        
        if ($currentStep === 'form.review' && (empty($sessionData['step_1_data']) || empty($sessionData['step_2_data']))) {
            return redirect()->route('form.step1');
        }
        
        return $next($request);
    }
}
```

### 2. Validazione Personalizzata
```php
namespace Modules\Cms\Rules;

use Illuminate\Contracts\Validation\Rule;

class CustomFormRule implements Rule
{
    public function passes($attribute, $value)
    {
        // Logica di validazione personalizzata
        return true;
    }
    
    public function message()
    {
        return 'Il campo :attribute non è valido.';
    }
}
```

## Testing

### 1. Feature Tests
```php
namespace Tests\Feature\Forms;

use Tests\TestCase;
use Livewire\Volt\Volt;

class MultiStepFormTest extends TestCase
{
    /** @test */
    public function it_can_complete_step_one()
    {
        $this->actingAs($user = User::factory()->create());
        
        Volt::test('form-step1')
            ->set('step_1_field', 'Test Value')
            ->call('saveAndContinue')
            ->assertRedirect(route('form.step2'));
            
        $this->assertEquals('Test Value', session('step_1_data.step_1_field'));
    }
}
```

### 2. Browser Tests
```php
namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MultiStepFormTest extends DuskTestCase
{
    /** @test */
    public function it_can_navigate_through_all_steps()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($user)
                   ->visit(route('form.step1'))
                   ->type('@step-1-field', 'Test Value')
                   ->click('@continue-button')
                   ->assertRouteIs('form.step2');
        });
    }
}
```

## Best Practices

### 1. Gestione dello Stato
- Utilizzare la sessione per dati temporanei
- Pulire la sessione dopo l'invio
- Validare ogni step individualmente

### 2. UX/UI
- Mostrare indicatore di progresso
- Permettere la navigazione tra step
- Fornire feedback immediato
- Salvare dati in bozza

### 3. Performance
- Minimizzare le richieste al server
- Ottimizzare le query del database
- Implementare caching appropriato

## Troubleshooting

### Problemi Comuni

1. **Perdita dei Dati**
```php
// Implementare auto-save
$autosave = function () {
    if ($this->validate()) {
        session(['draft_data' => [
            'step_1_field' => $this->step_1_field,
        ]]);
    }
};
```

2. **Validazione non Funzionante**
```php
// Aggiungere validazione real-time
rules([
    'step_1_field' => 'required|min:3',
])->validateOnBlur();
```

3. **Problemi di Navigazione**
```php
// Implementare controllo dello stato
public function mount()
{
    if (!session()->has('step_1_data')) {
        return redirect()->route('form.step1');
    }
}
```

## Risorse Utili

### Documentation
- [Laravel Volt Documentation](https://livewire.laravel.com/docs/volt)
- [Laravel Folio Documentation](https://laravel.com/docs/folio)
- [Filament Forms Documentation](https://filamentphp.com/docs/forms) 

## Collegamenti tra versioni di multi-step-forms.md
* [multi-step-forms.md](laravel/Modules/Cms/docs/multi-step-forms.md)
* [multi-step-forms.md](laravel/Modules/Cms/docs/components/multi-step-forms.md)

