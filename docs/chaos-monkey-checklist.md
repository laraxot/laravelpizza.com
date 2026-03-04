# Chaos monkey checklist (meetup theme)

## Scopo

Checklist operativa lato tema per ripristinare velocemente la UI quando il chaos monkey rompe:

- registrazione/risoluzione `pub_theme::`
- layout (`<x-layouts.*>` + `<x-metatags>`) e asset
- componenti sezione (`<x-section slug="..." />`)
- Volt blocks (detected da `BlockData`)

Questa checklist complementa:

- `Themes/Meetup/docs/chaos-monkey-debug-skills.md`
- `Modules/Cms/docs/chaos-monkey-checklist.md`

## Entry points (theme)

- Folio pages: `Themes/Meetup/resources/views/pages/*`
- Layouts: `Themes/Meetup/resources/views/components/layouts/*`
- Blocks: `Themes/Meetup/resources/views/components/blocks/*`
- Sections: `Themes/Meetup/resources/views/components/sections/*`

## Incident playbook (ordine consigliato)

### 1) View namespace rotto (`pub_theme::...` non risolve)

- **Sintomo**
  - `View [pub_theme::...] not found`

- **Diagnosi rapida**
  - Provider che registrano `pub_theme`:

    - `Modules/Cms/app/Providers/CmsServiceProvider.php`
    - `Themes/Meetup/app/Providers/ThemeServiceProvider.php`

  - Verifica config tenant `xra.pub_theme` e `register_pub_theme`

- **Fix tipici**
  - Ripristinare la directory `Themes/Meetup/resources/views`
  - Evitare duplicazioni/overlap che puntano a path diversi

### 2) Layout/Assets rotti (CSS non applicato, Alpine/Volt non parte)

- **Sintomo**
  - UI “unstyled” o JS non funziona

- **Diagnosi rapida**
  - Verifica che i layout usino `<x-metatags>` (canonical):

    - `Themes/Meetup/resources/views/components/layouts/main.blade.php`

  - Verifica `@vite([...], 'themes/' . $meta->getPubTheme())` in `Modules/Cms/resources/views/components/metatags.blade.php`

- **Fix tipici**
  - Ricompilare e copiare gli asset del tema (build + copy)
  - Pulire cache view/optimize

### 3) Sezioni header/footer non renderizzate

- **Sintomo**
  - Mancano header/footer (layout presente ma pagine “nude”)

- **Diagnosi rapida**
  - `Themes/Meetup/resources/views/components/layouts/app.blade.php` usa:

    - `<x-section slug="header" />`
    - `<x-section slug="footer" />`

  - Verifica JSON sections tenant:

    - `config/local/<tenant>/database/content/sections/*.json`

- **Fix tipici**
  - Ripristinare `header.json` / `footer.json`
  - Verificare che le view section `pub_theme::components.sections.*` esistano

### 4) Componenti Volt non montati (block interattivi non reattivi)

- **Sintomo**
  - UI renderizza, ma funzionalità (wizard, copy-to-clipboard, filtri) non reagiscono

- **Diagnosi rapida**
  - `BlockData` rileva Volt leggendo l’header della view e cercando pattern `new class extends Component`.
  - Se il file Blade del blocco non ha l’header Volt, verrà incluso come Blade “statico”.

- **Fix tipici**
  - Ripristinare header Volt nel blocco
  - Evitare PHP inline nel template (spostare in mount/metodi Volt)

## Chaos targets consigliati (tema)

1. Rinominare una view `Themes/Meetup/resources/views/components/blocks/...` e verificare fail-fast.
2. Rimuovere `header.json` e verificare che il layout fallisca in modo “evidente” (non silenzioso).
3. Cambiare `xra.pub_theme` e verificare path Folio + namespace `pub_theme::`.
4. Alterare i bundle in `public_html/themes/Meetup/` e verificare recovery build/copy.
