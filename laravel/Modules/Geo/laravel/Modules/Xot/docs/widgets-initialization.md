# Inizializzazione dei Widget XotBaseWidget

## ⚠️ Problema delle Signature (Incompatibilità)

In Filament v4 (Livewire 3), i widget che estendono `XotBaseWidget` (che a sua volta estende `Filament\Widgets\Widget`) spesso presentano firme (signature) del metodo `mount()` differenti:

- `EditUserWidget::mount(string $type, ?string $userId = null)`
- `TimeClockWidget::mount()` (senza parametri)
- Altri widget potrebbero avere parametri diversi passati da layout o pagine.

Se `XotBaseWidget` definisce un metodo `mount()`, tutti i figli devono avere una firma compatibile. Dato che il progetto ha oltre 120 widget, è impossibile e rischioso uniformarli tutti o usare firme variadiche che potrebbero nascondere errori.

## 🚀 Soluzione: Inizializzazione nel Metodo `form()`

Per mantenere il principio **DRY** (Don't Repeat Yourself) e garantire che il form sia correttamente inizializzato (soprattutto con `statePath('data')`), l'inizializzazione di `$this->data` avviene direttamente nel metodo `form()` invece che in `mount()`.

### 1. Definizione in `XotBaseWidget::form()`

L'inizializzazione di `$this->data` avviene automaticamente nel metodo `form()`:

```php
public function form(Schema $schema): Schema
{
    $schema = $schema->components($this->getFormSchema());
    $schema->statePath('data');
    $data = $this->getFormFill();

    // Per widget senza modello, inizializza $this->data con le chiavi dello schema
    // per garantire che Livewire possa correttamente bindare i campi con statePath('data')
    if (empty($data)) {
        $schemaKeys = array_keys($this->getFormSchema());
        $data = array_fill_keys($schemaKeys, null);
    }

    $this->data = $data;

    $model = $this->getFormModel();
    if ($model !== null) {
        // Configurazione modello...
    }

    return $schema;
}
```

### 2. Pattern per Widget senza Modello

I widget senza modello (come `LoginWidget`) **NON devono** implementare `mount()`:

```php
// ✅ CORRETTO: Nessun mount() necessario
class LoginWidget extends XotBaseWidget
{
    #[\Override]
    public function getFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')->email()->required(),
            'password' => TextInput::make('password')->password()->required(),
            'remember' => Checkbox::make('remember'),
        ];
    }

    // mount() NON necessario - l'inizializzazione avviene in form()
}
```

### 3. Pattern per Widget con Modello o Logica Aggiuntiva

I widget che hanno bisogno di logica aggiuntiva nel `mount()` (es. caricare dati dal database) possono implementare `mount()`:

```php
// ✅ CORRETTO: mount() con logica aggiuntiva
class EditUserWidget extends XotBaseWidget
{
    public function mount(string $type, ?string $userId = null): void
    {
        // Logica specifica (carica record, setta proprietà, ecc.)
        $this->type = $type;
        $this->record = $this->getFormModel($userId);

        // NON serve chiamare initXotBaseWidget() - form() gestisce tutto
    }
}
```

## 🔒 Perché è importante?

Senza l'inizializzazione di `$this->data` con le chiavi dello schema:
1.  **Livewire non trova le proprietà**: Quando si usa `statePath('data')`, Livewire cerca le chiavi in `$this->data`
2.  **Errore "property does not exist"**: Se `$this->data = []`, Livewire non può bindare `wire:model="data.email"` perché la chiave `email` non esiste
3.  **Form non funziona**: I campi non vengono popolati o validati correttamente

Questo problema è stato diagnosticato e risolto durante il debug del `LoginWidget`, che mostrava errori:
```
Livewire: [wire:model="email"] property does not exist on component
```

## 🧪 Casi Particolari

### LoginWidget (Widget senza Modello)

**NON** implementa `mount()` - l'inizializzazione avviene automaticamente in `form()`:

```php
class LoginWidget extends XotBaseWidget
{
    #[\Override]
    public function getFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')->email()->required(),
            'password' => TextInput::make('password')->password()->required(),
            'remember' => Checkbox::make('remember'),
        ];
    }

    // mount() NON necessario
}
```

### EditUserWidget (Widget con Modello e Parametri)

Implementa `mount()` per gestire parametri, ma **NON** deve inizializzare il form manualmente:

```php
class EditUserWidget extends XotBaseWidget
{
    public function mount(string $type, ?string $userId = null): void
    {
        // Solo logica specifica - NON inizializzare $this->data qui
        $this->type = $type;
        $this->record = $this->getFormModel($userId);

        // form() gestirà automaticamente l'inizializzazione di $this->data
    }
}
```

### EnvWidget (Widget con Dati Custom)

Widget che necessita di caricare dati da fonti esterne nel `mount()`:

```php
class EnvWidget extends XotBaseWidget
{
    public function mount(): void
    {
        // Carica dati da EnvData
        $data = EnvData::make()->toArray();
        $this->data = $data;
        $this->form->fill($this->data);
    }
}
```

**NOTA**: Questo pattern è valido solo se il widget NON estende `XotBaseWidget` o se ha esigenze speciali. Per la maggior parte dei widget, l'inizializzazione automatica in `form()` è sufficiente.
