# Lista Studi Odontoiatrici - <nome progetto>

> **🎯 OBIETTIVO**: Visualizzazione ottimizzata dei risultati di ricerca degli studi odontoiatrici convenzionati

## 📋 Overview

La lista studi presenta i risultati della ricerca geografica con informazioni complete, filtri avanzati, e funzionalità di confronto per aiutare le pazienti a scegliere lo studio più adatto alle loro esigenze.

## 🔧 Componenti Implementati

### 1. Lista Risultati Studi

```php
// Resource: StudioSearchResultsResource
class StudioSearchResultsResource extends XotBaseResource
{
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    ImageColumn::make('logo')
                        ->circular()
                        ->size(60)
                        ->defaultImageUrl('/images/studio-placeholder.png'),
                        
                    TextColumn::make('nome')
                        ->weight(FontWeight::Bold)
                        ->size(TextColumnSize::Large)
                        ->searchable(),
                        
                    TextColumn::make('indirizzo_completo')
                        ->icon('heroicon-o-map-pin')
                        ->color('gray')
                        ->limit(50),
                        
                    TextColumn::make('distanza_km')
                        ->suffix(' km')
                        ->badge()
                        ->color('info')
                        ->sortable(),
                ])->space(2),
                
                Stack::make([
                    TextColumn::make('valutazione_media')
                        ->formatStateUsing(fn ($state) => $this->formatRating($state))
                        ->html(),
                        
                    TextColumn::make('numero_recensioni')
                        ->formatStateUsing(fn ($state) => "({$state} recensioni)")
                        ->color('gray'),
                        
                    TextColumn::make('telefono')
                        ->icon('heroicon-o-phone')
                        ->copyable()
                        ->copyMessage('Numero copiato!'),
                        
                    TextColumn::make('email')
                        ->icon('heroicon-o-envelope')
                        ->copyable()
                        ->limit(30),
                ])->space(1),
                
                Stack::make([
                    TextColumn::make('servizi_disponibili')
                        ->formatStateUsing(fn ($record) => $this->formatServizi($record))
                        ->html()
                        ->wrap(),
                        
                    TextColumn::make('orari_apertura')
                        ->formatStateUsing(fn ($record) => $this->formatOrari($record))
                        ->color('success'),
                        
                    TextColumn::make('prossima_disponibilita')
                        ->formatStateUsing(fn ($record) => $this->getNextAvailability($record))
                        ->badge()
                        ->color(fn ($record) => $this->getAvailabilityColor($record)),
                ])->space(1),
            ])
            ->filters([
                SelectFilter::make('distanza_massima')
                    ->options([
                        5 => 'Entro 5 km',
                        10 => 'Entro 10 km',
                        20 => 'Entro 20 km',
                        50 => 'Entro 50 km',
                    ])
                    ->default(20),
                    
                SelectFilter::make('valutazione_minima')
                    ->options([
                        4.5 => '4.5+ stelle',
                        4.0 => '4+ stelle',
                        3.5 => '3.5+ stelle',
                        3.0 => '3+ stelle',
                    ]),
                    
                SelectFilter::make('servizi')
                    ->multiple()
                    ->options([
                        'prima_visita' => 'Prima Visita',
                        'pulizia_dentale' => 'Pulizia Dentale',
                        'urgenze' => 'Urgenze',
                        'odontoiatria_conservativa' => 'Conservativa',
                        'endodonzia' => 'Endodonzia',
                        'parodontologia' => 'Parodontologia',
                    ]),
                    
                Filter::make('disponibilita_immediata')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => 
                        $query->whereHas('disponibilita', function ($subQuery) {
                            $subQuery->where('data', '>=', now())
                                     ->where('data', '<=', now()->addDays(7))
                                     ->where('prenotato', false);
                        })
                    ),
                    
                Filter::make('accessibile_disabili')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => 
                        $query->where('accessibile_disabili', true)
                    ),
            ])
            ->actions([
                Action::make('visualizza_dettagli')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Studio $record): string => route('studios.show', $record))
                    ->openUrlInNewTab(),
                    
                Action::make('prenota_visita')
                    ->icon('heroicon-o-calendar-plus')
                    ->color('primary')
                    ->url(fn (Studio $record): string => route('appointments.book', $record))
                    ->visible(fn (Studio $record): bool => $this->hasAvailability($record)),
                    
                Action::make('chiama_studio')
                    ->icon('heroicon-o-phone')
                    ->color('success')
                    ->action(fn (Studio $record) => $this->logPhoneClick($record))
                    ->url(fn (Studio $record): string => "tel:{$record->telefono}"),
                    
                Action::make('indicazioni_stradali')
                    ->icon('heroicon-o-map')
                    ->color('info')
                    ->url(fn (Studio $record): string => $this->getDirectionsUrl($record))
                    ->openUrlInNewTab(),
                    
                Action::make('aggiungi_preferiti')
                    ->icon(fn (Studio $record): string => $this->isFavorite($record) ? 'heroicon-s-heart' : 'heroicon-o-heart')
                    ->color(fn (Studio $record): string => $this->isFavorite($record) ? 'danger' : 'gray')
                    ->action(fn (Studio $record) => $this->toggleFavorite($record)),
            ])
            ->defaultSort('distanza_km', 'asc')
            ->paginated([12, 24, 48])
            ->striped()
            ->defaultPaginationPageOption(12);
    }
}
```

### 2. Card Studio Dettagliata

```blade
<div class="studio-card {{ $studio->is_premium ? 'premium' : '' }}">
    <div class="studio-header">
        <div class="studio-logo">
            <img src="{{ $studio->logo_url ?: '/images/studio-placeholder.png' }}" 
                 alt="{{ $studio->nome }}" 
                 class="logo">
            @if($studio->is_premium)
                <span class="premium-badge">Premium</span>
            @endif
        </div>
        
        <div class="studio-info">
            <h3 class="studio-name">{{ $studio->nome }}</h3>
            <p class="studio-address">
                <i class="icon-map-pin"></i>
                {{ $studio->indirizzo_completo }}
            </p>
            <p class="studio-distance">
                <i class="icon-location"></i>
                {{ number_format($studio->distanza_km, 1) }} km da te
            </p>
        </div>
        
        <div class="studio-rating">
            <div class="rating-stars">
                @for($i = 1; $i <= 5; $i++)
                    <span class="star {{ $i <= $studio->valutazione_media ? 'filled' : '' }}">★</span>
                @endfor
                <span class="rating-value">{{ number_format($studio->valutazione_media, 1) }}</span>
            </div>
            <p class="reviews-count">({{ $studio->numero_recensioni }} recensioni)</p>
        </div>
    </div>
    
    <div class="studio-details">
        <div class="contact-info">
            <p class="phone">
                <i class="icon-phone"></i>
                <a href="tel:{{ $studio->telefono }}">{{ $studio->telefono }}</a>
            </p>
            <p class="email">
                <i class="icon-email"></i>
                <a href="mailto:{{ $studio->email }}">{{ $studio->email }}</a>
            </p>
        </div>
        
        <div class="services-offered">
            <h4>Servizi Disponibili</h4>
            <div class="services-tags">
                @foreach($studio->servizi_disponibili as $servizio)
                    <span class="service-tag">{{ $servizio }}</span>
                @endforeach
            </div>
        </div>
        
        <div class="availability-info">
            <h4>Disponibilità</h4>
            <div class="opening-hours">
                @foreach($studio->orari_apertura as $giorno => $orario)
                    <div class="day-hours">
                        <span class="day">{{ $giorno }}</span>
                        <span class="hours">{{ $orario }}</span>
                    </div>
                @endforeach
            </div>
            
            <div class="next-availability">
                <span class="label">Prossima disponibilità:</span>
                <span class="date {{ $studio->availability_class }}">
                    {{ $studio->prossima_disponibilita }}
                </span>
            </div>
        </div>
    </div>
    
    <div class="studio-actions">
        <button class="btn btn-primary" 
                onclick="bookAppointment('{{ $studio->id }}')"
                {{ $studio->hasAvailability() ? '' : 'disabled' }}>
            <i class="icon-calendar"></i>
            Prenota Visita
        </button>
        
        <button class="btn btn-secondary" 
                onclick="viewStudioDetails('{{ $studio->id }}')">
            <i class="icon-eye"></i>
            Dettagli
        </button>
        
        <button class="btn btn-outline" 
                onclick="getDirections('{{ $studio->latitude }}', '{{ $studio->longitude }}')">
            <i class="icon-map"></i>
            Indicazioni
        </button>
        
        <button class="btn btn-icon favorite-btn {{ $studio->is_favorite ? 'active' : '' }}"
                onclick="toggleFavorite('{{ $studio->id }}')"
                title="{{ $studio->is_favorite ? 'Rimuovi dai preferiti' : 'Aggiungi ai preferiti' }}">
            <i class="icon-heart"></i>
        </button>
    </div>
</div>
```

### 3. Filtri Avanzati Sidebar

```blade
<div class="filters-sidebar">
    <div class="filters-header">
        <h3>Filtra Risultati</h3>
        <button onclick="resetAllFilters()" class="reset-filters">
            <i class="icon-refresh"></i>
            Reset
        </button>
    </div>
    
    <div class="filter-group">
        <h4>Distanza</h4>
        <div class="distance-slider">
            <input type="range" id="distance-slider" min="1" max="100" value="20" 
                   oninput="updateDistanceFilter(this.value)">
            <div class="slider-labels">
                <span>1 km</span>
                <span id="current-distance">20 km</span>
                <span>100+ km</span>
            </div>
        </div>
    </div>
    
    <div class="filter-group">
        <h4>Valutazione</h4>
        <div class="rating-filters">
            @for($i = 5; $i >= 3; $i--)
                <label class="rating-filter">
                    <input type="checkbox" value="{{ $i }}" onchange="updateRatingFilter()">
                    <span class="rating-stars">
                        @for($j = 1; $j <= $i; $j++)
                            <span class="star filled">★</span>
                        @endfor
                        @for($j = $i + 1; $j <= 5; $j++)
                            <span class="star">★</span>
                        @endfor
                    </span>
                    <span class="rating-text">{{ $i }}+ stelle</span>
                </label>
            @endfor
        </div>
    </div>
    
    <div class="filter-group">
        <h4>Servizi</h4>
        <div class="service-filters">
            @foreach($servizi_disponibili as $key => $label)
                <label class="service-filter">
                    <input type="checkbox" value="{{ $key }}" onchange="updateServicesFilter()">
                    <span>{{ $label }}</span>
                </label>
            @endforeach
        </div>
    </div>
    
    <div class="filter-group">
        <h4>Caratteristiche</h4>
        <div class="feature-filters">
            <label class="feature-filter">
                <input type="checkbox" value="disponibilita_immediata" onchange="updateFeaturesFilter()">
                <span>Disponibilità entro 7 giorni</span>
            </label>
            <label class="feature-filter">
                <input type="checkbox" value="accessibile_disabili" onchange="updateFeaturesFilter()">
                <span>Accessibile ai disabili</span>
            </label>
            <label class="feature-filter">
                <input type="checkbox" value="parcheggio" onchange="updateFeaturesFilter()">
                <span>Parcheggio disponibile</span>
            </label>
            <label class="feature-filter">
                <input type="checkbox" value="mezzi_pubblici" onchange="updateFeaturesFilter()">
                <span>Vicino mezzi pubblici</span>
            </label>
        </div>
    </div>
</div>
```

## 📱 Layout e UX

### Vista Desktop

```css
.studios-list-container {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 2rem;
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem;
}

.filters-sidebar {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 1.5rem;
    height: fit-content;
    position: sticky;
    top: 2rem;
}

.studios-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
}

.studio-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    padding: 1.5rem;
    transition: transform 0.2s, box-shadow 0.2s;
}

.studio-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}

.studio-card.premium {
    border: 2px solid #ffd700;
    position: relative;
}
```

### Vista Mobile

```css
@media (max-width: 768px) {
    .studios-list-container {
        grid-template-columns: 1fr;
        padding: 1rem;
    }
    
    .filters-sidebar {
        order: 2;
        position: relative;
        top: auto;
    }
    
    .studios-grid {
        grid-template-columns: 1fr;
        order: 1;
    }
    
    .studio-card {
        padding: 1rem;
    }
    
    .studio-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.5rem;
    }
    
    .studio-actions .btn {
        font-size: 0.875rem;
        padding: 0.5rem;
    }
}
```

## 🔍 Funzionalità di Ricerca

### Ricerca Geografica

```php
// Service: GeographicSearchService
class GeographicSearchService
{
    public function searchNearby(array $coordinates, int $radiusKm = 20): Collection
    {
        return Studio::selectRaw('
            studios.*,
            (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * 
            cos(radians(longitude) - radians(?)) + sin(radians(?)) * 
            sin(radians(latitude)))) AS distanza_km
        ', [$coordinates['lat'], $coordinates['lng'], $coordinates['lat']])
        ->having('distanza_km', '<=', $radiusKm)
        ->orderBy('distanza_km')
        ->with(['servizi', 'recensioni', 'disponibilita' => function ($query) {
            $query->where('data', '>=', now())->where('prenotato', false);
        }])
        ->get();
    }
    
    public function searchByAddress(string $address): Collection
    {
        $coordinates = $this->geocodeAddress($address);
        
        if (!$coordinates) {
            throw new InvalidAddressException("Indirizzo non trovato: {$address}");
        }
        
        return $this->searchNearby($coordinates);
    }
}
```

### Algoritmo di Ranking

```php
// Service: StudioRankingService
class StudioRankingService
{
    public function calculateScore(Studio $studio, array $preferences = []): float
    {
        $score = 0;
        
        // Distanza (peso 30%)
        $distanceScore = max(0, (50 - $studio->distanza_km) / 50) * 30;
        $score += $distanceScore;
        
        // Valutazione (peso 25%)
        $ratingScore = ($studio->valutazione_media / 5) * 25;
        $score += $ratingScore;
        
        // Disponibilità (peso 20%)
        $availabilityScore = $this->getAvailabilityScore($studio) * 20;
        $score += $availabilityScore;
        
        // Servizi richiesti (peso 15%)
        if (!empty($preferences['servizi'])) {
            $servicesScore = $this->getServicesScore($studio, $preferences['servizi']) * 15;
            $score += $servicesScore;
        }
        
        // Premium boost (peso 10%)
        if ($studio->is_premium) {
            $score += 10;
        }
        
        return round($score, 2);
    }
}
```

## 📊 Metriche e Analytics

### Tracking Interazioni

```php
// Event: StudioInteractionEvent
class StudioInteractionEvent
{
    public function __construct(
        public Studio $studio,
        public string $action, // 'view', 'call', 'directions', 'favorite', 'book'
        public ?User $user = null
    ) {}
}

// Listener: TrackStudioInteraction
class TrackStudioInteraction
{
    public function handle(StudioInteractionEvent $event): void
    {
        StudioInteractionLog::create([
            'studio_id' => $event->studio->id,
            'user_id' => $event->user?->id,
            'action' => $event->action,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'session_id' => session()->getId(),
        ]);
        
        // Aggiorna contatori in tempo reale
        $this->updateStudioStats($event->studio, $event->action);
    }
}
```

### Dashboard Analytics Studi

```php
// Widget: StudioPerformanceWidget (per amministratori)
class StudioPerformanceWidget extends Widget
{
    public function getStudioStats(): array
    {
        return [
            'visualizzazioni_totali' => StudioInteractionLog::where('action', 'view')->count(),
            'chiamate_generate' => StudioInteractionLog::where('action', 'call')->count(),
            'prenotazioni_generate' => StudioInteractionLog::where('action', 'book')->count(),
            'conversione_media' => $this->calculateConversionRate(),
        ];
    }
}
```

## 🚀 Performance e Ottimizzazioni

### Caching Intelligente

```php
// Cache risultati ricerca per 15 minuti
Cache::remember("studio_search_{$searchKey}", 900, function () use ($params) {
    return $this->performSearch($params);
});

// Cache immagini studio
Cache::remember("studio_images_{$studioId}", 3600, function () use ($studio) {
    return $this->processStudioImages($studio);
});
```

### Lazy Loading

```javascript
// Caricamento progressivo immagini
document.addEventListener('DOMContentLoaded', function() {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                observer.unobserve(img);
            }
        });
    });
    
    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
});
```

## 📱 JavaScript Interattivo

### Gestione Filtri

```javascript
class StudioFilters {
    constructor() {
        this.filters = {
            distance: 20,
            rating: [],
            services: [],
            features: []
        };
        
        this.initializeFilters();
    }
    
    updateDistanceFilter(distance) {
        this.filters.distance = distance;
        document.getElementById('current-distance').textContent = distance + ' km';
        this.applyFilters();
    }
    
    updateRatingFilter() {
        const checkboxes = document.querySelectorAll('.rating-filter input:checked');
        this.filters.rating = Array.from(checkboxes).map(cb => parseInt(cb.value));
        this.applyFilters();
    }
    
    async applyFilters() {
        const loader = document.getElementById('studios-loader');
        loader.style.display = 'block';
        
        try {
            const response = await fetch('/api/studios/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    filters: this.filters,
                    coordinates: this.getUserCoordinates()
                })
            });
            
            const data = await response.json();
            this.updateStudiosList(data.studios);
            this.updateResultsCount(data.total);
            
        } catch (error) {
            console.error('Errore nell\'applicazione dei filtri:', error);
        } finally {
            loader.style.display = 'none';
        }
    }
    
    updateStudiosList(studios) {
        const container = document.getElementById('studios-grid');
        container.innerHTML = studios.map(studio => this.renderStudioCard(studio)).join('');
    }
}

// Inizializza filtri
const studioFilters = new StudioFilters();
```

## 🔗 Collegamenti

### Documenti Correlati
- [Ricerca Studi](./ricerca_studi.md)
- [Calendario Disponibilità](./calendario_disponibilita.md)
- [Conferma Prenotazione](./conferma_prenotazione.md)
- [Sistema Prenotazione](../03_prenotazione_visite.md)

### File Tecnici
- `Modules/<nome progetto>/Filament/Resources/StudioSearchResultsResource.php`
- `Modules/<nome progetto>/Services/GeographicSearchService.php`
- `Modules/<nome progetto>/Services/StudioRankingService.php`

---

**📅 Ultimo aggiornamento**: 5 Giugno 2025  
**👥 Stato sviluppo**: ✅ **Completato** (100%)  
**🔄 Prossimi passi**: Ottimizzazioni performance e ranking intelligente