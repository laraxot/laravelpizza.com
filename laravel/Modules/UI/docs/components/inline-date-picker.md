# InlineDatePicker Component

## Overview
The InlineDatePicker is an advanced date selection component with multilingual support and intuitive navigation. Designed to provide an immediate and minimalist user experience, the component is fully integrated with Laravel's translation system.
## Key Features
### 🌐 **Multilingual Support**
- **Centralized Translations**: Uses translation files for each supported language
- **Month and Day Names**: Pulled from centralized translation files
- **Navigation Labels**: Fully translatable and customizable
- **Cultural Adaptability**: Respects local date display conventions
- **Carbon Integration**: Uses Carbon for reliable date handling and localization
### 🔄 **Enhanced Navigation**
- **Bidirectional Controls**: Built-in previous/next month navigation
- **Livewire Sync**: Seamless server-side state management
- **Visual Feedback**: Immediate visual feedback during navigation
- **Accessibility**: Keyboard navigable and screen reader friendly
### 📱 **Responsive Design**
- **Compact Mode**: Optimized for mobile devices
- **Adaptive Layout**: Automatically adjusts to available space
- **Touch Interactions**: Optimized for touch screens
- **Theme Support**: Built-in light/dark theme support
## Architettura Tecnica
### Componente PHP: `InlineDatePicker.php`
```php
<?php
declare(strict_types=1);
namespace Modules\UI\Filament\Forms\Components;
use Filament\Forms\Components\DatePicker;
use Carbon\Carbon;
/**
 * InlineDatePicker - Componente calendario inline con supporto multilingua
 *
 * Estende il DatePicker standard con funzionalità avanzate:
 * - Navigazione mese precedente/successivo
 * - Supporto completo multilingua
 * - Selezione date abilitate/disabilitate
 * - Design responsivo e accessibile
 */
class InlineDatePicker extends DatePicker
{
    // Proprietà e metodi...
}
```
## API Completa e Funzionalità
### Metodi di Configurazione
#### `enabledDates(array|Closure $dates): static`
Definisce le date selezionabili secondo il **principio di scarsità controllata**.
// Array statico di date
InlineDatePicker::make('appointment_date')
    ->enabledDates(['2025-06-05', '2025-06-21', '2025-07-10']);
// Closure dinamica per logica complessa
    ->enabledDates(function () {
        return Appointment::where('available', true)
            ->pluck('date')
            ->map(fn($date) => $date->format('Y-m-d'))
            ->toArray();
    });
#### `highlightColor(string $color): static`
Applica la **teoria del colore** per comunicazione visiva.
// Colori semantici predefiniti
InlineDatePicker::make('emergency_date')
    ->highlightColor('bg-red-600 text-white'); // Emergenza
InlineDatePicker::make('routine_date')
    ->highlightColor('bg-green-600 text-white'); // Routine
InlineDatePicker::make('priority_date')
    ->highlightColor('bg-amber-600 text-white'); // Priorità
// Colori personalizzati con gradienti
InlineDatePicker::make('vip_date')
    ->highlightColor('bg-gradient-to-r from-purple-600 to-blue-600 text-white');
#### `compactMode(bool $compact = true): static`
Attiva il **design responsivo** per spazi ridotti.
// In sidebar o widget stretti
InlineDatePicker::make('quick_date')
    ->compactMode()
    ->showNavigation(false); // Nasconde i controlli per massima compattezza
// Modalità estesa per dashboard
InlineDatePicker::make('main_calendar')
    ->compactMode(false)
    ->showNavigation(true);
#### `showNavigation(bool $show = true): static`
Controlla la **democrazia temporale** tramite controlli di navigazione.
// Navigazione completa (default)
InlineDatePicker::make('flexible_date')
// Solo visualizzazione (modalità read-only temporale)
InlineDatePicker::make('readonly_date')
    ->showNavigation(false);
### Navigazione Temporale Avanzata - ARCHITETTURA CORRETTA ✅
### Architettura Frontend-Only (CORRETTA)
**Principio Fondamentale:** L'`InlineDatePicker` è un **componente Filament Form**, non un componente Livewire standalone. Pertanto, la navigazione deve essere gestita puramente frontend.
#### Approccio Corretto ✅
1. **Frontend JavaScript (Alpine.js)**:
   ```javascript
   // ✅ CORRETTO: Navigazione puramente frontend
   previousMonth() {
       this.navigateToMonth('prev');
   },

   nextMonth() {
       this.navigateToMonth('next');
   navigateToMonth(direction) {
       const currentDate = new Date(this.currentViewMonth + '-01');

       if (direction === 'prev') {
           currentDate.setMonth(currentDate.getMonth() - 1);
       } else if (direction === 'next') {
           currentDate.setMonth(currentDate.getMonth() + 1);
       }
       this.currentViewMonth = currentDate.getFullYear() + '-' +
           String(currentDate.getMonth() + 1).padStart(2, '0');
       // Rigenera calendario localmente
       this.regenerateCalendar();
   }
   ```
2. **Backend PHP (InlineDatePicker)**:
   ```php
   // ✅ I metodi PHP esistono per compatibilità API
   // Ma NON vengono chiamati dal frontend
   public function previousMonth(): void
   public function nextMonth(): void
#### Vantaggi dell'Approccio Frontend-Only
1. **Performance**: Zero chiamate HTTP per navigazione
2. **UX**: Navigazione istantanea senza latenza
3. **Architettura**: Rispetta il pattern Filament Form Component
4. **Semplicità**: Nessun accoppiamento con componenti Livewire contenitori
5. **Riusabilità**: Funziona in qualsiasi form senza dipendenze esterne
### Errore Architetturale Precedente ❌
**Cosa NON fare:**
```javascript
// ❌ ERRATO: Chiamate Livewire da componente Form
previousMonth() {
    $wire.call('previousMonth'); // Chiamata al widget contenitore
**Problemi:**
- Accoppiamento tra componente e widget contenitore
- Ogni widget che usa il componente deve implementare i metodi
- Violazione del principio di responsabilità singola
- Performance peggiore
### Pattern Implementativo
1. **InlineDatePicker.php** (Componente Form):
   - Estende `DatePicker` di Filament
   - Contiene logica PHP per configurazione iniziale
   - Metodi `previousMonth/nextMonth` per compatibilità API
2. **inline-date-picker.blade.php** (Vista):
   - Logica Alpine.js per navigazione frontend
   - Rigenerazione calendario JavaScript
   - Nessuna chiamata `$wire.call()` per navigazione
3. **Widget che lo usa**:
   - Non deve implementare metodi di navigazione
   - Si limita a configurare `enabledDates` e `currentViewMonth`
   - Zero dipendenze da logica di navigazione
### Implementazione Rigenerazione Frontend
// Rigenera calendario per il nuovo mese
regenerateCalendar() {
    const [year, month] = this.currentViewMonth.split('-').map(Number);
    this.calendarData = this.generateCalendarDataForMonth(year, month);
},
// Genera struttura calendario JavaScript
generateCalendarDataForMonth(year, month) {
    const firstDay = new Date(year, month - 1, 1);
    const startDate = new Date(firstDay);
    startDate.setDate(startDate.getDate() - firstDay.getDay() + 1);

    const weeks = [];
    let currentDate = new Date(startDate);
    for (let week = 0; week < 6; week++) {
        const weekDays = [];
        for (let day = 0; day < 7; day++) {
            const dateString = currentDate.toISOString().split('T')[0];
            const isCurrentMonth = currentDate.getMonth() === month - 1;

            weekDays.push({
                dateString: dateString,
                datetime: dateString,
                day: currentDate.getDate(),
                isCurrentMonth: isCurrentMonth,
                isToday: this.isToday(currentDate),
                isSelected: this.selectedDate === dateString,
                isEnabled: this.isDateEnabled(dateString) && isCurrentMonth,
            });
            currentDate.setDate(currentDate.getDate() + 1);
        }
        weeks.push(weekDays);
    }
    return {
        weeks: weeks,
        monthName: firstDay.toLocaleDateString('{{ app()->getLocale() }}', { month: 'long' }),
        year: year,
    };
## Utilizzo nel Widget
### Configurazione Corretta ✅
protected function getDateStepSchema(): array
    return [
        'appointment_date' => InlineDatePicker::make('appointment_date')
            ->enabledDates(['2025-06-05','2025-06-21'])
            ->currentViewMonth(now()->format('Y-m'))
    ];
### Note Importanti
1. **Il widget NON deve implementare `previousMonth/nextMonth`**
2. **La navigazione è completamente self-contained nel componente**
3. **Le `enabledDates` sono rispettate durante la navigazione frontend**
4. **Il mese di visualizzazione può essere inizializzato dal widget ma poi è autonomo**
Questo approccio rispetta i principi SOLID e il pattern architetturale di Filament, garantendo componenti riusabili e disaccoppiati.
## Esempi di Utilizzo Avanzato
### 1. Calendario Appuntamenti Medici
// Nel Widget o Risorsa Filament
InlineDatePicker::make('visit_date')
    ->label('Data Visita')
        // Solo giorni lavorativi con disponibilità
        return Doctor::find($this->doctor_id)
            ->getAvailableDates()
            ->filter(fn($date) => !$date->isWeekend())
    })
    ->highlightColor('bg-green-600 text-white')
    ->showNavigation(true)
    ->required();
### 2. Calendario Eventi Ricorrenti
InlineDatePicker::make('recurring_event_date')
    ->label('Data Evento Ricorrente')
        // Pattern ricorrenti: ogni lunedì e mercoledì
        $dates = collect();
        $start = now()->startOfMonth();
        $end = now()->addMonths(3)->endOfMonth();

        while ($start->lte($end)) {
            if ($start->isMonday() || $start->isWednesday()) {
                $dates->push($start->format('Y-m-d'));
            }
            $start->addDay();
        return $dates->toArray();
    ->highlightColor('bg-purple-600 text-white');
### 3. Calendario con Restrizioni Dinamiche
InlineDatePicker::make('project_deadline')
    ->label('Scadenza Progetto')
        // Solo date future con almeno 7 giorni di preavviso
        return collect(range(7, 90))
            ->map(fn($days) => now()->addDays($days)->format('Y-m-d'))
            ->filter(function ($date) {
                // Escludi festività
                $carbon = Carbon::parse($date);
                return !in_array($carbon->format('m-d'), [
                    '01-01', '12-25', '12-26', // Festività
                ]);
            })
    ->highlightColor('bg-amber-600 text-white');
## Accessibilità e Inclusività
### Supporto Screen Reader
```html
<!-- Ogni elemento ha labels appropriati -->
<button
    aria-label=\"Seleziona {{ $day['date']->translatedFormat('d F Y') }}\"
    @if($isSelected) aria-pressed=\"true\" @endif
>
    <time datetime=\"{{ $dateString }}\">{{ $day['day'] }}</time>
</button>
### Navigazione da Tastiera
- **Tab**: Navigazione tra controlli
- **Space/Enter**: Selezione data
- **Arrow Keys**: Navigazione tra date (implementazione futura)
- **Escape**: Chiudi eventuali modal
### Supporto Internazionale
// Localizzazione automatica
'monthYearLabel' => $currentViewMonth->translatedFormat('F Y'),
'monthName' => $currentViewMonth->translatedFormat('F'),
// Configurazione locale
'locale' => app()->getLocale(),
'timezone' => config('app.timezone'),
## Performance e Ottimizzazioni
### Caching Intelligente
public function getEnabledDates(): Collection
    return cache()->remember(
        \"enabled_dates_{$this->getId()}_{$this->displayDate->format('Y-m')}\",
        now()->addMinutes(15),
        fn() => $this->calculateEnabledDates()
    );
### Lazy Loading
// Le date vengono calcolate solo quando necessario
protected $enabledDates = null;
public function enabledDates(array|Closure $dates): static
    $this->enabledDates = $dates; // Non eseguito immediatamente
    return $this;
### Debouncing Navigation
// Evita chiamate eccessive durante navigazione rapida
navigateToMonth: debounce(function(direction) {
    // Logica di navigazione
}, 250)
## Testing e Quality Assurance
### Unit Tests
namespace Modules\\UI\\Tests\\Unit\\Components;
use Tests\\TestCase;
use Modules\\UI\\Filament\\Forms\\Components\\InlineDatePicker;
class InlineDatePickerTest extends TestCase
    /** @test */
    public function it_can_set_enabled_dates(): void
    {
        $picker = InlineDatePicker::make('test')
            ->enabledDates(['2025-06-05', '2025-06-21']);
        $this->assertTrue($picker->isDateEnabled('2025-06-05'));
        $this->assertFalse($picker->isDateEnabled('2025-06-10'));
    public function it_can_navigate_between_months(): void
        $picker = InlineDatePicker::make('test');
        $initialMonth = $picker->getCurrentViewMonth();
        $picker->setCurrentViewMonth('2025-07');
        $this->assertEquals('2025-07', $picker->getCurrentViewMonth()->format('Y-m'));
### Integration Tests
/** @test */
public function it_integrates_with_livewire_forms(): void
    $component = Livewire::test(FormWithDatePicker::class)
        ->set('data.appointment_date', '2025-06-05')
        ->assertHasNoErrors()
        ->assertSee('2025-06-05');
## Troubleshooting e Debug
### Debug Mode
<!-- Debug info rimosso per ambiente di produzione -->
            Enabled Dates: <span x-text=\"enabledDates.length\"></span><br>
            Current Month: <span x-text=\"currentMonth\"></span><br>
            Compact Mode: {{ $compactMode ? 'true' : 'false' }}<br>
            Show Navigation: {{ $showNavigation ? 'true' : 'false' }}
        </div>
    </div>
@endif
### Logging Avanzato
public function setCurrentViewMonth(string $monthString): void
    try {
        $parsedMonth = Carbon::createFromFormat('Y-m', $monthString)->startOfMonth();
        $this->displayDate = $parsedMonth;
    } catch (\\Throwable $e) {
        // Log per debugging temporale
        if (config('app.debug')) {
            logger()->warning('InlineDatePicker: Invalid month format', [
                'input' => $monthString,
                'error' => $e->getMessage(),
                'component' => static::class,
                'user_id' => auth()->id(),
                'timestamp' => now()->toISOString(),
            ]);
        $this->displayDate = Carbon::now()->startOfMonth();
## Roadmap e Sviluppi Futuri
### Versione 2.0 - Quantum Calendar
- **Selezione Multi-Data**: Date multiple simultanee
- **Range Selection**: Selezione intervalli temporali
- **Time Integration**: Integrazione con selettori orario
- **Recurring Patterns**: Pattern ricorrenti avanzati
### Versione 3.0 - AI-Powered Temporal Intelligence
- **Smart Suggestions**: Suggerimenti AI per date ottimali
- **Pattern Recognition**: Riconoscimento pattern utente
- **Predictive Availability**: Previsione disponibilità
### Versione 4.0 - Universal Temporal Interface
- **Multiple Calendars**: Supporto calendari diversi (Gregoriano, Lunare, etc.)
- **Timezone Handling**: Gestione fusi orari avanzata
- **External Sync**: Sincronizzazione con Google Calendar, Outlook
## Best Practice e Convenzioni
### 1. **Naming Semantic**
- Date proprietà: `appointment_date`, `deadline_date`, `birth_date`
- Evitare nomi generici: `date`, `day`, `time`
### 2. **Validation Logic**
// Sempre validare date abilitate lato server
public function rules(): array
        'appointment_date' => [
            'required',
            'date',
            function ($attribute, $value, $fail) {
                if (!$this->isDateEnabled($value)) {
                    $fail('La data selezionata non è disponibile.');
                }
            },
        ],
### 3. **Error Handling**
// Gestione graceful degli errori
try {
    $enabledDates = $this->getEnabledDates();
} catch (\\Throwable $e) {
    // Fallback a tutte le date abilitate
    $enabledDates = collect();
    report($e); // Log per monitoring
### 4. **Security Considerations**
// Autorizzazione per date specifiche
    return collect($this->baseDates)
        ->filter(function ($date) {
            // Controllo permessi per ogni data
            return auth()->user()->canAccessDate($date);
        });
## Integrazione Ecosistema Laraxot
### Service Provider Registration
// In ModuleServiceProvider
public function boot(): void
    // Registrazione componente globale
    Blade::component('inline-date-picker', InlineDatePicker::class);
    // Livewire component
    Livewire::component('ui::inline-date-picker', InlineDatePicker::class);
### Filament Plugin Integration
// In FilamentServiceProvider
public function register(): void
    FilamentAsset::register([
        Css::make('inline-date-picker', __DIR__.'/../resources/css/inline-date-picker.css'),
        Js::make('inline-date-picker', __DIR__.'/../resources/js/inline-date-picker.js'),
    ], 'ui');
---
**Ultimo aggiornamento**: Dicembre 2024
**Versione**: 2.0 con Navigazione Temporale Avanzata
**Compatibilità**: Laraxot , Filament 4.x, Alpine.js 3.x
**Compatibilità**: Laraxot , Filament 4.x, Alpine.js 3.x
**Compatibilità**: Laraxot <nome progetto>, Filament 3.x, Alpine.js 3.x
**Filosofia**: Fenomenologia Quantistica applicata al Design Temporale
**Filosofia**: Fenomenologia Quantistica applicata al Design Temporale
**Compatibilità**: Laraxot , Filament 4.x, Alpine.js 3.x
**Compatibilità**: Laraxot , Filament 4.x, Alpine.js 3.x
**Compatibilità**: Laraxot <nome progetto>, Filament 3.x, Alpine.js 3.x
**Filosofia**: Fenomenologia Quantistica applicata al Design Temporale
**Filosofia**: Fenomenologia Quantistica applicata al Design Temporale
**Compatibilità**: Laraxot , Filament 4.x, Alpine.js 3.x
**Compatibilità**: Laraxot <nome progetto>, Filament 3.x, Alpine.js 3.x
**Filosofia**: Fenomenologia Quantistica applicata al Design Temporale
