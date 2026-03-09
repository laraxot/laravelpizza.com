# Laravel Folio Runtime Memory

## Decisione da ricordare

Nel repository Folio non e' teoria: e' il runtime reale del frontoffice tema.

La catena corretta e':

- `App\\Providers\\FolioServiceProvider`
- `Folio::path($pagesPath)->middleware(...)`
- fallback route Folio
- page file Blade
- metadata inline `name()/middleware()/render()`

## Dettagli importanti

- Folio prepende sempre `web` ai middleware risolti;
- mount middleware e inline middleware vengono uniti;
- `name()` sostituisce il route name della richiesta matchata;
- i wildcard segment della route diventano dati della pagina.

## Regola pratica

Quando una pagina pubblica rompe, controllare prima:

1. mount path reale;
2. middleware applicati da provider + inline;
3. naming Folio;
4. dati wildcard disponibili alla pagina.
