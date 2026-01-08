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

### 2. Schema con chiavi stringa

Corretto lo schema per usare array associativo con chiavi stringa (conforme alle regole Filament):

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

- [XotBaseWidget Documentation](../../Xot/docs/README.md)
- [Filament Form State Management](https://filamentphp.com/docs/3.x/forms/fields#state-management)
- [RegisterWidget Implementation](../app/Filament/Widgets/Auth/RegisterWidget.php) - Esempio corretto

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

*Ultimo aggiornamento: Dicembre 2024*
