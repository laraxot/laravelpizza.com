# Footer Component Reference (CMS Module)

Questo documento è un riferimento al componente Footer implementato nel tema One.

## Collegamenti alla Documentazione

- [Documentazione Completa del Footer](/laravel/Themes/One/docs/components/layouts/footer.md)
- [Documentazione Root](/laravel/docs/themes/one/components/footer.md)

## Integrazione con il Modulo CMS

Il componente Footer del tema One può essere utilizzato nel modulo CMS attraverso:

```php
<x-one::layouts.footer />
```

### Personalizzazione nel Contesto CMS

Per personalizzare il footer all'interno del modulo CMS:

1. **Override del Componente**
```php
// Modules/Cms/Resources/views/components/layouts/footer.blade.php
@props(['customLinks' => []])

<x-one::layouts.footer :links="array_merge($customLinks, [
    ['title' => 'Area Amministrativa', 'url' => route('cms.admin')],
])" />
```

2. **Configurazione**
```php
// Modules/Cms/Config/theme.php
return [
    'footer' => [
        'show_admin_links' => true,
        'additional_links' => [
            // link specifici del CMS
        ],
    ],
];
```

## Collegamenti Utili

- [Tema One - Overview](/laravel/Themes/One/docs/README.md)
- [CMS Module - Components](/laravel/Modules/Cms/docs/components.md)
- [Integrazione Temi](/laravel/Modules/Cms/docs/themes.md) 

## Collegamenti tra versioni di footer.md
* [footer.md](docs/laravel-app/themes/one/components/footer.md)
* [footer.md](docs/sections/footer.md)
* [footer.md](laravel/Modules/UI/docs/components/footer.md)
* [footer.md](laravel/Modules/Cms/docs/blocks/footer.md)
* [footer.md](laravel/Modules/Cms/docs/themes/one/footer.md)
* [footer.md](laravel/Modules/Cms/docs/components/footer.md)
* [footer.md](laravel/Themes/One/docs/components/layouts/footer.md)
* [footer.md](laravel/Themes/One/docs/sections/footer.md)

