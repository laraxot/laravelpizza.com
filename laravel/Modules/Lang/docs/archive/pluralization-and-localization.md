# Plurale/Singolare e Localizzazione Date/Valute

## Pluralizzazione

### Uso di `trans_choice()` e `@choice()`
- Per messaggi che variano in base al conteggio, usa `trans_choice()` o la direttiva Blade `@choice()`.
- Sintassi tipica in PHP:
  ```php
  // lang/en/messages.php
  return [
      'newMessageIndicator' => '{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages',
  ];
  ```
- In Blade:
  ```blade
  @choice('messages.newMessageIndicator', $messagesCount)
  ```
- Sintassi delle regole plurali:
  - `{0}`: caso zero
  - `{1}`: caso singolare
  - `[2,*]`: da 2 in poi
  - Usa `:count` per il numero
- Plurale in JSON: supportato ma meno leggibile, preferire i file PHP.
- Modifiche proposte:
  - Inserire tutte le stringhe plurali in `/lang/{locale}/messages.php`.
  - Nei Blade, sostituire blocchi condizionali con `trans_choice()` o `@choice()`.
  - Evitare l'uso del JSON per le stringhe plurali.

### 1.4 Modifiche Proposte ai File
- **File PHP**: Inserire tutte le stringhe plurali in file dedicati (es. `lang/en/messages.php` e `lang/it/messages.php`).
- **Blade**: Sostituire blocchi condizionali con `trans_choice()` o `@choice()`.
- **File JSON**: Evitare l'uso per le stringhe plurali, salvo casi di necessità per traduttori non-dev.

### 1.5 Esempio Completo
- `/var/www/html/<nome progetto>/laravel/lang/en/messages.php`:
  ```php
  return [
      'newMessageIndicator' => '{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages',
  ];
  ```
- `/var/www/html/<nome progetto>/laravel/lang/it/messages.php`:
  ```php
  return [
      'newMessageIndicator' => '{0} Non hai nuovi messaggi|{1} Hai 1 nuovo messaggio|[2,*] Hai :count nuovi messaggi',
  ];
  ```
- In Blade:
  ```blade
  @choice('messages.newMessageIndicator', $messagesCount)
  ```

### 1.6 Checklist
- [ ] Tutte le stringhe plurali sono in file PHP dedicati
- [ ] Si usano chiavi descrittive e strutturate
- [ ] Si documenta la presenza di stringhe plurali nei file PHP
- [ ] Si versionano i file di traduzione dopo ogni modifica

---

## Localizzazione Date con Carbon

### Setup
- In `app/Providers/AppServiceProvider.php`:
  ```php
  use Carbon\Carbon;
  public function boot()
  {
      Carbon::setLocale(app()->getLocale());
  }
  ```
- In Blade:
  ```blade
  {{ now()->isoFormat('dddd, D MMMM YYYY') }}
  // Output: lunedì, 3 aprile 2023 (it) | Monday, 3 April 2023 (en)
  ```

### Localizzazione differenze temporali
- In Controller:
  ```php
  $start = now()->subMinutes(56)->subSeconds(33)->subHour();
  $end = now();
  $difference = $end->longRelativeDiffForHumans($start, 5);
  // Output: 1 ora 56 minuti 33 secondi dopo (it)
  ```

### Formati diversi per lingua
- Per cambiare l'ordine/casing, usa formati diversi per ogni lingua:
  ```php
  __('date_format.full') // Definisci la chiave in lang/{locale}/date.php
  // es: 'full' => 'dddd, D MMMM YYYY'
  ```
  E in Blade:
  ```blade
  {{ now()->isoFormat(__('date_format.full')) }}
  ```

---

## Localizzazione Valute con NumberFormatter

### Prerequisiti
- Abilita l'estensione PHP `intl` nel tuo ambiente (php.ini).

### Esempio base
- In Controller:
  ```php
  $formatter = new \NumberFormatter('it_IT', \NumberFormatter::CURRENCY);
  echo $formatter->formatCurrency(35578.883, 'EUR');
  // Output: 35.578,88 €
  ```

### Helper globale
- In `app/helpers.php`:
  ```php
  if (! function_exists('formatCurrency')) {
      function formatCurrency($amount, $locale = null, $currency = 'EUR')
      {
          $locale = $locale ?: app()->getLocale();
          $formatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
          return $formatter->formatCurrency($amount, $currency);
      }
  }
  ```
- In Blade:
  ```blade
  {{ formatCurrency(35578.883) }}
  // Output: 35.578,88 € (it) | $35,578.88 (en)
  ```

### Modifiche proposte
- Aggiungi/aggiorna `app/helpers.php` con la funzione `formatCurrency`.
- Usa sempre il locale corrente per formattare date e valute.
- Definisci i formati data in `/lang/{locale}/date.php` per ogni lingua.
- Documenta l'uso di Carbon e NumberFormatter nei README dei moduli coinvolti.

---

## Middleware e Configurazione Locale

### Middleware SetLocale
- Per gestire la lingua da URL, sessione o DB, crea un middleware dedicato (`app/Http/Middleware/SetLocale.php`).
- Esempio:
  ```php
  public function handle($request, Closure $next)
  {
      $locale = ... // da URL, session, DB
      app()->setLocale($locale);
      Carbon::setLocale($locale);
      return $next($request);
  }
  ```

### Configurazione
- In `config/app.php`:
  ```php
  'locale' => 'it',
  'available_locales' => ['it', 'en', 'es'],
  ```

---

## Riferimenti
- [Carbon Docs](https://carbon.nesbot.com/docs/)
- [NumberFormatter PHP](https://www.php.net/manual/en/class.numberformatter.php)
- [Laravel Localization](https://laravel.com/docs/12.x/localization)
- [Corso Laravel Daily](https://laraveldaily.com/course/multi-language-laravel)

---

## 3. FAQ e Problemi Comuni

- **Come gestire plurale/singolare in più lingue?**  
  Usa sempre file PHP e chiavi strutturate, sfrutta `trans_choice()` e `@choice()`.
- **Come localizzare date e valute?**  
  Usa Carbon per le date e NumberFormatter per le valute, impostando la locale corretta.

---

## 4. Collegamenti correlati

- [translations-faq.md](./translations-faq.md)
- [TRANSLATION_KEYS_BEST_PRACTICES.md](./TRANSLATION_KEYS_BEST_PRACTICES.md)
- [translations-storage.md](./translations-storage.md)
- [translation-process.md](./translation-process.md)
- [README.md](./README.md) 
