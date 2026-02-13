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

### 4. Layout e Spaziatura (UX)

La pagina di registrazione utilizza un layout **wide-container** (max-w-4xl) invece del tradizionale narrow-container (max-w-md):

```blade
<div class="w-full max-w-4xl mx-auto">
```

Questo permette:
- Form più largo e leggibile
- Migliore utilizzo dello spazio su schermi grandi
- Sezioni chiaramente separate
- Visual hierarchy migliorata

### 5. Progress Indicator (UX/WCAG)

Indicatori di progresso visibili per guidare l'utente:

```blade
<div class="flex items-center space-x-4" aria-label="Progresso registrazione">
    <div class="flex items-center">
        <span class="w-8 h-8 rounded-full bg-primary-600 text-white" aria-current="step">1</span>
        <span class="ml-2 text-sm font-medium">Dati personali</span>
    </div>
    <div class="flex-1 h-1 bg-primary-200 rounded">
        <div class="h-full w-full bg-primary-600 rounded"></div>
    </div>
</div>
```

### 6. Trust Indicators (UX)

Elementi di trust visibili per aumentare la fiducia dell'utente:

- Badge "Dati protetti con crittografia SSL"
- Badge "GDPR Compliant"
- Design professionale e pulito

### 7. Organizzazione del Form

Il form è organizzato in sezioni logiche:

1. **Informazioni personali** (nome, cognome, email)
2. **Sicurezza** (password, conferma)
3. **Consensi e Privacy**:
   - Consensi Obbligatori (Privacy, Termini, Trattamento dati)
   - Consensi Opzionali (Marketing, Profilazione, Analytics, Terze parti)

Ogni sezione ha:
- Titolo chiaro
- Descrizione esplicativa
- Icona identificativa
- Possibilità di collassare (per sezioni lunghe)

## WCAG Compliance (2.1 AA)

### Contrasto

- Testo su sfondo: rapporto minimo 4.5:1
- Testo grande (18px+): rapporto minimo 3:1
- Elementi UI interattivi: sempre visibili

```css
/* Esempio: testo grigio su bianco */
.text-gray-600 /* 6.4:1 ratio */
.text-gray-700 /* 7.5:1 ratio */
```

### Focus Visibile

Tutti gli elementi interattivi hanno focus indicator visibile:

```css
.focus:outline-none.focus:ring-2.focus:ring-offset-2.focus:ring-primary-500
```

### ARIA Labels

Landmark e labels per screen reader:

```blade
<section aria-labelledby="register-heading">
<h1 id="register-heading">Crea il tuo account</h1>

<div role="form" aria-label="Form di registrazione">
<div role="complementary" aria-label="Accesso alternativo">
```

### Touch Targets

Tutti i target touch sono minimo 44x44px (WCAG 2.5.5):

```css
.min-h-[48px] /* Pulsanti */
```

### Autocomplete

Campi con attributi autocomplete corretti:

```php
->autocomplete('given-name')   // Nome
->autocomplete('family-name')  // Cognome
->autocomplete('email')         // Email
->autocomplete('new-password')  // Password
```

## File Correlati

- Widget: `Modules/User/app/Filament/Widgets/Auth/RegisterWidget.php`
- View Tema: `Themes/Meetup/resources/views/pages/auth/register.blade.php`
- Password Config: `Modules/User/app/Datas/PasswordData.php`
- Traduzioni: `Modules/User/lang/*/auth.php`

## Ultimo Aggiornamento

2026-02-09 - Layout wide-container, progress indicator, trust badges, sezioni form organizzate, WCAG 2.1 AA compliance.


costantemente migliora i prompt che sono dentro laravel/Themes/Meetup/docs/replikate e anche le memorie e le skills e quelle degli altri agenti ai
