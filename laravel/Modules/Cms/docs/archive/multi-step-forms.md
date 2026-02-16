# Form Multi-Step con Laravel Volt e Folio

Questa guida spiega come implementare form multi-step utilizzando Laravel Volt e Folio, con particolare attenzione alla gestione dei dati e alla user experience.

## Prerequisiti

- Laravel 10+
- Composer
- PHP 8.1 o superiore
- Conoscenza base di Laravel e database relazionali

## Installazione Componenti

### 1. Laravel Folio per il Routing

```bash
composer require laravel/folio
```

### 2. Laravel Volt per la Reattività

```bash
composer require livewire/volt
php artisan volt:install
```

## Struttura del Database

### 1. Tabella Principale (applicants)

```php
public function up()
{
    Schema::create('applicants', function (Blueprint $table) {
        $table->id();
        $table->string('first_name');
        $table->string('last_name');
        $table->string('email')->unique();
        $table->jsonb('additional_info')->nullable();
        $table->timestamps();
    });
}
```

### 2. Tabelle Correlate

```php
// Educations
Schema::create('educations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('applicant_id')->constrained()->onDelete('cascade');
    $table->string('institution');
    $table->string('degree');
    $table->date('start_date');
    $table->date('end_date')->nullable();
    $table->jsonb('additional_info')->nullable();
    $table->timestamps();
});

// Work Experiences
Schema::create('work_experiences', function (Blueprint $table) {
    $table->id();
    $table->foreignId('applicant_id')->constrained()->onDelete('cascade');
    $table->string('company');
    $table->string('position');
    $table->date('start_date');
    $table->date('end_date')->nullable();
    $table->text('responsibilities');
    $table->jsonb('additional_info')->nullable();
    $table->timestamps();
});
```

## Modelli Eloquent

### 1. Applicant Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Applicant extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'additional_info'
    ];

    protected $casts = [
        'additional_info' => 'array'
    ];

    public function educations(): HasMany
    {
        return $this->hasMany(Education::class);
    }

    public function workExperiences(): HasMany
    {
        return $this->hasMany(WorkExperience::class);
    }
}
```

### 2. Education Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Education extends Model
{
    protected $fillable = [
        'institution',
        'degree',
        'start_date',
        'end_date',
        'additional_info'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'additional_info' => 'array'
    ];

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }
}
```

### 3. WorkExperience Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkExperience extends Model
{
    protected $fillable = [
        'company',
        'position',
        'start_date',
        'end_date',
        'responsibilities',
        'additional_info'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'additional_info' => 'array'
    ];

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }
}
```

## Componenti Volt

### 1. Form Informazioni Personali

```php
<?php

use function Livewire\Volt\{state, rules};

state([
    'first_name' => '',
    'last_name' => '',
    'email' => ''
]);

rules([
    'first_name' => 'required|min:2',
    'last_name' => 'required|min:2',
    'email' => 'required|email|unique:applicants'
]);

$saveAndContinue = function () {
    $this->validate();

    $applicant = Applicant::create([
        'first_name' => $this->first_name,
        'last_name' => $this->last_name,
        'email' => $this->email
    ]);

    session(['applicant_id' => $applicant->id]);

    return redirect()->route('apply.education');
};
?>

<div>
    <form wire:submit="saveAndContinue">
        <div class="space-y-4">
            <div>
                <label>Nome</label>
                <input type="text" wire:model="first_name" />
                @error('first_name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Cognome</label>
                <input type="text" wire:model="last_name" />
                @error('last_name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Email</label>
                <input type="email" wire:model="email" />
                @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <button type="submit">Continua</button>
        </div>
    </form>
</div>
```

### 2. Form Educazione

```php
<?php

use function Livewire\Volt\{state, rules};

state([
    'institution' => '',
    'degree' => '',
    'start_date' => '',
    'end_date' => null
]);

rules([
    'institution' => 'required',
    'degree' => 'required',
    'start_date' => 'required|date',
    'end_date' => 'nullable|date|after:start_date'
]);

$saveAndContinue = function () {
    $this->validate();

    $applicant = Applicant::findOrFail(session('applicant_id'));
    
    $applicant->educations()->create([
        'institution' => $this->institution,
        'degree' => $this->degree,
        'start_date' => $this->start_date,
        'end_date' => $this->end_date
    ]);

    return redirect()->route('apply.work-experience');
};
?>

<div>
    <form wire:submit="saveAndContinue">
        <!-- Form fields -->
    </form>
</div>
```

## Routing con Folio

### 1. Struttura delle Route

```
resources/
└── views/
    └── pages/
        └── apply/
            ├── personal-info.blade.php
            ├── education.blade.php
            ├── work-experience.blade.php
            ├── review.blade.php
            └── confirmation.blade.php
```

### 2. Configurazione Route

```php
<?php
// personal-info.blade.php
use function Laravel\Folio\name;

name('apply.personal-info');
?>

@extends('layouts.app')

@section('content')
    <livewire:personal-info-form />
@endsection
```

## Best Practices

1. **Validazione e Sicurezza**
   - Validare tutti gli input
   - Implementare CSRF protection
   - Verificare autorizzazioni utente

2. **User Experience**
   - Mostrare indicatori di progresso
   - Salvare dati in sessione
   - Gestire navigazione back/forward

3. **Performance**
   - Ottimizzare query database
   - Implementare caching appropriato
   - Gestire file upload efficientemente

4. **Testing**
   - Scrivere test per ogni step
   - Verificare validazioni
   - Testare flusso completo

## Testing

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Applicant;
use Livewire\Volt\Volt;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PersonalInfoTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_submit_personal_info()
    {
        Volt::test('personal-info-form')
            ->set('first_name', 'Mario')
            ->set('last_name', 'Rossi')
            ->set('email', 'mario@example.com')
            ->call('saveAndContinue')
            ->assertRedirect('/apply/education');

        $this->assertDatabaseHas('applicants', [
            'first_name' => 'Mario',
            'last_name' => 'Rossi',
            'email' => 'mario@example.com',
        ]);
    }
}
```

## Troubleshooting

1. **Problemi Comuni**
   - Gestione sessione scaduta
   - Validazione dati incompleti
   - Conflitti di routing

2. **Soluzioni**
   - Implementare middleware di sessione
   - Aggiungere validazioni server-side
   - Verificare configurazione route

## Note sulla Performance

1. **Ottimizzazione Database**
   - Utilizzare indici appropriati
   - Implementare eager loading
   - Ottimizzare query N+1

2. **Front-end**
   - Minimizzare richieste AJAX
   - Implementare loading states
   - Ottimizzare assets

## Riferimenti

- [Documentazione Laravel Volt](https://livewire.laravel.com/project_docs/volt)
- [Documentazione Laravel Folio](https://github.com/laravel/folio)
- [Documentazione Laravel](https://laravel.com/docs) 

## Collegamenti tra versioni di multi-step-forms.md
* [multi-step-forms.md](laravel/Modules/Cms/project_docs/multi-step-forms.md)
* [multi-step-forms.md](laravel/Modules/Cms/project_docs/components/multi-step-forms.md)

