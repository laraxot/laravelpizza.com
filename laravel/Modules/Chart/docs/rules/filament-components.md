# Regole per i Componenti Filament

## Principi Fondamentali

1. **Verifica Componenti**
   - SEMPRE verificare l'esistenza del componente nella documentazione ufficiale
   - NON assumere l'esistenza di un componente basandosi sulla logica dei nomi
   - Consultare la documentazione ufficiale: https://filamentphp.com/docs/3.x/support/blade-components
   - In caso di dubbio, ispezionare il codice sorgente di Filament

2. **Componenti UI Comuni**
   - Dropdown: `<x-filament::dropdown>`
   - Modal: `<x-filament::modal>`
   - Button: `<x-filament::button>`
   - Card: `<x-filament::card>`
   - Form: `<x-filament::form>`

3. **Best Practices**
   - Mantenere la coerenza visiva usando i componenti Filament
   - Seguire le convenzioni di naming di Filament
   - Utilizzare gli slot e gli attributi standard
   - Documentare le personalizzazioni
   - Per elementi non disponibili come componenti, usare le classi Tailwind di Filament

4. **Personalizzazioni**
   - Estendere i componenti Filament solo quando necessario
   - Mantenere la compatibilità con le versioni future
   - Testare le personalizzazioni su diverse versioni

## Esempi di Uso

1. **Dropdown Menu con Separatore**
   ```blade
   <x-filament::dropdown>
       <x-slot name="trigger">
           <button class="flex items-center">
               <img class="h-8 w-8 rounded-full" src="{{ auth()->user()->profile_photo_url }}" />
               <span class="ml-2">{{ auth()->user()->name }}</span>
           </button>
       </x-slot>

       <x-filament::dropdown.list>
           <x-filament::dropdown.list.item
               icon="heroicon-m-user"
               :href="route('profile.show')"
           >
               {{ __('Profile') }}
           </x-filament::dropdown.list.item>

           {{-- Separatore --}}
           <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>

           <form method="POST" action="{{ route('logout') }}" class="w-full">
               @csrf
               <x-filament::dropdown.list.item type="submit">
                   {{ __('Log Out') }}
               </x-filament::dropdown.list.item>
           </form>
       </x-filament::dropdown.list>
   </x-filament::dropdown>
   ```

## Struttura dei Componenti

1. **Dropdown**
   - Container: `<x-filament::dropdown>`
   - Trigger: `<x-slot name="trigger">`
   - Lista: `<x-filament::dropdown.list>`
   - Item: `<x-filament::dropdown.list.item>`
   - Separatore: `<div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>`

2. **Attributi Comuni**
   - `icon`: Icona Heroicon (es. "heroicon-m-user")
   - `:href`: URL di destinazione (per link)
   - `type="submit"`: Per item in form
   - `badge-color`: Colore del badge
   - `icon-color`: Colore dell'icona
   - `color`: Colore dell'item

3. **Form nel Dropdown**
   - Il form deve avere `class="w-full"`
   - Usare `type="submit"` invece di `:href` e `x-on:click`
   - Il form deve essere all'interno di `dropdown.list`
   - Non usare eventi Alpine.js per il submit

## Elementi UI non disponibili come Componenti

1. **Separatori**
   ```blade
   <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
   ```
   - Usa `border-t` per il bordo superiore
   - Usa `border-gray-200` per il colore chiaro
   - Usa `dark:border-gray-700` per il tema scuro
   - Usa `my-1` per lo spaziamento verticale

## Checklist Verifica

Prima di usare un componente:
- [ ] Ho verificato l'esistenza nella documentazione ufficiale?
- [ ] Ho controllato gli esempi nella documentazione?
- [ ] Ho verificato gli attributi supportati?
- [ ] Ho considerato il tema scuro?
- [ ] Ho documentato eventuali personalizzazioni? 