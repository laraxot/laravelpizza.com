# Applicazione dei Principi di Architettura Filament ai Moduli

## Introduzione

Dopo aver studiato il pacchetto `filament-spatie-laravel-database-mail-templates`, possiamo applicare i suoi principi architetturali ad altri moduli del progetto LaravelPizza. Questo documento illustra come estendere questi concetti ai moduli Cms, User e altri.

## Modulo Cms - Sistema di Gestione Contenuti

### Applicazione del Pattern Plugin

Come nel pacchetto studiato, possiamo implementare un'architettura plugin per il modulo Cms:

```php
<?php

namespace Modules\Cms\Filament;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Modules\Cms\Filament\Resources\PageResource;
use Modules\Cms\Filament\Resources\PostResource;
use Modules\Cms\Filament\Resources\MenuResource;

class CmsPlugin implements Plugin
{
    public function getId(): string
    {
        return 'cms';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            PageResource::class,
            PostResource::class,
            MenuResource::class,
            // Altre risorse del CMS
        ]);
    }

    public function boot(Panel $panel): void
    {
        // Logica di inizializzazione specifica del CMS
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
```

### Sistema di Template Contenuti

Basandoci sul sistema di template del pacchetto studiato, possiamo creare un sistema avanzato per i template di contenuto:

```php
<?php

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ContentTemplate extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'html_template',
        'json_schema',
        'ui_schema',
        'variables',
        'default_content',
    ];

    public array $translatable = [
        'name',
        'description',
        'html_template',
        'default_content',
    ];

    protected function casts(): array
    {
        return [
            'variables' => 'array',
            'json_schema' => 'array',
            'ui_schema' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function pages()
    {
        return $this->hasMany(Page::class, 'template_id');
    }
}
```

### UI Specializzata per il CMS

Come nel pacchetto studiato, possiamo creare componenti UI specializzati:

```php
<?php

namespace Modules\Cms\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class ContentTemplateEditor extends Field
{
    protected string $view = 'cms::filament.components.content-template-editor';

    protected function setUp(): void
    {
        parent::setUp();

        $this->dehydrated(false);
    }

    public static function make(string $name = 'content-template-editor'): static
    {
        return parent::make($name)
            ->view('cms::filament.components.content-template-editor');
    }
}
```

## Modulo User - Sistema di Gestione Utenti

### Plugin per la Gestione Utenti

Applicando il pattern plugin anche al modulo User:

```php
<?php

namespace Modules\User\Filament;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Modules\User\Filament\Resources\UserResource;
use Modules\User\Filament\Resources\RoleResource;
use Modules\User\Filament\Resources\PermissionResource;

class UserPlugin implements Plugin
{
    public function getId(): string
    {
        return 'user';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            UserResource::class,
            RoleResource::class,
            PermissionResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        // Inizializzazione specifica per la gestione utenti
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
```

### Sistema di Template Utente

Implementazione di template per le comunicazioni con gli utenti:

```php
<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MailTemplates\Models\MailTemplate as SpatieMailTemplate;

class UserMailTemplate extends SpatieMailTemplate
{
    protected $fillable = [
        'mailable',
        'name',
        'slug',
        'subject',
        'html_template',
        'text_template',
        'variables',
    ];

    protected function casts(): array
    {
        return [
            'variables' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function scopeForUserMailable($query, string $mailableClass)
    {
        return $query->where('mailable', $mailableClass)
                     ->where('type', 'user');
    }
}
```

## Modulo Geo - Sistema di Geolocalizzazione

### Componenti Specializzati per Mappe

Come nel pacchetto studiato, possiamo creare componenti specializzati per la gestione dei dati geografici:

```php
<?php

namespace Modules\Geo\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class LocationPicker extends Field
{
    protected string $view = 'geo::filament.components.location-picker';

    protected function setUp(): void
    {
        parent::setUp();

        $this->dehydrated(false);
    }

    public static function make(string $name = 'location-picker'): static
    {
        return parent::make($name)
            ->view('geo::filament.components.location-picker');
    }
}
```

## Best Practices Generali

### 1. Architettura Modulare

Come osservato nel pacchetto studiato, ogni modulo dovrebbe avere:

- Un plugin principale per la registrazione in Filament
- Risorse organizzate in modo logico
- Componenti UI specializzati
- Servizi dedicati per la logica di business

### 2. Componenti UI Riutilizzabili

I componenti dovrebbero essere progettati per essere riutilizzabili e specializzati per compiti specifici, come nel pacchetto studiato.

### 3. Sistema di Traduzioni

Tutti i moduli dovrebbero sfruttare il sistema di traduzioni integrato, come nel pacchetto studiato.

### 4. Versioning e Storia

Dove appropriato, implementare sistemi di versioning come nel modulo Notify, per mantenere traccia delle modifiche ai contenuti o ai template.

## Conclusione

Applicando i principi architetturali osservati nel pacchetto `filament-spatie-laravel-database-mail-templates`, possiamo creare un'esperienza utente coerente e funzionale in tutti i moduli del progetto LaravelPizza, mantenendo però la specificità e le esigenze di ciascun modulo.
