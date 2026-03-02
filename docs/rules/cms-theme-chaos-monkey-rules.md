# Regole Critiche - CMS Theme Chaos Monkey

## Scope

Regole operative per debug e recovery del frontoffice quando il caos introduce regressioni su template, tema e blocchi CMS.

## Regole runtime

1. Usare sempre namespace `pub_theme::` per view e traduzioni tema.
2. Non introdurre controller/route frontoffice: usare Folio + page JSON CMS.
3. Nei blocchi dinamici Alpine usare URL pre-localizzato (`event.url`), non concatenazioni manuali.
4. Ogni blocco CMS deve avere `data.view` valido e `view()->exists(...)` true.
5. Per query dinamiche blocchi usare `data.query` con model FQCN valido.

## Regole recovery

1. Verificare prima catena route -> Folio page -> `<x-page>` -> JSON page -> block view.
2. Isolare il guasto a livello singolo: route, slug pagina, blocco, query, view.
3. Applicare fix minimi e reversibili, senza refactor laterali durante incidente.
4. Aggiornare docs modulo/tema subito dopo il fix.

## Riferimenti

- [Modules/Cms/docs/cms-theme-template-runtime-architecture](../../laravel/Modules/Cms/docs/cms-theme-template-runtime-architecture.md)
- [Modules/Cms/docs/chaos-monkey-recovery-playbook](../../laravel/Modules/Cms/docs/chaos-monkey-recovery-playbook.md)
- [Themes/Meetup/docs/chaos-monkey-theme-recovery-playbook](../../laravel/Themes/Meetup/docs/chaos-monkey-theme-recovery-playbook.md)
- [Modules/Meetup/docs/chaos-monkey-event-rendering-playbook](../../laravel/Modules/Meetup/docs/chaos-monkey-event-rendering-playbook.md)
