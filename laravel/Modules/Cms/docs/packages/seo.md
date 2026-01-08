# SEO

## Pacchetti Utilizzati

### Sitemap
- [spatie/laravel-sitemap](https://github.com/spatie/laravel-sitemap)
  - Generazione automatica sitemap
  - Supporto immagini e video
  - Gestione priorità

### SEO
- [spatie/laravel-seo](https://github.com/spatie/laravel-seo)
  - Gestione meta tags
  - Open Graph tags
  - Twitter Cards

## Implementazione

### Sitemap
```php
use Spatie\Sitemap\SitemapGenerator;

SitemapGenerator::create('https://example.com')
    ->writeToFile(public_path('sitemap.xml'));
```

### SEO Tags
```php
use Spatie\Seo\Seo;

class Page extends Model
{
    public function getSeo(): Seo
    {
        return Seo::make()
            ->title($this->title)
            ->description($this->description)
            ->image($this->image);
    }
}
```

## Best Practices

### Sitemap
1. Aggiornare regolarmente
2. Includere solo pagine pubbliche
3. Gestire priorità e frequenza

### Meta Tags
1. Ottimizzare title e description
2. Utilizzare keywords appropriate
3. Implementare schema markup

## Performance

### Ottimizzazioni
- Implementare canonical URLs
- Gestire redirect 301/302
- Ottimizzare immagini
- Implementare breadcrumbs

### Monitoring
- Monitorare ranking
- Analizzare traffico
- Tracciare conversioni
- Monitorare errori

## Tools

### Analisi
- Google Search Console
- Google Analytics
- SEMrush
- Ahrefs

### Validazione
- W3C Validator
- Google Mobile-Friendly Test
- PageSpeed Insights
- Lighthouse

## Collegamenti

- [Torna a packages.md](../packages.md)
- [Performance](performance.md)
- [Analytics](analytics.md) 
