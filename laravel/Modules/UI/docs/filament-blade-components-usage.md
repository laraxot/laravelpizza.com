# Utilizzo dei Componenti Blade di Filament

## Indice
- [Panoramica](#panoramica)
- [Componenti Disponibili](#componenti-disponibili)
- [Utilizzo delle Icone](#utilizzo-delle-icone)
- [Migrazione da Componenti Personalizzati](#migrazione-da-componenti-personalizzati)
- [Best Practices](#best-practices)

## Panoramica

Questo documento descrive l'utilizzo corretto dei componenti Blade nativi di Filament , con particolare attenzione alla sostituzione dei componenti personalizzati con quelli forniti da Filament.

## Componenti Disponibili

Filament fornisce una serie di componenti Blade pronti all'uso che dovrebbero essere utilizzati al posto dei componenti personalizzati quando possibile:

### Componenti UI Principali

- `<x-filament::section>` - Sezioni con titolo, descrizione e contenuto
- `<x-filament::card>` - Card con bordi arrotondati e ombreggiatura
- `<x-filament::dropdown>` - Menu a discesa (vedi [Dropdown](#dropdown))
- `<x-filament::modal>` - Finestre modali
- `<x-filament::button>` - Pulsanti stilizzati

### Componenti per Form

- `<x-filament::input>` - Campi di input
- `<x-filament::select>` - Menu a discesa selezionabili
- `<x-filament::checkbox>` - Caselle di controllo
- `<x-filament::textarea>` - Aree di testo

### Componenti per Layout

- `<x-filament::grid>` - Layout a griglia responsive
- `<x-filament::section>` - Sezione con titolo e descrizione

### Layout NON disponibili in Filament

⚠️ **ATTENZIONE**: I seguenti layout **NON esistono** in Filament e non devono essere utilizzati:

- ❌ `<x-filament::layouts.app>` - Non esiste, utilizzare invece `<x-layouts.app>` di
- ❌ `<x-filament::layouts.app>` - Non esiste, utilizzare invece `<x-layouts.app>` di <nome progetto>
- ❌ `<x-filament::layouts.app>` - Non esiste, utilizzare invece `<x-layouts.app>` di
- ❌ `<x-filament::layouts.app>` - Non esiste, utilizzare invece `<x-layouts.app>` di <nome progetto>
- ❌ `<x-filament::layouts.app>` - Non esiste, utilizzare invece `<x-layouts.app>` di
- ❌ `<x-filament::layouts.app>` - Non esiste, utilizzare invece `<x-layouts.app>` di <nome progetto>
- ❌ `<x-filament::layouts.card>` - Non esiste, utilizzare invece una combinazione di `<x-filament::card>` e altri componenti
- ❌ `<x-filament::layouts.base>` - Non esiste

### Componenti per Feedback

- `<x-filament::loading-indicator>` - Indicatore di caricamento
- `<x-filament::badge>` - Badge colorati per stati
- `<x-filament::alert>` - Avvisi e notifiche

## Utilizzo delle Icone

### Componente Icon di Filament

Filament fornisce un componente nativo per le icone che dovrebbe essere utilizzato al posto di componenti personalizzati:

```blade
<!-- ERRATO: Componente personalizzato -->
<x-ui.icon name="user" class="h-5 w-5" />

<!-- CORRETTO: Componente Filament -->
<x-filament::icon
    name="heroicon-o-user"
    class="h-5 w-5"
/>
```

### Set di Icone Supportati

Filament supporta nativamente diversi set di icone:

1. **Heroicons** (predefinito)
   ```blade
   <x-filament::icon name="heroicon-o-user" />  <!-- Outline -->
   <x-filament::icon name="heroicon-s-user" />  <!-- Solid -->
   ```

2. **Icone personalizzate**
   ```blade
   <x-filament::icon name="custom-icon-name" />
   ```

### Dimensioni e Stili

```blade
<x-filament::icon
    name="heroicon-o-user"
    class="h-8 w-8 text-primary-600"
/>
```

## Migrazione da Componenti Personalizzati

### Da ui.icon a filament::icon

| Componente Personalizzato | Componente Filament |
|---------------------------|---------------------|
| `<x-ui.icon name="user" />` | `<x-filament::icon name="heroicon-o-user" />` |
| `<x-ui.icon name="menu" />` | `<x-filament::icon name="heroicon-o-bars-3" />` |
| `<x-ui.icon name="close" />` | `<x-filament::icon name="heroicon-o-x-mark" />` |
| `<x-ui.icon name="logout" />` | `<x-filament::icon name="heroicon-o-arrow-right-on-rectangle" />` |
| `<x-ui.icon name="settings" />` | `<x-filament::icon name="heroicon-o-cog-6-tooth" />` |
| `<x-ui.icon name="home" />` | `<x-filament::icon name="heroicon-o-home" />` |
| `<x-ui.icon name="chevron-down" />` | `<x-filament::icon name="heroicon-o-chevron-down" />` |
| `<x-ui.icon name="default-avatar" />` | `<x-filament::icon name="heroicon-o-user-circle" />` |

### Da ui.button a filament::button

```blade
<!-- ERRATO -->
<x-ui.button type="primary" rounded="md">
    Pulsante
</x-ui.button>

<!-- CORRETTO -->
<x-filament::button>
    Pulsante
</x-filament::button>
```

## Dropdown

### Struttura Corretta dei Dropdown

I dropdown di Filament hanno una struttura specifica che deve essere rispettata. Ecco l'implementazione corretta:

```blade
<x-filament::dropdown placement="bottom-end" width="xs">
    <x-slot name="trigger">
        <!-- Elemento che attiva il dropdown -->
        <button class="...">
            Contenuto del trigger
        </button>
    </x-slot>

    <x-filament::dropdown.list>
        <!-- Intestazione del dropdown -->
        <div class="px-4 py-2 text-xs text-gray-400">
            {{ __('Titolo Sezione') }}
        </div>

        <!-- Elementi del dropdown -->
        <x-filament::dropdown.list.item
            icon="heroicon-o-user"
            href="/{{ LaravelLocalization::getCurrentLocale() }}/percorso"
            tag="a"
        >
            {{ __('Etichetta') }}
        </x-filament::dropdown.list.item>

        <!-- Separatore (IMPORTANTE: usare un div, NON un componente) -->
        <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>

        <!-- Form per azioni come logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-filament::dropdown.list.item
                tag="button"
                type="submit"
                icon="heroicon-o-arrow-right-on-rectangle"
                color="danger"
            >
                {{ __('Log Out') }}
            </x-filament::dropdown.list.item>
        </form>
    </x-filament::dropdown.list>
</x-filament::dropdown>
```

### Errori Comuni da Evitare

1. **NON utilizzare** `<x-filament::dropdown.list.separator />` o `<x-filament::dropdown.list.divider />` - Questi componenti non esistono in Filament. Utilizzare invece un div con bordo:
   ```blade
   <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
   ```

2. **NON utilizzare** `route()` per percorsi frontend - Utilizzare invece percorsi diretti con localizzazione:
   ```blade
   href="/{{ LaravelLocalization::getCurrentLocale() }}/percorso"
   ```

3. **NON nidificare** elementi dropdown in modo errato - Rispettare la struttura gerarchica dei componenti Filament.

## Gestione delle Rotte

### Regole Fondamentali

1. **MAI creare rotte aggiungendole in web.php**
   - Filament gestisce automaticamente le rotte dell'amministrazione
   - Folio gestisce automaticamente le rotte del frontend

2. **Per le pagine frontend**:
   - Creare file Blade in `Themes/One/resources/views/pages/`
   - Creare file Blade in `Themes/One/resources/views/pages/`
   - Creare file Blade in `Themes/One/resources/views/pages/`
   - Creare file Blade in `Themes/One/resources/views/pages/`
   - Creare file Blade in `Themes/One/resources/views/pages/`
   - Creare file Blade in `Themes/One/resources/views/pages/`
   - Utilizzare Folio per il routing automatico
   - Esempio: `/profile/index.blade.php` sarà accessibile come `/it/profile`

3. **Per i link localizzati**:
   - Utilizzare sempre `LaravelLocalization::getCurrentLocale()` per ottenere la lingua corrente
   - Costruire i percorsi con il prefisso della lingua: `/{{ LaravelLocalization::getCurrentLocale() }}/percorso`
   - NON utilizzare `app()->getLocale()` per la localizzazione

4. **Per i form e le azioni**:
   - Utilizzare le rotte predefinite di Laravel/Filament (es. `route('logout')`) solo quando necessario
   - Per le azioni frontend, utilizzare sempre percorsi Folio

## Best Practices

1. **Preferire sempre i componenti nativi di Filament** rispetto a componenti personalizzati
2. **Mantenere la coerenza visiva** utilizzando i componenti Filament in tutta l'applicazione
3. **Evitare di sovrascrivere gli stili** dei componenti Filament a meno che non sia assolutamente necessario
4. **Utilizzare le varianti fornite** dai componenti Filament invece di creare varianti personalizzate
5. **Seguire la documentazione ufficiale** di Filament per l'utilizzo corretto dei componenti

## Risorse Utili

- [Documentazione Ufficiale di Filament](https://filamentphp.com/docs)
- [Componenti Blade di Filament](https://filamentphp.com/docs/3.x/support/blade-components)
- [Icone in Filament](https://filamentphp.com/docs/3.x/support/icons)

## Conclusione

Utilizzando i componenti Blade nativi di Filament, possiamo garantire una maggiore coerenza visiva, una migliore manutenibilità del codice e un'esperienza utente più fluida . Inoltre, possiamo beneficiare degli aggiornamenti e dei miglioramenti futuri di Filament senza dover modificare i nostri componenti personalizzati.
# Utilizzo dei Componenti Blade di Filament

## Indice
- [Panoramica](#panoramica)
- [Componenti Disponibili](#componenti-disponibili)
- [Utilizzo delle Icone](#utilizzo-delle-icone)
- [Migrazione da Componenti Personalizzati](#migrazione-da-componenti-personalizzati)
- [Best Practices](#best-practices)

## Panoramica

Questo documento descrive l'utilizzo corretto dei componenti Blade nativi di Filament , con particolare attenzione alla sostituzione dei componenti personalizzati con quelli forniti da Filament.

## Componenti Disponibili

Filament fornisce una serie di componenti Blade pronti all'uso che dovrebbero essere utilizzati al posto dei componenti personalizzati quando possibile:

### Componenti UI Principali

- `<x-filament::section>` - Sezioni con titolo, descrizione e contenuto
- `<x-filament::card>` - Card con bordi arrotondati e ombreggiatura
- `<x-filament::dropdown>` - Menu a discesa (vedi [Dropdown](#dropdown))
- `<x-filament::modal>` - Finestre modali
- `<x-filament::button>` - Pulsanti stilizzati

### Componenti per Form

- `<x-filament::input>` - Campi di input
- `<x-filament::select>` - Menu a discesa selezionabili
- `<x-filament::checkbox>` - Caselle di controllo
- `<x-filament::textarea>` - Aree di testo

### Componenti per Layout

- `<x-filament::grid>` - Layout a griglia responsive
- `<x-filament::section>` - Sezione con titolo e descrizione

### Layout NON disponibili in Filament

⚠️ **ATTENZIONE**: I seguenti layout **NON esistono** in Filament e non devono essere utilizzati:

- ❌ `<x-filament::layouts.app>` - Non esiste, utilizzare invece `<x-layouts.app>` di <nome progetto>
- ❌ `<x-filament::layouts.card>` - Non esiste, utilizzare invece una combinazione di `<x-filament::card>` e altri componenti
- ❌ `<x-filament::layouts.base>` - Non esiste

### Componenti per Feedback

- `<x-filament::loading-indicator>` - Indicatore di caricamento
- `<x-filament::badge>` - Badge colorati per stati
- `<x-filament::alert>` - Avvisi e notifiche

## Utilizzo delle Icone

### Componente Icon di Filament

Filament fornisce un componente nativo per le icone che dovrebbe essere utilizzato al posto di componenti personalizzati:

```blade
<!-- ERRATO: Componente personalizzato -->
<x-ui.icon name="user" class="h-5 w-5" />

<!-- CORRETTO: Componente Filament -->
<x-filament::icon
    name="heroicon-o-user"
    class="h-5 w-5"
/>
```

### Set di Icone Supportati

Filament supporta nativamente diversi set di icone:

1. **Heroicons** (predefinito)
   ```blade
   <x-filament::icon name="heroicon-o-user" />  <!-- Outline -->
   <x-filament::icon name="heroicon-s-user" />  <!-- Solid -->
   ```

2. **Icone personalizzate**
   ```blade
   <x-filament::icon name="custom-icon-name" />
   ```

### Dimensioni e Stili

```blade
<x-filament::icon
    name="heroicon-o-user"
    class="h-8 w-8 text-primary-600"
/>
```

## Migrazione da Componenti Personalizzati

### Da ui.icon a filament::icon

| Componente Personalizzato | Componente Filament |
|---------------------------|---------------------|
| `<x-ui.icon name="user" />` | `<x-filament::icon name="heroicon-o-user" />` |
| `<x-ui.icon name="menu" />` | `<x-filament::icon name="heroicon-o-bars-3" />` |
| `<x-ui.icon name="close" />` | `<x-filament::icon name="heroicon-o-x-mark" />` |
| `<x-ui.icon name="logout" />` | `<x-filament::icon name="heroicon-o-arrow-right-on-rectangle" />` |
| `<x-ui.icon name="settings" />` | `<x-filament::icon name="heroicon-o-cog-6-tooth" />` |
| `<x-ui.icon name="home" />` | `<x-filament::icon name="heroicon-o-home" />` |
| `<x-ui.icon name="chevron-down" />` | `<x-filament::icon name="heroicon-o-chevron-down" />` |
| `<x-ui.icon name="default-avatar" />` | `<x-filament::icon name="heroicon-o-user-circle" />` |

### Da ui.button a filament::button

```blade
<!-- ERRATO -->
<x-ui.button type="primary" rounded="md">
    Pulsante
</x-ui.button>

<!-- CORRETTO -->
<x-filament::button>
    Pulsante
</x-filament::button>
```

## Dropdown

### Struttura Corretta dei Dropdown

I dropdown di Filament hanno una struttura specifica che deve essere rispettata. Ecco l'implementazione corretta:

```blade
<x-filament::dropdown placement="bottom-end" width="xs">
    <x-slot name="trigger">
        <!-- Elemento che attiva il dropdown -->
        <button class="...">
            Contenuto del trigger
        </button>
    </x-slot>

    <x-filament::dropdown.list>
        <!-- Intestazione del dropdown -->
        <div class="px-4 py-2 text-xs text-gray-400">
            {{ __('Titolo Sezione') }}
        </div>

        <!-- Elementi del dropdown -->
        <x-filament::dropdown.list.item
            icon="heroicon-o-user"
            href="/{{ LaravelLocalization::getCurrentLocale() }}/percorso"
            tag="a"
        >
            {{ __('Etichetta') }}
        </x-filament::dropdown.list.item>

        <!-- Separatore (IMPORTANTE: usare un div, NON un componente) -->
        <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>

        <!-- Form per azioni come logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-filament::dropdown.list.item
                tag="button"
                type="submit"
                icon="heroicon-o-arrow-right-on-rectangle"
                color="danger"
            >
                {{ __('Log Out') }}
            </x-filament::dropdown.list.item>
        </form>
    </x-filament::dropdown.list>
</x-filament::dropdown>
```

### Errori Comuni da Evitare

1. **NON utilizzare** `<x-filament::dropdown.list.separator />` o `<x-filament::dropdown.list.divider />` - Questi componenti non esistono in Filament. Utilizzare invece un div con bordo:
   ```blade
   <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
   ```

2. **NON utilizzare** `route()` per percorsi frontend - Utilizzare invece percorsi diretti con localizzazione:
   ```blade
   href="/{{ LaravelLocalization::getCurrentLocale() }}/percorso"
   ```

3. **NON nidificare** elementi dropdown in modo errato - Rispettare la struttura gerarchica dei componenti Filament.

## Gestione delle Rotte

### Regole Fondamentali

1. **MAI creare rotte aggiungendole in web.php**
   - Filament gestisce automaticamente le rotte dell'amministrazione
   - Folio gestisce automaticamente le rotte del frontend

2. **Per le pagine frontend**:
   - Creare file Blade in `Themes/One/resources/views/pages/`
   - Utilizzare Folio per il routing automatico
   - Esempio: `/profile/index.blade.php` sarà accessibile come `/it/profile`

3. **Per i link localizzati**:
   - Utilizzare sempre `LaravelLocalization::getCurrentLocale()` per ottenere la lingua corrente
   - Costruire i percorsi con il prefisso della lingua: `/{{ LaravelLocalization::getCurrentLocale() }}/percorso`
   - NON utilizzare `app()->getLocale()` per la localizzazione

4. **Per i form e le azioni**:
   - Utilizzare le rotte predefinite di Laravel/Filament (es. `route('logout')`) solo quando necessario
   - Per le azioni frontend, utilizzare sempre percorsi Folio

## Best Practices

1. **Preferire sempre i componenti nativi di Filament** rispetto a componenti personalizzati
2. **Mantenere la coerenza visiva** utilizzando i componenti Filament in tutta l'applicazione
3. **Evitare di sovrascrivere gli stili** dei componenti Filament a meno che non sia assolutamente necessario
4. **Utilizzare le varianti fornite** dai componenti Filament invece di creare varianti personalizzate
5. **Seguire la documentazione ufficiale** di Filament per l'utilizzo corretto dei componenti

## Risorse Utili

- [Documentazione Ufficiale di Filament](https://filamentphp.com/docs)
- [Componenti Blade di Filament](https://filamentphp.com/docs/3.x/support/blade-components)
- [Icone in Filament](https://filamentphp.com/docs/3.x/support/icons)

## Conclusione

Utilizzando i componenti Blade nativi di Filament, possiamo garantire una maggiore coerenza visiva, una migliore manutenibilità del codice e un'esperienza utente più fluida . Inoltre, possiamo beneficiare degli aggiornamenti e dei miglioramenti futuri di Filament senza dover modificare i nostri componenti personalizzati.
