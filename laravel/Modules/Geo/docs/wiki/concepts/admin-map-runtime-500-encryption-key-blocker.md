# Admin map runtime 500 encryption key blocker

## Problema

La route admin ticket create non carica la mappa perche' la pagina va in 500 prima del rendering del form:

- `Unsupported cipher or incorrect key length`
- stack in `Illuminate\Encryption\Encrypter`

## Evidenza

- URL: `fixcity/admin/tickets/create?step=form.data::data::wizard-step`
- screenshot contesto: `laravel/Themes/Sixteen/scripts/admin-map-context.png`
- diagnostica browser: assenza totale di `coordinate-picker-lit` e `map-picker-lit` nel DOM.

## Implicazione

Questo e' un blocker infrastrutturale/bootstrapping, non un bug mappa:

1. il componente Geo non viene montato;
2. i fix JS/CSS del map picker non possono essere validati;
3. ogni troubleshooting UI mappa in questo stato produce falsi positivi.

## Regola operativa

Prima di aprire story mappa:

1. verificare route senza 500;
2. verificare presenza custom element nel DOM;
3. solo dopo analizzare tile/controls/sync.

## Checklist rapida

- [ ] `APP_KEY` e cipher coerenti in `laravel/.env`
- [ ] route admin risponde senza eccezioni bootstrap
- [ ] `coordinate-picker-lit` presente
- [ ] screenshot visuale post-bootstrap salvato

## Riferimenti

- [filament admin panel map visibility contract](./filament-admin-panel-map-visibility-contract.md)
- [geo vite build contract](./geo-vite-build-contract.md)
