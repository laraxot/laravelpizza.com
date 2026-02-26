# Componenti UI con Filament

## Introduzione

Questo documento descrive i componenti UI utilizzati nel modulo Notify, basati sui componenti Filament. La migrazione a Filament garantisce:

- Consistenza visiva
- Componenti testati e mantenuti
- Supporto per dark mode
- Accessibilità WCAG 2.1
- Facile personalizzazione

## Componenti Base

### Button
```blade
<x-filament::button
    type="button"
    color="primary"
    size="lg"
    icon="heroicon-o-plus"
    wire:click="create"
>
    Crea Notifica
</x-filament::button>
```

### Badge
```blade
<x-filament::badge
    color="success"
    icon="heroicon-o-check"
>
    Completato
</x-filament::badge>
```

### Card
```blade
<x-filament::card>
    <x-slot name="header">
        <h3>Titolo Card</h3>
    </x-slot>

    Contenuto Card

    <x-slot name="footer">
        Footer Card
    </x-slot>
</x-filament::card>
```

## Componenti Form

### Input Group
```blade
<x-filament::input.group
    label="Email"
    required
    :error="$errors->first('email')"
>
    <x-filament::input.email
        wire:model="email"
        required
    />
</x-filament::input.group>
```

### Select
```blade
<x-filament::select
    wire:model="type"
    :options="[
        'info' => 'Informazione',
        'warning' => 'Avviso',
        'error' => 'Errore'
    ]"
    placeholder="Seleziona tipo"
/>
```

### Toggle
```blade
<x-filament::toggle
    wire:model="active"
    label="Attivo"
/>
```

## Componenti Tabella

### Table Base
```blade
<x-filament::table>
    <x-slot name="header">
        <x-filament::table.heading>
            ID
        </x-filament::table.heading>
        <x-filament::table.heading>
            Titolo
        </x-filament::table.heading>
        <x-filament::table.heading>
            Stato
        </x-filament::table.heading>
        <x-filament::table.heading>
            Azioni
        </x-filament::table.heading>
    </x-slot>

    @foreach($notifications as $notification)
        <x-filament::table.row>
            <x-filament::table.cell>
                {{ $notification->id }}
            </x-filament::table.cell>
            <x-filament::table.cell>
                {{ $notification->title }}
            </x-filament::table.cell>
            <x-filament::table.cell>
                <x-filament::badge :color="$notification->status_color">
                    {{ $notification->status }}
                </x-filament::badge>
            </x-filament::table.cell>
            <x-filament::table.cell>
                <x-filament::button
                    size="sm"
                    wire:click="edit({{ $notification->id }})"
                >
                    Modifica
                </x-filament::button>
            </x-filament::table.cell>
        </x-filament::table.row>
    @endforeach
</x-filament::table>
```

## Componenti Modal

### Modal Base
```blade
<x-filament::modal
    wire:model="showModal"
    :title="__('notify::modals.create_notification')"
>
    <x-filament::card>
        <form wire:submit.prevent="save">
            <x-filament::input.group
                label="Titolo"
                required
            >
                <x-filament::input
                    wire:model="form.title"
                    required
                />
            </x-filament::input.group>

            <x-filament::input.group
                label="Messaggio"
                required
            >
                <x-filament::textarea
                    wire:model="form.message"
                    required
                />
            </x-filament::input.group>
        </form>
    </x-filament::card>

    <x-slot name="footer">
        <x-filament::button
            wire:click="$set('showModal', false)"
        >
            Annulla
        </x-filament::button>

        <x-filament::button
            type="submit"
            color="primary"
        >
            Salva
        </x-filament::button>
    </x-slot>
</x-filament::modal>
```

## Componenti Lista

### List Item
```blade
<x-filament::list.item>
    <x-slot name="avatar">
        <x-filament::avatar
            src="{{ $notification->user->avatar }}"
            alt="{{ $notification->user->name }}"
        />
    </x-slot>

    <x-slot name="title">
        {{ $notification->title }}
    </x-slot>

    <x-slot name="description">
        {{ $notification->message }}
    </x-slot>

    <x-slot name="actions">
        <x-filament::button
            size="sm"
            wire:click="markAsRead({{ $notification->id }})"
        >
            Segna come letto
        </x-filament::button>
    </x-slot>
</x-filament::list.item>
```

## Componenti Alert

### Alert Base
```blade
<x-filament::alert
    type="success"
    icon="heroicon-o-check-circle"
    dismissible
>
    <x-slot name="title">
        Operazione completata
    </x-slot>

    La notifica è stata inviata con successo.
</x-filament::alert>
```

## Personalizzazione

### Tema Custom
```php
// config/filament.php
return [
    'theme' => [
        'colors' => [
            'primary' => [
                '50' => '#f0f9ff',
                '100' => '#e0f2fe',
                // ...
            ],
        ],
    ],
];
```

### Stili Custom
```css
/* resources/css/filament.css */
@layer components {
    .filament-button {
        @apply rounded-lg;
    }

    .filament-card {
        @apply shadow-lg;
    }
}
```

## Best Practices

1. **Organizzazione**
   - Raggruppare componenti correlati
   - Mantenere la consistenza visiva
   - Seguire le convenzioni di naming

2. **Performance**
   - Lazy loading per componenti pesanti
   - Ottimizzare le immagini
   - Minimizzare le dipendenze

3. **Accessibilità**
   - Utilizzare attributi ARIA
   - Testare con screen reader
   - Mantenere contrasto adeguato

4. **Manutenibilità**
   - Documentare i componenti
   - Creare componenti riutilizzabili
   - Seguire le convenzioni Filament

## Collegamenti

- [Documentazione Form](tailwind_forms.md)
- [Documentazione Layout](tailwind_layouts.md)
- [Documentazione Notifiche](tailwind_notifications.md)
- [Architettura](architecture.md)

## Note
- Tutti i collegamenti sono relativi
- La documentazione è mantenuta in italiano
- I collegamenti sono bidirezionali quando appropriato
- Ogni sezione ha il suo README.md specifico

## Contribuire
Per contribuire alla documentazione, seguire le [Linee Guida](../../../docs/linee-guida-documentazione.md) e le [Regole dei Collegamenti](../../../docs/regole_collegamenti_documentazione.md).

## Collegamenti Completi
Per una lista completa di tutti i collegamenti tra i README.md, consultare il file [README_links.md](../../../docs/README_links.md). 
