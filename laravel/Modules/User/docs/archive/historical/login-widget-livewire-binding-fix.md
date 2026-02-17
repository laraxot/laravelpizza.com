# LoginWidget Livewire wire:model Binding Fix

**Data**: 2025-12-18  
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

- [Xot Widgets Initialization](../../Xot/docs/widgets-initialization.md)
- [Filament Class Extension Rules](../../Xot/docs/filament-class-extension-rules.md)
- [Login Widget Fix](./login-widget-fix.md)
