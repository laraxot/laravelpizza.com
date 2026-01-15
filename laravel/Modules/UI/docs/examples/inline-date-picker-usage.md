# Esempi di Utilizzo di InlineDatePicker

## Esempio 1: Prenotazione Appuntamenti Medici

```php
<?php

declare(strict_types=1);

namespace Modules\<nome progetto>\Filament\Forms;

use Modules\UI\Filament\Forms\Components\InlineDatePicker;
use Modules\<nome progetto>\Models\Appointment;
use Carbon\Carbon;

class AppointmentBookingForm
{
    public function getDatePickerSchema(): array
    {
        return [
            InlineDatePicker::make('appointment_date')
                ->enabledDates(function () {
                    // Solo giorni feriali dei prossimi 30 giorni
                    $availableDates = [];
                    $start = Carbon::today();
                    $end = Carbon::today()->addDays(30);

                    while ($start <= $end) {
                        if ($start->isWeekday()) {
                            $availableDates[] = $start->format('Y-m-d');
                        }
                        $start->addDay();
                    }

                    return $availableDates;
                })
                ->calendarConfig([
                    'locale' => 'it',
                    'firstDayOfWeek' => 1,
                ])
                ->afterStateUpdated(function ($state, Set $set) {
                    // Reset orario quando cambia la data
                    $set('appointment_time', null);

                    // Carica orari disponibili per la data selezionata
                    $this->loadAvailableTimeSlots($state);
                })
                ->required(),
        ];
    }
}
```

## Esempio 2: Selezione Date Evento

```php
<?php

declare(strict_types=1);

namespace Modules\Events\Filament\Forms;

use Modules\UI\Filament\Forms\Components\InlineDatePicker;
use Modules\Events\Models\Event;

class EventSchedulingForm
{
    public function getDatePickerSchema(): array
    {
        return [
            InlineDatePicker::make('event_date')
                ->enabledDates(function () {
                    // Date specifiche configurate dall'amministratore
                    return Event::query()
                        ->where('is_available', true)
                        ->where('date', '>=', now())
                        ->pluck('date')
                        ->map(fn($date) => $date->format('Y-m-d'))
                        ->toArray();
                })
                ->calendarConfig([
                    'locale' => 'it',
                    'firstDayOfWeek' => 1,
                    'numberOfMonths' => 2, // Mostra due mesi
                ])
                ->afterStateUpdated(function ($state) {
                    // Log della selezione per analytics
                    \Log::info('Event date selected', [
                        'date' => $state,
                        'user' => auth()->id(),
                        'timestamp' => now(),
                    ]);
                })
                ->required(),
        ];
    }
}
```

## Esempio 3: Sistema di Prenotazione con Restrizioni Avanzate

```php
<?php

declare(strict_types=1);

namespace Modules\Bookings\Filament\Forms;

use Modules\UI\Filament\Forms\Components\InlineDatePicker;
use Modules\Bookings\Services\AvailabilityService;
use Carbon\Carbon;

class AdvancedBookingForm
{
    public function __construct(
        private AvailabilityService $availabilityService
    ) {}

    public function getDatePickerSchema(): array
    {
        return [
            InlineDatePicker::make('booking_date')
                ->enabledDates(function (Get $get) {
                    $serviceId = $get('service_id');
                    $locationId = $get('location_id');

                    if (!$serviceId || !$locationId) {
                        return [];
                    }

                    // Logica avanzata per date disponibili
                    return $this->availabilityService->getAvailableDates(
                        serviceId: $serviceId,
                        locationId: $locationId,
                        startDate: Carbon::today(),
                        endDate: Carbon::today()->addMonths(3)
                    );
                })
                ->calendarConfig([
                    'locale' => 'it',
                    'firstDayOfWeek' => 1,
                ])
                ->afterStateUpdated(function ($state, Set $set, Get $get) {
                    if (!$state) return;

                    // Reset campi dipendenti
                    $set('booking_time', null);
                    $set('duration', null);

                    // Calcola durata massima per la data
                    $maxDuration = $this->availabilityService->getMaxDuration(
                        date: $state,
                        serviceId: $get('service_id'),
                        locationId: $get('location_id')
                    );

                    $set('max_duration', $maxDuration);
                })
                ->visible(fn (Get $get) => $get('service_id') && $get('location_id'))
                ->required(),
        ];
    }
}
```

## Esempio 4: Integrazione con Wizard Multi-Step

```php
<?php

declare(strict_types=1);

namespace Modules\Wizards\Filament\Forms;

use Modules\UI\Filament\Forms\Components\InlineDatePicker;
use Filament\Forms\Components\Wizard;

class MultiStepWizardForm
{
    public function getWizardSchema(): array
    {
        return [
            Wizard::make([
                Wizard\Step::make('service_selection')
                    ->label('Selezione Servizio')
                    ->schema([
                        // ... altri componenti
                    ]),

                Wizard\Step::make('date_selection')
                    ->label('Selezione Data')
                    ->schema([
                        InlineDatePicker::make('appointment_date')
                            ->enabledDates(function (Get $get) {
                                $serviceType = $get('service_type');

                                // Date diverse per tipologia di servizio
                                return match($serviceType) {
                                    'urgent' => $this->getUrgentDates(),
                                    'standard' => $this->getStandardDates(),
                                    'premium' => $this->getPremiumDates(),
                                    default => [],
                                };
                            })
                            ->calendarConfig([
                                'locale' => 'it',
                                'firstDayOfWeek' => 1,
                            ])
                            ->live()
                            ->required(),
                    ]),

                Wizard\Step::make('confirmation')
                    ->label('Conferma')
                    ->schema([
                        // ... conferma dettagli
                    ]),
            ])
        ];
    }

    private function getUrgentDates(): array
    {
        // Solo i prossimi 7 giorni (giorni feriali)
        $dates = [];
        $start = Carbon::today();

        for ($i = 0; $i < 7; $i++) {
            if ($start->isWeekday()) {
                $dates[] = $start->format('Y-m-d');
            }
            $start->addDay();
        }

        return $dates;
    }

    private function getStandardDates(): array
    {
        // Prossime 4 settimane (solo giorni feriali)
        $dates = [];
        $start = Carbon::today();
        $end = Carbon::today()->addWeeks(4);

        while ($start <= $end) {
            if ($start->isWeekday()) {
                $dates[] = $start->format('Y-m-d');
            }
            $start->addDay();
        }

        return $dates;
    }

    private function getPremiumDates(): array
    {
        // Tutti i giorni dei prossimi 3 mesi
        $dates = [];
        $start = Carbon::today();
        $end = Carbon::today()->addMonths(3);

        while ($start <= $end) {
            $dates[] = $start->format('Y-m-d');
            $start->addDay();
        }

        return $dates;
    }
}
```

## Esempio 5: Personalizzazione Avanzata con Stati Speciali

```php
<?php

declare(strict_types=1);

namespace Modules\CustomCalendar\Filament\Forms;

use Modules\UI\Filament\Forms\Components\InlineDatePicker;
use Modules\CustomCalendar\Models\SpecialDate;

class CustomCalendarForm
{
    public function getAdvancedDatePickerSchema(): array
    {
        return [
            InlineDatePicker::make('special_date')
                ->enabledDates(function () {
                    // Date con stati speciali
                    return SpecialDate::query()
                        ->where('is_active', true)
                        ->where('date', '>=', now())
                        ->get()
                        ->map(function ($specialDate) {
                            return [
                                'date' => $specialDate->date->format('Y-m-d'),
                                'type' => $specialDate->type,
                                'priority' => $specialDate->priority,
                                'metadata' => $specialDate->metadata,
                            ];
                        })
                        ->pluck('date')
                        ->toArray();
                })
                ->calendarConfig([
                    'locale' => 'it',
                    'firstDayOfWeek' => 1,
                    'customClasses' => [
                        'special-holiday' => fn($date) => $this->isHoliday($date),
                        'high-demand' => fn($date) => $this->isHighDemand($date),
                        'premium-only' => fn($date) => $this->isPremiumOnly($date),
                    ],
                ])
                ->afterStateUpdated(function ($state) {
                    // Carica metadati per la data selezionata
                    $specialDate = SpecialDate::whereDate('date', $state)->first();

                    if ($specialDate) {
                        $this->selectedDateMetadata = $specialDate->metadata;
                        $this->selectedDateType = $specialDate->type;
                    }
                })
                ->required(),
        ];
    }

    private function isHoliday(string $date): bool
    {
        return SpecialDate::whereDate('date', $date)
            ->where('type', 'holiday')
            ->exists();
    }

    private function isHighDemand(string $date): bool
    {
        return SpecialDate::whereDate('date', $date)
            ->where('priority', 'high')
            ->exists();
    }

    private function isPremiumOnly(string $date): bool
    {
        return SpecialDate::whereDate('date', $date)
            ->where('type', 'premium_only')
            ->exists();
    }
}
```

## Esempio 6: Testing del Componente

```php
<?php

declare(strict_types=1);

namespace Tests\Feature\UI\Components;

use Tests\TestCase;
use Livewire\Livewire;
use Modules\UI\Filament\Forms\Components\InlineDatePicker;
use Carbon\Carbon;

class InlineDatePickerTest extends TestCase
{
    /** @test */
    public function it_renders_with_enabled_dates(): void
    {
        $enabledDates = [
            Carbon::today()->format('Y-m-d'),
            Carbon::tomorrow()->format('Y-m-d'),
        ];

        $component = InlineDatePicker::make('test_date')
            ->enabledDates($enabledDates);

        $this->assertEquals($enabledDates, $component->getEnabledDates());
    }

    /** @test */
    public function it_validates_date_selection(): void
    {
        $enabledDates = [Carbon::today()->format('Y-m-d')];

        Livewire::test(TestFormComponent::class)
            ->assertFormFieldExists('test_date')
            ->fillForm([
                'test_date' => Carbon::yesterday()->format('Y-m-d'), // Data non abilitata
            ])
            ->assertHasFormErrors(['test_date']);
    }

    /** @test */
    public function it_generates_correct_month_grid(): void
    {
        $component = InlineDatePicker::make('test_date');
        $grid = $component->generateMonthGrid(2025, 1);

        $this->assertArrayHasKey('year', $grid);
        $this->assertArrayHasKey('month', $grid);
        $this->assertArrayHasKey('days', $grid);
        $this->assertEquals(2025, $grid['year']);
        $this->assertEquals(1, $grid['month']);
        $this->assertIsArray($grid['days']);
    }
}
```

## Best Practice per l'Utilizzo

### 1. Performance
- Utilizzare closure per date dinamiche solo quando necessario
- Implementare caching per calcoli costosi di disponibilità
- Limitare il numero di date abilitate (max 1000)

### 2. UX/UI
- Fornire feedback visivo per stati speciali
- Implementare loading states per operazioni asincrone
- Utilizzare tooltip per informazioni aggiuntive

### 3. Accessibilità
- Testare con screen reader
- Verificare navigazione da tastiera
- Implementare ARIA labels appropriati

### 4. Testing
- Testare tutti i percorsi di navigazione
- Verificare comportamento con date edge case
- Implementare test di regressione per fix di bug

---

*Ultima modifica: Gennaio 2025*
*Versione: 1.0.0*
