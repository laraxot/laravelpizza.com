# Componenti Form

## Introduzione

I componenti form forniscono elementi di input e validazione per la creazione di form complessi e interattivi.

## Componenti Disponibili

### InlineDatePicker

Un componente avanzato per la selezione di date che mostra un calendario inline con la possibilità di abilitare/disabilitare date specifiche.

```php
use Modules\UI\Filament\Forms\Components\InlineDatePicker;

InlineDatePicker::make('appointment_date')
    ->enabledDates(['2025-06-05', '2025-06-21', '2025-06-25'])
    ->calendarConfig([
        'locale' => 'it',
        'firstDayOfWeek' => 1, // Lunedì come primo giorno della settimana
        'numberOfMonths' => 1, // Numero di mesi da mostrare
    ])
    ->required();
```

#### Caratteristiche Principali

- **Selezione Controllata**: Solo le date specificate in `enabledDates()` sono selezionabili
- **Interfaccia Intuitiva**: Navigazione tra mesi con frecce e visualizzazione chiara
- **Accessibilità Completa**: Supporto per screen reader e navigazione da tastiera
- **Design Responsivo**: Si adatta perfettamente a qualsiasi dispositivo
- **Personalizzabile**: Aspetto e comportamento completamente personalizzabili
- **Internazionalizzazione**: Supporto integrato per diverse lingue e formati di data
- **Performance Ottimizzate**: Caricamento lazy dei dati e rendering efficiente

#### Metodi Disponibili

| Metodo | Parametri | Descrizione |
|--------|-----------|-------------|
| `enabledDates` | `array|Closure $dates` | Imposta le date selezionabili (formato Y-m-d) |
| `calendarConfig` | `array $config` | Configura i parametri del calendario |
| `getEnabledDates` | - | Restituisce l'array delle date abilitate |
| `isDateEnabled` | `string $date` | Verifica se una data è abilitata |
| `generateMonthGrid` | `?int $year`, `?int $month` | Genera la griglia del mese per visualizzazione |

#### Configurazione Avanzata

```php
InlineDatePicker::make('appointment_date')
    ->enabledDates(function () {
        // Logica dinamica per generare le date abilitate
        return [
            now()->format('Y-m-d'),
            now()->addDays(2)->format('Y-m-d'),
            now()->addWeek()->format('Y-m-d'),
        ];
    })
    ->calendarConfig([
        'locale' => app()->getLocale(),
        'firstDayOfWeek' => 1, // Lunedì
        'numberOfMonths' => 2,  // Mostra 2 mesi affiancati
        'inline' => true,       // Mostra sempre il calendario
    ]);
```

#### Personalizzazione dello Stile

Lo stile del componente può essere personalizzato sovrascrivendo le classi CSS nel file di vista:
`resources/views/vendor/filament/forms/components/inline-date-picker.blade.php`

#### Gestione degli Eventi

```php
InlineDatePicker::make('appointment_date')
    ->enabledDates($enabledDates)
    ->live()
    ->afterStateUpdated(function (Set $set, $state) {
        // Azioni da eseguire quando viene selezionata una data
        $set('related_field', $state);
    });
```

#### Accesso ai Dati

```php
// Ottenere le date abilitate
$enabledDates = $datePicker->getEnabledDates();

// Verificare se una data è abilitata
$isEnabled = $datePicker->isDateEnabled('2025-06-15');

// Generare la griglia di un mese specifico
$monthGrid = $datePicker->generateMonthGrid(2025, 6);
```

#### Best Practice

1. **Performance**: Per un gran numero di date, utilizzare una closure per generare le date abilitate in modo lazy
2. **Accessibilità**: Assicurarsi che il componente sia accessibile da tastiera
3. **Localizzazione**: Configurare correttamente la lingua e il formato della data
4. **Validazione**: Aggiungere sempre la validazione appropriata per il campo data
5. **Stati di Caricamento**: Implementare indicatori di caricamento per operazioni asincrone

#### Esempio Completo

```php
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Modules\UI\Filament\Forms\Components\InlineDatePicker;

public function form(Form $form): Form
{
    return $form->schema([
        Section::make('Prenotazione Appuntamento')
            ->schema([
                InlineDatePicker::make('appointment_date')
                    ->label('Seleziona una data')
                    ->enabledDates(function () {
                        // Esempio: abilita solo i prossimi 30 giorni lavorativi
                        $dates = [];
                        $date = now();
                        $count = 0;

                        while ($count < 30) {
                            if (!$date->isWeekend()) {
                                $dates[] = $date->format('Y-m-d');
                                $count++;
                            }
                            $date->addDay();
                        }

                        return $dates;
                    })
                    ->calendarConfig([
                        'locale' => 'it',
                        'firstDayOfWeek' => 1,
                        'numberOfMonths' => 2,
                    ])
                    ->required()
                    ->columnSpanFull(),
            ])
    ]);
}
```

### Input
```blade
<x-ui::input
    name="email"
    type="email"
    label="Email"
    placeholder="Inserisci la tua email"
    :required="true"
    :disabled="false"
    :readonly="false"
    :autofocus="false"
    :autocomplete="true"
    :error="$errors->first('email')"
/>
```

### Select
```blade
<x-ui::select
    name="role"
    label="Ruolo"
    :options="[
        'admin' => 'Amministratore',
        'user' => 'Utente',
        'guest' => 'Ospite'
    ]"
    :required="true"
    :multiple="false"
    :searchable="true"
    :clearable="true"
    :error="$errors->first('role')"
/>
```

### Checkbox
```blade
<x-ui::checkbox
    name="terms"
    label="Accetto i termini e condizioni"
    :required="true"
    :checked="false"
    :disabled="false"
    :error="$errors->first('terms')"
/>
```

### Radio
```blade
<x-ui::radio
    name="gender"
    label="Genere"
    :options="[
        'male' => 'Maschio',
        'female' => 'Femmina',
        'other' => 'Altro'
    ]"
    :required="true"
    :error="$errors->first('gender')"
/>
```

### Textarea
```blade
<x-ui::textarea
    name="message"
    label="Messaggio"
    placeholder="Inserisci il tuo messaggio"
    :rows="4"
    :required="true"
    :disabled="false"
    :readonly="false"
    :error="$errors->first('message')"
/>
```

## Validazione

### Regole
- Required
- Min/Max length
- Pattern
- Custom rules

### Messaggi
- Personalizzazione messaggi errore
- Localizzazione
- Tooltip di aiuto

## Integrazione

### Livewire
```php
use Livewire\Component;

class UserForm extends Component
{
    public $name;
    public $email;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
    ];

    public function save()
    {
        $this->validate();
        // Salva i dati
    }
}
```

### JavaScript
```javascript
// Validazione lato client
const form = document.querySelector('form');
form.addEventListener('submit', (e) => {
    if (!form.checkValidity()) {
        e.preventDefault();
        // Mostra errori
    }
});
```

## Best Practices

### Utilizzo
- Validazione lato server e client
- Feedback immediato
- Accessibilità
- UX ottimizzata

### Performance
- Lazy loading
- Debounce input
- Cache validazione
- Ottimizzazione risorse

## Collegamenti
- [Componenti Base](./base-components.md)
- [Componenti Table](./table-components.md)
- [Componenti Chart](./chart-components.md)
- [Componenti Layout](./layout-components.md)
- [Documentazione Frontend](../Cms/docs/frontend-architecture.md)
## Collegamenti tra versioni di form-components.md
* [form-components.md](../../../UI/docs/form-components.md)
* [form-components.md](../../../UI/docs/roadmap/form-components.md)
