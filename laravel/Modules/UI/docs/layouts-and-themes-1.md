### Versione HEAD

# Struttura dei Temi

## Posizionamento Corretto dei Temi

Nel progetto, è fondamentale mantenere una chiara separazione tra moduli funzionali e temi. I temi devono essere posizionati nella directory `Themes`, non nella directory `Modules`.

### Struttura Corretta

```
/laravel/
├── Modules/        # Contiene i moduli funzionali
│   ├── Xot/
│   ├── User/
│   ├── Patient/
│   └── ...
└── Themes/         # Contiene i temi dell'applicazione
    ├── One/        # Tema principale
    └── ...
```

### Errore Identificato

È stato identificato un errore di implementazione: il tema One è stato erroneamente posizionato come modulo in:

```
/laravel/Modules/ThemeOne
```

Quando invece dovrebbe essere posizionato in:

```
/laravel/Themes/One
```

## Conseguenze dell'Errore

Questo posizionamento errato può causare diversi problemi:

1. **Caricamento errato del tema**: Laravel e i gestori di temi cercano i temi nella directory `Themes`
2. **Conflitti di namespace**: I namespace dei temi dovrebbero essere `Themes\NomeTema` e non `Modules\NomeTema`
3. **Problemi di autoloading**: I service provider dei temi potrebbero non essere caricati correttamente
4. **Conflitti con il sistema di moduli**: Il sistema di gestione moduli potrebbe tentare di caricare il tema come un modulo, causando comportamenti imprevisti

## Azione Correttiva

Per correggere questa situazione, è necessario:

1. Spostare il contenuto della directory `Modules/ThemeOne` in `Themes/One`
2. Aggiornare i riferimenti al tema nel codice
3. Aggiornare eventuali service provider che registrano il tema
4. Rigenerare l'autoloader

```bash
# Creare la directory Themes se non esiste
mkdir -p /laravel/Themes

# Spostare il tema nella posizione corretta
mv /laravel/Modules/ThemeOne /laravel/Themes/One

# Rigenerare l'autoloader
cd /laravel
composer dump-autoload -o
```

## Linee Guida per la Gestione dei Temi

### Utilizzo di git subtree

Quando si aggiunge un tema con git subtree, utilizzare il seguente formato:

```bash
# Corretto
git subtree add -P Themes/NomeTema git@repository:owner/theme.git branch --squash

# NON utilizzare (errato)
git subtree add -P Modules/ThemeNome git@repository:owner/theme.git branch --squash
```

### Namespace

I namespace nei file del tema dovrebbero seguire la convenzione:

```php
namespace Themes\NomeTema;
```

e non:

```php
namespace Modules\ThemeNome;
```

## Gestione dei Temi

### Importante: Integrazione con il Modulo Cms

Un'importante considerazione sulla struttura dei temi è che tutta la logica di gestione dei temi è già implementata dal **modulo Cms**. Non è necessario creare un service provider dedicato (come `ThemeServiceProvider`) poiché il modulo Cms si occupa già di:

- Registrare le viste dei temi
- Registrare i componenti Blade dei temi
- Gestire le configurazioni dei temi
- Fornire i meccanismi di switch tra temi diversi

Questo approccio centralizzato garantisce coerenza e riduce la duplicazione del codice, semplificando la manutenzione dell'applicazione.

### Come Funziona l'Integrazione

Il modulo Cms rileva automaticamente i temi nella directory `Themes/` e li registra nel sistema, rendendo disponibili:

- Viste e layout dei temi
- Componenti Blade
- Asset e risorse statiche
- Configurazioni specifiche dei temi

Qualsiasi tentativo di implementare un service provider dedicato per i temi sarebbe ridondante e potrebbe causare conflitti con la gestione esistente implementata dal modulo Cms.

## Struttura Directory

```
laravel/Themes/
├── One/
│   ├── resources/
│   │   ├── views/
│   │   │   ├── home.blade.php
│   │   │   ├── welcome.blade.php
│   │   │   └── ...
│   │   ├── assets/
│   │   └── ...
│   └── ...
└── ...
```

## Componenti del Tema

### Views

Le viste sono organizzate in:
- `home.blade.php`: Template principale della homepage
- `welcome.blade.php`: Template di benvenuto
- Altri template specifici per sezioni

### Assets

Ogni tema può avere i propri:
- CSS
- JavaScript
- Immagini
- Altri file statici

## Sistema di Caricamento

Il contenuto viene caricato dinamicamente attraverso:
```php
{{ $_theme->showPageContent('nome_pagina') }}
```

## Personalizzazione

### Modificare un Tema

1. Identificare il tema corrente
2. Modificare i file necessari
3. Testare le modifiche
4. Documentare i cambiamenti

### Creare un Nuovo Tema

1. Creare una nuova directory in `laravel/Themes/`
2. Copiare la struttura base
3. Personalizzare i file
4. Registrare il tema nel sistema

## Best Practices

- Mantenere la compatibilità con il sistema di temi
- Documentare tutte le personalizzazioni
- Testare su diversi dispositivi
- Seguire le convenzioni di naming
- Mantenere il codice pulito e organizzato

# Layouts e Temi UI

## Gestione conflitti e pulizia componenti hero

## Gestione conflitti azione icone (GetAllIconsAction)

Nel file GetAllIconsAction.php è stato risolto un conflitto mantenendo una sola versione coerente e tipizzata della funzione execute. Sono stati rimossi duplicati e marcatori git, garantendo:
- Robustezza e chiarezza della logica di recupero icone
- Coerenza con le convenzioni PSR-12 e PHP 8.2+
- Facilità di manutenzione futura

Questa scelta evita ambiguità e possibili errori runtime nella gestione delle icone dinamiche.

Per il ragionamento generale sulle strategie di risoluzione, vedi la [documentazione centrale](../../../../../../docs/risoluzione_conflitti_git.md).

In caso di conflitti nei componenti hero (es. simple.blade.php), è fondamentale:
- Rimuovere codice commentato o superfluo lasciato da template generici o da sviluppi temporanei.
- Mantenere solo la versione corretta e validata dei contenuti (es. titoli, testi, markup).
- Garantire che i componenti hero siano semplici, puliti e aderenti alle specifiche di design del progetto.

**Decisione architetturale**: In simple.blade.php è stato rimosso un blocco di codice commentato relativo a header e menu di esempio, mantenendo solo la struttura effettivamente utilizzata e correggendo il titolo. Questa scelta assicura chiarezza, manutenibilità e coerenza visiva.

Per ulteriori dettagli sulle strategie di risoluzione dei conflitti, fare riferimento alla [documentazione centrale](../../../../../../docs/risoluzione_conflitti_git.md).

## Layout System

### Grid System
```blade
{{-- Grid base a 12 colonne --}}
<x-ui::grid cols="12">
    <x-ui::col span="4">Sidebar</x-ui::col>
    <x-ui::col span="8">Content</x-ui::col>
</x-ui::grid>

{{-- Grid responsive --}}
<x-ui::grid cols="1" sm="2" md="3" lg="4">
    <x-ui::col>Item 1</x-ui::col>
    <x-ui::col>Item 2</x-ui::col>
</x-ui::grid>

{{-- Grid con gap --}}
<x-ui::grid cols="3" gap="4">
    <x-ui::col>Card 1</x-ui::col>
    <x-ui::col>Card 2</x-ui::col>
</x-ui::grid>
```

### Container
```blade
{{-- Container standard --}}
<x-ui::container>
    <x-ui::content>
        <!-- Contenuto principale -->
    </x-ui::content>
</x-ui::container>

{{-- Container fluid --}}
<x-ui::container fluid>
    <!-- Contenuto full-width -->
</x-ui::container>

{{-- Container con padding personalizzato --}}
<x-ui::container class="px-4 py-8">
    <!-- Contenuto con padding -->
</x-ui::container>
```

### Layouts Predefiniti

#### AdminLayout
```php
use Modules\UI\Layouts\AdminLayout;

class Dashboard extends Component
{
    protected static string $layout = AdminLayout::class;

    protected function getLayoutData(): array
    {
        return [
            'title' => 'Dashboard',
            'breadcrumbs' => [
                'Home' => route('home'),
                'Dashboard' => null
            ],
            'menu' => [
                [
                    'label' => 'Portafoglio',
                    'icon' => 'heroicon-o-briefcase',
                    'items' => [
                        [
                            'label' => 'Polizze',
                            'route' => 'polizze.index'
                        ]
                    ]
                ]
            ]
        ];
    }
}
```

#### PrintLayout
```php
use Modules\UI\Layouts\PrintLayout;

class StampaPratica extends Component
{
    protected static string $layout = PrintLayout::class;

    protected function getLayoutData(): array
    {
        return [
            'title' => 'Pratica #123',
            'orientation' => 'portrait',
            'pageSize' => 'a4',
            'margins' => [
                'top' => 20,
                'right' => 15,
                'bottom' => 20,
                'left' => 15
            ],
            'header' => view('header'),
            'footer' => view('footer')
        ];
    }
}
```

## Sistema dei Temi

### Configurazione
```php
// config/ui.php
return [
    'theme' => [
        // Colori principali
        'colors' => [
            'primary' => [
                50 => '#f0fdf4',
                100 => '#dcfce7',
                500 => '#22c55e',
                700 => '#15803d',
                900 => '#14532d',
            ],
            'secondary' => [
                500 => '#3b82f6',
            ],
            'success' => '#22c55e',
            'warning' => '#f59e0b',
            'danger' => '#ef4444',
        ],

        // Tipografia
        'typography' => [
            'fonts' => [
                'base' => 'Inter var',
                'mono' => 'JetBrains Mono',
            ],
            'sizes' => [
                'base' => '1rem',
                'lg' => '1.125rem',
                'xl' => '1.25rem',
            ],
        ],

        // Spaziature
        'spacing' => [
            'base' => '1rem',
            'lg' => '1.5rem',
            'xl' => '2rem',
        ],

        // Bordi
        'border' => [
            'radius' => '0.375rem',
            'width' => '1px',
        ],

        // Ombre
        'shadows' => [
            'sm' => '0 1px 2px 0 rgb(0 0 0 / 0.05)',
            'md' => '0 4px 6px -1px rgb(0 0 0 / 0.1)',
            'lg' => '0 10px 15px -3px rgb(0 0 0 / 0.1)',
        ],
    ],
];
```

### Personalizzazione Tema

#### Override CSS
```css
/* resources/css/theme.css */
:root {
    --color-primary-500: #22c55e;
    --font-family-base: 'Inter var';
    --spacing-base: 1rem;
}

.dark {
    --color-primary-500: #4ade80;
}
```

#### Estensione Tailwind
```js
// tailwind.config.js
module.exports = {
    theme: {
        extend: {
            colors: {
                primary: {
                    50: 'var(--color-primary-50)',
                    500: 'var(--color-primary-500)',
                    900: 'var(--color-primary-900)',
                },
            },
            fontFamily: {
                sans: ['var(--font-family-base)'],
                mono: ['var(--font-family-mono)'],
            },
            spacing: {
                base: 'var(--spacing-base)',
            },
        },
    },
};
```

### Dark Mode
```php
// Attivazione dark mode
AdminLayout::make()
    ->darkMode(true)
    ->darkModeToggle(true);

// Stili condizionali
<div class="bg-white dark:bg-gray-800">
    <h1 class="text-gray-900 dark:text-white">
        Titolo
    </h1>
</div>
```

### Responsive Design
```blade
{{-- Breakpoints standard --}}
<div class="hidden sm:block md:hidden lg:block">
    <!-- Visibile su small e large, nascosto su medium -->
</div>

{{-- Layout responsive --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
    <!-- Grid responsive -->
</div>

{{-- Tipografia responsive --}}
<h1 class="text-xl md:text-2xl lg:text-3xl">
    <!-- Titolo responsive -->
</h1>
```

### Best Practices

1. **Consistenza**
   - Utilizzare le variabili del tema
   - Mantenere una palette colori coerente
   - Seguire le scale tipografiche

2. **Accessibilità**
   - Garantire contrasto sufficiente
   - Supportare dark mode
   - Testare con screen reader

3. **Performance**
   - Ottimizzare assets
   - Utilizzare lazy loading
   - Minimizzare CSS

4. **Manutenibilità**
   - Documentare personalizzazioni
   - Seguire convenzioni di naming
   - Centralizzare configurazioni
