# Gestione delle Lingue (Locales) in Laravel

## Introduzione

In Laravel, la gestione delle lingue (locales) è fondamentale per determinare quale lingua utilizzare per le traduzioni. Ogni progetto Laravel ha una lingua predefinita e una di fallback. Questa documentazione, basata sul corso di Laravel Daily, esplora come configurare queste impostazioni e propone modifiche per il progetto `<nome progetto>`.

## Configurazione della Lingua Predefinita

Per impostare la lingua predefinita dell'applicazione, modificare il file `config/app.php`:

```php
'locale' => 'it',
// Deve corrispondere al nome della cartella in `lang/FOLDER` o al nome del file `lang/KEY.json`.
```

Questa sarà la lingua predefinita per tutti gli utenti dell'applicazione. È importante non lasciare il valore predefinito 'en' se l'applicazione è destinata a un pubblico con una lingua diversa.

## Configurazione della Lingua di Fallback

La lingua di fallback viene utilizzata quando una traduzione non è disponibile nella lingua predefinita. Configurarla in `config/app.php`:

```php
'fallback_locale' => 'en',
```

Quando una traduzione manca nella lingua predefinita, Laravel cercherà la traduzione nella lingua di fallback. Ad esempio, se la lingua predefinita è 'it' e manca una traduzione per 'register', Laravel utilizzerà la traduzione da `lang/en/auth.php`:

```php
return [
    // ...
    'register' => 'Registration',
];
```

Questo evita di mostrare agli utenti la chiave di traduzione non tradotta.

## Limitazioni delle Traduzioni JSON con Fallback

Le traduzioni basate su file JSON non funzionano con il fallback nello stesso modo dei file PHP. Se una traduzione manca nel file JSON della lingua predefinita, Laravel non cercherà nel file JSON della lingua di fallback, ma mostrerà direttamente la chiave di traduzione.

Ad esempio, con:
- Lingua predefinita: 'it'
- Lingua di fallback: 'en'
- Traduzione in `lang/en.json`:
  ```json
  {
      "Register": "Registration"
  }
  ```

Se la traduzione per 'Register' manca in `lang/it.json`, l'output sarà 'Register' invece di 'Registration'. Questo comportamento è diverso dai file PHP, dove il fallback funziona come previsto.

Un altro esempio con frasi più lunghe:
```php
<a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
    {{ __('Register to Join our Community') }}
</a>
```

Con traduzione in `lang/en.json`:
```json
{
    "Register to Join our Community": "Sign up to join our community"
}
```

Anche con il fallback configurato, se manca in `lang/it.json`, l'output sarà 'Register to Join our Community' invece della traduzione attesa.

## Impostazione Dinamica della Lingua nel Codice

Per progetti multilingue, la lingua dovrebbe essere impostata in base alle preferenze dell'utente o all'URL. Questo può essere fatto con il seguente codice:

```php
use Illuminate\Support\Facades\App;

// ...

if(! in_array($locale, ['en', 'it'])) {
    abort(404);
}

App::setLocale($locale);

// ...
```

Il posto migliore per questo codice è un middleware, che verrà trattato in dettaglio in lezioni successive sul cambio di lingua basato sull'interfaccia utente.

## Analisi e Ragionamento per il Progetto `<nome progetto>`

Considerando le regole di localizzazione del progetto `<nome progetto>`, che richiedono il prefisso della lingua negli URL (`/{locale}/{sezione}/{risorsa}`), è essenziale configurare correttamente la lingua predefinita e di fallback. Propongo di impostare 'it' (italiano) come lingua predefinita, poiché è probabile che sia la lingua principale per gli utenti target. La lingua di fallback sarà 'en' (inglese) per garantire che ci sia sempre una traduzione disponibile, anche se non perfetta.

Inoltre, data la limitazione del fallback con i file JSON, raccomando di continuare a utilizzare principalmente file PHP per le traduzioni strutturate, come discusso nella documentazione precedente (`/var/www/html/<nome progetto>/laravel/Modules/Lang/docs/static-text-translation.md`). I file JSON possono essere utilizzati per testi più lunghi, ma con la consapevolezza che il fallback non funzionerà come previsto.

Per l'impostazione dinamica della lingua, suggerisco di integrare questa logica con il pacchetto `mcamara/laravel-localization`, che è già documentato in `/var/www/html/<nome progetto>/laravel/Modules/Lang/docs/laravel-localization-complete.md`. Questo pacchetto gestisce il cambio di lingua tramite middleware, il che si allinea con le migliori pratiche.

## Modifiche Proposte

Di seguito elenco i file che modificherei e le modifiche specifiche che apporterei per implementare la gestione delle lingue nel progetto `<nome progetto>`:

1. **Configurazione della Lingua Predefinita e di Fallback**:
   - Modificare il file `/var/www/html/<nome progetto>/laravel/config/app.php`:
     ```php
     /*
      * Application Locale Configuration
      *
      * The application locale determines the default locale that will be used
      * by the translation service provider. You are free to set this value
      * to any of the locales which will be supported by the application.
      */
     'locale' => 'it',

     /*
      * Application Fallback Locale
      *
      * The fallback locale determines the locale to use when the current one
      * is not available. You may change the value to correspond to any of
      * the language folders that are provided through your application.
      */
     'fallback_locale' => 'en',
     ```
   - **Ragionamento**: Impostare 'it' come lingua predefinita riflette il pubblico principale del progetto `<nome progetto>`. 'en' come fallback garantisce che ci sia una traduzione di riserva, migliorando l'esperienza utente rispetto alla visualizzazione di chiavi non tradotte.

2. **Integrazione con `mcamara/laravel-localization` per l'Impostazione Dinamica della Lingua**:
   - Assicurarsi che il pacchetto sia installato come descritto in `/var/www/html/<nome progetto>/laravel/Modules/Lang/docs/laravel-localization-complete.md`.
   - Verificare che i middleware siano registrati in `/var/www/html/<nome progetto>/laravel/app/Http/Kernel.php`:
     ```php
     protected $routeMiddleware = [
         // ...
         'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
         'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
         'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
         'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
         'localeViewPath'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class
     ];
     ```
   - Modificare il file `/var/www/html/<nome progetto>/laravel/routes/web.php` per utilizzare il middleware di localizzazione:
     ```php
     Route::group([
         'prefix' => LaravelLocalization::setLocale(),
         'middleware' => ['localeSessionRedirect', 'localizationRedirect']
     ], function () {
         // Tutte le route web
         Route::get('/', function () {
             return view('welcome');
         });
         // altre route...
         require __DIR__ . '/auth.php';
     });
     ```
   - **Ragionamento**: Utilizzare `mcamara/laravel-localization` per gestire dinamicamente la lingua tramite URL e preferenze utente è più efficiente rispetto a un middleware personalizzato. Questo approccio si allinea con le regole del progetto che richiedono il prefisso della lingua negli URL e garantisce che la lingua sia impostata correttamente prima del caricamento delle traduzioni.

3. **Configurazione delle Lingue Supportate**:
   - Modificare il file `/var/www/html/<nome progetto>/laravel/config/laravellocalization.php` per definire le lingue supportate:
     ```php
     // Lingue supportate
     'supportedLocales' => [
         'it' => ['name' => 'Italian', 'script' => 'Latn', 'native' => 'Italiano', 'regional' => 'it_IT'],
         'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
         // Aggiungere altre lingue se necessario
     ],

     // Nascondere la lingua predefinita nell'URL (opzionale)
     'hideDefaultLocaleInURL' => false,
     ```
   - **Ragionamento**: Definire chiaramente le lingue supportate garantisce che il pacchetto `mcamara/laravel-localization` possa gestire correttamente i cambi di lingua. Mantenere `hideDefaultLocaleInURL` su `false` è coerente con la regola del progetto di includere sempre il prefisso della lingua negli URL.

4. **Uso di File PHP per Traduzioni Strutturate**:
   - Continuare a utilizzare file PHP per traduzioni strutturate, come raccomandato in `/var/www/html/<nome progetto>/laravel/Modules/Lang/docs/static-text-translation.md`.
   - Esempio di file in `/var/www/html/<nome progetto>/laravel/lang/it/auth.php`:
     ```php
     return [
         'register' => [
             'name' => 'Nome',
             'email' => 'Email',
             'password' => 'Password',
             // ...
         ],
         // Commento: Traduzioni per messaggi di errore
         'failed' => 'Queste credenziali non corrispondono ai nostri record.',
     ];
     ```
   - **Ragionamento**: I file PHP offrono un fallback funzionante, essenziale per evitare di mostrare chiavi non tradotte agli utenti. La struttura modulare si adatta bene all'organizzazione del progetto `<nome progetto>`.

## Conclusione

La gestione delle lingue in Laravel richiede una configurazione attenta della lingua predefinita e di fallback, tenendo conto delle limitazioni dei file JSON rispetto ai file PHP. Per il progetto `<nome progetto>`, impostare 'it' come lingua predefinita e 'en' come fallback, insieme all'uso del pacchetto `mcamara/laravel-localization` per l'impostazione dinamica della lingua, garantirà un'esperienza utente coerente e conforme alle regole di localizzazione del progetto. Le modifiche proposte ai file di configurazione e alle route implementano queste best practices, migliorando l'accessibilità multilingue dell'applicazione.

## Risorse

- Corso Laravel Daily: [Multi-Language Laravel 11: All You Need to Know](https://laraveldaily.com/course/multi-language-laravel)
