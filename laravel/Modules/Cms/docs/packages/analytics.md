# Analytics

## Pacchetti Utilizzati

### Google Analytics
- [spatie/laravel-analytics](https://github.com/spatie/laravel-analytics)
  - Integrazione Google Analytics
  - Query builder
  - Cache support

## Implementazione

### Analytics
```php
use Spatie\Analytics\Analytics;
use Spatie\Analytics\Period;

class AnalyticsController extends Controller
{
    public function index(Analytics $analytics)
    {
        $visitors = $analytics->fetchVisitorsAndPageViews(Period::days(7));
        $topPages = $analytics->fetchMostVisitedPages(Period::days(7));
        
        return view('analytics', compact('visitors', 'topPages'));
    }
}
```

## Best Practices

### Tracking
1. Implementare event tracking
2. Configurare e-commerce tracking
3. Utilizzare custom dimensions

### Privacy
1. Rispettare GDPR
2. Implementare cookie consent
3. Anonimizzare IP

## Performance

### Ottimizzazioni
- Implementare cache per query frequenti
- Utilizzare batch processing
- Ottimizzare query complesse

### Monitoring
- Monitorare API limits
- Tracciare errori
- Analizzare performance

## Tools

### Analytics
- Google Analytics 4
- Google Tag Manager
- Google Data Studio
- Google Optimize

### Testing
- Google Analytics Debugger
- Tag Assistant
- Data Layer Inspector

## Collegamenti

- [Torna a packages.md](../packages.md)
- [SEO](seo.md)
- [Performance](performance.md) 
