# 🌐 Cms - Il SISTEMA di GESTIONE CONTENUTI più AVANZATO! 📝

<!-- Dynamic validation badges -->
[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![Filament 4.x](https://img.shields.io/badge/Filament-3.x-blue.svg)](https://filamentphp.com/)
[![PHPStan Level 9](https://img.shields.io/badge/PHPStan-Level%209-brightgreen.svg)](https://phpstan.org/)
[![Translation Ready](https://img.shields.io/badge/Translation-IT%20%7C%20EN%20%7C%20DE-green.svg)](https://laravel.com/docs/localization)
[![Folio Routes](https://img.shields.io/badge/Folio-File%20Routes-purple.svg)](https://laravel.com/docs/folio)
[![Volt Components](https://img.shields.io/badge/Volt-Single%20File%20Components-orange.svg)](https://laravel.com/docs/volt)
[![Pest Tests](https://img.shields.io/badge/Pest%20Tests-✅%20Passing-brightgreen.svg)](tests/)
[![PHP Version](https://img.shields.io/badge/PHP-8.3+-blue.svg)](https://php.net)

Un modulo CMS modulare, estensibile e riutilizzabile per Laravel, con supporto per Filament, Volt e Folio.

## Caratteristiche

- Gestione pagine e contenuti
- Blocchi di contenuto personalizzabili
- Menu e navigazione
- Gestione media
- Layout e temi
- API RESTful e GraphQL
- Pannello amministrativo con Filament
- Componenti reattivi con Volt
- Routing basato su file con Folio

## Requisiti

- PHP 8.2+
- Laravel 11.x
- Filament 4.x
- Laravel Volt
- Laravel Folio
- Composer

## Installazione

```bash
composer require modules/cms
```

Pubblicare le risorse:

```bash
php artisan vendor:publish --provider="Modules\Cms\Providers\CmsServiceProvider"
```

Eseguire le migrazioni:

```bash
php artisan module:migrate cms
```

## Configurazione

Il modulo può essere configurato tramite il file `config/cms.php`:

```php
return [
    'prefix' => 'cms',
    'middleware' => ['web', 'auth'],
    'cache' => [
        'enabled' => true,
        'ttl' => 3600
    ],
    'media' => [
        'disk' => 'public',
        'path' => 'media'
    ]
];
```

## Utilizzo

### Creazione Pagina

```php
use Modules\Cms\Actions\CreatePageAction;

$page = app(CreatePageAction::class)->execute([
    'title' => 'La mia pagina',
    'slug' => 'la-mia-pagina',
    'content' => 'Contenuto della pagina'
]);
```

### Aggiunta Blocco

```php
use Modules\Cms\Actions\AddBlockAction;

$block = app(AddBlockAction::class)->execute($page, [
    'type' => 'text',
    'content' => 'Contenuto del blocco'
]);
```

### Componente Volt

```php
use Livewire\Volt\Component;

class PageEditor extends Component
{
    public Page $page;
    
    public function save(): void
    {
        $this->page->save();
    }
}
```

### Pagina Folio

```php
use Illuminate\View\View;

class Show
{
    public function __invoke(Page $page): View
    {
        return view('cms::pages.show', [
            'page' => $page
        ]);
    }
}
```

## Documentazione

- [Architettura](docs/architecture.md)
- [Tecnologie](docs/technologies.md)
- [Frontend](docs/frontoffice/README.md)
- [API](docs/api/README.md)
- [Sviluppo](docs/developer/README.md)
- [Utente](docs/user/README.md)

## Testing

```bash
composer test
```

## Contribuire

Le pull request sono benvenute. Per modifiche importanti, aprire prima una issue per discutere la modifica proposta.

## Licenza

MIT
