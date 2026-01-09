# Componenti UI

## Componenti Form Avanzati

### InlineDatePicker

Componente Filament Form per la selezione di date con calendario inline sempre visibile e controllo granulare delle date selezionabili.

#### Utilizzo Base
```php
use Modules\UI\Filament\Forms\Components\InlineDatePicker;

InlineDatePicker::make('appointment_date')
    ->enabledDates(['2025-06-05', '2025-06-21'])
    ->highlightColor('bg-indigo-600 text-white')
    ->compactMode()
    ->required();
```

#### Caratteristiche
- **Design Inline**: Calendario sempre visibile senza popup
- **Date Selettive**: Solo date specifiche sono cliccabili e evidenziate
- **Tema Coerente**: Basato sul design One theme con Tailwind CSS
- **Alpine.js**: Interattività fluida senza page reload
- **Accessibilità**: Supporto completo keyboard navigation e screen reader

#### Metodi Principali
```php
// Date abilitate (array o Closure dinamica)
->enabledDates(['2025-06-05', '2025-06-21'])
->enabledDates(fn () => $this->getAvailableDates())

// Personalizzazione colori
->highlightColor('bg-green-600 text-white')

// Layout compatto
->compactMode()

// Controlli navigazione
->showNavigation(false)
```

#### Integrazione con Wizard
```php
InlineDatePicker::make('date')
    ->enabledDates(fn () => $this->getDoctorAvailableDates())
    ->live()
    ->afterStateUpdated(fn ($state) => $this->loadTimeSlots($state))
```

[**📖 Documentazione Completa**](./components/inline-date-picker.md)

### StudioCardSelector

Componente Filament Form per la selezione di studi medici attraverso interfaccia card visuale.

#### Utilizzo Base
```php
use Modules\UI\Forms\Components\StudioCardSelector;

StudioCardSelector::make('selected_studio')
    ->studios(fn (Get $get) => $this->getStudiosForLocation($get))
    ->required();
```

#### Caratteristiche
- **Layout Responsive**: Card stack verticali su mobile, orizzontali su desktop
- **Accessibilità**: Supporto completo keyboard navigation e screen reader
- **Personalizzazione**: Varianti compact/default/detailed
- **Interattività**: Selezione radio con feedback visivo
- **Alpine.js**: Interazioni fluide senza page reload

#### Varianti Layout
```php
// Layout compatto
StudioCardSelector::make('studio')->compact();

// Layout dettagliato con info extra
StudioCardSelector::make('studio')
    ->detailed()
    ->showDistance()
    ->showSpecializations()
    ->showPhone();
```

#### Features Opzionali
- `showDistance()`: Badge distanza con icona mappa
- `showSpecializations()`: Tag specializzazioni mediche
- `showPhone()`: Numero telefono con icona

[**📖 Documentazione Completa**](./studio-card-selector-implementation.md)

## Componenti Form Filament

### RadioCollection

Componente per la selezione mutuamente esclusiva con interfaccia card personalizzabile.

#### Utilizzo Base
```php
use Modules\UI\Filament\Forms\Components\RadioCollection;

RadioCollection::make('selection')
    ->options(collect([
        (object)['id' => 1, 'name' => 'Opzione 1', 'description' => 'Descrizione 1'],
        (object)['id' => 2, 'name' => 'Opzione 2', 'description' => 'Descrizione 2'],
    ]))
    ->valueKey('id')
    ->itemView('custom.item-template')
    ->required();
```

#### Caratteristiche Avanzate
- **Type Safety**: Comparazione type-safe tra valori per evitare problemi di type coercion
- **Accessibilità**: Supporto completo per screen reader e navigazione keyboard
- **Reattività**: Alpine.js + Livewire per feedback immediato
- **Personalizzazione**: Template item completamente personalizzabile

#### Features Filosofiche
- **Fisica Quantistica**: Ogni opzione esiste in superposizione fino alla selezione
- **Fenomenologia**: Interfaccia progettata per minimizzare interruzioni cognitive
- **Gestalt**: Rispetta principi di prossimità, somiglianza e chiusura
- **Zen**: Design minimalista che riduce all'essenziale

[**📖 Documentazione Filosofica Completa**](./components/radio-collection-component.md)

### LocationSelector

Componente per la selezione gerarchica di dati geografici (Regione → Provincia → CAP).

#### Utilizzo
```php
use Modules\UI\Filament\Forms\Components\LocationSelector;

LocationSelector::make()
    ->regionField('region')
    ->provinceField('province')
    ->capField('cap')
    ->required()
    ->searchable()
```

#### Caratteristiche
- Selezione gerarchica con dipendenze automatiche
- Integrazione con modulo Geo
- Live updates tra i campi
- Validazione cascata
- Gestione errori con logging

## Componenti Blade UI

### StudioSelector

Componente semplificato per la selezione di uno studio odontoiatrico tramite pulsanti radio-style.

#### Utilizzo
```blade
<x-ui::ui.studio-selector
    :studios="$studios"
    :selected-studio="$selectedStudioId"
    target-field="selected_studio"
/>
```

#### Caratteristiche
- Pulsanti radio-style per selezione singola
- Visual feedback per stato selezionato
- Informazioni compatte (nome, indirizzo, contatti)
- Empty states integrati
- Integrazione Livewire automatica
- Layout responsive

### StudioCard (Completa)

Componente avanzato per la visualizzazione dettagliata di uno studio (per liste, dashboard, dettagli).

#### Utilizzo
```blade
<x-ui::ui.studio-card
    :studio="$studio"
    :show-distance="true"
    :show-rating="true"
    :show-services="true"
    :actions="['book', 'details', 'contact']"
/>
```

#### Caratteristiche
- Layout responsive completo
- Rating con stelle
- Informazioni di contatto estese
- Servizi offerti
- Azioni personalizzabili
- Orari di apertura

## Componenti SVG

### Bandiere (Flags)

I componenti SVG per le bandiere sono registrati automaticamente e possono essere utilizzati con il prefisso `ui-flags`.

#### Utilizzo
```blade
{{-- Bandiera italiana --}}
<x-ui-flags.it class="w-6 h-4" />

{{-- Bandiera inglese --}}
<x-ui-flags.gb class="w-6 h-4" />
```

#### Caratteristiche
- Registrazione automatica dei componenti
- Supporto per tutte le bandiere del mondo
- Dimensioni ottimizzate
- Colori ufficiali
- ViewBox corretto per il mantenimento delle proporzioni

#### Best Practices
1. **Dimensioni**
   - Utilizzare classi Tailwind per le dimensioni
   - Mantenere le proporzioni originali (3:2)
   - Esempio: `class="w-6 h-4"`

2. **Accessibilità**
   - Aggiungere attributi `aria-label` quando necessario
   - Fornire testo alternativo per screen reader
   - Esempio:
     ```blade
     <x-ui-flags.it class="w-6 h-4" aria-label="Bandiera italiana" />
     ```

3. **Performance**
   - Gli SVG sono ottimizzati
   - Non richiedono richieste HTTP aggiuntive
   - Caching automatico

4. **Personalizzazione**
   - Possibilità di modificare i colori via CSS
   - Supporto per classi Tailwind
   - Esempio:
     ```blade
     <x-ui-flags.it class="w-6 h-4 text-primary-600" />
     ```

## Collegamenti Correlati
- [Documentazione SVG](./SVG.md)
- [Best Practices UI](./UI_BEST_PRACTICES.md)
- [Guida Componenti](./COMPONENTS_GUIDE.md)

# Componenti UI - Documentazione Generale

Questo documento descrive i componenti UI disponibili nel modulo UI e le loro funzionalità principali.

## Componenti Form

### RadioCollection - Selettori Radio Personalizzabili

Il componente `RadioCollection` offre un'alternativa avanzata ai radio button standard di Filament, permettendo visualizzazioni ricche e personalizzabili per ogni opzione.

#### Caratteristiche Principali
- **Template Personalizzabili**: Ogni opzione può avere un template visivo personalizzato
- **Accessibilità Completa**: Supporto completo per screen reader e navigazione da tastiera
- **Alpine.js Integration**: Feedback visivo immediato con Alpine.js
- **Performance Ottimizzate**: Rendering efficiente anche con molte opzioni
- **Type Safety**: Comparazione type-safe per evitare problemi di type coercion

#### Utilizzo Base
```php
use Modules\UI\Filament\Forms\Components\RadioCollection;

RadioCollection::make('selection')
    ->options(collect([
        (object)['id' => 1, 'name' => 'Opzione 1', 'description' => 'Descrizione 1'],
        (object)['id' => 2, 'name' => 'Opzione 2', 'description' => 'Descrizione 2'],
    ]))
    ->valueKey('id')
    ->itemView('custom.item-template')
    ->required();
```

#### Personalizzazione Template
```php
// Template item personalizzato: resources/views/custom/item-template.blade.php
<div class="space-y-1">
    <h4 class="font-medium text-gray-900 dark:text-gray-100">
        {{ $item->name }}
    </h4>
    <p class="text-sm text-gray-500 dark:text-gray-400">
        {{ $item->description }}
    </p>
</div>
```

#### API Methods
- `options(Collection $options)` - Imposta la collezione di opzioni
- `valueKey(string $key)` - Imposta la chiave da usare come valore (default: 'id')
- `itemView(string $view)` - Imposta il template personalizzato per ogni item

#### Features Filosofiche
- **Fisica Quantistica**: Ogni opzione esiste in superposizione fino alla selezione
- **Fenomenologia**: Interfaccia progettata per minimizzare interruzioni cognitive
- **Gestalt**: Rispetta principi di prossimità, somiglianza e chiusura
- **Zen**: Design minimalista che riduce all'essenziale

[**📖 Documentazione Filosofica Completa**](./components/radio-collection-component.md)

## Componenti Form Filament

### RadioCollection

Componente per la selezione mutuamente esclusiva con interfaccia card personalizzabile.

#### Utilizzo Base
```php
use Modules\UI\Filament\Forms\Components\RadioCollection;

RadioCollection::make('selection')
    ->options(collect([
        (object)['id' => 1, 'name' => 'Opzione 1', 'description' => 'Descrizione 1'],
        (object)['id' => 2, 'name' => 'Opzione 2', 'description' => 'Descrizione 2'],
    ]))
    ->valueKey('id')
    ->itemView('custom.item-template')
    ->required();
```

#### Caratteristiche Avanzate
- **Type Safety**: Comparazione type-safe tra valori per evitare problemi di type coercion
- **Accessibilità**: Supporto completo per screen reader e navigazione keyboard
- **Reattività**: Alpine.js + Livewire per feedback immediato
- **Personalizzazione**: Template item completamente personalizzabile

#### Features Filosofiche
- **Fisica Quantistica**: Ogni opzione esiste in superposizione fino alla selezione
- **Fenomenologia**: Interfaccia progettata per minimizzare interruzioni cognitive
- **Gestalt**: Rispetta principi di prossimità, somiglianza e chiusura
- **Zen**: Design minimalista che riduce all'essenziale

[**📖 Documentazione Filosofica Completa**](./components/radio-collection-component.md)

### LocationSelector

Il componente `LocationSelector` facilita la selezione di posizioni geografiche con supporto per autocompletamento e validazione.

#### Caratteristiche
- Autocompletamento integrato
- Validazione coordinate
- Supporto mappe integrate
- Geocoding automatico

#### Esempi di Utilizzo
```php
LocationSelector::make('address')
    ->enableMap()
    ->required();
```

## Best Practice

1. **Riutilizzabilità**: Progettare componenti modulari e riutilizzabili
2. **Accessibilità**: Seguire sempre le linee guida WCAG 2.1
3. **Performance**: Ottimizzare il rendering e la reattività
4. **Documentazione**: Mantenere documentazione aggiornata con esempi

## Struttura File

```
Modules/UI/resources/views/components/ui/
├── buttons/
├── cards/
├── forms/
└── layout/
```

Tutti i componenti UI condivisi devono essere posizionati in `Modules/UI/resources/views/components/ui/` seguendo la struttura modulare.

## Collegamenti

- [RadioCollection Debugging](./components/radio-collection-debugging.md)
- [RadioCollection Examples](./components/radio-collection-usage-examples.md)
- [UI Components Architecture](../README.md)

*Documentazione aggiornata: Dicembre 2024*
