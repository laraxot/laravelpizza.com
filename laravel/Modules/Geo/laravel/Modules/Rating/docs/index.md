# Rating Module

Sistema di valutazione e rating per la piattaforma con supporto per diverse entità e filtraggio avanzato.

## Overview

Il modulo **Rating** fornisce funzionalità di valutazione polimorfiche:

- ⭐ **Rating System** - Valutazioni numeriche (1-5 stelle) su qualsiasi entità
- 👥 **Gestione Utenti** - Tracking autore rating, prevenzione duplicati
- 📊 **Aggregazioni** - Media voti, conteggi, trending
- 🎨 **Interfaccia Filament** - Gestione admin con Filament 5.x
- 🌐 **Multi-lingua** - Traduzioni IT/EN
- ✅ **PHPStan Level 9** - Compliance statica completa

## Key Features

### Rating Management
- Valutazioni numeriche (1-5 stelle)
- Commenti opzionali per ogni voto
- Relazioni polimorfiche (rate qualsiasi modello)
- Prevenzione voti duplicati per utente
- Update/modifica rating esistente

### Filtering & Analytics
- Filtro per range voti (es. solo 4-5 stelle)
- Ordinamento per rating, data, utenti attivi
- Aggregazioni (media, conteggio, distribuzione)
- Trend detection (rising products)

### User Experience
- Widget di rating visuale
- Responsive design
- Notifiche per nuovi rating
- Rating history per utente

## Architecture

```
Rating/
├── app/
│   ├── Models/
│   │   ├── Rating.php
│   │   └── RatingEnum.php
│   ├── Actions/
│   │   ├── CreateRatingAction.php
│   │   └── UpdateRatingAction.php
│   ├── Filament/
│   │   ├── Resources/
│   │   └── Pages/
│   └── Events/
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
├── lang/
│   ├── it/
│   └── en/
└── docs/
```

**Base Classes**: `XotBaseModel`, `XotBaseResource`

## Core Components

### Models
- **Rating** - Modello principale per rating
- **RatingEnum** - Valori numerici (1, 2, 3, 4, 5 stelle)
- Relazioni polimorfiche (`rateable`)
- Relation con User (autore del voto)

### Filament Resources
- **RatingResource** - Gestione admin rating
- Filtri per entità, valore, autore
- Bulk actions (approvazione, eliminazione)
- Column per media e conteggio

### Events
- `RatingCreated` - Evento creazione rating
- `RatingUpdated` - Evento aggiornamento rating
- Trigger aggregazioni e cache invalidation

## Implementation Guide

### Quick Start
```bash
# Abilitare il modulo
php artisan module:enable Rating

# Eseguire migrazioni
php artisan migrate

# Seeder dati esempio
php artisan db:seed --class=RatingSeeder
```

### Creazione Rating
```php
$rating = Rating::create([
    'user_id' => $user->id,
    'rateable_type' => Product::class,
    'rateable_id' => $product->id,
    'rating' => 5,
    'comment' => 'Ottimo prodotto!',
]);

// Oppure tramite action
app(CreateRatingAction::class)->execute([
    'user_id' => auth()->id(),
    'rateable_type' => Product::class,
    'rateable_id' => $product->id,
    'rating' => 4,
]);
```

### Query Aggregazioni
```php
// Media rating
$avgRating = Rating::where('rateable_type', Product::class)
    ->where('rateable_id', $productId)
    ->average('rating');

// Distribuzione voti (per histogram)
$distribution = Rating::where('rateable_type', Product::class)
    ->where('rateable_id', $productId)
    ->groupBy('rating')
    ->selectRaw('rating, count(*) as count')
    ->get();
```

## Best Practices

### Data Quality
- Validate rating value in range [1, 5]
- Check user authorization prima di allow rating
- Prevent duplicate rating da stesso user (update existing)
- Sanitize commenti (no spam, no profanity)

### Performance
- Index su `rateable_type`, `rateable_id`, `user_id`
- Cache media rating per entità
- Paginate rating lists (20 per pagina)
- Lazy load commenti dettagliati

### User Experience
- Star UI feedback (hover highlight)
- Validazione real-time
- Success message post-submit
- Loading state durante submit

### Privacy
- Mostrar nome autore opzionale
- Option per rating anonimo
- Respect user privacy settings
- GDPR compliance (cancellazione dati utente)

## Related Modules

- [User Module](../User/docs/) - Autori rating
- [Product Module](../Product/docs/) - Prodotti (se exists)
- [Activity Module](../Activity/docs/) - Activity logging
- [Notify Module](../Notify/docs/) - Notifiche rating
- [Xot Module](../Xot/docs/) - Base classes

## Troubleshooting

**Duplicate rating error**
- Verificare constraint unique su (user_id, rateable_type, rateable_id)
- Implementare find-or-create pattern per updates
- Check model method `hasRatedBy($user)`

**Cache not updating dopo nuovo rating**
- Invalidare cache in event listener
- Verificare cache key pattern
- Force clear: `php artisan cache:clear`

**Rating not visible nel frontend**
- Check visibility query scopes
- Verify eager loading relazioni
- Ensure policy autorizzazione consente read

## Documentation

Vedi anche:
- [README](README.md) - Panoramica
- [PRD](PRD.md) - Product requirements
- [Architecture Rules](architecture-rules.md) - Regole architetturali
- [Best Practices](best-practices.md) - Pattern consolidati
- [PHPStan Fixes](phpstan-fixes.md) - Conformità statica

---

**Status**: Active Development  
**PHPStan Level**: Target Level 9  
**Translation**: IT/EN ✅  
**Last Updated**: 2026-05-13
