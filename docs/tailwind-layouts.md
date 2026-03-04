# Layout con Filament Components

## Introduzione

Questo documento descrive l'implementazione dei layout nel modulo Notify utilizzando i componenti Filament. I layout sono stati migrati da implementazioni custom a componenti Filament per garantire:

- Consistenza visiva in tutta l'applicazione
- Responsive design out-of-the-box
- Supporto per dark mode
- Accessibilità WCAG 2.1
- Manutenibilità migliorata

## Layout Base

### App Layout
```blade
<x-filament::layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('notify::layout.dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </div>
</x-filament::layouts.app>
```

### Card Layout
```blade
<x-filament::layouts.card>
    <x-slot name="header">
        <h2 class="text-lg font-medium">
            {{ $title }}
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ $description }}
        </p>
    </x-slot>

    {{ $slot }}

    <x-slot name="footer">
        {{ $footer }}
    </x-slot>
</x-filament::layouts.card>
```

## Componenti Layout

### Header
```blade
<x-filament::header>
    <x-slot name="heading">
        {{ __('notify::layout.notifications') }}
    </x-slot>

    <x-slot name="actions">
        <x-filament::button
            type="button"
            wire:click="markAllAsRead"
        >
            {{ __('notify::actions.mark_all_as_read') }}
        </x-filament::button>
    </x-slot>
</x-filament::header>
```

### Sidebar
```blade
<x-filament::sidebar>
    <x-filament::sidebar.group
        :label="__('notify::layout.navigation')"
        :collapsible="true"
    >
        <x-filament::sidebar.item
            icon="heroicon-o-bell"
            :label="__('notify::layout.notifications')"
            :active="request()->routeIs('notifications.*')"
            :href="route('notifications.index')"
        />
        
        <x-filament::sidebar.item
            icon="heroicon-o-cog"
            :label="__('notify::layout.settings')"
            :active="request()->routeIs('settings.*')"
            :href="route('settings.index')"
        />
    </x-filament::sidebar.group>
</x-filament::sidebar>
```

### Content
```blade
<x-filament::main>
    <x-filament::grid>
        <x-filament::grid.column span="2">
            <x-filament::card>
                <!-- Sidebar content -->
            </x-filament::card>
        </x-filament::grid.column>

        <x-filament::grid.column span="10">
            <x-filament::card>
                <!-- Main content -->
            </x-filament::card>
        </x-filament::grid.column>
    </x-filament::grid>
</x-filament::main>
```

## Layout Specifici

### Notification List Layout
```blade
<x-notify::layouts.app>
    <x-filament::header>
        <x-slot name="heading">
            {{ __('notify::notifications.list_title') }}
        </x-slot>

        <x-slot name="actions">
            <x-filament::button
                type="button"
                wire:click="markAllAsRead"
            >
                {{ __('notify::actions.mark_all_as_read') }}
            </x-filament::button>
        </x-slot>
    </x-filament::header>

    <x-filament::card>
        <div class="space-y-4">
            @forelse($notifications as $notification)
                <x-notify::notification-item
                    :notification="$notification"
                />
            @empty
                <x-filament::empty-state
                    icon="heroicon-o-bell"
                    :heading="__('notify::notifications.empty_heading')"
                    :description="__('notify::notifications.empty_description')"
                />
            @endforelse
        </div>

        <x-slot name="footer">
            {{ $notifications->links() }}
        </x-slot>
    </x-filament::card>
</x-notify::layouts.app>
```

### Settings Layout
```blade
<x-notify::layouts.app>
    <x-filament::header>
        <x-slot name="heading">
            {{ __('notify::settings.title') }}
        </x-slot>
    </x-filament::header>

    <x-filament::grid>
        <x-filament::grid.column span="4">
            <x-filament::card>
                <x-filament::card.heading>
                    {{ __('notify::settings.notification_preferences') }}
                </x-filament::card.heading>

                <x-notify::settings.notification-preferences
                    wire:model="preferences"
                />
            </x-filament::card>
        </x-filament::grid.column>

        <x-filament::grid.column span="8">
            <x-filament::card>
                <x-filament::card.heading>
                    {{ __('notify::settings.email_templates') }}
                </x-filament::card.heading>

                <x-notify::settings.email-templates
                    :templates="$templates"
                />
            </x-filament::card>
        </x-filament::grid.column>
    </x-filament::grid>
</x-notify::layouts.app>
```

## Responsive Design

### Breakpoints
```blade
<x-filament::responsive>
    <!-- Mobile -->
    <x-slot name="sm">
        <x-notify::mobile-layout>
            {{ $slot }}
        </x-notify::mobile-layout>
    </x-slot>

    <!-- Tablet -->
    <x-slot name="md">
        <x-notify::tablet-layout>
            {{ $slot }}
        </x-notify::tablet-layout>
    </x-slot>

    <!-- Desktop -->
    <x-slot name="lg">
        <x-notify::desktop-layout>
            {{ $slot }}
        </x-notify::desktop-layout>
    </x-slot>
</x-filament::responsive>
```

### Grid System
```blade
<x-filament::grid>
    <!-- Full width on mobile -->
    <x-filament::grid.column
        sm="12"
        md="6"
        lg="4"
    >
        <!-- Content -->
    </x-filament::grid.column>
</x-filament::grid>
```

## Dark Mode

### Configurazione
```php
// config/filament.php
return [
    'dark_mode' => [
        'enabled' => true,
        'auto' => true,
    ],
];
```

### Classi Dark Mode
```blade
<div class="
    bg-white dark:bg-gray-800
    text-gray-900 dark:text-gray-100
">
    <!-- Content -->
</div>
```

## Best Practices

1. **Organizzazione**
   - Utilizzare layout nidificati per strutture complesse
   - Mantenere i componenti modulari
   - Seguire la gerarchia dei componenti Filament

2. **Performance**
   - Lazy loading per componenti pesanti
   - Caching dei layout quando possibile
   - Ottimizzazione delle immagini

3. **Accessibilità**
   - Utilizzare landmark HTML5
   - Mantenere una struttura semantica
   - Seguire le linee guida WCAG

4. **Manutenibilità**
   - Documentare i componenti layout
   - Utilizzare nomi descrittivi
   - Seguire le convenzioni Filament

## Collegamenti

- [Documentazione Form](tailwind_forms.md)
- [Documentazione Notifiche](tailwind_notifications.md)
- [Documentazione Componenti](tailwind_components.md)
- [Architettura](architecture.md)
