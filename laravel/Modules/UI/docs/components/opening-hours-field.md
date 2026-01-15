# OpeningHoursField Component

## Introduzione

Il componente `OpeningHoursField` è un campo custom Filament per la gestione degli orari di apertura settimanali. È progettato per essere utilizzato in forms dove è necessario configurare orari di disponibilità per giorni specifici della settimana.

## ⚠️ ERRORE CRITICO RISOLTO

**Problema identificato**: Il componente estendeva `ViewComponent` ma non aveva la proprietà `$view` definita correttamente.

### Errore Originale
```php
class OpeningHoursField extends Field
{
    // protected string $view = 'filament-forms::components.field'; // COMMENTATO!
}
```

### Conseguenze dell'Errore
1. **Runtime Error**: "Class [OpeningHoursField] does not have a [$view] property defined"
2. **Rendering Fallito**: Il componente non poteva essere renderizzato
3. **Logica Perduta**: La struttura complessa per gli orari non veniva visualizzata

### Correzione Implementata
```php
class OpeningHoursField extends Field
{
    /**
     * Vista Blade per il rendering del componente.
     */
    protected string $view = 'ui::filament.forms.components.opening-hours-field';
}
```

**File Vista Creato**: `laravel/Modules/UI/resources/views/filament/forms/components/opening-hours-field.blade.php`

**Traduzioni Aggiunte**: `laravel/Modules/UI/lang/it/opening_hours.php`

## Miglioramento Layout (Dicembre 2024)

### Struttura a 3 Colonne
Il componente è stato migliorato per utilizzare un layout a griglia a 3 colonne più chiaro e organizzato:

| Giorno | Mattina | Pomeriggio |
|--------|---------|------------|
| Lunedì | 08:00-12:30 | 15:00-19:00 |
| Martedì | 08:00-12:30 | 15:00-19:00 |
| ... | ... | ... |

### Vantaggi del Nuovo Layout
1. **Chiarezza visiva**: Nome del giorno sempre visibile nella prima colonna
2. **Intestazioni esplicite**: Colonne chiaramente etichettate
3. **Facilità di lettura**: Disposizione tabellare intuitiva
4. **Accessibilità**: Struttura più accessibile per screen reader
5. **Zebra Striping**: Righe alternate con colori di sfondo diversi
6. **Effetti Interattivi**: Hover e transizioni per migliore feedback utente

### Implementazione Tecnica
```php
// Intestazioni delle colonne
Grid::make(3)->schema([
    Placeholder::make('header_day')->content(__('ui::opening_hours.headers.day')),
    Placeholder::make('header_morning')->content(__('ui::opening_hours.headers.morning')),
    Placeholder::make('header_afternoon')->content(__('ui::opening_hours.headers.afternoon')),
])

// Per ogni giorno: griglia a 3 colonne
Grid::make(3)->schema([
    Placeholder::make($dayKey.'_label')->content($label), // Nome giorno
    TextInput::make("$dayKey.morning"),                   // Input mattina
    TextInput::make("$dayKey.afternoon"),                 // Input pomeriggio
])

// Zebra striping per righe alternate
$isEvenRow = $dayIndex % 2 === 0;
$rowClass = $isEvenRow
    ? 'bg-gray-50 dark:bg-gray-800/50 rounded-lg px-2 py-1'
    : 'bg-white dark:bg-gray-900/50 rounded-lg px-2 py-1';

Grid::make(3)->schema([...])
    ->extraAttributes(['class' => $rowClass . ' transition-colors duration-200 hover:bg-blue-50 dark:hover:bg-blue-900/20']);
```

### Miglioramento UX: Zebra Striping (Dicembre 2024)

È stato aggiunto il **zebra striping** per migliorare significativamente l'esperienza utente:

#### Caratteristiche del Zebra Striping
- **Righe Pari**: Sfondo grigio chiaro (`bg-gray-50` / `dark:bg-gray-800/50`)
- **Righe Dispari**: Sfondo bianco (`bg-white` / `dark:bg-gray-900/50`)
- **Effetto Hover**: Blu chiaro al passaggio del mouse
- **Transizioni**: Animazioni fluide di 200ms
- **Header Stilizzato**: Intestazioni con sfondo distintivo e bordo inferiore

#### Benefici UX
1. **Leggibilità**: Facile seguire le righe orizzontalmente
2. **Orientamento**: Riduce la perdita di posto durante la lettura
3. **Professionalità**: Aspetto più curato e moderno
4. **Accessibilità**: Migliore per utenti con difficoltà visive
5. **Feedback**: Hover chiaro su quale riga si sta interagendo

### Miglioramento Mobile-First: TimePicker Separati (Dicembre 2024)

È stato implementato un **miglioramento rivoluzionario per l'UX mobile**:

#### Layout Risultante con TimePicker
```
┌─────────────────────────────────────────────────────────────────────┐
│  Header: [Giorno] [Mattina]        [Pomeriggio]                    │ ← Intestazioni
├─────────────────────────────────────────────────────────────────────┤
│  Lunedì   │ [Dalle▼08:00] [Alle▼12:30] │ [Dalle▼15:00] [Alle▼19:00] │ ← Bianco
│  Martedì  │ [Dalle▼08:00] [Alle▼12:30] │ [Dalle▼15:00] [Alle▼19:00] │ ← Grigio
│  Mercoledì│ [Dalle▼08:00] [Alle▼12:30] │ [Dalle▼15:00] [Alle▼19:00] │ ← Bianco
│  Giovedì  │ [Dalle▼08:00] [Alle▼12:30] │ [Dalle▼15:00] [Alle▼19:00] │ ← Grigio
│  Venerdì  │ [Dalle▼08:00] [Alle▼12:30] │ [Dalle▼15:00] [Alle▼19:00] │ ← Bianco
│  Sabato   │ [Dalle▼08:00] [Alle▼12:30] │ [   vuoto    ] [   vuoto   ] │ ← Grigio
└─────────────────────────────────────────────────────────────────────┘
```

#### Vantaggi Mobile
- **▼ Picker Nativi**: Ogni `[Dalle▼]` e `[Alle▼]` attiva il picker time nativo del dispositivo
- **Touch-Friendly**: Icone grandi e facili da toccare con il dito
- **Zero Errori**: Impossibile inserire formati errati
- **Step Intelligenti**: Incrementi di 15 minuti per orari realistici
- **Validazione Live**: Controllo immediato che "Dalle" < "Alle"

## Posizione

```
Modules/UI/app/Filament/Forms/Components/OpeningHoursField.php
```

## Caratteristiche

- **Gestione settimanale**: Dal lunedì al sabato
- **Doppio slot per giorno**: Mattina e pomeriggio
- **Layout a 3 colonne**: Giorno, Mattina, Pomeriggio in una griglia chiara e organizzata
- **Intestazioni esplicite**: Colonne con intestazioni per massima chiarezza nell'interfaccia
- **Visualizzazione giorno**: Prima colonna mostra chiaramente il nome del giorno
- **Zebra Striping**: Righe alternate con colori diversi per migliorare la leggibilità
- **Effetti Hover**: Transizioni fluide e feedback visivo al passaggio del mouse
- **TimePicker Nativi**: Due TimePicker separati (Dalle/Alle) per ogni periodo
- **Mobile-First UX**: Picker nativi perfetti per dispositivi touch
- **Validazione Automatica**: Controllo integrato che "Dalle" < "Alle"
- **Step 15 minuti**: Incrementi ottimizzati per orari realistici
- **Layout responsive**: Griglia adattiva per dispositivi diversi
- **Nullable**: I campi possono essere lasciati vuoti per indicare "chiuso"

## Struttura Dati

⚠️ **STRUTTURA AGGIORNATA (Dicembre 2024)**: Da TimePicker separati invece di formato stringa

Il componente gestisce dati con la seguente struttura:

```php
[
    'monday' => [
        'morning_from' => '08:00',
        'morning_to' => '12:30',
        'afternoon_from' => '15:00',
        'afternoon_to' => '19:00'
    ],
    'tuesday' => [
        'morning_from' => '08:00',
        'morning_to' => '12:30',
        'afternoon_from' => '15:00',
        'afternoon_to' => '19:00'
    ],
    // ... altri giorni
    'saturday' => [
        'morning_from' => '08:00',
        'morning_to' => '12:30',
        'afternoon_from' => null, // Pomeriggio chiuso
        'afternoon_to' => null
    ]
]
```

### ⬆️ Migrazione dalla Struttura Precedente

```php
// PRIMA (formato stringa)
'morning' => '08:00-12:30'

// DOPO (TimePicker separati)
'morning_from' => '08:00',
'morning_to' => '12:30'
```

## Utilizzo

### Inclusione in un Form Filament

```php
use Modules\UI\Filament\Forms\Components\OpeningHoursField;

public function getFormSchema(): array
{
    return [
        OpeningHoursField::make('availability')
            ->label(__('<nome progetto>::fields.availability.label'))
            ->columnSpanFull(),
    ];
}
```

### Configurazione nel modello

```php
class Doctor extends BaseModel
{
    protected $fillable = [
        'availability',
        // altri campi...
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'availability' => 'array',
        ];
    }
}
```

## Validazione

⚠️ **VALIDAZIONE AGGIORNATA (Dicembre 2024)**: Sistema automatico con TimePicker

Il componente include validazione automatica avanzata:

- **Formato Time**: Automatico tramite TimePicker (formato HH:MM)
- **Cross-Field Validation**: Controllo automatico che "Dalle" < "Alle"
- **Live Validation**: Controllo immediato durante l'inserimento
- **Step Validation**: Solo incrementi di 15 minuti permessi
- **Nullable**: I campi possono essere vuoti (indicano "chiuso")

### Regole di Validazione Automatiche

```php
// Per ogni TimePicker automaticamente applicate:
TimePicker::make("{day}.morning_from")
    ->rules(['before_or_equal:' . $day . '.morning_to']),

TimePicker::make("{day}.morning_to")
    ->rules(['after_or_equal:' . $day . '.morning_from']),
```

### Esempio di validazione custom per nuova struttura

```php
use Illuminate\Validation\Rule;

public function rules(): array
{
    return [
        'availability.*.morning_from' => ['nullable', 'date_format:H:i'],
        'availability.*.morning_to' => [
            'nullable',
            'date_format:H:i',
            'after_or_equal:availability.*.morning_from'
        ],
        'availability.*.afternoon_from' => ['nullable', 'date_format:H:i'],
        'availability.*.afternoon_to' => [
            'nullable',
            'date_format:H:i',
            'after_or_equal:availability.*.afternoon_from'
        ],
    ];
}
```

### Messaggi di Errore Localizzati

```php
// Traduzioni automatiche in ui::opening_hours.validation:
'from_before_to' => 'L\'orario "Dalle" deve essere precedente all\'orario "Alle"',
'to_after_from' => 'L\'orario "Alle" deve essere successivo all\'orario "Dalle"',
'time_sequence' => 'L\'orario di inizio deve essere precedente a quello di fine',
```

## Localizzazione

Il componente utilizza le traduzioni standard:

```php
// lang/it/fields.php
return [
    'availability' => [
        'label' => 'Disponibilità',
        'help' => 'Imposta gli orari di disponibilità per ogni giorno della settimana',
    ],
];
```

Le etichette dei giorni sono generate automaticamente usando Carbon:

```php
$dayLabel = ucfirst(Carbon::create()->startOfWeek()->addDays($day - 1)->isoFormat('dddd'));
```

## Estensioni Possibili

Il componente può essere esteso per supportare:

- **Giorni festivi**: Gestione di date specifiche
- **Eccezioni**: Orari speciali per determinati giorni
- **Validazione avanzata**: Controllo sovrapposizioni e logica business
- **Template**: Preset di orari comuni
- **Export/Import**: Salvataggio e caricamento configurazioni

## Integration con Spatie OpeningHours

⚠️ **INTEGRAZIONE AGGIORNATA (Dicembre 2024)**: Gestione nuova struttura TimePicker

Per integrare con la libreria `spatie/opening-hours`:

```php
use Spatie\OpeningHours\OpeningHours;

class Doctor extends BaseModel
{
    public function getOpeningHoursAttribute(): OpeningHours
    {
        $data = [];

        foreach ($this->availability as $day => $hours) {
            $dayHours = [];

            // Gestione mattina con nuova struttura separata
            if (!empty($hours['morning_from']) && !empty($hours['morning_to'])) {
                $dayHours[] = [
                    'open' => $hours['morning_from'],
                    'close' => $hours['morning_to']
                ];
            }

            // Gestione pomeriggio con nuova struttura separata
            if (!empty($hours['afternoon_from']) && !empty($hours['afternoon_to'])) {
                $dayHours[] = [
                    'open' => $hours['afternoon_from'],
                    'close' => $hours['afternoon_to']
                ];
            }

            $data[$day] = $dayHours;
        }

        return OpeningHours::from($data);
    }

    public function isAvailableAt(string $datetime): bool
    {
        return $this->opening_hours->isOpenAt($datetime);
    }

    /**
     * Helper per convertire dalla vecchia struttura alla nuova.
     * Utile durante la migrazione.
     */
    public function migrateFromOldFormat(): void
    {
        $availability = $this->availability;
        $migrated = [];

        foreach ($availability as $day => $hours) {
            $migrated[$day] = [];

            // Migra formato 'morning' => '08:00-12:30'
            if (isset($hours['morning']) && str_contains($hours['morning'], '-')) {
                [$from, $to] = explode('-', $hours['morning']);
                $migrated[$day]['morning_from'] = $from;
                $migrated[$day]['morning_to'] = $to;
            }

            // Migra formato 'afternoon' => '15:00-19:00'
            if (isset($hours['afternoon']) && str_contains($hours['afternoon'], '-')) {
                [$from, $to] = explode('-', $hours['afternoon']);
                $migrated[$day]['afternoon_from'] = $from;
                $migrated[$day]['afternoon_to'] = $to;
            }
        }

        $this->update(['availability' => $migrated]);
    }
}
```

## Best Practices

1. **Usare sempre columnSpanFull()** per il layout ottimale
2. **Implementare validazione custom** per logiche business specifiche
3. **Localizzare sempre le etichette** nei file di traduzione
4. **Gestire i casi null** nei metodi che processano i dati
5. **Documentare la struttura dati** nel modello o nella risorsa

## Troubleshooting

### Problemi comuni

1. **Validazione non funziona**: Verificare che il regex sia corretto
2. **Layout rotto**: Assicurarsi di usare `columnSpanFull()`
3. **Dati non salvati**: Controllare che il campo sia in `$fillable`
4. **Traduzioni mancanti**: Verificare i percorsi dei file di lingua

## Collegamenti

- [<nome progetto>: Documentazione Opening Hours](../../<nome progetto>/docs/opening-hours-filament-field.md)
- [Spatie Opening Hours Library](https://github.com/spatie/opening-hours)
- [Filament Custom Fields Documentation](https://filamentphp.com/docs/forms/fields/custom)

---

*Ultimo aggiornamento: Dicembre 2024*
