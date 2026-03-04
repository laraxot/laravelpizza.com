# Localizzazione di Date e Valute

## Introduzione

La localizzazione di date e valute è un aspetto cruciale per un'applicazione multilingue come `<nome progetto>`. Questa documentazione, basata sul corso di Laravel Daily, esplora come utilizzare Carbon per localizzare date e differenze temporali, e la classe `NumberFormatter` di PHP per formattare valute in base alla lingua corrente dell'utente.
- Configurare Carbon per utilizzare il locale corrente in `AppServiceProvider`, garantendo che date e differenze temporali siano mostrate correttamente in italiano, inglese o altre lingue supportate.
- Implementare una funzione helper per formattare valute, considerando che in un'applicazione sanitaria potrebbero essere visualizzati costi di trattamenti o servizi. Usare `NumberFormatter` assicura che i prezzi siano formattati correttamente in base alla lingua e al paese dell'utente.

Questo approccio è coerente con le regole di localizzazione del progetto, che richiedono l'uso di `app()->getLocale()` per determinare la lingua corrente e garantire che tutti gli elementi siano tradotti correttamente.

## Modifiche Proposte

Di seguito elenco i file che modificherei e le modifiche specifiche che apporterei per implementare la localizzazione di date e valute nel progetto `<nome progetto>`:

1. **Configurazione di Carbon per la Localizzazione delle Date**:
   - File: `app/Providers/AppServiceProvider.php`
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
   - File: `Modules/Dental/Resources/views/appointment.blade.php`
