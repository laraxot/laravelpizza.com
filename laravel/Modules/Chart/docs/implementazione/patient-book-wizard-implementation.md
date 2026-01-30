# Patient Booking Wizard Implementation

## Overview

This document outlines the implementation of the patient booking wizard for the <nome progetto> platform.

Il wizard di prenotazione accessibile da `/it/patient/book` è il flusso principale per permettere ai pazienti di prenotare appuntamenti. Questo documento descrive l'implementazione dettagliata del primo step "Cerca un dentista".

## Design di Riferimento

Il design del primo step è documentato in:

- `/docs/images/9.md` - Analisi dell'interfaccia
- `/docs/images/9.blade.php` - Esempio di implementazione Blade/Volt
- `/docs/images/9.html` - Mockup HTML statico

## Struttura del Wizard

### Step 1: Cerca un dentista

L'interfaccia presenta:

1. **Header**: "Cerca un dentista" con sottotitolo "Compila il seguente modulo"
2. **Form con 3 dropdown**:
   - Regione (es. Lazio)
   - Città (es. Anzio)
   - CAP (es. 00042)
3. **Pulsante CERCA**: Ampio e centrato

### Caratteristiche UI/UX

- Design mobile-first
- Dropdown con sfondo bianco e ombre
- Transizioni progressive per migliorare l'esperienza utente
- Layout responsive che si adatta a desktop e mobile

## Implementazione Tecnica

### 1. Widget Filament

Il widget `FindDoctorAndAppointmentWidget` deve essere aggiornato per:

```php
// Primo step del wizard
protected function getSearchStep(): Wizard\Step
{
    return Wizard\Step::make('search')
        ->label('Cerca un dentista')
        ->description('Compila il seguente modulo')
        ->schema([
            Select::make('region')
                ->label('Regione')
                ->options(fn () => Region::all()->pluck('nome', 'codice'))
                ->searchable()
                ->required()
                ->live()
                ->afterStateUpdated(function (Set $set) {
                    $set('province', null);
                    $set('city', null);
                    $set('cap', null);
                }),
            
            Select::make('city')
                ->label('Città')
                ->options(function (Get $get) {
                    $region = $get('region');
                    if (!$region) return [];
                    
                    // Ottieni tutte le città della regione
                    return City::whereHas('province', function ($query) use ($region) {
                        $query->where('codice_regione', $region);
                    })->pluck('nome', 'id');
                })
                ->searchable()
                ->required()
                ->live()
                ->visible(fn (Get $get) => filled($get('region')))
                ->afterStateUpdated(fn (Set $set) => $set('cap', null)),
            
            Select::make('cap')
                ->label('CAP')
                ->options(function (Get $get) {
                    $city = $get('city');
                    if (!$city) return [];
                    
                    return Cap::where('city_id', $city)
                        ->pluck('code', 'id');
                })
                ->searchable()
                ->required()
                ->visible(fn (Get $get) => filled($get('city')))
        ]);
}
```

### 2. Modelli Geo

Il widget deve utilizzare i modelli corretti dal modulo Geo:

- `Modules\Geo\Models\Region`
- `Modules\Geo\Models\Province`
- `Modules\Geo\Models\City`
- `Modules\Geo\Models\Cap`

### 3. Vista Blade Personalizzata

Per ottenere il design esatto del mockup, creare una vista personalizzata:

```blade
<div class="find-doctor-step">
    <header class="text-center mb-6">
        <h1 class="text-3xl font-bold text-blue-900">Cerca un dentista</h1>
        <p class="text-xl text-gray-500 mt-1">Compila il seguente modulo</p>
    </header>
    
    <div class="space-y-4 max-w-md mx-auto">
        {{ $this->form }}
    </div>
    
    <div class="mt-8">
        <x-filament::button
            wire:click="search"
            class="w-full py-4 text-xl uppercase tracking-wider"
            size="xl"
        >
            CERCA
        </x-filament::button>
    </div>
</div>
```

### 4. Stili CSS Aggiuntivi

Per replicare esattamente il design:

```css
/* Dropdown personalizzati */
.find-doctor-step select {
    @apply rounded-full px-6 py-4 text-xl shadow-md;
}

/* Animazioni dropdown */
.find-doctor-step .dropdown-arrow {
    transition: transform 0.3s ease;
}

.find-doctor-step select:focus + .dropdown-arrow {
    transform: rotate(180deg);
}

/* Background waves */
.wave-background {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    opacity: 0.1;
    z-index: -1;
}
```

## Step Successivi del Wizard

### Step 2: Selezione Data e Orario

- Calendario per selezione data
- Slot orari disponibili
- Integrazione con disponibilità dentisti

### Step 3: Conferma Prenotazione

- Riepilogo dati
- Upload documenti richiesti
- Conferma finale

## Testing

### Test Funzionali

1. Verifica caricamento dinamico città basato su regione
2. Verifica caricamento CAP basato su città
3. Test navigazione tra step del wizard
4. Test validazione form

### Test UI/UX

1. Responsive design su mobile/tablet/desktop
2. Animazioni e transizioni fluide
3. Accessibilità (WCAG compliance)
4. Performance caricamento dati

## Note Implementative

1. **Performance**: Utilizzare cache per le liste di regioni/città/CAP
2. **UX**: Implementare skeleton loader durante caricamento dati
3. **Validazione**: Validare lato client e server
4. **Internazionalizzazione**: Utilizzare file di traduzione per tutti i testi

## Collegamenti

- [Roadmap Frontoffice](../roadmap_frontoffice.md)
- [Patient Book Feature](../roadmap_frontoffice/30-patient-book.md)
- [Calendar Booking System](../../laravel/Modules/<nome progetto>/docs/calendar-booking-system.md)
