# Filament Blade Components Usage (CMS)

## Collegamenti
- [Documentazione Root](../../../../docs/collegamenti-documentazione.md) - Indice centrale dei collegamenti
- [Documentazione in Themes/One](../../../../Themes/One/docs/filament-blade-components.md) - Contesto del tema principale

Per le best practice di **Filament** (https://filamentphp.com/docs/3.x/support/blade-components/overview), utilizziamo sempre i componenti Blade di Filament per elementi interattivi e di navigazione.

## Perché usare `<x-filament::button>`
- **Stile e coerenza**: rispetta il tema e le varianti predefinite.
- **Accessibilità e funzionalità**: supporto integrato per attributi come `size`, `color`, `tag`, e altri.
- **Manutenzione semplificata**: meno markup custom, un’unica API per pulsanti e link.

### Esempio consigliato
```blade
<x-filament::button 
    size="sm" 
    href="{{ route('register.type', ['type' => $type]) }}" 
    tag="a"
>
    {{ ucfirst($type) }}
</x-filament::button>
```

### Cosa evitare
```blade
<a href="{{ route('register.type', ['type' => $type]) }}">
    <x-ui.button class="w-full">{{ ucfirst($type) }}</x-ui.button>
</a>
```

## Collegamenti tra versioni di filament-blade-components.md
* [filament-blade-components.md](laravel/Modules/Cms/docs/filament-blade-components.md)
* [filament-blade-components.md](laravel/Themes/One/docs/filament-blade-components.md)

