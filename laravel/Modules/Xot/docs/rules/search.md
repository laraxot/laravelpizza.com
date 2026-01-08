## Gestione degli SVG

### Utilizzo degli SVG in Filament

1. **Componenti Icona**
   - Utilizzare sempre il componente `x-filament::icon` per le icone
   - Supporto nativo per Heroicons e Filament Icons
   - Esempio: `<x-filament::icon name="heroicon-o-home" />`

2. **Pacchetti Icone**
   - Heroicons: `heroicon-o-*` per outline, `heroicon-s-*` per solid
   - Filament Icons: `filament-*` per icone specifiche di Filament
   - Blade Icons: supporto per pacchetti personalizzati

3. **Best Practices**
   - Utilizzare sempre icone da pacchetti ufficiali
   - Evitare SVG inline quando possibile
   - Supporto dark/light mode con classi appropriate
   - Dimensioni standardizzate (h-4 w-4, h-6 w-6, h-8 w-8)

4. **Personalizzazione**
   - Override delle icone tramite configurazione
   - Registrazione di set di icone personalizzati
   - Supporto per colori e dimensioni dinamiche 

## Gestione dei Blocchi

### Struttura dei Dati
1. **Dati Diretti**
   - I blocchi ricevono direttamente i dati come props
   - Non utilizzare `$block->data` ma accettare i dati direttamente
   - Esempio: `@props(['src', 'alt', 'width', 'height'])`

2. **Configurazione**
   - I dati sono definiti nei file JSON delle sezioni
   - Path: `/laravel/config/local/<nome progetto>/database/content/sections/`
   - Struttura: `{ "data": { "key": "value" } }`

3. **Best Practices**
   - Definire valori di default per tutte le props
   - Utilizzare nomi di props chiari e descrittivi
   - Mantenere la coerenza tra dati JSON e props del componente
   - Documentare la struttura dei dati nel file JSON

4. **Validazione**
   - Verificare sempre la presenza dei dati necessari
   - Utilizzare valori di default appropriati
   - Gestire i casi di dati mancanti 

## Gestione dei Percorsi delle Risorse

### Struttura delle Directory
1. **Directory Pubbliche**
   - `public_html/`: Root pubblica del sito
   - `public_html/images/`: Immagini pubbliche
   - `public_html/css/`: CSS pubblici
   - `public_html/js/`: JavaScript pubblici

2. **Percorsi nei JSON**
   - I percorsi devono essere relativi a `public_html`
   - Esempio: `/images/logo.svg` non `images/logo.svg`
   - Mai usare percorsi assoluti del filesystem

3. **Helper Laravel**
   - Usare sempre `URL::asset()` invece di `asset()`
   - `URL::asset()` è la macro personalizzata di Xot
   - Esempio: `URL::asset('/images/logo.svg')`
   - L'helper globale `asset()` non viene intercettato dalla macro

4. **Best Practices**
   - Documentare la struttura delle directory
   - Standardizzare i percorsi nei JSON
   - Verificare sempre l'esistenza delle risorse
   - Usare percorsi relativi a `public_html`

5. **Validazione**
   - Controllare che i percorsi inizino con `/`
   - Verificare che le risorse esistano
   - Gestire i casi di percorsi errati 

## Struttura delle Directory

### Struttura Standard
1. **Moduli**
   - `/laravel/Modules/NomeModulo/app/`
   - `/laravel/Modules/NomeModulo/resources/`
   - `/laravel/Modules/NomeModulo/config/`

2. **Temi**
   - `/laravel/Themes/NomeTema/app/`
   - `/laravel/Themes/NomeTema/resources/`
   - `/laravel/Themes/NomeTema/config/`

3. **Directory Principali**
   - `app/`: Contiene il codice sorgente
   - `resources/`: Contiene assets e viste
   - `config/`: Contiene configurazioni
   - `database/`: Contiene migrazioni e seeders
   - `routes/`: Contiene le rotte

4. **Struttura App**
   - `app/Providers/`: Service Providers
   - `app/Models/`: Modelli
   - `app/Http/`: Controller e Middleware
   - `app/Console/`: Comandi Artisan

5. **Best Practices**
   - Seguire sempre la struttura PSR-4
   - Mantenere la coerenza tra moduli e temi
   - Documentare la struttura delle directory
   - Verificare i namespace

6. **Validazione**
   - Controllare i percorsi prima di creare file
   - Verificare i namespace
   - Assicurarsi che le directory esistano
   - Seguire le convenzioni Laravel 

## Gestione delle Traduzioni

### Struttura delle Traduzioni
1. **Modulo Lang**
   - `/laravel/Modules/Lang/docs/`: Documentazione tradotta
   - `/laravel/Modules/Lang/resources/lang/`: File di traduzione
   - Struttura per lingua: `it/`, `en/`, etc.

2. **Moduli con Traduzioni**
   - Ogni modulo ha la sua cartella `docs/`
   - Collegamenti bidirezionali con `Lang/docs/`
   - File di traduzione nel modulo `Lang`

3. **Collegamenti Bidirezionali**
   - Ogni file `.md` deve avere un corrispondente in `Lang/docs/`
   - I collegamenti devono essere mantenuti aggiornati
   - Le traduzioni devono essere sincronizzate

4. **Best Practices**
   - Usare chiavi di traduzione univoche
   - Mantenere la struttura delle directory
   - Verificare i collegamenti
   - Aggiornare le traduzioni

5. **Struttura dei File**
   ```
   Module/docs/
   ├── it/
   │   └── file.md -> ../../Lang/docs/it/file.md
   └── en/
       └── file.md -> ../../Lang/docs/en/file.md
   ```

6. **Validazione**
   - Verificare i collegamenti
   - Controllare le traduzioni
   - Assicurare la sincronizzazione
   - Mantenere la coerenza

7. **Template Traduzioni**
   - Usare il template standard
   - Includere metadati
   - Seguire la struttura
   - Mantenere la formattazione

8. **Processo di Traduzione**
   - Creare file sorgente
   - Generare template traduzione
   - Tradurre contenuti
   - Verificare collegamenti
   - Aggiornare metadati 

## Collegamenti tra versioni di search.md
* [search.md](docs/rules/search.md)
* [search.md](../../../Xot/docs/features/search.md)
* [search.md](../../../Xot/docs/rules/search.md)

