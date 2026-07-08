# Utilizzo dei Componenti Filament 

## Collegamenti correlati
- [README modulo UI](/laravel/Modules/UI/docs/README.md)
- [Architettura Modulare](/docs/architettura-modulare.md)
- [Percorsi e Asset](/laravel/Modules/UI/docs/PATHS_AND_ASSETS.md)
- [Collegamenti Documentazione](/docs/collegamenti-documentazione.md)

## Panoramica

Questo documento descrive l'utilizzo corretto dei componenti Filament , con particolare attenzione alle icone, avatar e altri elementi UI comuni.

## Struttura dei Componenti Filament

Filament fornisce un ricco set di componenti Blade che possono essere utilizzati in tutta l'applicazione. Questi componenti sono accessibili tramite il prefisso `x-filament::`.

### Componenti Principali

| Componente | Descrizione | Esempio di Utilizzo |
|------------|-------------|---------------------|
| `x-filament::avatar` | Avatar utente | `<x-filament::avatar :src="$user->profile_photo_url" :alt="$user->name" size="md" />` |
| `x-filament::icon` | Icone Heroicon | `<x-filament::icon name="heroicon-o-user" class="h-6 w-6" />` |
| `x-filament::button` | Pulsanti | `<x-filament::button>Clicca qui</x-filament::button>` |
| `x-filament::dropdown` | Menu a discesa | `<x-filament::dropdown>...</x-filament::dropdown>` |
| `x-filament::card` | Card contenitore | `<x-filament::card>Contenuto</x-filament::card>` |

## Utilizzo delle Icone

Filament utilizza le icone [Heroicons](https://heroicons.com/) che sono accessibili tramite il componente `x-filament::icon`. Le icone sono disponibili in stile outline (`heroicon-o-*`) e solid (`heroicon-s-*`).

### Esempi di Utilizzo delle Icone

```blade
<x-filament::icon
    name="heroicon-o-user"
    class="h-6 w-6 text-gray-500"
/>

<x-filament::icon
    name="heroicon-o-home"
    class="h-5 w-5 text-primary-600"
/>

<x-filament::icon
    name="heroicon-s-check"
    class="h-4 w-4 text-success-500"
/>
```

### Icone Comuni

| Nome | Descrizione |
|------|-------------|
| `heroicon-o-user` | Utente (outline) |
| `heroicon-o-user-circle` | Utente circolare (outline) |
| `heroicon-o-home` | Casa (outline) |
| `heroicon-o-cog` | Impostazioni (outline) |
| `heroicon-o-logout` | Logout (outline) |
| `heroicon-o-x-mark` | X/Chiudi (outline) |
| `heroicon-o-bars-3` | Menu hamburger (outline) |
| `heroicon-o-bell` | Notifica (outline) |
| `heroicon-o-envelope` | Email (outline) |
| `heroicon-o-globe-alt` | Globo/Lingua (outline) |

## Utilizzo degli Avatar

Filament fornisce un componente `x-filament::avatar` che può essere utilizzato per visualizzare gli avatar degli utenti.

### Esempio di Utilizzo degli Avatar

```blade
<x-filament::avatar
    :src="$user->profile_photo_url"
    :alt="$user->name"
    size="md"
    class="bg-gray-200 dark:bg-gray-700"
/>
```

### Dimensioni degli Avatar

| Dimensione | Valore |
|------------|--------|
| Extra Small | `xs` |
| Small | `sm` |
| Medium | `md` |
| Large | `lg` |
| Extra Large | `xl` |

## Utilizzo dei Pulsanti

Filament fornisce un componente `x-filament::button` che può essere utilizzato per creare pulsanti con stili coerenti.

### Esempio di Utilizzo dei Pulsanti

```blade
<x-filament::button>
    Pulsante Primario
</x-filament::button>

<x-filament::button color="secondary">
    Pulsante Secondario
</x-filament::button>

<x-filament::button color="danger" size="sm">
    Pulsante Piccolo Pericoloso
</x-filament::button>
```

### Colori dei Pulsanti

| Colore | Descrizione |
|--------|-------------|
| `primary` | Colore primario (default) |
| `secondary` | Colore secondario |
| `success` | Verde/Successo |
| `warning` | Giallo/Avviso |
| `danger` | Rosso/Pericolo |
| `gray` | Grigio/Neutro |

## Utilizzo dei Dropdown

Filament fornisce un componente `x-filament::dropdown` che può essere utilizzato per creare menu a discesa.

### Esempio di Utilizzo dei Dropdown

```blade
<x-filament::dropdown>
    <x-slot name="trigger">
        <x-filament::button>
            Apri Menu
        </x-filament::button>
    </x-slot>
    
    <x-filament::dropdown.item wire:click="action">
        Azione 1
    </x-filament::dropdown.item>
    
    <x-filament::dropdown.item href="#">
        Azione 2
    </x-filament::dropdown.item>
</x-filament::dropdown>
```

## Best Practices

1. **SEMPRE utilizzare i componenti Filament** quando disponibili invece di creare componenti personalizzati
2. **SEMPRE utilizzare il prefisso corretto** `x-filament::` per accedere ai componenti Filament
3. **MAI modificare direttamente i componenti Filament**, ma estenderli se necessario
4. **SEMPRE consultare la documentazione ufficiale** di Filament per le ultime funzionalità e best practices
5. **SEMPRE utilizzare le classi Tailwind** fornite da Filament per mantenere la coerenza visiva
6. **SEMPRE verificare il percorso corretto** dei componenti e degli asset

## Errori Comuni

1. **Utilizzo del prefisso errato**: Utilizzare `x-ui-icon` invece di `x-filament::icon`
2. **Percorso errato del provider**: Utilizzare `/var/www/html/saluteora/laravel/Modules/UI/Providers/UIServiceProvider.php` invece di `/var/www/html/saluteora/laravel/Modules/UI/app/Providers/UIServiceProvider.php`
3. **Creazione di componenti duplicati**: Creare componenti personalizzati che duplicano funzionalità già fornite da Filament
4. **Mancata verifica dei componenti esistenti**: Non controllare se un componente è già disponibile in Filament prima di crearne uno personalizzato

## Riferimenti

- [Documentazione Filament](https://filamentphp.com/docs/3.x/support/blade-components/overview)
- [Heroicons](https://heroicons.com/)
- [Tailwind CSS](https://tailwindcss.com/)
- [Laravel Blade](https://laravel.com/docs/10.x/blade)
