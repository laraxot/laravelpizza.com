# Design Comuni — accesso-servizio

La pagina di test `/it/tests/accesso-servizio` è una pagina CMS, non una view Folio dedicata.

## Contratto di risoluzione

- Route: `Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`.
- Slug pubblico: `accesso-servizio`.
- Slug CMS: `tests.accesso-servizio`.
- Fixture: `config/local/fixcity/database/content/pages/tests.accesso-servizio.json`.
- Ogni blocco deve dichiarare una view realmente esistente: `BlockData` fallisce esplicitamente se il namespace non è risolvibile.

Il prefisso `tests.` è necessario perché `PageSlugMiddleware` e il componente Folio costruiscono il page slug dal container e dal segmento. Un JSON con solo `accesso-servizio` può produrre una risposta HTTP valida ma senza blocchi.

## Sequenza dei blocchi

`breadcrumb → hero → access-method-card → contacts → search-form → suggestions`.

Il contenuto resta nei dati JSON; le view accettano `data` e rendono soltanto struttura, semantica e comportamento accessibile.

## Verifica CMS

```bash
jq empty config/local/fixcity/database/content/pages/tests.accesso-servizio.json
curl -f http://192.168.1.40:8000/it/tests/accesso-servizio
```

La verifica browser deve inoltre controllare H1, sezioni SPID/CIE, asset SVG, console e overflow sui breakpoint 375, 768 e 1440.
