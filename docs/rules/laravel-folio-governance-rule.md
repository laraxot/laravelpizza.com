# Laravel Folio Governance Rule

## Regola

Nel progetto le pagine frontoffice file-based devono seguire il runtime reale di `laravel/folio`, non pattern generici inventati.

## Regole operative

- Folio viene montato dal provider applicativo con `Folio::path(...)`, non tramite route classiche duplicate in `routes/web.php`;
- il dispatch Folio avviene tramite fallback route del pacchetto;
- ogni pagina puo' dichiarare metadata inline con gli helper:
  - `name()`
  - `middleware()`
  - `render()`
  - `withTrashed()`
- i segmenti wildcard del path (`[slug]`, `[container0]`, `[slug0]`) arrivano come dati della pagina / callback, quindi non vanno ricalcolati con `request()->route()` salvo casi eccezionali;
- mount-level middleware e inline middleware si compongono, e Folio prepende sempre `web`.

## Implicazione per LaravelPizza

- il provider `App\\Providers\\FolioServiceProvider` e' la fonte canonica del mount;
- `SetFolioLocale` e gli altri middleware pagina devono essere pensati come parte del runtime Folio, non come patch esterne;
- il nome route pubblico delle pagine deve passare da `name()` nel file Blade Folio.

## Anti-pattern

- documentare Folio come se fosse registrato nel nostro `routes/web.php`;
- usare controller o route classiche per pagine che sono gia' page files Folio senza una motivazione precisa;
- leggere i parametri route da `request()->route()` in modo ridondante quando Folio/Volt li ha gia' resi disponibili.
