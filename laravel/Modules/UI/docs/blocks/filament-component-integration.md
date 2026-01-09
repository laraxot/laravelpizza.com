# Integrazione dei Componenti Filament nei Blocchi

## Introduzione

Questo documento spiega come integrare correttamente i componenti Filament nei blocchi utilizzati nel frontend, in particolare per elementi UI complessi come dropdown.

## Principi Fondamentali

### Precedenza ai Componenti Filament

Quando si implementano blocchi per l'interfaccia utente, si dovrebbe **dare precedenza all'utilizzo dei componenti Filament** anziché implementare componenti personalizzati. I componenti Filament offrono:

- Stile consistente
- Accessibilità incorporata
- Comportamenti interattivi pre-costruiti
- Facilità di manutenzione

### Passaggio Dati dal JSON ai Componenti

Un concetto fondamentale da comprendere è che **i dati dal JSON delle sezioni vengono passati automaticamente ai componenti Blade** tramite il meccanismo di inclusione:

```blade
@include($block->view, $block->data)
```

Questo rende le proprietà definite nel JSON direttamente accessibili come variabili nel componente, **senza bisogno di definizioni esplicite tramite la direttiva `@props`**.

## Utilizzo Corretto di Filament in Dropdown e Menu

### User Dropdown con Componenti Filament

Per implementare un menu dropdown utente:

```blade
<!-- components/blocks/navigation/user-dropdown.blade.php -->

@php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
    $locale = LaravelLocalization::getCurrentLocale();
    $isLoggedIn = auth()->check();
    $user = auth()->user();
@endphp

@if($isLoggedIn)
    <div class="relative">
        <x-filament::dropdown>
            <x-slot name="trigger">
                <x-filament::avatar
                    :src="$user->profile_photo_url"
                    :alt="$user->name"
                    class="h-8 w-8"
                />
            </x-slot>

            @foreach($menu_items as $item)
                @if(isset($item['type']) && $item['type'] === 'divider')
                    <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                @else
                    <x-filament::dropdown.list.item
                        :href="$item['url']"
                        :icon="$item['icon'] ?? null"
                    >
                        {{ $item['label'] }}
                    </x-filament::dropdown.list.item>
                @endif
            @endforeach
        </x-filament::dropdown>
    </div>
@else
    @if(isset($guest_view))
        @include($guest_view)
    @else
        <div class="flex space-x-4">
            <x-filament::button
                href="/{{ $locale }}/auth/login"
                color="gray"
                tag="a"
            >
                {{ __('auth.login.link') }}
            </x-filament::button>

            <x-filament::button
                href="/{{ $locale }}/auth/register"
                color="primary"
                tag="a"
            >
                {{ __('auth.register.link') }}
            </x-filament::button>
        </div>
    @endif
@endif
```

### Configurazione JSON

```json
{
    "name": {
        "it": "Menu Utente",
        "en": "User Menu"
    },
    "type": "user-dropdown",
    "data": {
        "view": "pub_theme::components.blocks.navigation.user-dropdown",
        "guest_view": "pub_theme::components.blocks.navigation.login-buttons",
        "menu_items": [
            {
                "label": "Profilo",
                "url": "/profilo",
                "icon": "heroicon-o-user"
            },
            {
                "type": "divider"
            },
            {
                "label": "Logout",
                "url": "/logout",
                "icon": "heroicon-o-arrow-left-on-rectangle"
            }
        ]
    }
}
```

## Vantaggi dell'Integrazione con Filament

1. **Coerenza visiva**: I componenti mantengono lo stesso aspetto in tutto il frontend e il backoffice
2. **Manutenibilità**: Aggiornamenti a Filament si riflettono automaticamente in tutto il sistema
3. **Performance**: I componenti sono ottimizzati per prestazioni elevate
4. **Accessibilità**: I componenti Filament seguono le linee guida WCAG per l'accessibilità

## Errori da Evitare

1. **Non creare componenti personalizzati** quando esistono equivalenti Filament
2. **Non aggiungere `@props` non necessari** per dati già passati dal JSON
3. **Non ignorare le convenzioni di Filament** per stili e comportamenti
4. **Non hardcodare riferimenti al progetto** nelle template (usare configurazioni dinamiche)

## Layout Responsivo dei Widget Filament

### Gestione Corretta della Larghezza dei Form

Quando si integrano widget Filament contenenti form nel frontend, è fondamentale prestare attenzione alla larghezza disponibile per garantire una buona esperienza utente.

#### Problematiche Comuni

- **Larghezza troppo limitata**: Utilizzare classi come `max-w-lg` può rendere i form troppo stretti su schermi ampi
- **Larghezza eccessiva**: Form troppo larghi possono causare problemi di leggibilità e di usabilità
- **Layout non adattivo**: Form che non si adattano correttamente a diverse dimensioni dello schermo

#### Best Practices per i Form di Registrazione

1. **Utilizzare larghezze relative**: Preferire `max-w-3xl` o `max-w-4xl` per form complessi con campi multipli
2. **Layout a colonne**: Per form wizard multi-step, utilizzare `grid` per organizzare i campi in modo efficiente
3. **Centrare con padding laterale**: Usare `mx-auto px-4 sm:px-6 lg:px-8` per centrare il form con spaziatura adeguata
4. **Rimuovere i vincoli di larghezza massima** per i form wizard che richiedono spazio orizzontale maggiore

#### Implementazione Corretta

```blade
<!-- Versione migliorata per widget di registrazione -->
<x-filament-widgets::widget>
    <x-filament::section>
        <!-- Rimuovere max-w-lg per form complessi o aumentare a max-w-4xl -->
        <div class="max-w-4xl mx-auto">
            <form wire:submit.prevent="register" class="space-y-6">
                {{ $this->form }}
            </form>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
```

### Regola Applicativa

I form Filament che utilizzano campi complessi, wizard multi-step o molti campi su una singola riga **non devono essere limitati** da classi di larghezza restrittive come `max-w-lg`. Utilizzare invece:

- `max-w-3xl` (48rem/768px) per form di media complessità
- `max-w-4xl` (56rem/896px) per form complessi
- Nessun limite di larghezza massima per wizard che utilizzano layout a griglia complessi

## Riferimenti alla Documentazione

- [Documentazione ufficiale Filament](https://filamentphp.com/docs/3.x/support/blade-components)
- [Integrazione Filament nel modulo CMS](../../Cms/docs/filament-integration.md)
- [Best practices per i componenti UI](../components/best-practices.md)

---
*Aggiornato: 2025-05-08*
