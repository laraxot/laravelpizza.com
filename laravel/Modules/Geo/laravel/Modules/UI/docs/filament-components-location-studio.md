# Componenti Filament per Location e Studio Selection

## Overview

Questi componenti Filament sono stati creati per supportare la selezione geografica e la gestione degli studi odontoiatrici nel widget `FindDoctorAndAppointmentWidget` del modulo <nome progetto>.

## Componenti Implementati

### 1. LocationSelector Component

**Percorso**: `app/Filament/Forms/Components/LocationSelector.php`

#### Descrizione
Componente Filament per la selezione gerarchica di Regione → Provincia → CAP con aggiornamenti live e integrazione con il modulo Geo.

#### Caratteristiche
- ✅ **Selezione Gerarchica**: Regione → Provincia → CAP
- ✅ **Live Updates**: I campi si aggiornano automaticamente
- ✅ **Integrazione Geo**: Utilizza i modelli del modulo Geo
- ✅ **Validazione Cascata**: I campi dipendenti si validano automaticamente
- ✅ **Personalizzazione**: Campi field names configurabili

#### Utilizzo Base

```php
use Modules\UI\Filament\Forms\Components\LocationSelector;

// Utilizzo semplice
LocationSelector::make()
    ->required()

// Utilizzo con field names personalizzati
LocationSelector::make()
    ->regionField('region_code')
    ->provinceField('province_code')
    ->capField('postal_code')
    ->required()
```

### 2. StudioSelector Component (Semplificato)

**Percorso**: `laravel/Modules/UI/resources/views/components/ui/studio-selector.blade.php`

#### Descrizione
Componente Blade per la selezione di studi odontoiatrici tramite pulsanti radio-style che popolano un TextInput.

#### Caratteristiche
- ✅ **Pulsanti Radio-Style**: Selezione singola con visual feedback
- ✅ **Informazioni Compatte**: Nome, indirizzo, contatti essenziali
- ✅ **Empty States**: Gestione caso nessuno studio trovato
- ✅ **Integrazione Livewire**: wire:click automatico
- ✅ **Layout Responsive**: Ottimizzato mobile/desktop

#### Utilizzo Base

```blade
<x-ui::ui.studio-selector
    :studios="$studios"
    :selected-studio="$selectedStudioId"
    target-field="selected_studio"
/>
```

## Integrazione nel FindDoctorAndAppointmentWidget

### Step 1: Search Step (Aggiornato)

```php
protected function getSearchStepSchema(): array
{
    return [
        LocationSelector::make()
            ->regionField('region')
            ->provinceField('province')
            ->capField('cap')
            ->required()
            ->searchable()
    ];
}
```

### Step 2: Studio Step (Semplificato)

```php
protected function getStudioStepSchema(): array
{
    return [
        // Titolo step
        View::make('<nome progetto>::filament.widgets.studio-step-header')
            ->viewData([
                'studiosCount' => $this->getStudiosCount(),
                'geographicArea' => $this->getGeographicAreaName(),
            ])
            ->visible(fn (): bool => $this->hasValidGeographicSelection()),

        // Pulsanti selezione studio
        View::make('<nome progetto>::filament.widgets.studio-selector')
            ->viewData([
                'studios' => $this->getStudiosForSelectedArea(),
                'selectedStudio' => $this->data['selected_studio'] ?? null,
            ])
            ->visible(fn (): bool => $this->hasValidGeographicSelection()),

        // TextInput per mostrare studio selezionato
        TextInput::make('selected_studio_name')
            ->label(__('<nome progetto>::widgets.find_doctor.fields.selected_studio.label'))
            ->placeholder(__('<nome progetto>::widgets.find_doctor.fields.selected_studio.placeholder'))
            ->readonly()
            ->visible(fn (): bool => !empty($this->data['selected_studio']))
            ->suffixIcon('heroicon-o-check-circle')
            ->suffixIconColor('success'),

        // Hidden field per memorizzare ID studio
        Hidden::make('selected_studio'),
    ];
}
```

### Azione Livewire Semplificata

```php
/**
 * Azione Livewire per selezione studio (popola TextInput)
 */
public function selectStudio(int $studioId): void
{
    $studio = Studio::find($studioId);

    if (!$studio || !$studio->active) {
        $this->addError('selected_studio', 'Studio non disponibile');
        return;
    }

    // Aggiorna i dati del form
    $this->data['selected_studio'] = $studioId;
    $this->data['selected_studio_name'] = $studio->name;

    // Notifica il cambio di stato
    $this->dispatch('studio-selected', studioId: $studioId, studioName: $studio->name);
}
```

## Flusso UX Semplificato

### 1. **Step Selezione Area**
- Utente seleziona Regione → Provincia → CAP
- Live updates automatici tra i campi
- Validazione cascata

### 2. **Step Selezione Studio**
- Visualizzazione pulsanti per ogni studio nell'area
- Click su pulsante = selezione studio
- Visual feedback immediato (radio indicator + colori)
- TextInput readonly mostra studio selezionato

### 3. **Vantaggi Approccio Semplificato**
- ✅ **UX Intuitiva**: Pattern radio button familiare
- ✅ **Performance**: Meno componenti complessi
- ✅ **Manutenibilità**: Logica più semplice
- ✅ **Accessibilità**: Supporto keyboard navigation
- ✅ **Mobile Friendly**: Touch target ottimizzati

## Performance e Ottimizzazioni

### Caching Strategy
```php
// Cache risultati studio per area
protected function getStudiosForSelectedArea(): Collection
{
    $cacheKey = "studios_area_{$this->data['region']}_{$this->data['province']}_{$this->data['cap']}";

    return cache()->remember($cacheKey, 300, function () {
        return Studio::query()
            ->active()
            ->with(['addresses'])
            ->whereHas('addresses', function ($query) {
                $query->where('region_code', $this->data['region'])
                      ->where('province_code', $this->data['province'])
                      ->where('postal_code', $this->data['cap']);
            })
            ->limit(10)
            ->get();
    });
}
```

## Testing

### Test Funzionale Semplificato
```php
class FindDoctorWidgetStep2Test extends TestCase
{
    /** @test */
    public function clicking_studio_button_populates_textinput()
    {
        $studio = Studio::factory()->create(['name' => 'Studio Test']);

        $widget = Livewire::test(FindDoctorAndAppointmentWidget::class)
            ->set('data.region', '12')
            ->set('data.province', 'RM')
            ->set('data.cap', '00042')
            ->call('selectStudio', $studio->id);

        $widget->assertSet('data.selected_studio', $studio->id)
               ->assertSet('data.selected_studio_name', 'Studio Test');
    }
}
```

## Migration da Approccio Complesso

### Prima (Complesso)
- StudioCard con molte informazioni
- Azioni multiple (Prenota, Dettagli, Contatti)
- Layout complesso responsive

### Dopo (Semplificato)
- Pulsanti radio-style semplici
- Informazioni essenziali (nome, indirizzo)
- Un'azione sola: selezione studio
- TextInput readonly per conferma

## Best Practices

### 1. **Semplicità Prima di Tutto**
- Componenti focalizzati su un singolo scopo
- UX patterns familiari (radio buttons)
- Meno stato da gestire

### 2. **Performance**
- Componenti Blade leggeri
- Cache appropriato per query
- Lazy loading quando possibile

### 3. **Accessibilità**
- Supporto keyboard navigation
- ARIA labels appropriati
- Contrasti colori sufficienti
- Touch targets ottimizzati

---

**Creato**: 26 Giugno 2025
**Versione**: 2.0 - Semplificato
**Stato**: Implementation Ready
**Approccio**: Pulsanti + TextInput (semplice e diretto)
# Componenti Filament per Location e Studio Selection

## Overview

Questi componenti Filament sono stati creati per supportare la selezione geografica e la gestione degli studi odontoiatrici nel widget `FindDoctorAndAppointmentWidget` del modulo <nome progetto>.
Questi componenti Filament sono stati creati per supportare la selezione geografica e la gestione degli studi odontoiatrici nel widget `FindDoctorAndAppointmentWidget` del modulo <nome progetto>.
Questi componenti Filament sono stati creati per supportare la selezione geografica e la gestione degli studi odontoiatrici nel widget `FindDoctorAndAppointmentWidget` del modulo <nome progetto>.

## Componenti Implementati

### 1. LocationSelector Component

**Percorso**: `app/Filament/Forms/Components/LocationSelector.php`

#### Descrizione
Componente Filament per la selezione gerarchica di Regione → Provincia → CAP con aggiornamenti live e integrazione con il modulo Geo.

#### Caratteristiche
- ✅ **Selezione Gerarchica**: Regione → Provincia → CAP
- ✅ **Live Updates**: I campi si aggiornano automaticamente
- ✅ **Integrazione Geo**: Utilizza i modelli del modulo Geo
- ✅ **Validazione Cascata**: I campi dipendenti si validano automaticamente
- ✅ **Personalizzazione**: Campi field names configurabili

#### Utilizzo Base

```php
use Modules\UI\Filament\Forms\Components\LocationSelector;

// Utilizzo semplice
LocationSelector::make()
    ->required()

// Utilizzo con field names personalizzati
LocationSelector::make()
    ->regionField('region_code')
    ->provinceField('province_code')
    ->capField('postal_code')
    ->required()
```

### 2. StudioSelector Component (Semplificato)

**Percorso**: `laravel/Modules/UI/resources/views/components/ui/studio-selector.blade.php`

#### Descrizione
Componente Blade per la selezione di studi odontoiatrici tramite pulsanti radio-style che popolano un TextInput.

#### Caratteristiche
- ✅ **Pulsanti Radio-Style**: Selezione singola con visual feedback
- ✅ **Informazioni Compatte**: Nome, indirizzo, contatti essenziali
- ✅ **Empty States**: Gestione caso nessuno studio trovato
- ✅ **Integrazione Livewire**: wire:click automatico
- ✅ **Layout Responsive**: Ottimizzato mobile/desktop

#### Utilizzo Base

```blade
<x-ui::ui.studio-selector
    :studios="$studios"
    :selected-studio="$selectedStudioId"
    target-field="selected_studio"
/>
```

## Integrazione nel FindDoctorAndAppointmentWidget

### Step 1: Search Step (Aggiornato)

```php
protected function getSearchStepSchema(): array
{
    return [
        LocationSelector::make()
            ->regionField('region')
            ->provinceField('province')
            ->capField('cap')
            ->required()
            ->searchable()
    ];
}
```

### Step 2: Studio Step (Semplificato)

```php
protected function getStudioStepSchema(): array
{
    return [
        // Titolo step
        View::make('<nome progetto>::filament.widgets.studio-step-header')
        View::make('<nome progetto>::filament.widgets.studio-step-header')
        View::make('<nome progetto>::filament.widgets.studio-step-header')
            ->viewData([
                'studiosCount' => $this->getStudiosCount(),
                'geographicArea' => $this->getGeographicAreaName(),
            ])
            ->visible(fn (): bool => $this->hasValidGeographicSelection()),

        // Pulsanti selezione studio
        View::make('<nome progetto>::filament.widgets.studio-selector')
        View::make('<nome progetto>::filament.widgets.studio-selector')
        View::make('<nome progetto>::filament.widgets.studio-selector')
            ->viewData([
                'studios' => $this->getStudiosForSelectedArea(),
                'selectedStudio' => $this->data['selected_studio'] ?? null,
            ])
            ->visible(fn (): bool => $this->hasValidGeographicSelection()),

        // TextInput per mostrare studio selezionato
        TextInput::make('selected_studio_name')
            ->label(__('<nome progetto>::widgets.find_doctor.fields.selected_studio.label'))
            ->placeholder(__('<nome progetto>::widgets.find_doctor.fields.selected_studio.placeholder'))
            ->label(__('<nome progetto>::widgets.find_doctor.fields.selected_studio.label'))
            ->placeholder(__('<nome progetto>::widgets.find_doctor.fields.selected_studio.placeholder'))
            ->label(__('<nome progetto>::widgets.find_doctor.fields.selected_studio.label'))
            ->placeholder(__('<nome progetto>::widgets.find_doctor.fields.selected_studio.placeholder'))
            ->readonly()
            ->visible(fn (): bool => !empty($this->data['selected_studio']))
            ->suffixIcon('heroicon-o-check-circle')
            ->suffixIconColor('success'),

        // Hidden field per memorizzare ID studio
        Hidden::make('selected_studio'),
    ];
}
```

### Azione Livewire Semplificata

```php
/**
 * Azione Livewire per selezione studio (popola TextInput)
 */
public function selectStudio(int $studioId): void
{
    $studio = Studio::find($studioId);

    if (!$studio || !$studio->active) {
        $this->addError('selected_studio', 'Studio non disponibile');
        return;
    }

    // Aggiorna i dati del form
    $this->data['selected_studio'] = $studioId;
    $this->data['selected_studio_name'] = $studio->name;

    // Notifica il cambio di stato
    $this->dispatch('studio-selected', studioId: $studioId, studioName: $studio->name);
}
```

## Flusso UX Semplificato

### 1. **Step Selezione Area**
- Utente seleziona Regione → Provincia → CAP
- Live updates automatici tra i campi
- Validazione cascata

### 2. **Step Selezione Studio**
- Visualizzazione pulsanti per ogni studio nell'area
- Click su pulsante = selezione studio
- Visual feedback immediato (radio indicator + colori)
- TextInput readonly mostra studio selezionato

### 3. **Vantaggi Approccio Semplificato**
- ✅ **UX Intuitiva**: Pattern radio button familiare
- ✅ **Performance**: Meno componenti complessi
- ✅ **Manutenibilità**: Logica più semplice
- ✅ **Accessibilità**: Supporto keyboard navigation
- ✅ **Mobile Friendly**: Touch target ottimizzati

## Performance e Ottimizzazioni

### Caching Strategy
```php
// Cache risultati studio per area
protected function getStudiosForSelectedArea(): Collection
{
    $cacheKey = "studios_area_{$this->data['region']}_{$this->data['province']}_{$this->data['cap']}";

    return cache()->remember($cacheKey, 300, function () {
        return Studio::query()
            ->active()
            ->with(['addresses'])
            ->whereHas('addresses', function ($query) {
                $query->where('region_code', $this->data['region'])
                      ->where('province_code', $this->data['province'])
                      ->where('postal_code', $this->data['cap']);
            })
            ->limit(10)
            ->get();
    });
}
```

## Testing

### Test Funzionale Semplificato
```php
class FindDoctorWidgetStep2Test extends TestCase
{
    /** @test */
    public function clicking_studio_button_populates_textinput()
    {
        $studio = Studio::factory()->create(['name' => 'Studio Test']);

        $widget = Livewire::test(FindDoctorAndAppointmentWidget::class)
            ->set('data.region', '12')
            ->set('data.province', 'RM')
            ->set('data.cap', '00042')
            ->call('selectStudio', $studio->id);

        $widget->assertSet('data.selected_studio', $studio->id)
               ->assertSet('data.selected_studio_name', 'Studio Test');
    }
}
```

## Migration da Approccio Complesso

### Prima (Complesso)
- StudioCard con molte informazioni
- Azioni multiple (Prenota, Dettagli, Contatti)
- Layout complesso responsive

### Dopo (Semplificato)
- Pulsanti radio-style semplici
- Informazioni essenziali (nome, indirizzo)
- Un'azione sola: selezione studio
- TextInput readonly per conferma

## Best Practices

### 1. **Semplicità Prima di Tutto**
- Componenti focalizzati su un singolo scopo
- UX patterns familiari (radio buttons)
- Meno stato da gestire

### 2. **Performance**
- Componenti Blade leggeri
- Cache appropriato per query
- Lazy loading quando possibile

### 3. **Accessibilità**
- Supporto keyboard navigation
- ARIA labels appropriati
- Contrasti colori sufficienti
- Touch targets ottimizzati

---

**Creato**: 26 Giugno 2025
**Versione**: 2.0 - Semplificato
**Stato**: Implementation Ready
**Approccio**: Pulsanti + TextInput (semplice e diretto)
