# RegisterWidget Fix - 13 Febbraio 2026

## Problema Risolto

La pagina di registrazione `/it/auth/register` non funzionava correttamente:
- Form non renderizzato (Internal Server Error)
- Layout a una colonna invece di due
- Traduzioni mancanti

## Cause Identificate

### 1. Conflitto tra Filament Schema e Custom Blade View

Il RegisterWidget aveva sia:
- `getFormSchema()` con componenti Filament (TextInput, Grid, etc.)
- Un blade view custom con form HTML diretto

Questo creava conflitti perché Filament aspettava di renderizzare lo schema del form, ma il blade view cercava di renderizzare un form HTML completamente diverso.

### 2. Errore di Access Level

Il metodo `getFormSchema()` era definito come `protected` nella classe padre `XotBaseWidget`, ma era stato sovrascritto senza mantenere lo stesso access level. Questo causava l'errore:

```
Access level to Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget::getFormSchema() must be public
```

### 3. Errore di Dichiarazione Proprietà Statica

La proprietà `$view` era definita come `static` nel RegisterWidget ma come `non static` nella classe padre `XotBaseWidget`. Questo causava l'errore:

```
Cannot redeclare non static Modules\Xot\Filament\Widgets\XotBaseWidget::$view as static
```

## Soluzione Implementata

### 1. Rimozione di getFormSchema()

Rimosso completamente il metodo `getFormSchema()` perché il blade view gestisce il form rendering direttamente.

```php
// RIMOSSO
#[\Override]
public function getFormSchema(): array
{
    return [
        'name_grid' => Grid::make(2)->schema([...]),
        'email' => TextInput::make('email')->...,
        // ...
    ];
}
```

### 2. Aggiunta di Proprietà Pubbliche per Campi Form

Aggiunte proprietà pubbliche con validation attributes per tutti i campi del form:

```php
#[Validate('required|string|min:2|max:255')]
public string $first_name = '';

#[Validate('required|string|min:2|max:255')]
public string $last_name = '';

#[Validate('required|email|max:255')]
public string $email = '';

#[Validate('required|string')]
public string $password = '';

#[Validate('required|string|same:password')]
public string $password_confirmation = '';

public bool $show_password = false;
```

### 3. Uso di getView() Invece di Proprietà Statica

Sostituita la proprietà statica `$view` con il metodo `getView()`:

```php
// SBAGLIATO
protected static string $view = 'filament.widgets.auth.register';

// CORRETTO
protected function getView(): string
{
    return 'filament.widgets.auth.register';
}
```

### 4. Aggiornamento Metodo submit()

Modificato il metodo `submit()` per raccogliere i dati dalle proprietà pubbliche invece che dal form schema:

```php
public function submit(): void
{
    try {
        // Validate form data using Livewire attributes
        $this->validate();

        // Validate GDPR consents
        app(ValidateGdprConsentAction::class)->execute(
            $this->privacy_accepted,
            $this->terms_accepted
        );

        // Prepare form data from public properties
        $formData = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ];

        // ... rest of the logic
    }
}
```

### 5. Correzione Blade View

Corretta la struttura HTML nel file blade view con classi Tailwind appropriate:

```php
<x-filament-widgets::widget>
    <x-filament::section>
        <form wire:submit="submit" class="space-y-6">
            
            <!-- Personal Information Section -->
            <div class="space-y-5">
                <div>
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <!-- Icona -->
                        {{ __('gdpr::register.sections.user_info') }}
                    </h2>
                    <!-- ... -->
                </div>

                <!-- Name Fields Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- first_name -->
                    <!-- last_name -->
                </div>

                <!-- ... altri campi ... -->
            </div>

            <!-- GDPR Consent Section -->
            <!-- ... -->

            <!-- Submit Section -->
            <!-- ... -->
        </form>
    </x-filament::section>
</x-filament-widgets::widget>
```

## Layout Corretto

Il layout della pagina ora è:

```
Container: max-w-7xl (1280px wide)
├── Grid: lg:grid-cols-2 gap-16
│   ├── Left Column: Branding & Benefits
│   │   ├── Title: "Unisciti alla Pizza Revolution 🍕"
│   │   ├── Subtitle: Community description
│   │   └── Benefits list (icons + text)
│   └── Right Column: Registration Form Card
│       ├── Personal Information Section
│       ├── GDPR Consent Section (required)
│       ├── Optional Consent Section
│       └── Submit Button + Login Link
```

## Verifiche Eseguite

### 1. Rendering Corretto
- ✅ Campo `first_name` renderizzato correttamente
- ✅ Tutti i campi form presenti (first_name, last_name, email, password, password_confirmation)
- ✅ Consensi GDPR presenti e funzionanti
- ✅ Pulsante submit con testo corretto

### 2. Traduzioni Funzionanti
- ✅ "Nome" per first_name
- ✅ "Cognome" per last_name
- ✅ "La tua migliore Email" per email
- ✅ "Password sicura" per password
- ✅ "Conferma Password" per password_confirmation
- ✅ "Crea il mio account gratis" per submit button
- ✅ "Informativa Privacy" per consenso privacy
- ✅ "Termini e Condizioni" per consenso termini

### 3. Layout Verificato
- ✅ Container `max-w-7xl` (wide container)
- ✅ Grid `lg:grid-cols-2` (two columns)
- ✅ Gap `gap-16` (proper spacing)
- ✅ Branding section presente a sinistra
- ✅ Form card presente a destra

### 4. Qualità Codice
- ✅ PHPStan Level 10: 0 errori
- ✅ Nessun warning PHPStan
- ✅ Strict types dichiarati
- ✅ Validation attributes corretti

## File Modificati

1. `/laravel/Modules/Gdpr/app/Filament/Widgets/Auth/RegisterWidget.php`
   - Rimosso `getFormSchema()`
   - Aggiunte proprietà pubbliche per campi form
   - Aggiunto metodo `getView()`
   - Aggiornato metodo `submit()`

2. `/laravel/Themes/Meetup/resources/views/filament/widgets/auth/register.blade.php`
   - Corretta struttura HTML
   - Aggiornate classi Tailwind per dark mode

## Regole Importanti per Futuri Sviluppi

### 1. Quando Usare Custom Blade View nei Widget

Se un widget ha bisogno di un form HTML completamente custom con:
- Link cliccabili nei consensi (privacy/terms)
- Layout personalizzato non standard Filament
- Elementi HTML non supportati dai componenti Filament

Allora:
- NON definire `getFormSchema()`
- Definire proprietà pubbliche per i campi
- Usare `getView()` per specificare il blade view
- Usare validation attributes `#[Validate()]`

### 2. Mai Usare Proprietà Statiche per Override

Se la classe padre ha una proprietà `protected` o `public`, non dichiararla come `static` nella classe figlia. Invece:
- Se è una proprietà, usarla direttamente
- Se è un metodo, sovrascriverlo mantenendo lo stesso access level

### 3. Access Level Deve Essere Conservato

Quando si sovrascrive un metodo dalla classe padre, mantenere sempre lo stesso access level:
- `public` → `public`
- `protected` → `protected`
- `private` → non può essere sovrascritto

## Commit

- Hash: `f525afa2`
- Branch: `dev`
- Messaggio: "fix(gdpr): corregge rendering form registrazione e layout a due colonne"

## Risorse

- Pagina: http://127.0.0.1:8000/it/auth/register
- File traduzioni: `/laravel/Modules/Gdpr/lang/it/register.php`
- Widget: `/laravel/Modules/Gdpr/app/Filament/Widgets/Auth/RegisterWidget.php`
- View: `/laravel/Themes/Meetup/resources/views/filament/widgets/auth/register.blade.php`
- Page: `/laravel/Themes/Meetup/resources/views/pages/auth/register.blade.php`