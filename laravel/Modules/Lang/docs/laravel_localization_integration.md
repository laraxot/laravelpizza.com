# Integrazione avanzata: mcamara/laravel-localization + Laravel Folio

## 1. Introduzione

Questa guida approfondisce l'integrazione tra [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization) e [Laravel Folio](https://github.com/laravel/folio), con focus su:
- Localizzazione delle route Folio (file-based routing)
- Traduzione degli slug e dei parametri dinamici
- Best practice, criticità e raccomandazioni operative

---

## 2. Analisi tecnica e criticità

### 2.1. Come funziona Folio
- Genera route da `resources/views/pages` (ogni file Blade = una route)
- Supporta parametri dinamici (`[slug].blade.php` → `/qualcosa`)

### 2.2. Come funziona mcamara/laravel-localization
- Wrappa le route in un gruppo con prefisso lingua e middleware
- Permette la traduzione degli slug tramite `lang/{locale}/routes.php`
- Offre helper per URL localizzati e parametri tradotti

### 2.3. Punti critici
- Folio **non supporta nativamente** la traduzione degli slug: serve mappatura manuale
- Cache delle route: usare sempre `php artisan route:trans:cache`
- Parametri dinamici: richiedono override custom (vedi sotto)
- Fallback locale: va gestito sia lato Folio che localization

---

## 3. Passaggi operativi dettagliati

### 3.1. Wrappare tutte le route Folio nel gruppo localizzato

```php
use Laravel\Folio\Facades\Folio;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localize', 'localizationRedirect', 'localeViewPath'],
], function () {
    Folio::route('pages');
    // ...altre route
});
```

### 3.2. Traduzione degli slug Folio

#### a) File di traduzione degli slug

- Crea `lang/en/routes.php`, `lang/it/routes.php`, ecc.
- Esempio:
  ```php
  // lang/en/routes.php
  return [ 'about' => 'about', 'contact' => 'contact', ];
  // lang/it/routes.php
  return [ 'about' => 'chi-siamo', 'contact' => 'contatti', ];
  ```

#### b) Mappare le route Folio agli slug tradotti

- Folio non supporta la traduzione automatica degli slug: usa i nomi tradotti nei link e, se serve, crea route custom:
  ```php
  Route::get(LaravelLocalization::transRoute('routes.about'), function () {
      return view('pages.about');
  })->name('about');
  ```

#### c) Nei Blade Folio, usa sempre i metodi di LaravelLocalization

```blade
<a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), route('about')) }}">
    {{ __('About us') }}
</a>
```

### 3.3. Gestione avanzata dei parametri dinamici (slug, id, ecc.)

- Per tradurre parametri dinamici (es. `/it/articolo/slug-italiano` vs `/en/article/english-slug`):
  - Implementa l'interfaccia `LocalizedUrlRoutable` nel model
  - Override di `getLocalizedRouteKey($locale)` e `resolveRouteBinding($slug)`

**Esempio:**
```php
class Article extends Model implements \Mcamara\LaravelLocalization\Interfaces\LocalizedUrlRoutable
{
    public function getLocalizedRouteKey($locale)
    {
        return $this->getTranslation('slug', $locale);
    }
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where("slug->{$locale}", $value)->firstOrFail();
    }
}
```

- Richiede che il model abbia un campo `slug` multilingua (es. via spatie/laravel-translatable)

### 3.4. Cache delle route

- Usa **sempre** `php artisan route:trans:cache` per la cache delle route localizzate
- Non usare il comando standard `route:cache`

### 3.5. Testing

- Nei test, imposta il locale con:
  ```php
  protected function refreshApplicationWithLocale($locale)
  {
      self::tearDown();
      putenv(LaravelLocalization::ENV_ROUTE_KEY . '=' . $locale);
      self::setUp();
  }
  ```

---

## 4. Best practice e raccomandazioni

- Versiona sempre i file `lang/{locale}/routes.php` e aggiorna la documentazione ad ogni nuova pagina Folio
- Usa sempre i metodi di LaravelLocalization per link e redirect nei Blade
- Testa la localizzazione sia per le route che per i contenuti delle pagine Folio
- Documenta la strategia in `/Modules/Lang/docs/laravel-localization-integration.md` e linka dal README
- Per la cache delle route, usa sempre `php artisan route:trans:cache`

---

## 5. Modifiche consigliate ai file del progetto

- Aggiorna `routes/web.php` per wrappare tutte le route Folio nel gruppo localizzato
- Crea/aggiorna i file `lang/{locale}/routes.php` per tutte le lingue supportate
- Nei Blade Folio, sostituisci tutti i link hardcoded con i metodi di LaravelLocalization
- Se usi parametri dinamici multilingua, aggiorna i model per supportare `LocalizedUrlRoutable`
- Documenta la strategia in `/Modules/Lang/docs/laravel-localization-integration.md` e linka dal README

---

## 6. Checklist finale

- [ ] Tutte le route Folio sono wrappate dal gruppo localizzato
- [ ] I file `lang/{locale}/routes.php` sono completi e versionati
- [ ] I link nei Blade usano i metodi di LaravelLocalization
- [ ] I parametri dinamici sono gestiti in modo multilingua se necessario
- [ ] La cache delle route usa `route:trans:cache`
- [ ] La documentazione è aggiornata e linkata nei README

---

## 7. Collegamenti utili

- [mcamara/laravel-localization - GitHub](https://github.com/mcamara/laravel-localization)
- [Laravel Folio - Docs](https://laravel.com/docs/12.x/folio)
- [Traduzione route con mcamara](https://github.com/mcamara/laravel-localization#translated-routes)
- [Esempio di override parametri dinamici](https://github.com/mcamara/laravel-localization#translatable-route-parameters)
