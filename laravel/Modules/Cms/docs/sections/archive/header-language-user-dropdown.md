# Implementazione del Selettore di Lingua e Dropdown Utente nell'Header

## Collegamenti correlati
- [Documentazione centrale](/project_docs/README.md)
- [Collegamenti documentazione](/project_docs/collegamenti-documentazione.md)
- [Documentazione sezioni](/project_docs/sections.md)
- [Sezioni CMS](/laravel/Modules/Cms/project_docs/sections.md)
- [Sezioni Tema One](/laravel/Themes/One/project_docs/sections/HEADER_LANGUAGE_USER_DROPDOWN.md)
- [Implementazione Logout](/laravel/Modules/User/project_docs/LOGOUT_BLADE_IMPLEMENTATION.md)
- [Analisi Errore Logout](/laravel/Modules/User/project_docs/LOGOUT_BLADE_ERROR_ANALYSIS.md)
- [Errore Eventi Logout](/laravel/Modules/User/project_docs/LOGOUT_EVENT_ERROR.md)

## Panoramica

Questo documento descrive l'implementazione di due nuovi componenti nell'header principale:

1. **Selettore di Lingua**: Permette all'utente di cambiare la lingua dell'interfaccia
2. **Dropdown Utente**: Mostra l'avatar dell'utente autenticato e contiene un menu con opzioni, incluso il logout

## Architettura dei Componenti

### Struttura dei Componenti

I componenti seguono un'architettura modulare standard:
I componenti seguono l'architettura modulare di <main module>:

1. **Definizione JSON**: I componenti sono definiti nel file JSON dell'header
2. **Componenti Blade**: Implementati come componenti Blade nel tema
3. **Integrazione**: Integrati con il sistema di autenticazione e localizzazione

### Responsabilità del Modulo CMS

Il modulo CMS è responsabile di:

1. Caricare il file JSON dell'header
2. Renderizzare i componenti dell'header
3. Gestire la localizzazione dei contenuti
4. Integrare i componenti con il tema attivo

## Implementazione dei Componenti Blade

### 1. Selettore di Lingua con SVG Bandiere

```blade
@props(['languages' => []])

<div class="relative" x-data="{ open: false }">
    <button 
        @click="open = !open" 
        @click.away="open = false"
        class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-md transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-primary-500"
    >
        @php
            $currentLocale = app()->getLocale();
            $currentFlag = $currentLocale === 'en' ? 'gb' : $currentLocale;
        @endphp
        
        <div class="flex items-center justify-center w-6 h-6 overflow-hidden rounded-full border border-gray-200">
            <x-dynamic-component :component="'ui-flags.' . $currentFlag" class="w-7 h-7 object-cover" />
        </div>
        
        <span class="hidden md:inline">{{ $languages[$currentLocale]['name'] ?? ucfirst($currentLocale) }}</span>
        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </button>
    
    <div 
        x-show="open" 
        x-transition:enter="transition ease-out duration-100" 
        x-transition:enter-start="transform opacity-0 scale-95" 
        x-transition:enter-end="transform opacity-100 scale-100" 
        x-transition:leave="transition ease-in duration-75" 
        x-transition:leave-start="transform opacity-100 scale-100" 
        x-transition:leave-end="transform opacity-0 scale-95" 
        class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 divide-y divide-gray-100"
    >
        <div class="py-1">
            @foreach($languages as $code => $language)
                @php
                    $flag = $code === 'en' ? 'gb' : $code;
                @endphp
                <a 
                    href="{{ url($code . substr(request()->getRequestUri(), 3)) }}" 
                    class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >
                    <div class="flex items-center justify-center w-6 h-6 overflow-hidden rounded-full border border-gray-200">
                        <x-dynamic-component :component="'ui-flags.' . $flag" class="w-7 h-7 object-cover" />
                    </div>
                    {{ $language['name'] }}
                </a>
            @endforeach
        </div>
    </div>
</div>
```

### 2. Dropdown Utente con Logout

```json
{
    "name": {
        "it": "Dropdown Utente",
        "en": "User Dropdown"
    },
    "type": "user-dropdown",
    "data": {
        "view": "pub_theme::components.blocks.user-dropdown",
        "guest_view": "pub_theme::components.blocks.login-buttons",
        "menu_items": [
            {
                "label": "Profilo",
                "url": "/profilo",
                "icon": "heroicon-o-user"
            },
            {
                "label": "Impostazioni",
                "url": "/impostazioni",
                "icon": "heroicon-o-cog-6-tooth"
            },
            {
                "type": "divider"
            },
            {
                "label": "Logout",
                "url": "/logout",
                "icon": "heroicon-o-arrow-left-on-rectangle",
                "method": "get"
            }
        ]
    }
}
```

## Integrazione con il Sistema di Autenticazione

Il componente Dropdown Utente si integra con il sistema di autenticazione di Laravel:

1. Verifica se l'utente è autenticato con la direttiva `@auth`
2. Mostra l'avatar e il nome dell'utente autenticato
3. Include un link al logout che utilizza il file `logout.blade.php` corretto

## Integrazione con il Sistema di Localizzazione

Il selettore di lingua si integra con il sistema di localizzazione:

1. Mostra la lingua corrente utilizzando `app()->getLocale()`
2. Genera URL localizzati mantenendo il percorso corrente
3. Segue la convenzione `/{locale}/{sezione}/{risorsa}` per gli URL

## Implementazione nel File JSON dell'Header

Il file JSON dell'header (`/config/local/<directory progetto>/database/content/sections/1.json`) deve essere aggiornato per includere i nuovi blocchi:
Il file JSON dell'header (`/config/local/<directory progetto>/database/content/sections/1.json`) deve essere aggiornato per includere i nuovi blocchi:

```json
"blocks": {"it":[
    // Blocchi esistenti
    
    // Nuovo blocco Selettore Lingua
    {
        "name": {
            "it": "Selettore Lingua",
            "en": "Language Selector"
        },
        "type": "language-selector",
        "data": {
            "view": "pub_theme::components.blocks.language-selector",
            "languages": {
                "it": {
                    "name": "Italiano",
                    "flag": "it"
                },
                "en": {
                    "name": "English",
                    "flag": "gb"
                },
                "fr": {
                    "name": "Français",
                    "flag": "fr"
                },
                "de": {
                    "name": "Deutsch",
                    "flag": "de"
                },
                "es": {
                    "name": "Español",
                    "flag": "es"
                }
            }
        }
    },
    
    // Nuovo blocco Dropdown Utente
    {
        "name": {
            "it": "Dropdown Utente",
            "en": "User Dropdown"
        },
        "type": "user-dropdown",
        "data": {
            "view": "pub_theme::components.blocks.user-dropdown",
            "guest_view": "pub_theme::components.blocks.login-buttons",
            "menu_items": [
                {
                    "label": "auth.profile.link.label",
                    "url": "/profilo",
                    "icon": "heroicon-o-user"
                },
                {
                    "label": "auth.settings.link.label",
                    "url": "/impostazioni",
                    "icon": "heroicon-o-cog-6-tooth"
                },
                {
                    "type": "divider"
                },
                {
                    "label": "auth.logout.button.label",
                    "url": "/logout",
                    "icon": "heroicon-o-arrow-left-on-rectangle",
                    "method": "get"
                }
            ]
        }
    }
]}
```

## Utilizzo dei Componenti SVG delle Bandiere

Per rendere il selettore di lingue più accattivante e visibile, utilizziamo i componenti SVG delle bandiere forniti dal modulo UI. Questi componenti sono autoregistrati e possono essere facilmente integrati nell'header.
Per rendere il selettore di lingue più accattivante e visibile, utilizziamo i componenti SVG delle bandiere forniti dal modulo UI di <main module>. Questi componenti sono autoregistrati e possono essere facilmente integrati nell'header.

### Vantaggi dei Componenti SVG

1. **Qualità Visiva**: Gli SVG sono vettoriali e mantengono la qualità a qualsiasi dimensione
2. **Personalizzazione**: Facile da personalizzare con classi CSS
3. **Prestazioni**: Gli SVG sono leggeri e non richiedono richieste HTTP aggiuntive
4. **Accessibilità**: Possibilità di aggiungere attributi di accessibilità
5. **Coerenza**: Utilizzo di componenti nativi del sistema
5. **Coerenza**: Utilizzo di componenti nativi di <main module>

### Sintassi di Utilizzo

```blade
<x-ui-flags.it class="h-5 w-5" />
<x-ui-flags.gb class="h-5 w-5" />
<x-ui-flags.fr class="h-5 w-5" />
```

Dove:
- `ui` è il prefisso del modulo (in minuscolo)
- `flags` è la sottodirectory all'interno della cartella `svg`
- `it`, `gb`, `fr` sono i codici ISO dei paesi

Per maggiori dettagli, consultare la [documentazione sui componenti SVG delle bandiere](/laravel/Modules/UI/project_docs/FLAGS_COMPONENTS.md).

## Considerazioni Tecniche

### Gestione della Sessione

Il componente Dropdown Utente deve essere compatibile con il sistema di gestione della sessione di Laravel:

1. Il link di logout deve inviare una richiesta GET al percorso `/logout`
2. Il file `logout.blade.php` deve gestire correttamente gli eventi di logout come descritto in [LOGOUT_EVENT_ERROR.md](/laravel/Modules/User/project_docs/LOGOUT_EVENT_ERROR.md)

### Sicurezza

1. Verificare sempre se l'utente è autenticato prima di mostrare il dropdown utente
2. Utilizzare CSRF per le richieste POST (se applicabile)
3. Sanitizzare i dati dell'utente prima di visualizzarli

### Prestazioni

1. Utilizzare Alpine.js per la gestione dei dropdown lato client
2. Caricare le immagini delle bandiere e degli avatar in modo efficiente

## Conclusione

L'implementazione del selettore di lingua e del dropdown utente nell'header migliorerà significativamente l'esperienza utente, consentendo un facile cambio di lingua e un accesso rapido alle funzionalità relative all'utente, incluso il logout.

Questa implementazione segue le convenzioni standard per la gestione dei contenuti statici e l'integrazione con i sistemi di autenticazione e localizzazione.
Questa implementazione segue le convenzioni di <main module> per la gestione dei contenuti statici e l'integrazione con i sistemi di autenticazione e localizzazione.

Per i dettagli specifici sull'implementazione nel tema One, consultare la [documentazione del tema](/laravel/Themes/One/project_docs/sections/HEADER_LANGUAGE_USER_DROPDOWN.md).
