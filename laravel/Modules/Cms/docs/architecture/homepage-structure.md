# Struttura della Homepage

## Scopo

Questo documento descrive il flusso reale della homepage di test usata per la parity con Design Comuni: ` /it/tests/homepage `.

Non descrive la vecchia homepage di `Themes/One`, ma la pipeline attiva su `Sixteen` + Cms.

## Architettura reale

La homepage di test e' composta da quattro livelli:

1. **Laravel Folio**
   - routing file-based della pagina di test
2. **Theme Sixteen**
   - layout, asset Vite, CSS e JS
3. **Cms module**
   - caricamento pagina e blocchi CMS-driven
4. **JSON locale di contenuto**
   - struttura della pagina e dati dei blocchi

## File principali

### Route / page entry
- `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`

Questo file gestisce gli URL `/it/tests/*` e costruisce lo slug Cms in forma `tests.<slug>`.

### Content source
- `laravel/config/local/fixcity/database/content/pages/tests.homepage.json`

Questo file contiene la composizione della homepage di test: sezioni, ordine, contenuti e configurazioni dei blocchi.

### Rendering layer
- `laravel/Modules/Cms/app/View/Components/Page.php`
- `laravel/Modules/Cms/app/Datas/BlockData.php`

Questi componenti si occupano di:
- leggere lo slug di pagina
- risolvere i blocchi del JSON
- preparare i dati per la view finale
- delegare il rendering ai componenti del tema attivo

## Flusso runtime

```text
/it/tests/homepage
  -> Themes/Sixteen/resources/views/pages/tests/[slug].blade.php
  -> pageSlug = tests.homepage
  -> config/local/fixcity/database/content/pages/tests.homepage.json
  -> Cms Page component / BlockData
  -> pub_theme::... views del tema Sixteen
  -> CSS/JS del tema Sixteen
```

## Responsabilita per layer

### Cms
Responsabile di:
- struttura della pagina
- elenco e ordine dei blocchi
- dati associati ai blocchi
- contratto CMS-driven della homepage

### Theme Sixteen
Responsabile di:
- layout pubblico
- resa visuale finale
- tipografia, spacing, dimensioni, allineamenti
- behaviour JS leggero necessario alla parity visuale

## Parity con Design Comuni

Per il lavoro corrente, la distinzione e' fondamentale:

- se la differenza riguarda la **struttura del body**, controllare prima il JSON e il routing Folio
- se la differenza riguarda la **resa visiva**, lavorare in `Themes/Sixteen/resources/css/app.css` e `Themes/Sixteen/resources/js/app.js`

## Documenti collegati

### Cms
- [../design-comuni-homepage.md](../design-comuni-homepage.md)
- [../00-index.md](../00-index.md)

### Theme Sixteen
- [../../../../Themes/Sixteen/docs/design-comuni/00-index.md](../../../../Themes/Sixteen/docs/design-comuni/00-index.md)
- [../../../../Themes/Sixteen/docs/design-comuni/homepage-structure-diff-2026-04-02.md](../../../../Themes/Sixteen/docs/design-comuni/homepage-structure-diff-2026-04-02.md)
- [../../../../Themes/Sixteen/docs/design-comuni/work-plan.md](../../../../Themes/Sixteen/docs/design-comuni/work-plan.md)
- [../../../../Themes/Sixteen/docs/design-comuni/screenshots/homepage-visual-pass-2026-04-02.md](../../../../Themes/Sixteen/docs/design-comuni/screenshots/homepage-visual-pass-2026-04-02.md)
