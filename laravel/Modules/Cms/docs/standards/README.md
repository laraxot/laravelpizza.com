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
* [README.md](bashscripts/docs/README.md)
* [README.md](bashscripts/docs/it/README.md)
* [README.md](docs/laravel-app/phpstan/README.md)
* [README.md](docs/laravel-app/README.md)
* [README.md](docs/moduli/struttura/README.md)
* [README.md](docs/moduli/README.md)
* [README.md](docs/moduli/manutenzione/README.md)
* [README.md](docs/moduli/core/README.md)
* [README.md](docs/moduli/installati/README.md)
* [README.md](docs/moduli/comandi/README.md)
* [README.md](docs/phpstan/README.md)
* [README.md](docs/README.md)
* [README.md](docs/module-links/README.md)
* [README.md](docs/troubleshooting/git-conflicts/README.md)
* [README.md](docs/tecnico/laraxot/README.md)
* [README.md](docs/modules/README.md)
* [README.md](docs/conventions/README.md)
* [README.md](docs/amministrazione/backup/README.md)
* [README.md](docs/amministrazione/monitoraggio/README.md)
* [README.md](docs/amministrazione/deployment/README.md)
* [README.md](docs/translations/README.md)
* [README.md](docs/roadmap/README.md)
* [README.md](docs/ide/cursor/README.md)
* [README.md](docs/implementazione/api/README.md)
* [README.md](docs/implementazione/testing/README.md)
* [README.md](docs/implementazione/pazienti/README.md)
* [README.md](docs/implementazione/ui/README.md)
* [README.md](docs/implementazione/dental/README.md)
* [README.md](docs/implementazione/core/README.md)
* [README.md](docs/implementazione/reporting/README.md)
* [README.md](docs/implementazione/isee/README.md)
* [README.md](docs/it/README.md)
* [README.md](laravel/vendor/mockery/mockery/docs/README.md)
* [README.md](laravel/Modules/Chart/docs/README.md)
* [README.md](laravel/Modules/Reporting/docs/README.md)
* [README.md](laravel/Modules/Gdpr/docs/phpstan/README.md)
* [README.md](laravel/Modules/Gdpr/docs/README.md)
* [README.md](laravel/Modules/Notify/docs/phpstan/README.md)
* [README.md](laravel/Modules/Notify/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/filament/README.md)
* [README.md](laravel/Modules/Xot/docs/phpstan/README.md)
* [README.md](laravel/Modules/Xot/docs/exceptions/README.md)
* [README.md](laravel/Modules/Xot/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/standards/README.md)
* [README.md](laravel/Modules/Xot/docs/conventions/README.md)
* [README.md](laravel/Modules/Xot/docs/development/README.md)
* [README.md](laravel/Modules/Dental/docs/README.md)
* [README.md](laravel/Modules/User/docs/phpstan/README.md)
* [README.md](laravel/Modules/User/docs/README.md)
* [README.md](laravel/Modules/User/resources/views/docs/README.md)
* [README.md](laravel/Modules/UI/docs/phpstan/README.md)
* [README.md](laravel/Modules/UI/docs/README.md)
* [README.md](laravel/Modules/UI/docs/standards/README.md)
* [README.md](laravel/Modules/UI/docs/themes/README.md)
* [README.md](laravel/Modules/UI/docs/components/README.md)
* [README.md](laravel/Modules/Lang/docs/phpstan/README.md)
* [README.md](laravel/Modules/Lang/docs/README.md)
* [README.md](laravel/Modules/Job/docs/phpstan/README.md)
* [README.md](laravel/Modules/Job/docs/README.md)
* [README.md](laravel/Modules/Media/docs/phpstan/README.md)
* [README.md](laravel/Modules/Media/docs/README.md)
* [README.md](laravel/Modules/Tenant/docs/phpstan/README.md)
* [README.md](laravel/Modules/Tenant/docs/README.md)
* [README.md](laravel/Modules/Activity/docs/phpstan/README.md)
* [README.md](laravel/Modules/Activity/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/standards/README.md)
* [README.md](laravel/Modules/Patient/docs/value-objects/README.md)
* [README.md](laravel/Modules/Cms/docs/blocks/README.md)
* [README.md](laravel/Modules/Cms/docs/README.md)
* [README.md](laravel/Modules/Cms/docs/standards/README.md)
* [README.md](laravel/Modules/Cms/docs/content/README.md)
* [README.md](laravel/Modules/Cms/docs/frontoffice/README.md)
* [README.md](laravel/Modules/Cms/docs/components/README.md)
* [README.md](laravel/Themes/Two/docs/README.md)
* [README.md](laravel/Themes/One/docs/README.md)

