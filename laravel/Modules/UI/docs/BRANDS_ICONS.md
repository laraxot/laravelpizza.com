# UI Brands Icons - Documentazione

## Panoramica

Il modulo UI fornisce un set di icone SVG per i brand social media, registrate automaticamente con il prefisso `ui-brands`.

## Icone Disponibili

Le icone sono posizionate in `Modules/UI/resources/svg/brands/`:

- `facebook.svg` → `<x-icon name="ui-brands.facebook" />`
- `twitter.svg` → `<x-icon name="ui-brands.twitter" />`
- `instagram.svg` → `<x-icon name="ui-brands.instagram" />`
- `linkedin.svg` → `<x-icon name="ui-brands.linkedin" />`
- `youtube.svg` → `<x-icon name="ui-brands.youtube" />`
- `telegram.svg` → `<x-icon name="ui-brands.telegram" />`
- `whatsapp.svg` → `<x-icon name="ui-brands.whatsapp" />`
- `rss.svg` → `<x-icon name="ui-brands.rss" />`

## Utilizzo

### Sintassi Base

```blade
<x-icon name="ui-brands.facebook" class="w-6 h-6" />
```

### Con Classi Tailwind

```blade
<x-icon 
    name="ui-brands.facebook" 
    class="w-6 h-6 text-blue-600 hover:text-blue-700" 
/>
```

### Link Social

```blade
<a href="https://facebook.com/pagina" target="_blank" rel="noopener noreferrer">
    <x-icon name="ui-brands.facebook" class="w-6 h-6" />
</a>
```

## Configurazione

Le icone sono configurate in `config/blade-icons.php`:

```php
'sets' => [
    'ui-brands' => [
        'path' => base_path('Modules/UI/resources/svg/brands'),
        'prefix' => 'ui-brands',
    ],
],
```

## Aggiungere Nuove Icone

1. Crea il file SVG in `Modules/UI/resources/svg/brands/nome-icona.svg`
2. Usa l'icona con `<x-icon name="ui-brands.nome-icona" />`

L'icona verrà registrata automaticamente al prossimo request.

## Esempio Completo

```blade
{{-- Social Links Component --}}
<nav class="flex space-x-4" aria-label="Social media links">
    <a href="{{ config('social.facebook') }}" 
       target="_blank" 
       rel="noopener noreferrer"
       class="w-10 h-10 hover:bg-blue-50 rounded-full flex items-center justify-center">
        <x-icon name="ui-brands.facebook" class="w-5 h-5 text-blue-600" />
        <span class="sr-only">Facebook</span>
    </a>
    
    <a href="{{ config('social.twitter') }}" 
       target="_blank" 
       rel="noopener noreferrer"
       class="w-10 h-10 hover:bg-gray-50 rounded-full flex items-center justify-center">
        <x-icon name="ui-brands.twitter" class="w-5 h-5 text-gray-900" />
        <span class="sr-only">Twitter</span>
    </a>
    
    <a href="{{ config('social.instagram') }}" 
       target="_blank" 
       rel="noopener noreferrer"
       class="w-10 h-10 hover:bg-pink-50 rounded-full flex items-center justify-center">
        <x-icon name="ui-brands.instagram" class="w-5 h-5 text-pink-600" />
        <span class="sr-only">Instagram</span>
    </a>
</nav>
```

## Note

- Le icone sono in formato SVG e si ridimensionano automaticamente
- Usa classi Tailwind per colori e dimensioni
- Il componente `<x-icon>` è fornito da `blade-icons`
- Accessibilità: aggiungi sempre `<span class="sr-only">` per screen readers
