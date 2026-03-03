# Integrazione tra mcamara/laravel-localization e Laravel Folio

## Obiettivo
Fornire una guida pratica e dettagliata per integrare la localizzazione delle rotte (mcamara/laravel-localization) con il routing file-based di **Laravel Folio**, garantendo URL localizzati, contenuti multilingua e compatibilità con le best practice Laravel.

---

## 1. Cos'è Laravel Folio?
- **Folio** è il sistema di routing file-based introdotto in Laravel 11+, che permette di definire le rotte tramite la struttura delle cartelle e dei file in `resources/views/pages`.
- Ogni file Blade in questa cartella diventa una rotta accessibile via URL.

---

## 2. Sfida dell'integrazione
- **mcamara/laravel-localization** si basa su gruppi di rotte Laravel classici (`Route::group`) per aggiungere il prefisso della lingua e gestire la localizzazione.
- **Folio** genera le rotte in modo automatico, senza passare da `routes/web.php`.
- È necessario assicurarsi che tutte le rotte Folio siano "wrappate" dal middleware di localizzazione e che i path siano localizzati.

---

## 3. Best Practice per l'integrazione

### a) Registrazione delle rotte Folio nel gruppo localizzato
**Soluzione consigliata:**
- Registra Folio **dentro** il gruppo di localizzazione, esattamente come faresti con le rotte classiche.

Esempio in `routes/web.php`:
```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Laravel\Folio\Folio;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localize', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Folio::route(resource_path('views/pages'));
        // ...altre rotte classiche se necessario
    }
);
```
**Risultato:**  
Tutte le pagine Folio saranno accessibili con il prefisso lingua (`/it/about`, `/en/about`, ecc).

---

### b) Traduzione dei path delle pagine Folio
- Di default, i path Folio sono basati sul nome del file (es: `about.blade.php` → `/about`).
- Per avere path localizzati (es: `/it/chi-siamo` invece di `/it/about`), sfrutta la funzionalità di **route translation mapping** di mcamara/laravel-localization.

**Procedura:**
1. Crea i file di mapping in `lang/{locale}/routes.php`:
    ```php
    // lang/it/routes.php
    return [
        'about' => 'chi-siamo',
        'contact' => 'contatti',
    ];
    ```
2. Quando generi link o usi redirect, usa sempre:
    ```php
    route(LaravelLocalization::transRoute('routes.about'))
    ```
3. Se vuoi che anche Folio generi le rotte con path tradotti, valuta di creare symlink o duplicati dei file Blade con nomi localizzati, oppure implementa una logica custom (ad oggi Folio non supporta nativamente il mapping automatico dei path tramite array di traduzioni).

**Nota:**  
Se la localizzazione dei path è fondamentale, valuta se usare ancora le rotte classiche per le pagine che richiedono path tradotti, oppure contribuisci/estendi Folio per supportare questa feature.

---

### c) Middleware e sessione
- Il middleware di mcamara/laravel-localization gestisce la lingua tramite sessione, cookie e URL.
- Assicurati che il middleware sia applicato a tutte le rotte Folio (come nell'esempio sopra).
- Se usi componenti Livewire/Volt nelle pagine Folio, la lingua sarà già impostata correttamente.

---

### d) Language Switcher
- Usa sempre gli helper di mcamara per generare i link di cambio lingua:
    ```blade
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
            {{ $properties['native'] }}
        </a>
    @endforeach
    ```
- Inserisci il language switcher in un layout Blade condiviso da tutte le pagine Folio.

---

### e) Caching delle rotte
- Per cache-izzare le rotte localizzate, usa **solo**:
    ```
    php artisan route:trans:cache
    ```
  e **non** il comando standard `route:cache`.
- Segui le istruzioni aggiornate nella [documentazione ufficiale](https://github.com/mcamara/laravel-localization#caching-routes) per Laravel 11+.

---

## 4. FAQ e problemi comuni
- **Perché una pagina Folio non viene localizzata?**  
  Verifica che la registrazione di Folio sia dentro il gruppo di localizzazione e che il middleware sia applicato.
- **Come traduco i path delle pagine Folio?**  
  Ad oggi serve una soluzione custom (symlink, duplicati, override di Folio) oppure accetta che i path siano in inglese ma i contenuti localizzati.
- **Come gestisco redirect e link?**  
  Usa sempre `route(LaravelLocalization::transRoute('routes.nome'))` per generare URL localizzati.
- **Come gestisco i form POST?**  
  Usa sempre l'helper `localizeURL` per l'action dei form:
  ```blade
  <form action="{{ LaravelLocalization::localizeURL('/contatti') }}" method="POST">
  ```

---

## 5. Checklist
- [ ] Folio è registrato dentro il gruppo localizzato.
- [ ] Tutti i link e redirect usano helper di localizzazione.
- [ ] I path delle pagine sono localizzati (se necessario) tramite mapping o workaround.
- [ ] Il language switcher è presente in tutti i layout.
- [ ] La cache delle rotte usa solo `route:trans:cache`.

---

## 6. Modifiche consigliate ai file del progetto
- **routes/web.php**:  
  Sposta la registrazione di Folio dentro il gruppo localizzato.
- **lang/{locale}/routes.php**:  
  Aggiungi mapping per i path delle pagine Folio se vuoi path tradotti.
- **layouts Blade**:  
  Inserisci il language switcher in tutti i layout usati da Folio.
- **Documentazione**:  
  Aggiorna sempre questa guida ogni volta che cambi la struttura delle pagine o la strategia di localizzazione.

---

## 7. Collegamenti correlati
- [Documentazione ufficiale mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)
- [Documentazione Laravel Folio](https://laravel.com/docs/12.x/folio)
- [Esempio di mapping rotte](https://github.com/mcamara/laravel-localization#translated-routes)
- [FAQ e problemi comuni](/var/www/html/<nome progetto>/laravel/Modules/Lang/docs/translations-faq.md)
- [Guida language switcher](/var/www/html/<nome progetto>/laravel/Modules/Lang/docs/README.md)

---

**Se vuoi che aggiorni direttamente la documentazione o vuoi esempi pratici di override/mapping path Folio, chiedi pure!** 
