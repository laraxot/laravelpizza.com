# RadioCollection - Esempi di Utilizzo

## Utilizzo Base

### In un Form Filament

```php
use Modules\UI\Filament\Forms\Components\RadioCollection;

RadioCollection::make('studio_selection')
    ->label('Seleziona Studio')
    ->options(collect([
        (object)['id' => 1, 'name' => 'Studio Centro', 'address' => 'Via Roma 123'],
        (object)['id' => 2, 'name' => 'Studio Periferia', 'address' => 'Via Milano 456'],
        (object)['id' => 3, 'name' => 'Studio Nord', 'address' => 'Via Torino 789'],
    ]))
    ->valueKey('id')
    ->required()
```

## Utilizzo Avanzato con Template Personalizzato

### 1. Creazione Template Personalizzato

```blade
{{-- resources/views/custom/studio-radio-item.blade.php --}}
<div class="flex items-center justify-between w-full">
    <div class="flex items-center">
        @if($item->image ?? false)
            <img src="{{ $item->image }}" alt="{{ $item->name }}" class="w-12 h-12 rounded-lg mr-4 object-cover">
        @else
            <div class="w-12 h-12 rounded-lg mr-4 bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.84L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.84l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                </svg>
            </div>
        @endif

        <div>
            <div class="font-semibold text-gray-900 dark:text-white">
                {{ $item->name }}
            </div>
            <div class="text-sm text-gray-500 dark:text-gray-400">
                {{ $item->address }}
            </div>
            @if($item->specializations ?? false)
                <div class="flex flex-wrap gap-1 mt-2">
                    @foreach($item->specializations as $spec)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-200">
                            {{ $spec }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    @if($item->rating ?? false)
        <div class="flex items-center">
            <div class="flex items-center">
                @for($i = 1; $i <= 5; $i++)
                    <svg class="w-4 h-4 {{ $i <= $item->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                @endfor
                <span class="ml-1 text-sm text-gray-600 dark:text-gray-400">{{ $item->rating }}</span>
            </div>
        </div>
    @endif
</div>
```

### 2. Utilizzo del Template Personalizzato

```php
use Modules\UI\Filament\Forms\Components\RadioCollection;

RadioCollection::make('selected_studio')
    ->label('Seleziona il tuo studio preferito')
    ->options(
        Studio::with('specializations')
            ->get()
            ->map(function ($studio) {
                return (object) [
                    'id' => $studio->id,
                    'name' => $studio->name,
                    'address' => $studio->full_address,
                    'image' => $studio->featured_image_url,
                    'rating' => $studio->average_rating,
                    'specializations' => $studio->specializations->pluck('name')->toArray(),
                ];
            })
    )
    ->itemView('custom.studio-radio-item')
    ->valueKey('id')
    ->debug(app()->isLocal()) // Debug solo in ambiente locale
    ->required()
```

## Utilizzo con Debug

### Abilitazione Debug con Callback Personalizzato

```php
RadioCollection::make('payment_method')
    ->options($paymentMethods)
    ->debug(true, function (array $logData) {
        // Log personalizzato per analisi comportamento utente
        logger()->channel('user_behavior')->info('RadioCollection interaction', $logData);

        // Invio metriche a servizio esterno
        if (app()->isProduction()) {
            Analytics::track('form_interaction', [
                'component' => $logData['component'],
                'field' => $logData['field_name'],
                'action' => $logData['message'],
            ]);
        }
    })
```

## Utilizzo in Widget Filament

```php
use Modules\UI\Filament\Forms\Components\RadioCollection;

class SettingsWidget extends BaseWidget
{
    protected static string $view = 'custom.settings-widget';

    public $selectedTheme = 'light';

    protected function getFormSchema(): array
    {
        return [
            RadioCollection::make('selectedTheme')
                ->label('Tema Applicazione')
                ->options(collect([
                    (object)['id' => 'light', 'name' => 'Tema Chiaro', 'description' => 'Ideale per uso diurno'],
                    (object)['id' => 'dark', 'name' => 'Tema Scuro', 'description' => 'Ideale per uso serale'],
                    (object)['id' => 'auto', 'name' => 'Automatico', 'description' => 'Segue impostazioni sistema'],
                ]))
                ->itemView('custom.theme-selector-item')
                ->valueKey('id')
                ->live()
                ->afterStateUpdated(fn ($state) => $this->applyTheme($state)),
        ];
    }

    public function applyTheme(string $theme): void
    {
        // Logica applicazione tema
        session(['theme' => $theme]);
        $this->dispatch('theme-changed', theme: $theme);
    }
}
```

## Gestione Errori e Validazione

### Validazione Personalizzata

```php
RadioCollection::make('user_type')
    ->options($userTypes)
    ->rules(['required', 'in:admin,editor,viewer'])
    ->validationMessages([
        'required' => 'Devi selezionare un tipo di utente.',
        'in' => 'Il tipo di utente selezionato non è valido.',
    ])
    ->afterStateUpdated(function ($state, $component) {
        // Validazione aggiuntiva
        if (!$component->validateSelectedValue($state)) {
            throw new \Exception('Valore selezionato non valido');
        }
    })
```

## Testing del Componente

### Test Livewire

```php
use Livewire\Livewire;

test('radio collection updates state correctly', function () {
    $component = Livewire::test(FormWithRadioCollection::class)
        ->assertSet('data.selection', null)
        ->set('data.selection', 'option1')
        ->assertSet('data.selection', 'option1')
        ->set('data.selection', 'option2')
        ->assertSet('data.selection', 'option2');
});

test('radio collection validates options correctly', function () {
    $component = Livewire::test(FormWithRadioCollection::class)
        ->set('data.selection', 'invalid_option')
        ->assertHasErrors(['data.selection']);
});
```

### Test Browser (Dusk)

```php
use Laravel\Dusk\Browser;

test('radio collection is interactive in browser', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/form-with-radio-collection')
                ->waitFor('[wire\\:key*="radio-collection"]')
                ->click('[wire\\:key*="option1"]')
                ->pause(500)
                ->assertInputValue('[name="radio-collection"]', 'option1')
                ->click('[wire\\:key*="option2"]')
                ->pause(500)
                ->assertInputValue('[name="radio-collection"]', 'option2');
    });
});
```

## Performance e Ottimizzazioni

### Lazy Loading per Grandi Dataset

```php
RadioCollection::make('city')
    ->options(function () {
        // Caricamento lazy solo quando necessario
        return Cache::remember('cities_collection', 3600, function () {
            return City::select('id', 'name', 'region')
                ->limit(50) // Limita per performance
                ->get()
                ->map(fn($city) => (object)[
                    'id' => $city->id,
                    'name' => $city->name,
                    'region' => $city->region,
                ]);
        });
    })
    ->searchable() // Aggiunge funzionalità di ricerca se disponibile
```

### Monitoring Performance

```php
RadioCollection::make('product_category')
    ->options($categories)
    ->debug(true, function (array $logData) {
        // Monitor performance per grandi dataset
        if ($logData['context']['options_count'] > 100) {
            logger()->warning('RadioCollection with large dataset', [
                'options_count' => $logData['context']['options_count'],
                'field' => $logData['field_name'],
            ]);
        }
    })
```

*Esempi aggiornati: {{ now() }}*
