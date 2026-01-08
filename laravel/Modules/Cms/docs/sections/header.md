# Sezione Header

## Panoramica
La sezione header è un componente fondamentale che gestisce la navigazione principale del FrontOffice. Viene renderizzata iterando i blocchi definiti in JSON e includendo le relative Blade:

```blade
@props(['section', 'blocks'])
@php
  $locale = app()->getLocale();
  $componentsBlocks = is_array($blocks) && isset($blocks[$locale]) ? $blocks[$locale] : $blocks;
@endphp

<header {{ $attributes->merge([ ... ]) }}>
  @foreach($componentsBlocks as $block)
    @include($block->view, $block->data)
  @endforeach
</header>
```

## Struttura JSON
I dati dell'header si trovano in:
```
config/local/{tenant}/database/content/sections/1.json
```
Esempio:
```json
{
  "id": "1",
  "name": { "it": "Header Principale", "en": "Main Header" },
  "slug": "header",
  "blocks": {
    "it": [
      {
        "type": "logo",
        "data": {
          "view": "pub_theme::components.blocks.logo",
          "src": "/images/logo.svg",
          "alt":  "Logo",
          "width": 150,
          "height": 32
        }
      },
      {
        "type": "navigation",
        "data": {
          "view": "pub_theme::components.blocks.navigation",
          "items": [...]
        }
      },
      {
        "type": "language-switcher",
        "data": {
          "view": "pub_theme::components.blocks.language-switcher",
          "languages": [
            {
              "code": "it",
              "name": "Italiano",
              "flag": "/images/flags/it.svg"
            },
            {
              "code": "en",
              "name": "English",
              "flag": "/images/flags/en.svg"
            }
          ],
          "current": "it"
        }
      },
      {
        "type": "user-menu",
        "data": {
          "view": "pub_theme::components.blocks.user-menu",
          "avatar": {
            "src": "/images/avatar.png",
            "alt": "User Avatar"
          },
          "items": [
            {
              "label": "Profilo",
              "url": "/profile",
              "icon": "user"
            },
            {
              "label": "Impostazioni",
              "url": "/settings",
              "icon": "cog"
            },
            {
              "label": "Logout",
              "url": "/logout",
              "icon": "logout",
              "method": "post"
            }
          ]
        }
      }
    ]
  },
  "attributes": { "class": "...", "id": "main-header", "style": { ... } }
}
```

## Blocchi Principali
- **Logo**: vista `pub_theme::components.blocks.logo`
- **Navigation**: vista `pub_theme::components.blocks.navigation`
- **Language Switcher**: vista `pub_theme::components.blocks.language-switcher`
- **User Menu**: vista `pub_theme::components.blocks.user-menu`

## Path delle Blade
- Logo: `Themes/<ThemeName>/resources/views/components/blocks/logo.blade.php`
- Navigation: `Themes/<ThemeName>/resources/views/components/blocks/navigation.blade.php`
- Language Switcher: `Themes/<ThemeName>/resources/views/components/blocks/language-switcher.blade.php`
- User Menu: `Themes/<ThemeName>/resources/views/components/blocks/user-menu.blade.php`

## Collegamenti
- [Documentazione Blocchi](../blocks.md)
- [Documentazione Frontoffice](../frontoffice.md)
- [Documentazione Navigation](navigation.md)

## Collegamenti tra versioni di header.md
* [header.md](docs/sections/header.md)
* [header.md](laravel/Modules/Cms/docs/components/header.md)
* [header.md](laravel/Modules/Cms/docs/sections/header.md)
* [header.md](laravel/Themes/One/docs/sections/header.md)

