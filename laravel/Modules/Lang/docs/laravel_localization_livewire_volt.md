# Integrazione di mcamara/laravel-localization con Livewire Volt

## Obiettivo
Fornire una guida pratica per integrare la localizzazione delle rotte e dei contenuti con Livewire Volt, sfruttando le potenzialità di mcamara/laravel-localization.

---

## 1. Cos'è Livewire Volt?
Volt è una sintassi semplificata per creare componenti Livewire, che permette di scrivere componenti reattivi direttamente in Blade, con una sintassi più concisa e moderna.

---

## 2. Sfida dell'integrazione
- **Volt** genera componenti Livewire che vengono richiamati tramite rotte Laravel.
- **mcamara/laravel-localization** lavora a livello di routing, aggiungendo il prefisso della lingua e gestendo la localizzazione delle rotte.
- È necessario assicurarsi che i componenti Volt siano accessibili tramite rotte localizzate e che i contenuti siano tradotti correttamente.

---

## 3. Best Practice per l'integrazione

### a) Registrazione delle rotte Volt nel gruppo localizzato
Assicurati che tutte le rotte che richiamano componenti Volt siano dichiarate all'interno del gruppo di localizzazione:

```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localize', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        // Rotte Volt
        Volt::route('dashboard', 'dashboard');
        Volt::route('profile', 'profile');
        // ...altre rotte Volt
    }
);
```

**Nota:**
Se usi Folio, assicurati che anche le pagine Volt siano registrate nel gruppo localizzato.

---

### b) Traduzione dei contenuti nei componenti Volt
- Usa sempre le funzioni di traduzione Laravel (`__()`, `@lang`) all'interno dei template Blade dei componenti Volt.
- Esempio:
  ```blade
  <h1>{{ __('Welcome') }}</h1>
  <button>{{ __('Logout') }}</button>
  ```
- Per i messaggi dinamici, usa la funzione `__()` anche nel codice PHP del componente Volt:
  ```php
  $this->notify(__('Profile updated successfully!'));
  ```

---

### c) Gestione dei redirect e dei link
- Quando effettui redirect o generi link all'interno dei componenti Volt, usa sempre i nomi delle rotte localizzate:
  ```php
  return redirect()->route(LaravelLocalization::getCurrentLocale().'.dashboard');
  ```
- Nei link Blade:
  ```blade
  <a href="{{ route(LaravelLocalization::getCurrentLocale().'.profile') }}">{{ __('Profile') }}</a>
  ```

---

### d) Middleware e Locale
- Se hai logica custom che dipende dalla lingua, puoi accedere alla lingua corrente tramite:
  ```php
  app()->getLocale()
  ```
- Se necessario, puoi forzare la lingua in un componente Volt:
  ```php
  app()->setLocale($locale);
  ```

---

### e) Traduzione delle rotte Volt
- Se vuoi tradurre anche i path delle rotte Volt (es: `/it/bacheca` invece di `/it/dashboard`), usa la funzionalità di route translation mapping di mcamara/laravel-localization.
- Esempio in `resources/lang/it/routes.php`:
  ```php
  return [
      'dashboard' => 'bacheca',
      'profile' => 'profilo',
  ];
  ```
- E registra le rotte Volt usando le chiavi tradotte:
  ```php
  Volt::route(__('routes.dashboard'), 'dashboard');
  ```

---

## 4. Checklist
- [ ] Tutte le rotte Volt sono dentro il gruppo localizzato.
- [ ] Tutti i testi nei componenti Volt sono tradotti con `__()` o `@lang`.
- [ ] Tutti i link e redirect usano nomi di rotte localizzate.
- [ ] Se necessario, i path delle rotte Volt sono tradotti tramite mapping.
- [ ] Documenta ogni eccezione o workaround in `/Modules/Lang/docs/laravel-localization-livewire-volt.md`.

---

## 5. FAQ e problemi comuni
- **Perché il componente Volt non si localizza?**  
  Verifica che la rotta sia dentro il gruppo localizzato e che il middleware sia applicato.
- **Come traduco i path delle rotte Volt?**  
  Usa il mapping delle rotte in `lang/{locale}/routes.php` e registra le rotte Volt con le chiavi tradotte.
- **Come gestisco la lingua nei redirect?**  
  Usa sempre `LaravelLocalization::getCurrentLocale()` nei redirect e nei link.

---

## 6. Modifiche consigliate ai file del progetto
- **web.php**:  
  Sposta tutte le rotte Volt dentro il gruppo localizzato.
- **lang/{locale}/routes.php**:  
  Aggiungi mapping per i path delle rotte Volt se vuoi path tradotti.
- **Componenti Volt**:  
  Verifica che tutti i testi siano tradotti e che i redirect usino le rotte localizzate.
- **Documentazione**:  
  Aggiorna sempre `/Modules/Lang/docs/laravel-localization-livewire-volt.md` ogni volta che cambi la struttura delle rotte o dei componenti Volt.

---

## 7. Best Practices operative (.mdc)

Vedi file `.cursor/rules/laravel-localization-livewire-volt.mdc` e `.windsurf/rules/laravel-localization-livewire-volt.mdc` per checklist e regole operative. 
