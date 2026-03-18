# Laravel Folio Governance

## Contesto

Nel progetto il frontoffice CMS e i temi pubblici usano Laravel Folio come router file-based. Questo significa che la struttura dei file Blade non e' una comodita' estetica: e' la definizione stessa delle route pubbliche.

## Regole operative

- Se una pagina puo' esistere come file Folio, non va duplicata in `routes/web.php`.
- Il provider che monta Folio e' il punto corretto per URI prefix, domain routing e middleware condivisi.
- `index.blade.php` rappresenta il root della directory; usarlo evita slug di comodo o redirect artificiali.
- Le variabili di route vanno espresse tramite filename dinamici (`[slug]`, `[id]`, `[...segments]`).
- Se il dominio lo consente, preferire implicit model binding via filename a resolver personalizzati sparsi.
- Le pagine Blade non devono farsi carico di riparare mount o middleware errati.

## `render()` e `name()`

- `name()` e' utile solo per route che richiedono URL generation stabile.
- `render()` e' appropriato per arricchire la response o passare dati alla view, non per concentrare business logic o ricostruire a mano il contesto di routing.

## Dynamic Theme Paths

Per supportare l'architettura modulare di Laraxot, il mount point di Folio non deve essere hardcoded. 
In `FolioServiceProvider`, il percorso viene risolto dinamicamente usando `XotData::make()->pub_theme`:

```php
$themePath = base_path('Themes/'.$pub_theme.'/resources/views/pages');
Folio::path($themePath)->middleware([...]);
```

Questo assicura che il router file-based punti sempre alle pagine del tema attivo (es. `TwentyOne`, `Meetup`, ecc.), evitando `ViewNotFoundException` o caricamenti di temi errati.

## Testing

- I test devono colpire la URL Folio finale.
- Le regressioni di locale, middleware o precedence vanno verificate a livello route, non solo a livello view/component.
- Se si usa model binding implicito, coprire almeno un caso di binding corretto e un caso di mancata risoluzione.

## Deployment

- Laravel Folio resta compatibile con `php artisan route:cache`.
- Eventuali eccezioni sul caching di route tradotte appartengono ai package di localizzazione, non a Folio.

## Fonte

- Laravel Folio docs: https://laravel.com/docs/12.x/folio
- Repository: https://github.com/laravel/folio
