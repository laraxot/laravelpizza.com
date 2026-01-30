# Modulo UI

## Struttura Directory
```
laravel/Modules/UI/
├── app/
│   ├── Providers/
│   │   └── UIServiceProvider.php    # Provider principale per i componenti UI
│   └── Services/
│       └── UIService.php           # Servizio per la gestione UI
├── resources/
│   ├── lang/                       # File di traduzione
│   ├── views/
│   │   └── components/            # Componenti Blade
│   └── svg/                       # File SVG per le icone
└── config/
    └── laravel-localization.php    # Configurazione localizzazione
```

## Regole di Routing

### Frontoffice (Folio)
- Le rotte del frontoffice sono gestite da Laravel Folio
- I file delle viste devono essere posizionati in `resources/views/pages`
- La struttura delle cartelle determina l'URL della pagina
- Non modificare `web.php` per le rotte del frontoffice

### Backoffice (Filament)
- Le rotte dell'amministrazione sono gestite da Filament
- I file delle viste devono essere posizionati in `resources/views/filament`
- La struttura delle cartelle determina l'URL della pagina
- Non modificare `web.php` per le rotte dell'amministrazione

## Gestione di Volt in Folio

### Regole per i Componenti Volt
1. **Direttiva @volt**:
   - Ogni componente Volt in una pagina Folio DEVE iniziare con la direttiva `@volt`
   - Esempio:
   ```blade
   @volt
   <div>
       <!-- Contenuto del componente -->
   </div>
   @endvolt
   ```

2. **Struttura dei File**:
   - I componenti Volt devono essere in file separati con estensione `.blade.php`
   - Posizionare i componenti in `resources/views/components`
   - Utilizzare il namespace corretto per i componenti

3. **Best Practices**:
   - Mantenere la logica di business nel componente
   - Utilizzare le proprietà state per la gestione dello stato
   - Implementare i metodi necessari all'interno del componente
   - Gestire correttamente gli eventi e le azioni

4. **Integrazione con Folio**:
   - Importare correttamente i componenti nelle pagine Folio
   - Utilizzare la sintassi corretta per il binding dei dati
   - Gestire correttamente gli eventi tra componenti

### Esempio di Componente Volt
```blade
@volt
<?php
use function Livewire\Volt\{state, mount};

state(['count' => 0]);

$increment = function () {
    $this->count++;
};
?>

<div>
    <h1>{{ $count }}</h1>
    <button wire:click="increment">Incrementa</button>
</div>
@endvolt
```

## Componenti Filament

### Layout
I componenti di layout di Filament forniscono la struttura base delle pagine:

```blade
<x-filament::page>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('Section Title') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Section description') }}
        </x-slot>

        <!-- Contenuto della sezione -->
    </x-filament::section>
</x-filament::page>
```

#### Componenti Layout
- `x-filament::page`: Contenitore principale della pagina
- `x-filament::section`: Sezione della pagina con titolo e descrizione
- `x-filament::card`: Card per raggruppare contenuti correlati (alternativa: `div` con classi Tailwind)

### Dropdown
Il componente dropdown di Filament fornisce un menu a discesa interattivo:

```blade
<x-filament::dropdown
    placement="right"
    width="48"
    :content-classes="'py-1 bg-white dark:bg-gray-800'"
>
    <x-slot name="trigger">
        <!-- Contenuto del trigger -->
    </x-slot>

    <x-filament::dropdown.list>
        <x-filament::dropdown.list.item
            :href="route('profile.show')"
            :icon="'heroicon-o-user'"
        >
            {{ __('Profile') }}
        </x-filament::dropdown.list.item>

        <!-- Separatore -->
        <div class="border-t border-gray-200 dark:border-gray-700"></div>
    </x-filament::dropdown.list>
</x-filament::dropdown>
```

#### Proprietà Dropdown
- `placement`: Posizione del dropdown ('left', 'right', 'top', 'bottom')
- `width`: Larghezza del dropdown ('48', '64', '96', etc.)
- `content-classes`: Classi CSS per il contenuto

#### Componenti Dropdown
- `x-filament::dropdown.list`: Contenitore per gli elementi del menu
- `x-filament::dropdown.list.item`: Elemento del menu
- Separatore: Utilizzare `div` con classi Tailwind invece di `dropdown.list.divider`

### Avatar
Il componente avatar di Filament gestisce le immagini profilo:

```blade
<x-filament::avatar
    src="{{ $user->profile_photo_url }}"
    alt="{{ $user->name }}"
    size="md"
    class="ring-2 ring-white ring-opacity-50 shadow-sm"
/>
```

#### Proprietà Avatar
- `src`: URL dell'immagine
- `alt`: Testo alternativo
- `size`: Dimensione ('sm', 'md', 'lg', 'xl')
- `class`: Classi CSS aggiuntive

### Loading Indicator
Il componente loading indicator mostra uno stato di caricamento:

```blade
<x-filament::loading-indicator
    wire:loading
    class="h-5 w-5"
/>
```

#### Proprietà Loading Indicator
- `wire:loading`: Mostra durante il caricamento Livewire
- `class`: Classi CSS per personalizzazione

### Best Practices
1. **Componenti Filament**:
   - Utilizzare sempre i componenti Filament quando disponibili
   - Seguire la documentazione ufficiale per l'uso corretto
   - Mantenere la coerenza con il design system di Filament
   - Utilizzare alternative Tailwind quando un componente non è disponibile

2. **Percorsi**:
   - Utilizzare sempre percorsi relativi al modulo
   - Non modificare la struttura del provider esistente
   - Verificare sempre i componenti esistenti prima di crearne di nuovi

3. **Componenti**:
   - Mantenere la coerenza con i componenti esistenti
   - Utilizzare il prefisso `x-filament::` per i componenti Filament
   - Seguire le convenzioni di naming Laravel
   - Utilizzare classi Tailwind per personalizzazione

4. **Localizzazione**:
   - Utilizzare i file di traduzione in `resources/lang`
   - Seguire la struttura delle traduzioni esistente
   - Mantenere la coerenza tra le lingue

5. **Routing**:
   - Utilizzare Folio per le rotte del frontoffice
   - Utilizzare Filament per le rotte dell'amministrazione
   - Non modificare `web.php` per le rotte standard
   - Seguire la struttura delle cartelle per il routing

## Regole di Sviluppo
1. Analizzare sempre il codice esistente prima di modificare
2. Verificare i componenti già registrati nel provider
3. Seguire la struttura delle directory esistente
4. Mantenere la coerenza con le convenzioni Laravel
5. Documentare le modifiche significative
6. Preferire i componenti Filament quando disponibili
7. Consultare la documentazione ufficiale di Filament
8. Non modificare `web.php` per le rotte standard
9. Utilizzare Folio per il frontoffice e Filament per il backoffice
10. Utilizzare classi Tailwind come alternativa ai componenti non disponibili
11. Aggiungere SEMPRE la direttiva `@volt` nei componenti Volt in Folio
12. Verificare la corretta importazione dei componenti Volt
13. Gestire correttamente lo stato e gli eventi nei componenti Volt
14. Mantenere la separazione tra logica e presentazione
15. Testare i componenti Volt in isolamento prima dell'integrazione
