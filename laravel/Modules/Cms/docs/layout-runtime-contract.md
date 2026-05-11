# Layout Runtime Contract

## Sintesi

Le pagine CMS dinamiche non devono contenere elementi strutturali globali.

La divisione corretta e:

- `Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`: risolve lo slug e invoca `<x-page />`
- `Themes/Sixteen/resources/views/layouts/app.blade.php`: skiplinks, header, main, footer
- `Themes/Sixteen/resources/views/layouts/main.blade.php`: shell HTML, Vite, Filament, script globali

## Regola operativa

### Nelle page blades

Ammessi:

- Folio
- Volt
- `<x-layouts.app>`
- `<x-page ... />`

Non ammessi:

- skiplinks
- `<x-section slug="header" />`
- `<x-section slug="footer" />`
- shell HTML completa

## Motivazione

### Confine corretto delle responsabilita

`<x-page />` rende blocchi JSON della pagina. Header e footer sono sezioni condivise, quindi non appartengono allo slug pagina.

### Riutilizzo

Una sola modifica al layout deve propagarsi a tutte le pagine pubbliche.

### Parita HTML

Per replicare Design Comuni pagina per pagina, il markup comune deve stare in un punto unico e stabile.

## Collegamenti

- [README.md](./README.md)
- [design-comuni-page-census.md](./design-comuni-page-census.md)
- [../../Themes/Sixteen/docs/layout-runtime-contract.md](../../Themes/Sixteen/docs/layout-runtime-contract.md)
