# Gestione Contenuti

## Pacchetti Utilizzati

### Core
- [spatie/laravel-medialibrary](https://github.com/spatie/laravel-medialibrary)
  - Gestione file e media
  - Conversione immagini
  - Generazione thumbnails

### Tagging
- [spatie/laravel-tags](https://github.com/spatie/laravel-tags)
  - Sistema di tagging flessibile
  - Ricerca per tag
  - Gestione categorie

## Implementazione

### Media Library
```php
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Page extends Model implements HasMedia
{
    use InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png'])
            ->withResponsiveImages();
    }
}
```

### Tags
```php
use Spatie\Tags\HasTags;

class Page extends Model
{
    use HasTags;

    public function scopeWithTags($query, array $tags)
    {
        return $query->whereHas('tags', function ($query) use ($tags) {
            $query->whereIn('name', $tags);
        });
    }
}
```

## Best Practices

### Media
1. Utilizzare collezioni specifiche per tipo di media
2. Implementare conversione immagini ottimizzata
3. Utilizzare CDN per la distribuzione

### Tags
1. Normalizzare i nomi dei tag
2. Implementare suggerimenti tag
3. Utilizzare cache per query frequenti

## Performance

### Ottimizzazioni
- Implementare lazy loading per le immagini
- Utilizzare cache per i tag più popolari
- Ottimizzare le query di ricerca

### Monitoring
- Tracciare utilizzo storage
- Monitorare performance conversioni
- Analizzare pattern di ricerca

## Collegamenti

- [Torna a packages.md](../packages.md)
- [Performance](performance.md)
- [SEO](seo.md) 
