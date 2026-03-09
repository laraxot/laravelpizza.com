# Folio Runtime Governance

## Contesto

Nel progetto il frontoffice tema viene servito da `laravel/folio` e il modulo `Cms` partecipa al runtime con middleware come `SetFolioLocale` e `PageSlugMiddleware`.

## Regola

Prima di modificare una pagina pubblica servita da Folio bisogna verificare:

- mount path registrato in `App\\Providers\\FolioServiceProvider`;
- middleware mount-level (`SetFolioLocale`);
- middleware inline dichiarati nel file pagina (`middleware(...)`);
- route name dichiarato con `name(...)`;
- dati wildcard e loro uso reale nel render/mount.

## Implicazione

Molti bug apparentemente “di Blade” o “di CMS” in realta' nascono dal runtime Folio:

- file matchato sbagliato;
- middleware non applicato;
- route name non dichiarato;
- parametro wildcard ri-estratto male;
- logica business messa nel page file invece che in Action o component.
