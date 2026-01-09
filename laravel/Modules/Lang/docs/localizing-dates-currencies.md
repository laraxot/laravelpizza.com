# Localizzazione di Date e Valute

## Introduzione

La localizzazione di date e valute è un aspetto cruciale per un'applicazione multilingue come `<nome progetto>`. Questa documentazione, basata sul corso di Laravel Daily, esplora come utilizzare Carbon per localizzare date e differenze temporali, e la classe `NumberFormatter` di PHP per formattare valute in base alla lingua corrente dell'utente.

## Localizzazione di Date con Carbon

Carbon, la libreria di gestione delle date integrata in Laravel, rende semplice la localizzazione delle date. È sufficiente impostare il locale di Carbon in base alla lingua corrente dell'applicazione.

**Configurazione in `AppServiceProvider`**:
```php
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // ...
        Carbon::setLocale(app()->getLocale());
        // ...
    }
}
```

Con questa configurazione, Carbon utilizzerà automaticamente il locale corrente per formattare le date.

**Esempio in una Vista Blade**:
```blade
{{ now()->isoFormat('dddd, D MMMM YYYY') }}
```

**Risultati in Diverse Lingue**:
- Inglese: `Monday, 3 April 2023`
- Italiano: `lunedì, 3 aprile 2023`
- Spagnolo: `lunes, 3 abril 2023`
- Tedesco: `Montag, 3 April 2023`

**Vantaggi**: Non è necessario tradurre manualmente i nomi dei mesi o dei giorni; Carbon gestisce tutto automaticamente in base al locale impostato.

## Localizzazione delle Differenze Temporali

Carbon permette anche di localizzare le differenze tra date in un formato leggibile per l'utente, utilizzando il metodo `diffForHumans`.

**Esempio in un Controller**:
```php
$start = now()->subMinutes(56)->subSeconds(33)->subHour();
$end = now();
$difference = $end->longRelativeDiffForHumans($start, 5);
dd($difference);
```

**Risultati in Diverse Lingue**:
- Inglese: `1 hour 56 minutes 33 seconds after`
- Italiano: `1 ora 56 minuti 33 secondi dopo`
- Spagnolo: `1 hora 56 minutos 33 segundos después`
- Tedesco: `1 Stunde 56 Minuten 33 Sekunden später`

**Vantaggi**: Questo approccio è utile per mostrare agli utenti quanto tempo è passato da un evento (es. creazione di un appuntamento) in modo intuitivo e localizzato.

## Localizzazione di Valute

La formattazione delle valute varia tra paesi per posizione del simbolo, separatori decimali e migliaia. PHP offre la classe `NumberFormatter` per gestire queste differenze.

**Nota**: È necessario abilitare l'estensione `intl` di PHP nel file `php.ini` per utilizzare `NumberFormatter`.

**Esempio in un Controller**:
```php
$formatter = new NumberFormatter('it_IT', NumberFormatter::CURRENCY);
dd($formatter->formatCurrency(35578.883, 'EUR'));
```

**Risultati per EUR in Diversi Locali**:
- `it_IT`: `35.578,88 €`
- `en_US`: `€35,578.88`
- `es_ES`: `35.578,88 €`
- `de_DE`: `35.578,88 €`

**Esempio per GBP**:
```php
$formatter = new NumberFormatter('en_GB', NumberFormatter::CURRENCY);
dd($formatter->formatCurrency(35578.883, 'GBP'));
```

**Risultati per GBP in Diversi Locali**:
- `en_GB`: `£35,578.88`
- `it_IT`: `35.578,88 GBP`
- `es_ES`: `35.578,88 GBP`
- `de_DE`: `35.578,88 £`

**Vantaggi**: `NumberFormatter` gestisce automaticamente il posizionamento del simbolo della valuta e i separatori, evitando errori manuali nella formattazione.

## Creazione di una Funzione Helper per le Valute

Per semplificare l'uso di `NumberFormatter` nelle viste o in altre parti del sistema, si può creare una funzione helper.

**Esempio in `app/helpers.php`**:
```php
if (!function_exists('formatCurrency')) {
    function formatCurrency($amount, $locale = 'it_IT', $currency = 'EUR')
    {
        $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($amount, $currency);
    }
}
```

**Uso in una Vista Blade**:
```blade
{{ formatCurrency(35578.883) }}
```

**Risultato**:
- `35.578,88 €` (per locale `it_IT` e valuta `EUR`)

**Vantaggi**: Una funzione helper rende la formattazione delle valute accessibile ovunque nell'applicazione senza dover ripetere il codice di inizializzazione di `NumberFormatter`.

## Analisi e Ragionamento per il Progetto `<nome progetto>`

Nel contesto del progetto `<nome progetto>`, la localizzazione di date e valute è essenziale per garantire un'esperienza utente coerente e comprensibile in diverse lingue. Propongo di:
- Configurare Carbon per utilizzare il locale corrente in `AppServiceProvider`, garantendo che date e differenze temporali siano mostrate correttamente in italiano, inglese o altre lingue supportate.
- Implementare una funzione helper per formattare valute, considerando che in un'applicazione sanitaria potrebbero essere visualizzati costi di trattamenti o servizi. Usare `NumberFormatter` assicura che i prezzi siano formattati correttamente in base alla lingua e al paese dell'utente.

Questo approccio è coerente con le regole di localizzazione del progetto, che richiedono l'uso di `app()->getLocale()` per determinare la lingua corrente e garantire che tutti gli elementi siano tradotti correttamente.

## Modifiche Proposte

Di seguito elenco i file che modificherei e le modifiche specifiche che apporterei per implementare la localizzazione di date e valute nel progetto `<nome progetto>`:

1. **Configurazione di Carbon per la Localizzazione delle Date**:
   - File: `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/app/Providers/AppServiceProvider.php`
   - Modifica: Aggiungere la configurazione del locale di Carbon nel metodo `boot()`:
     ```php
     use Carbon\Carbon;

     class AppServiceProvider extends ServiceProvider
     {
         public function boot()
         {
             // ...
             Carbon::setLocale(app()->getLocale());
             // ...
         }
     }
     ```
   - **Ragionamento**: Impostare il locale di Carbon con `app()->getLocale()` garantisce che tutte le date e differenze temporali siano formattate in base alla lingua corrente dell'utente (es. 'it' o 'en'). Questo è essenziale per un'applicazione multilingue come `<nome progetto>`, dove gli utenti devono vedere date nei formati familiari della loro lingua, come 'lunedì, 3 aprile 2023' in italiano. Questa modifica è coerente con le regole di localizzazione del progetto che richiedono l'uso del locale corrente.

2. **Creazione di una Funzione Helper per Formattare Valute**:
   - File: `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/app/helpers.php`
   - Modifica: Creare o aggiornare il file con la funzione `formatCurrency()`:
     ```php
     if (!function_exists('formatCurrency')) {
         function formatCurrency($amount, $locale = null, $currency = 'EUR')
         {
             $locale = $locale ?? app()->getLocale();
             $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
             return $formatter->formatCurrency($amount, $currency);
         }
     }
     ```
   - **Ragionamento**: Una funzione helper per formattare valute rende facile visualizzare prezzi in modo localizzato in tutta l'applicazione `<nome progetto>`. Usare `app()->getLocale()` come valore predefinito per il locale garantisce che la formattazione rispetti la lingua corrente dell'utente, come richiesto dalle regole di localizzazione del progetto. Impostare 'EUR' come valuta predefinita è appropriato per un contesto italiano, ma la funzione è flessibile per altre valute se necessario. Questo approccio è utile per mostrare costi di trattamenti o servizi in modo chiaro e corretto.

3. **Uso della Localizzazione nelle Viste per Date e Valute**:
   - File: `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Dental/Resources/views/appointment.blade.php`
   - Modifica: Usare Carbon e la funzione helper per formattare date e valute:
     ```blade
     <!-- Data dell'appuntamento -->
     <p>Data: {{ $appointment->date->isoFormat('dddd, D MMMM YYYY') }}</p>
     <!-- Tempo trascorso -->
     <p>Creato: {{ $appointment->created_at->longRelativeDiffForHumans(now(), 5) }}</p>
     <!-- Costo del trattamento -->
     <p>Costo: {{ formatCurrency($appointment->cost) }}</p>
     ```
   - **Ragionamento**: Nelle viste di `<nome progetto>`, come quelle per gli appuntamenti dentistici, mostrare date e differenze temporali con Carbon garantisce che siano localizzate automaticamente in base alla lingua dell'utente (es. 'lunedì, 3 aprile 2023' in italiano). Usare la funzione `formatCurrency()` per i costi assicura che i prezzi siano formattati correttamente (es. '35,578.88 €' in italiano). Questo migliora l'usabilità e rispetta le regole di localizzazione del progetto che richiedono l'uso del locale corrente per tutti gli elementi visibili all'utente.
