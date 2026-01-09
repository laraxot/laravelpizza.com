# SEO Multilingua

## Pacchetti Utilizzati

### Core
- [spatie/laravel-translatable](https://github.com/spatie/laravel-translatable)
  - SEO multilingua
  - Meta tags tradotti
  - URL friendly

### Sitemap
- [spatie/laravel-sitemap](https://github.com/spatie/laravel-sitemap)
  - Sitemap multilingua
  - Hreflang tags
  - Priorità per lingua

## Implementazione

### Meta Tags
```php
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasTranslations;

    public $translatable = ['title', 'meta_description', 'meta_keywords'];

    public function getSeoMeta()
    {
        return [
            'title' => $this->getTranslation('title', app()->getLocale()),
            'description' => $this->getTranslation('meta_description', app()->getLocale()),
            'keywords' => $this->getTranslation('meta_keywords', app()->getLocale()),
        ];
    }
}
```

### Sitemap
```php
use Spatie\Sitemap\SitemapGenerator;

$sitemap = SitemapGenerator::create('https://example.com')
    ->getSitemap();

foreach (config('app.supported_locales') as $locale) {
    $sitemap->add(Url::create("/{$locale}")
        ->setPriority(1.0)
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
}
```

## Best Practices

### Meta Tags
1. Implementare hreflang tags
2. Gestire canonical URLs
3. Ottimizzare title e description

### URL
1. Utilizzare struttura URL ottimizzata
2. Implementare redirect 301/302
3. Gestire URL senza prefisso lingua

## Performance

### Ottimizzazioni
- Implementare cache meta tags
- Ottimizzare query sitemap
- Utilizzare CDN per assets

### Monitoring
- Monitorare ranking per lingua
- Analizzare traffico per lingua
- Tracciare conversioni per lingua

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

## Collegamenti

- [Torna a packages.md](../packages.md)
- [Localizzazione](localization.md)
- [Performance](performance.md) 
