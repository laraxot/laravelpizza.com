# Register Implementation Architecture

## Pattern Utilizzato

Il modulo User utilizza il pattern Filament Widget per la registrazione, seguendo la stessa logica del login.

```blade
@livewire(\Modules\User\Filament\Widgets\Auth\RegisterWidget::class)
```

## Regole Fondamentali

### 1. NO ->label() nei Componenti Filament

**REGOLA ASSOLUTA**: Non utilizzare mai `->label()`, `->placeholder()` o `->helperText()` nei componenti Filament.

Le traduzioni sono gestite automaticamente dal `LangServiceProvider` che legge dai file di traduzione del modulo.

**Esempio CORRETTO:**
```php
'first_name' => TextInput::make('first_name')
    ->required()
    ->string()
    ->minLength(2)
    ->maxLength(255)
    ->autocomplete('given-name'),
    // NESSUN ->label()!
```

**Esempio ERRATO:**
```php
'first_name' => TextInput::make('first_name')
    ->label(__('user::fields.first_name.label'))  // ❌ VIETATO
    ->required(),
```

### 2. Validazione Password Centralizzata

La validazione delle password utilizza `PasswordData` per garantire coerenza con le impostazioni del tenant:

```php
use Modules\User\Datas\PasswordData;

'password' => TextInput::make('password')
    ->password()
    ->required()
    ->rule(PasswordData::make()->getPasswordRule())
    ->helperText(PasswordData::make()->getHelperText())
    ->autocomplete('new-password')
    ->confirmed(),
```

Le regole di validazione includono:
- Lunghezza minima configurabile
- Maiuscole/minuscole (opzionale)
- Numeri (opzionale)
- Simboli (opzionale)
- Controllo compromissione (opzionale)

### 3. GDPR Compliance (Event/Listener Pattern)

Il widget include la gestione completa dei consensi GDPR, implementata tramite pattern Event/Listener per mantenere il disaccoppiamento tra moduli:

- Privacy Policy (obbligatorio)
- Termini e Condizioni (obbligatorio)
- Trattamento dati (obbligatorio)
- Marketing (opzionale)
- Profilazione (opzionale)
- Analytics (opzionale)
- Terze parti (opzionale)

**Architettura Decoupled:**

```php
// User module (core) - dispatches event
UserRegistered::dispatch(
    user: $user,
    formData: $formData,
    ipAddress: request()->ip(),
    userAgent: request()->userAgent(),
);

// Gdpr module (optional) - listens and saves consents
class SaveGdprConsents {
    public function handle(UserRegistered $event): void {
        // Saves to Treatment/Consent entities
    }
}
```

Questo pattern garantisce che:
- Il modulo User funzioni indipendentemente dal modulo Gdpr
- Il modulo Gdpr estenda il comportamento di registrazione senza dipendenze inverse
- Altri moduli possano hookare l'evento `UserRegistered` per azioni aggiuntive

**File correlati:**
- Event: `Modules/User/app/Events/UserRegistered.php`
- Listener: `Modules/Gdpr/app/Listeners/SaveGdprConsents.php`
- Documentazione: `Modules/User/docs/architecture/user-gdpr-decoupling.md`

### 4. Struttura View

Il tema Meetup utilizza:
- `@livewire()` per includere il widget Filament
- Layout coerente con il login
- Design responsive con Tailwind CSS

## File Correlati

- Widget: `Modules/User/app/Filament/Widgets/Auth/RegisterWidget.php`
- View Tema: `Themes/Meetup/resources/views/pages/auth/register.blade.php`
- Password Config: `Modules/User/app/Datas/PasswordData.php`
- Traduzioni: `Modules/User/lang/*/auth.php`

## Ultimo Aggiornamento

2026-02-09 - Implementato pattern Event/Listener per disaccoppiare User da Gdpr (UserRegistered event + SaveGdprConsents listener).
