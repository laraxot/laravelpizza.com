---
title: "login: Consolidated Documentation"
module: user
type: integration
tags: [integrations, modules, user]
created: 2026-08-24
updated: 2026-08-24
status: draft
qmd: "login   consolidated documentation user"
---

# login: Consolidated Documentation

Consolidated from **12** individual files.

## Table of Contents

- [---](#login-resolution)
- [---](#login-widget-analysis)
- [---](#login-widget-conversion)
- [---](#login-widget-fix)
- [---](#login-widget-livewire-binding-fix)
- [---](#login-widget-livewire-binding)
- [---](#login-widget-translation)
- [---](#login-widget)
- [Analisi Dettagliata di LoginWidget](#login_widget_analysis)
- [Conversione Livewire Auth/Login a Filament LoginWidget](#login_widget_conversion)
- [---](#loginwidget-error-analysis)
- [---](#loginwidget)

---

## login-resolution

*Consolidated from: `login-resolution.md`*

title: "Risoluzione Problema Login - Report Finale (Aggiornato)"
type: concept
tags: [login, resolution]
created: 2026-07-14
updated: 2026-07-14
qmd: "login-resolution risoluzione problema login - report finale (aggiornato)"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Risoluzione Problema Login - Report Finale (Aggiornato)

## Prologo: La Sfida degli Agenti
Durante il lavoro coordinato tra più agenti AI, è emersa una discrepanza nell'analisi. Un precedente agente ha analizzato il componente `Modules/User/Http/Livewire/Auth/Login.php`, che risultava correttamente configurato. Tuttavia, il problema segnalato dall'utente riguardava la pagina `/it/auth/login` del tema **Sixteen**, che utilizza invece `Modules\User\Filament\Widgets\Auth\LoginWidget::class`.

## Problema Identificato
Il widget `LoginWidget` (e più in generale la classe base `XotBaseWidget`) presentava il metodo `mount()` commentato o assente.

### Analisi Tecnica
In Filament 4 (e v3), i componenti che usano `InteractsWithForms` necessitano di una chiamata a `$this->form->fill()` durante la fase di `mount()`. 
- Senza `fill()`, l'array `$data` (o lo statePath definito) non viene inizializzato con le chiavi del form.
- Livewire non riesce a sincronizzare correttamente i campi bound via `wire:model`.
- Al momento del submit, `$this->form->getState()` esegue la validazione su uno stato vuoto, restituendo errori di "campo obbligatorio" anche se l'utente ha compilato i campi.

## Logica e Filosofia Laraxot
- **DRY**: La soluzione deve essere applicata a livello di `XotBaseWidget` per garantire che tutti i widget Filament del progetto siano correttamente inizializzati.
- **KISS**: Evitare configurazioni complesse; un semplice `mount()` con `fill()` risolve il problema alla radice.
- **Solidità**: Il metodo `mount()` di `XotBaseWidget` deve caricare i dati (tramite `getFormFill()`) e popolare il form.

## Soluzione Implementata (Revisione Finale)

Dopo un'analisi approfondita su oltre 120 widget nel progetto, è emerso che definire `mount()` direttamente in `XotBaseWidget` causava errori fatali di "Signature Mismatch" (incompatibilità di firma) in molti figli che richiedono parametri specifici (es. `EditUserWidget`).

1.  **XotBaseWidget.php**: Introdotto il metodo `initXotBaseWidget()` per centralizzare la logica di inizializzazione senza rompere l'ereditarietà.
    ```php
    protected function initXotBaseWidget(): void
    {
        $this->data = $this->getFormFill();
        $this->form->fill($this->data);
    }
    ```
2.  **LoginWidget.php**: Implementato il metodo `mount()` che chiama esplicitamente l'inizializzazione.
    ```php
    public function mount(): void
    {
        $this->initXotBaseWidget();
    }
    ```
3.  **Qualità Codice**: Risolti tutti i problemi di type-hinting in `getFormFill()` per soddisfare PHPStan Level 10, garantendo che le chiavi dell'array siano sempre riconosciute come stringhe.

## Verifica Qualità
- Eseguito `phpstan` (Level 10)
- Verificata la conformità DRY + KISS
- Documentazione aggiornata nei moduli e nei temi

## Mantra Zen
"Il form deve essere preparato prima di essere servito. La mancanza di inizializzazione è il vuoto che impedisce alla sostanza di manifestarsi."
---

## login-widget-analysis

*Consolidated from: `login-widget-analysis.md`*

title: "Analisi Dettagliata di LoginWidget"
type: concept
tags: [login, widget, analysis]
created: 2026-07-14
updated: 2026-07-14
qmd: "login-widget-analysis analisi dettagliata di loginwidget"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Analisi Dettagliata di LoginWidget

**File**: `Modules/User/app/Filament/Widgets/LoginWidget.php`
**Namespace**: `Modules\User\Filament\Widgets`

## Estensione e Imports
- Estende `XotBaseWidget`.
- Import attuali:
  - `Filament\Forms\Components\TextInput`
  - `Filament\Forms\Components\Checkbox`
  - `Filament\Forms\Components\Actions\Button`
  - `Illuminate\Support\Facades\Auth`
  - `Illuminate\Validation\ValidationException`

## Metodo getFormSchema()
- Inizialmente definito come `public static function getFormSchema(): array`.
  - **Issue**: firma statica non compatibile con l’astrazione di `XotBaseWidget`, che richiede un metodo d’istanza `public function getFormSchema(): array`.
  - Motivo: PHP non permette di sovrascrivere un metodo di istanza con uno statico.
- Restituisce array associativo con componenti.
  - Chiavi stringa ok per PHPStan.
- **Mancanza**: manca il pulsante di submit per invocare `authenticate`.

## Autenticazione
- Metodo `authenticate(array $data): void`.
  - **Issue**: accetta `$data` come parametro; Filament Widgets preferiscono usare `$this->form->getState()`.
- Non chiama `session()->regenerate()` dopo login.
- Manca integrazione `WithRateLimiting` per proteggere da brute-force.
- Gestione errori via `ValidationException`, ma si può migliorare con `Notification::make()`.

## Miglioramenti Proposti
1. Correggere import di Button:
   ```php
   use Filament\Forms\Components\Actions\Button;
   ```
2. Rimuovere la parola chiave `static` e allineare la firma all’astrazione:
   ```php
   public function getFormSchema(): array { ... }
   ```
3. Aggiungere pulsante di submit nello schema:
   ```php
   Button::make('authenticate')
       ->label(__('Login'))
       ->action('authenticate')
       ->primary(),
   ```
4. Implementare `mount()` per inizializzare lo stato del form:
   ```php
   public function mount(): void {
       $this->form->fill([]);
   }
   ```
5. Usare `$this->form->getState()` dentro `authenticate()`, rimuovendo il parametro `$data`.
6. Aggiungere `session()->regenerate()` dopo `Auth::attempt()`:
   ```php
   if (Auth::attempt($credentials, $remember)) {
       session()->regenerate();
       //...
   }
   ```
7. Integrare trait `WithRateLimiting` per throttle:
   ```php
   use DanHarrin\LivewireRateLimiting\WithRateLimiting;
   class LoginWidget extends XotBaseWidget {
       use WithRateLimiting;
       //...
   }
   ```
8. Utilizzare `Notification::make()->danger()` per messaggi utente-friendly.

## Collegamenti
- [WIDGETS_STRUCTURE.md](../../widgets_structure.md) — Regole di struttura per widget Filament nel modulo User.
- [WIDGETS_STRUCTURE.md](../../widgets-structure.md) — Regole di struttura per widget Filament nel modulo User.
- [WIDGETS_STRUCTURE.md](../../widgets_structure.md) — Regole di struttura per widget Filament nel modulo User.
- [WIDGETS_STRUCTURE.md](../../widgets-structure-user.md) — Regole di struttura per widget Filament nel modulo User.
- [filament_best_practices.md](filament_best_practices.md) — Best practices per risorse Filament.
- [login-widget-conversion.md](login-widget-conversion.md) — Conversione del componente Livewire a LoginWidget.
- [WIDGETS_STRUCTURE.md](../WIDGETS_STRUCTURE.md): Regole di struttura per widget Filament nel modulo User.
- [WIDGETS_STRUCTURE.md](../widgets-structure.md): Regole di struttura per widget Filament nel modulo User.
- [WIDGETS_STRUCTURE.md](../../widgets_structure.md): Regole di struttura per widget Filament nel modulo User.
- [WIDGETS_STRUCTURE.md](../../widgets-structure-user.md): Regole di struttura per widget Filament nel modulo User.
- [filament_best_practices.md](filament_best_practices.md): Best practices per risorse Filament.
- [login-widget-conversion.md](login-widget-conversion.md): Conversione del componente Livewire a LoginWidget.

# Analisi Dettagliata di LoginWidget

**File**: `Modules/User/app/Filament/Widgets/LoginWidget.php`
**Namespace**: `Modules\User\Filament\Widgets`

## Estensione e Imports
- Estende `XotBaseWidget`.
- Import attuali:
  - `Filament\Forms\Components\TextInput`
  - `Filament\Forms\Components\Checkbox`
  - `Filament\Forms\Components\Actions\Button`
  - `Illuminate\Support\Facades\Auth`
  - `Illuminate\Validation\ValidationException`

## Metodo getFormSchema()
- Inizialmente definito come `public static function getFormSchema(): array`.
  - **Issue**: firma statica non compatibile con l’astrazione di `XotBaseWidget`, che richiede un metodo d’istanza `public function getFormSchema(): array`.
  - Motivo: PHP non permette di sovrascrivere un metodo di istanza con uno statico.
- Restituisce array associativo con componenti.
  - Chiavi stringa ok per PHPStan.
- **Mancanza**: manca il pulsante di submit per invocare `authenticate`.

## Autenticazione
- Metodo `authenticate(array $data): void`.
  - **Issue**: accetta `$data` come parametro; Filament Widgets preferiscono usare `$this->form->getState()`.
- Non chiama `session()->regenerate()` dopo login.
- Manca integrazione `WithRateLimiting` per proteggere da brute-force.
- Gestione errori via `ValidationException`, ma si può migliorare con `Notification::make()`.

## Miglioramenti Proposti
1. Correggere import di Button:
   ```php
   use Filament\Forms\Components\Actions\Button;
   ```
2. Rimuovere la parola chiave `static` e allineare la firma all’astrazione:
   ```php
   public function getFormSchema(): array { ... }
   ```
3. Aggiungere pulsante di submit nello schema:
   ```php
   Button::make('authenticate')
       ->label(__('Login'))
       ->action('authenticate')
       ->primary(),
   ```
4. Implementare `mount()` per inizializzare lo stato del form:
   ```php
   public function mount(): void {
       $this->form->fill([]);
   }
   ```
5. Usare `$this->form->getState()` dentro `authenticate()`, rimuovendo il parametro `$data`.
6. Aggiungere `session()->regenerate()` dopo `Auth::attempt()`:
   ```php
   if (Auth::attempt($credentials, $remember)) {
       session()->regenerate();
       //...
   }
   ```
7. Integrare trait `WithRateLimiting` per throttle:
   ```php
   use DanHarrin\LivewireRateLimiting\WithRateLimiting;
   class LoginWidget extends XotBaseWidget {
       use WithRateLimiting;
       //...
   }
   ```
8. Utilizzare `Notification::make()->danger()` per messaggi utente-friendly.

## Collegamenti
- [WIDGETS_STRUCTURE.md](../../widgets_structure.md) — Regole di struttura per widget Filament nel modulo User.
- [WIDGETS_STRUCTURE.md](../../widgets-structure.md) — Regole di struttura per widget Filament nel modulo User.
- [WIDGETS_STRUCTURE.md](../../widgets_structure.md) — Regole di struttura per widget Filament nel modulo User.
- [WIDGETS_STRUCTURE.md](../../widgets-structure-user.md) — Regole di struttura per widget Filament nel modulo User.
- [filament_best_practices.md](filament_best_practices.md) — Best practices per risorse Filament.
- [login-widget-conversion.md](login-widget-conversion.md) — Conversione del componente Livewire a LoginWidget.
- [WIDGETS_STRUCTURE.md](../WIDGETS_STRUCTURE.md): Regole di struttura per widget Filament nel modulo User.
- [WIDGETS_STRUCTURE.md](../widgets-structure.md): Regole di struttura per widget Filament nel modulo User.
- [WIDGETS_STRUCTURE.md](../../widgets_structure.md): Regole di struttura per widget Filament nel modulo User.
- [WIDGETS_STRUCTURE.md](../../widgets-structure-user.md): Regole di struttura per widget Filament nel modulo User.
- [filament_best_practices.md](filament_best_practices.md): Best practices per risorse Filament.
- [login-widget-conversion.md](login-widget-conversion.md): Conversione del componente Livewire a LoginWidget.

---

## login-widget-conversion

*Consolidated from: `login-widget-conversion.md`*

module: theme
topic: login-widget-conversion
canonical: ../../../Themes/docs/shared-components/login-widget-conversion.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/login-widget-conversion.md

---

## login-widget-fix

*Consolidated from: `login-widget-fix.md`*

title: "LoginWidget Form Data Binding Fix"
type: concept
tags: [login, widget, fix]
created: 2026-07-14
updated: 2026-07-14
qmd: "login-widget-fix loginwidget form data binding fix"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# LoginWidget Form Data Binding Fix

## Problema

Il `LoginWidget` mostrava un errore indicando che i campi email e password "non sono popolati" anche quando l'utente inseriva i valori nei campi del form.

## Causa Root

Il problema era dovuto alla mancanza del metodo `mount()` nel widget. Quando si usa `statePath('data')` in Filament, il form deve essere inizializzato correttamente durante il mount del componente Livewire.

### Analisi Tecnica

1. **XotBaseWidget** configura il form con `statePath('data')` nel metodo `schema()`
2. I dati del form vengono memorizzati in `$this->data` (proprietà pubblica del widget)
3. Senza `mount()` che chiama `$this->form->fill([])`, il form non viene inizializzato correttamente
4. Quando l'utente compila i campi, i valori non vengono salvati correttamente in `$this->data`
5. `getState()` restituisce valori vuoti o non validati correttamente

## Soluzione Implementata

### 1. Pattern `mount()` in XotBaseWidget

`XotBaseWidget` fornisce il metodo protetto `initXotBaseWidget()` che inizializza correttamente il form. Le classi figlie devono sovrascrivere `mount()` e chiamare questo metodo:

```php
// In XotBaseWidget (metodo protetto)
protected function initXotBaseWidget(): void
{
    $this->data = $this->getFormFill();
    $this->form->fill($this->data);
}

// In LoginWidget (deve sovrascrivere mount())
public function mount(): void
{
    $this->initXotBaseWidget();
}
```

**NOTA IMPORTANTE**: I widget che estendono `XotBaseWidget` **devono** sovrascrivere `mount()` e chiamare `$this->initXotBaseWidget()` per inizializzare correttamente il form. Se serve logica aggiuntiva (es. logging), aggiungere il codice dopo la chiamata a `initXotBaseWidget()`.

Per `LoginWidget`, che non ha un modello associato (`getFormModel()` restituisce `null`), `getFormFill()` restituisce un array vuoto `[]`, che è il comportamento corretto per un form vuoto.

### 2. Schema con chiavi stringa e NO label/placeholder

Corretto lo schema per usare array associativo con chiavi stringa (conforme alle regole Filament). **MAI usare `->label()`, `->placeholder()` o `->helperText()`**: il LangServiceProvider risolve automaticamente da `user::login_widget.fields.*` (file `lang/it/login_widget.php`).

```php
#[\Override]
public function getFormSchema(): array
{
    return [
        'email' => TextInput::make('email')->email()->required(),
        'password' => TextInput::make('password')->password()->required(),
        'remember' => Checkbox::make('remember'),
    ];
}
```

### 3. Gestione validazione e errori

Aggiunta gestione corretta delle eccezioni di validazione e conversione esplicita del tipo `bool` per `$remember`:

```php
public function login(): void
{
    try {
        $data = $this->form->getState();

        $credentials = [
            'email' => is_string($data['email'] ?? null) ? $data['email'] : '',
            'password' => is_string($data['password'] ?? null) ? $data['password'] : '',
        ];

        $remember = isset($data['remember']) && $data['remember'] === true;

        if (Auth::attempt($credentials, $remember)) {
            session()->regenerate();
            redirect()->intended('/');
        }

        $this->addError('data.email', __('auth.failed'));
    } catch (ValidationException $e) {
        // La validazione Filament gestisce automaticamente gli errori
        throw $e;
    }
}
```

## Pattern da Seguire

Tutti i widget Filament che estendono `XotBaseWidget` e usano `statePath('data')` devono:

1. **Sovrascrivere `mount()`** e chiamare `initXotBaseWidget()`:
   - `XotBaseWidget` fornisce il metodo protetto `initXotBaseWidget()` che inizializza il form
   - Le classi figlie devono sovrascrivere `mount()` e chiamare `$this->initXotBaseWidget()`
   - Se serve logica aggiuntiva (es. logging), aggiungerla dopo la chiamata:

   ```php
   // ✅ CORRETTO: Pattern base per LoginWidget
   public function mount(): void
   {
       $this->initXotBaseWidget();
   }

   // ✅ CORRETTO: Logica aggiuntiva in RegisterWidget
   public function mount(): void
   {
       $this->initXotBaseWidget();
       Log::debug('Registration form initialized', [
           'ip' => request()->ip(),
       ]);
   }

   // ❌ ERRATO: Non chiamare initXotBaseWidget()
   public function mount(): void
   {
       // Manca l'inizializzazione del form!
   }
   ```

2. **Usare chiavi stringa nello schema** (array associativo):
   ```php
   #[\Override]
   public function getFormSchema(): array
   {
       return [
           'email' => TextInput::make('email')->email()->required(),
           'password' => TextInput::make('password')->password()->required(),
       ];
   }
   ```

3. **Gestire correttamente i tipi** quando si accede ai dati:
   ```php
   $data = $this->form->getState();
   $boolValue = isset($data['field']) && true === $data['field'];
   ```

4. **Non ridichiarare proprietà già presenti in XotBaseWidget**:
   - `public ?array $data = []` è già definito in `XotBaseWidget`
   - Non ridichiarare per evitare warning e duplicazione

## Riferimenti

- [XotBaseWidget Documentation](../../../../Xot/docs/README.md)
- [Filament Form State Management](https://filamentphp.com/docs/3.x/forms/fields#state-management)
- [RegisterWidget Implementation](../../../app/Filament/Widgets/Auth/RegisterWidget.php) - Esempio corretto
- [XotBaseWidget Documentation](../../../../Xot/docs/README.md)
- [Filament Form State Management](https://filamentphp.com/docs/3.x/forms/fields#state-management)
- [RegisterWidget Implementation](../../../app/Filament/Widgets/Auth/RegisterWidget.php) - Esempio corretto

## File Modificati

- `Modules/User/app/Filament/Widgets/Auth/LoginWidget.php`

## Checklist Fix

- [x] Verificato che `XotBaseWidget` gestisce già `mount()` (non serve sovrascriverlo)
- [x] Rimosso `mount()` duplicato da `LoginWidget` (principio DRY)
- [x] Rimosso `public ?array $data = []` duplicato (già in XotBaseWidget)
- [x] Schema con chiavi stringa (array associativo)
- [x] Gestione corretta tipo `bool` per `$remember`
- [x] Gestione eccezioni di validazione
- [x] PHPStan Level 9 compliance
- [x] PHPMD compliance
- [x] Documentazione aggiornata

---


---

## login-widget-livewire-binding-fix

*Consolidated from: `login-widget-livewire-binding-fix.md`*

module: theme
topic: login-widget-livewire-binding-fix
canonical: ../../../Themes/docs/shared-components/login-widget-livewire-binding-fix.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/login-widget-livewire-binding-fix.md

---

## login-widget-livewire-binding

*Consolidated from: `login-widget-livewire-binding.md`*

title: "LoginWidget Livewire wire:model Binding Fix"
type: concept
tags: [login, widget, livewire, binding]
created: 2026-07-14
updated: 2026-07-14
qmd: "login-widget-livewire-binding loginwidget livewire wire:model binding fix"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# LoginWidget Livewire wire:model Binding Fix

**Errore**: `[wire:model="email"] property does not exist on component`

## Problema

Il `LoginWidget` mostra errori nella console del browser:
```
Livewire: [wire:model="email"] property does not exist on component
Livewire: [wire:model="password"] property does not exist on component  
Livewire: [wire:model="remember"] property does not exist on component
```

## Causa Root

Quando si usa `statePath('data')` in Filament, i componenti del form generano `wire:model="data.email"`, ma Livewire cerca le proprietà `email`, `password`, `remember` direttamente sul componente invece di cercarle in `$this->data`.

Il problema si verifica quando:
1. `getFormFill()` restituisce `[]` per widget senza modello
2. `$this->data` rimane `[]` (array vuoto)
3. Livewire non trova le chiavi `email`, `password`, `remember` in `$this->data`
4. I componenti Filament generano `wire:model` ma Livewire non può bindare correttamente

## Soluzione Implementata

### Fix in `XotBaseWidget::initXotBaseWidget()`

Aggiornato il metodo per inizializzare `$this->data` con le chiavi dello schema quando il widget non ha modello:

```php
protected function initXotBaseWidget(): void
{
    $fillData = $this->getFormFill();
    
    // Se getFormFill() restituisce array vuoto (widget senza modello),
    // inizializza $this->data con le chiavi dello schema per garantire
    // che Livewire possa correttamente bindare i campi con statePath('data')
    if (empty($fillData)) {
        $schemaKeys = array_keys($this->getFormSchema());
        $fillData = array_fill_keys($schemaKeys, null);
    }
    
    $this->data = $fillData;
    $this->form->fill($this->data);
}
```

### LoginWidget Pattern Corretto

```php
class LoginWidget extends XotBaseWidget
{
    /**
     * Inizializza il widget quando viene montato.
     * Chiama initXotBaseWidget() per inizializzare correttamente il form con statePath('data').
     */
    public function mount(): void
    {
        $this->initXotBaseWidget();
    }

    #[\Override]
    public function getFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->autofocus(),
            'password' => TextInput::make('password')
                ->password()
                ->required(),
            'remember' => Checkbox::make('remember'),
        ];
    }
}
```

## Risultato

Dopo il fix:
- `$this->data` viene inizializzato come `['email' => null, 'password' => null, 'remember' => null]`
- I componenti Filament generano correttamente `wire:model="data.email"`, `wire:model="data.password"`, ecc.
- Livewire può correttamente bindare i campi perché le chiavi esistono in `$this->data`
- Il form funziona correttamente senza errori nella console

## Pattern per Altri Widget Senza Modello

Tutti i widget senza modello devono:
1. Implementare `mount()` e chiamare `initXotBaseWidget()`
2. Definire `getFormSchema()` con chiavi stringa
3. Lasciare che `initXotBaseWidget()` gestisca l'inizializzazione automatica

## Riferimenti

- [Xot Widgets Initialization](../../xot/docs/widgets-initialization.md)
- [Filament Class Extension Rules](../../xot/docs/filament-class-extension-rules.md)
- [Login Widget Fix](../../login-widget-fix.md)
- [Login Widget Fix](../../login-widget-fix.md)

---

## login-widget-translation

*Consolidated from: `login-widget-translation.md`*

module: theme
topic: login-widget-translation
canonical: ../../../Themes/docs/shared-components/login-widget-translation-audit.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/login-widget-translation-audit.md

---

## login-widget

*Consolidated from: `login-widget.md`*

module: theme
topic: login-widget
canonical: ../../../Themes/docs/shared-components/login-widget-analysis.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/login-widget-analysis.md

---

## login_widget_analysis

*Consolidated from: `login_widget_analysis.md`*


**File**: `Modules/User/app/Filament/Widgets/LoginWidget.php`  
**Namespace**: `Modules\User\Filament\Widgets`

## Estensione e Imports
- Estende `XotBaseWidget`.
- Import attuali:
  - `Filament\Forms\Components\TextInput`
  - `Filament\Forms\Components\Checkbox`
  - `Filament\Forms\Components\Actions\Button`
  - `Illuminate\Support\Facades\Auth`
  - `Illuminate\Validation\ValidationException`

## Metodo getFormSchema()
- Inizialmente definito come `public static function getFormSchema(): array`.
  - **Issue**: firma statica non compatibile con l’astrazione di `XotBaseWidget`, che richiede un metodo d’istanza `public function getFormSchema(): array`.
  - Motivo: PHP non permette di sovrascrivere un metodo di istanza con uno statico.
- Restituisce array associativo con componenti.
  - Chiavi stringa ok per PHPStan.
- **Mancanza**: manca il pulsante di submit per invocare `authenticate`.

## Autenticazione
- Metodo `authenticate(array $data): void`.
  - **Issue**: accetta `$data` come parametro; Filament Widgets preferiscono usare `$this->form->getState()`.
- Non chiama `session()->regenerate()` dopo login.
- Manca integrazione `WithRateLimiting` per proteggere da brute-force.
- Gestione errori via `ValidationException`, ma si può migliorare con `Notification::make()`.

## Miglioramenti Proposti
1. Correggere import di Button:
   ```php
   use Filament\Forms\Components\Actions\Button;
   ```
2. Rimuovere la parola chiave `static` e allineare la firma all’astrazione:
   ```php
   public function getFormSchema(): array { ... }
   ```
3. Aggiungere pulsante di submit nello schema:
   ```php
   Button::make('authenticate')
       ->label(__('Login'))
       ->action('authenticate')
       ->primary(),
   ```
4. Implementare `mount()` per inizializzare lo stato del form:
   ```php
   public function mount(): void {
       $this->form->fill([]);
   }
   ```
5. Usare `$this->form->getState()` dentro `authenticate()`, rimuovendo il parametro `$data`.
6. Aggiungere `session()->regenerate()` dopo `Auth::attempt()`:
   ```php
   if (Auth::attempt($credentials, $remember)) {
       session()->regenerate();
       //...
   }
   ```
7. Integrare trait `WithRateLimiting` per throttle:
   ```php
   use DanHarrin\LivewireRateLimiting\WithRateLimiting;
   class LoginWidget extends XotBaseWidget {
       use WithRateLimiting;
       //...
   }
   ```
8. Utilizzare `Notification::make()->danger()` per messaggi utente-friendly.

## Collegamenti
- [WIDGETS_STRUCTURE.md](../../widgets_structure.md) — Regole di struttura per widget Filament nel modulo User.
- [WIDGETS_STRUCTURE.md](../../widgets_structure.md) — Regole di struttura per widget Filament nel modulo User.
- [filament_best_practices.md](filament_best_practices.md) — Best practices per risorse Filament.
- [login-widget-conversion.md](login-widget-conversion.md) — Conversione del componente Livewire a LoginWidget.
- [WIDGETS_STRUCTURE.md](../WIDGETS_STRUCTURE.md): Regole di struttura per widget Filament nel modulo User.
- [WIDGETS_STRUCTURE.md](../../widgets_structure.md): Regole di struttura per widget Filament nel modulo User.
- [filament_best_practices.md](filament_best_practices.md): Best practices per risorse Filament.
- [login-widget-conversion.md](login-widget-conversion.md): Conversione del componente Livewire a LoginWidget.


---

## login_widget_conversion

*Consolidated from: `login_widget_conversion.md`*


## Analisi del componente Livewire

Il componente `Login` (Livewire) definito in `Modules/User/Http/Livewire/Auth/Login.php.to_widget`:
- Usa `InteractsWithForms` per schema form e validazione.
- Definisce proprietà `$email`, `$password`, `$remember` e regole di validazione.
- Monta il form in `mount()` con `makeForm()` e `getFormSchema()`.
- `authenticate()` usa `Auth::attempt()`, `session()->regenerate()` e `addError()`.
- `render()` restituisce la view `pub_theme::livewire.auth.login` con layout custom.

## Proposta di LoginWidget

```php
namespace Modules\User\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginWidget extends XotBaseWidget
{
    protected static string $view = 'user::livewire.auth.login';

    public array $data = [
        'email' => '',
        'password' => '',
        'remember' => false,
    ];

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('data.email')
                ->label('Email')
                ->email()
                ->required()
                ->placeholder('Inserisci la tua email'),

            TextInput::make('data.password')
                ->label('Password')
                ->password()
                ->required()
                ->placeholder('Inserisci la tua password'),

            Checkbox::make('data.remember')
                ->label('Ricordami'),
        ];
    }

    public function mount(): void
    {
        $this->form->fill($this->data);
    }

    public function submit(): RedirectResponse
    {
        $state = $this->form->getState()['data'];
        $remember = $state['remember'] ?? false;

        if (Auth::attempt(
            ['email' => $state['email'], 'password' => $state['password']],
            $remember
        )) {
            session()->regenerate();

            return redirect()->intended();
        }

        $this->addError('data.email', __('Le credenziali non sono corrette.'));
    }
}
```

## Motivazioni e Trade-off

- **Riuso**: schema e logica di validazione già definiti in Livewire sono mappati in `getFormSchema`, `mount` e `submit`.
- **Coerenza**: estensione `XotBaseWidget` garantisce uniformità con altri widget Filament.
- **Rate Limiting**: è possibile aggiungere `WithRateLimiting` per throttling.

**Vantaggi**:
- Unico widget integrato con l'admin Filament.
- Logica custom concentrata nel widget, stesse regole di validazione.

**Svantaggi**:
- Ciclo di vita differente: Livewire puro vs Filament Widgets.
- Alcune funzionalità (es. `render()`) non sono necessarie nel widget.

## Collegamenti
- [WIDGETS_STRUCTURE.md](../../widgets_structure.md) — Regole di struttura per i widget Filament nel modulo User.
- [filament_best_practices.md](filament_best_practices.md) — Best practices per risorse e widget Filament.
- [login-improvements.md](../../../../../Themes/TwentyOne/docs/login-improvements.md) — Analisi e miglioramenti della pagina di login nel tema TwentyOne.
- [WIDGETS_STRUCTURE.md](../../widgets_structure.md) — Regole di struttura per i widget Filament nel modulo User.
- [filament_best_practices.md](filament_best_practices.md) — Best practices per risorse e widget Filament.
- [login-improvements.md](../../../../../Themes/TwentyOne/docs/login-improvements.md) — Analisi e miglioramenti della pagina di login nel tema TwentyOne.
- [WIDGETS_STRUCTURE.md](../WIDGETS_STRUCTURE.md): Regole di struttura per i widget Filament nel modulo User.
- [filament_best_practices.md](filament_best_practices.md): Best practices per risorse e widget Filament.
- [login-improvements.md](../../../Themes/TwentyOne/docs/login-improvements.md): Analisi e miglioramenti della pagina di login nel tema TwentyOne.
- [WIDGETS_STRUCTURE.md](../../widgets_structure.md): Regole di struttura per i widget Filament nel modulo User.
- [filament_best_practices.md](filament_best_practices.md): Best practices per risorse e widget Filament.
- [login-improvements.md](../../../../../Themes/TwentyOne/docs/login-improvements.md): Analisi e miglioramenti della pagina di login nel tema TwentyOne.


---

## loginwidget-error-analysis

*Consolidated from: `loginwidget-error-analysis.md`*

title: "Analisi Errore LoginWidget: Problema Logico e Soluzione"
type: concept
tags: [loginwidget, error, analysis]
created: 2026-07-14
updated: 2026-07-14
qmd: "loginwidget-error-analysis analisi errore loginwidget: problema logico e soluzione"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Analisi Errore LoginWidget: Problema Logico e Soluzione

## Problema Identificato

Il `LoginWidget` non mostrava errori di credenziali errate a causa di un **errore logico critico** nel metodo `login()` (poi rinominato `save()`).

## Analisi del Problema

### ❌ Codice Problematico (PRIMA)
```php
public function login(): void
{
    $data = $this->form->getState();

    if (Auth::attempt($data)) {
        session()->regenerate();
        redirect()->intended(route('filament.admin.pages.dashboard'));
    }

    $this->addError('email', __('auth.failed')); // ← SEMPRE ESEGUITO!
}
```

**Problema**: La riga `$this->addError()` veniva **sempre eseguita**, anche quando l'autenticazione aveva successo, perché non c'era un `return` dopo il blocco di successo.

### ✅ Codice Corretto (DOPO)
```php
public function save(): void
{
    $data = $this->form->getState();

    if (Auth::attempt($data)) {
        session()->regenerate();
        redirect()->intended(route('filament.admin.pages.dashboard'));
        return; // ← AGGIUNTO: Evita che addError venga sempre eseguito
    }

    $this->addError('email', __('auth.failed'));
}
```

## Analisi Approfondita di XotBaseWidget

### ✅ Cosa è GIÀ IMPLEMENTATO in XotBaseWidget

Dopo studio approfondito, XotBaseWidget ha già tutti i metodi necessari:

1. **Proprietà `$data`** - PRESENTE:
   ```php
   public ?array $data = [];
   ```

2. **Metodo `form()` con `statePath('data')`** - PRESENTE:
   ```php
   public function form(FilamentForm $form): FilamentForm
   {
       $form = $form->schema($this->getFormSchema());
       $form->statePath('data');
       // ... gestione del modello e dati iniziali
       return $form;
   }
   ```

3. **Metodo `save()`** - PRESENTE (da implementare nelle classi figlie):
   ```php
   public function save(): void
   {
       // Implementare nelle classi figlie
   }
   ```

### ⚠️ Errore di Analisi Iniziale

**ERRORE COMMESSO**: Aver assunto che mancassero metodi già implementati in XotBaseWidget senza aver prima studiato approfonditamente la classe base.

**LEZIONE**: Sempre studiare completamente le classi base prima di fare assunzioni sui metodi mancanti.

## Problema Secondario: Disallineamento Metodo/View

### Problema
La view blade chiamava `save` ma il widget aveva il metodo `login`:

**View blade**:
```blade
<form wire:submit.prevent="save" class="space-y-4">
```

**Widget (prima)**:
```php
public function login(): void // ← Nome sbagliato
```

### Soluzione
Rinominato il metodo seguendo la convenzione di XotBaseWidget:

```php
public function save(): void // ← Nome corretto
```

## Verifica Funzionamento Errori

La view blade gestisce correttamente la visualizzazione degli errori:

```blade
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative text-sm">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif
```

## Struttura Completa del LoginWidget Corretto

```php
<?php
declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\ComponentContainer;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class LoginWidget extends XotBaseWidget
{
    protected static string $view = 'pub_theme::filament.widgets.auth.login';

    public function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('email')
                ->email()
                ->required(),

            Forms\Components\TextInput::make('password')
                ->password()
                ->required(),

            Forms\Components\Checkbox::make('remember'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        if (Auth::attempt($data)) {
            session()->regenerate();
            redirect()->intended(route('filament.admin.pages.dashboard'));
            return; // ← CRITICO: Evita esecuzione di addError
        }

        $this->addError('email', __('auth.failed'));
    }
}
```

## Best Practices Apprese

1. **Studiare sempre le classi base** prima di assumere metodi mancanti
2. **Allineare i nomi dei metodi** con le convenzioni della classe base
3. **Verificare il flusso logico** per evitare esecuzione sempre di codice condizionale
4. **Testare sia i casi di successo che di errore** nell'autenticazione

## Errori da Evitare

1. ❌ Non studiare approfonditamente XotBaseWidget prima delle modifiche
2. ❌ Assumere che mancano metodi senza verifica
3. ❌ Non verificare l'allineamento tra view e metodi del widget
4. ❌ Dimenticare il `return` nei blocchi di successo prima di codice di errore

## Riferimenti

- [XotBaseWidget](Modules/Xot/app/Filament/Widgets/XotBaseWidget.php)
- [Documentazione Widget Structure](modules/user/widgets-structure.md)
- [Best Practices Widget Filament](modules/user/best-practices/filament-widgets.md) 
- [Documentazione Widget Structure](../../widgets-structure-user.md)
- [Best Practices Widget Filament](../../best-practices/filament-widgets.md) 
---

## loginwidget

*Consolidated from: `loginwidget.md`*

module: theme
topic: loginwidget
canonical: ../../../Themes/docs/shared-components/loginwidget-error-analysis.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/loginwidget-error-analysis.md

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04