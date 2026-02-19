# Standard CMS

Questo documento contiene gli standard specifici per il modulo CMS.

## Gestione Contenuti

### Nomenclatura
- Nome in PascalCase
- Prefisso `XotBase` per le classi base
- Suffisso `Content` per i modelli di contenuto
- Suffisso `Block` per i blocchi di contenuto

### Struttura Modelli
```php
namespace Modules\Cms\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class XotBaseContent extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => ContentStatus::class,
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function blocks(): HasMany
    {
        return $this->hasMany(ContentBlock::class);
    }
}
```

### Blocchi di Contenuto
- Componenti riutilizzabili
- Configurazione flessibile
- Versionamento
- Cache intelligente

## Frontend

### Nomenclatura
- Nome in PascalCase
- Prefisso `XotBase` per le classi base
- Suffisso `Page` per le pagine
- Suffisso `Layout` per i layout

### Struttura Pagine
```php
namespace Modules\Cms\app\View\Pages;

use Illuminate\View\View;
use Modules\Cms\app\Models\Content;

class XotBaseContentPage
{
    public function __construct(
        protected Content $content
    ) {}

    public function render(): View
    {
        return view('cms::pages.content', [
            'content' => $this->content,
            'blocks' => $this->content->blocks,
        ]);
    }
}
```

### SEO
- Meta tags dinamici
- Sitemap XML
- Robots.txt
- Structured data

## Performance

### Caching
- Cache a più livelli
- Cache invalidation
- Cache per tenant
- Cache per lingua

### Ottimizzazioni
- Lazy loading immagini
- Minificazione assets
- CDN per media
- Compressione

## Sicurezza

### Contenuti
- Sanitizzazione input
- Validazione output
- Protezione XSS
- Protezione CSRF

### Accesso
- Controlli permessi
- Audit log
- Versionamento
- Backup

## Multilingua

### Traduzioni
- File di traduzione
- Fallback chain
- Pluralizzazione
- Formattazione

### Contenuti
- Traduzioni gestite
- Fallback content
- RTL support
- Date/Time format

## Media

### Gestione
- Upload sicuro
- Ottimizzazione immagini
- CDN integration
- Backup media

### Tipi Supportati
- Immagini
- Documenti
- Video
- Audio

## API

### REST
- Versionamento
- Documentazione
- Rate limiting
- Authentication

### GraphQL
- Schema definition
- Resolvers
- Caching
- Error handling
## Collegamenti tra versioni di README.md
* [README.md](bashscripts/docs/readme.md)
* [README.md](bashscripts/docs/it/readme.md)
* [README.md](docs/laravel-app/phpstan/readme.md)
* [README.md](docs/laravel-app/readme.md)
* [README.md](docs/moduli/struttura/readme.md)
* [README.md](docs/moduli/readme.md)
* [README.md](docs/moduli/manutenzione/readme.md)
* [README.md](docs/moduli/core/readme.md)
* [README.md](docs/moduli/installati/readme.md)
* [README.md](docs/moduli/comandi/readme.md)
* [README.md](docs/phpstan/readme.md)
* [README.md](docs/readme.md)
* [README.md](docs/module-links/readme.md)
* [README.md](docs/troubleshooting/git-conflicts/readme.md)
* [README.md](docs/tecnico/laraxot/readme.md)
* [README.md](docs/modules/readme.md)
* [README.md](docs/conventions/readme.md)
* [README.md](docs/amministrazione/backup/readme.md)
* [README.md](docs/amministrazione/monitoraggio/readme.md)
* [README.md](docs/amministrazione/deployment/readme.md)
* [README.md](docs/translations/readme.md)
* [README.md](docs/roadmap/readme.md)
* [README.md](docs/ide/cursor/readme.md)
* [README.md](docs/implementazione/api/readme.md)
* [README.md](docs/implementazione/testing/readme.md)
* [README.md](docs/implementazione/pazienti/readme.md)
* [README.md](docs/implementazione/ui/readme.md)
* [README.md](docs/implementazione/dental/readme.md)
* [README.md](docs/implementazione/core/readme.md)
* [README.md](docs/implementazione/reporting/readme.md)
* [README.md](docs/implementazione/isee/readme.md)
* [README.md](docs/it/readme.md)
* [README.md](laravel/vendor/mockery/mockery/docs/readme.md)
* [README.md](laravel/modules/chart/docs/readme.md)
* [README.md](laravel/modules/reporting/docs/readme.md)
* [README.md](laravel/modules/gdpr/docs/phpstan/readme.md)
* [README.md](laravel/modules/gdpr/docs/readme.md)
* [README.md](laravel/modules/notify/docs/phpstan/readme.md)
* [README.md](laravel/modules/notify/docs/readme.md)
* [README.md](laravel/modules/xot/docs/filament/readme.md)
* [README.md](laravel/modules/xot/docs/phpstan/readme.md)
* [README.md](laravel/modules/xot/docs/exceptions/readme.md)
* [README.md](laravel/modules/xot/docs/readme.md)
* [README.md](laravel/modules/xot/docs/standards/readme.md)
* [README.md](laravel/modules/xot/docs/conventions/readme.md)
* [README.md](laravel/modules/xot/docs/development/readme.md)
* [README.md](laravel/modules/dental/docs/readme.md)
* [README.md](laravel/modules/user/docs/phpstan/readme.md)
* [README.md](laravel/modules/user/docs/readme.md)
* [README.md](laravel/modules/user/resources/views/docs/readme.md)
* [README.md](laravel/modules/ui/docs/phpstan/readme.md)
* [README.md](laravel/modules/ui/docs/readme.md)
* [README.md](laravel/modules/ui/docs/standards/readme.md)
* [README.md](laravel/modules/ui/docs/themes/readme.md)
* [README.md](laravel/modules/ui/docs/components/readme.md)
* [README.md](laravel/modules/lang/docs/phpstan/readme.md)
* [README.md](laravel/modules/lang/docs/readme.md)
* [README.md](laravel/modules/job/docs/phpstan/readme.md)
* [README.md](laravel/modules/job/docs/readme.md)
* [README.md](laravel/modules/media/docs/phpstan/readme.md)
* [README.md](laravel/modules/media/docs/readme.md)
* [README.md](laravel/modules/tenant/docs/phpstan/readme.md)
* [README.md](laravel/modules/tenant/docs/readme.md)
* [README.md](laravel/modules/activity/docs/phpstan/readme.md)
* [README.md](laravel/modules/activity/docs/readme.md)
* [README.md](laravel/modules/patient/docs/readme.md)
* [README.md](laravel/modules/patient/docs/standards/readme.md)
* [README.md](laravel/modules/patient/docs/value-objects/readme.md)
* [README.md](laravel/modules/cms/docs/blocks/readme.md)
* [README.md](laravel/modules/cms/docs/readme.md)
* [README.md](laravel/modules/cms/docs/standards/readme.md)
* [README.md](laravel/modules/cms/docs/content/readme.md)
* [README.md](laravel/modules/cms/docs/frontoffice/readme.md)
* [README.md](laravel/modules/cms/docs/components/readme.md)
* [README.md](laravel/themes/two/docs/readme.md)
* [README.md](laravel/themes/one/docs/readme.md)
