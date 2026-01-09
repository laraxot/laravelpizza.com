# Localizzazione di Date e Valute

## Introduzione

La localizzazione di date e valute è un aspetto cruciale per un'applicazione multilingue come `saluteora`. Tradurre manualmente mesi, giorni e simboli di valuta per ogni lingua sarebbe un lavoro enorme. Fortunatamente, Laravel e PHP offrono strumenti potenti come Carbon per le date e `NumberFormatter` per le valute, che gestiscono automaticamente la formattazione in base alla lingua. Questa documentazione, basata sul corso di Laravel Daily, esplora come implementare queste funzionalità nel progetto `saluteora`.
- Configurare Carbon per utilizzare il locale corrente, garantendo che date e differenze temporali siano mostrate correttamente in italiano (`it`), inglese (`en`), o altre lingue supportate.
- Implementare `NumberFormatter` per formattare valute, specialmente per costi di trattamenti o pagamenti, rispettando le convenzioni locali (es. simbolo € in Europa).
- Creare un helper per le valute, permettendo un uso flessibile in viste e logiche di business.

Questo approccio si integra con il sistema di localizzazione esistente (`mcamara/laravel-localization`), che utilizza il prefisso della lingua negli URL, garantendo che il locale corrente (`app()->getLocale()`) sia sempre disponibile per Carbon e `NumberFormatter`.

## Modifiche Proposte

Di seguito elenco i file che modificherei e le modifiche specifiche che apporterei per implementare la localizzazione di date e valute nel progetto `saluteora`:

1. **Configurazione di Carbon per la Localizzazione delle Date**:
   - File: `/var/www/html/saluteora/laravel/app/Providers/AppServiceProvider.php`
   - Modifica: Creare o aggiornare il file per aggiungere la funzione `formatCurrency()`:
     ```php
     if (!function_exists('formatCurrency')) {
         function formatCurrency($amount, $locale = null, $currency = 'EUR')
         {
             $locale = $locale ?? app()->getLocale() . '_' . strtoupper(app()->getLocale());
             $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
             return $formatter->formatCurrency($amount, $currency);
         }
     }
     ```
- **Ragionamento**: Un helper per formattare le valute centralizza la logica di localizzazione, rendendola accessibile in tutte le viste e i controller. Impostare il locale di default con `app()->getLocale()` (es. 'it_IT') garantisce coerenza con la lingua corrente dell'utente, mentre permettere di specificare un locale o una valuta diversi offre flessibilità (es. per mostrare costi in USD). Questo è utile per `saluteora` in scenari di fatturazione o pagamenti internazionali.

3. **Uso di Carbon e dell'Helper nelle Viste per Appuntamenti o Pagamenti**:
   - File: `/var/www/html/saluteora/laravel/Modules/Dental/Resources/views/appointments/index.blade.php`

4. **Verifica dell'Estensione `intl` per `NumberFormatter`**:
   - Nota: Assicurarsi che l'estensione `intl` sia abilitata nel file `php.ini` del server. Se non è abilitata, aggiungere o decommentare la linea:
     ```ini
     extension=intl
     ```
