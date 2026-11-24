---
title: "Xot — audit qualità (docs, naming, AssetAction)"
type: story
module: Xot
status: review
created: 2026-11-19
updated: 2026-11-19
issue: "https://github.com/laraxot/base_techplanner_fila5/issues/64"
tags: [xot, audit, docs, bmad]
qmd: "audit qualita Xot docs naming date duplicati AssetAction symlink"
---

# Story — audit qualità del modulo Xot

Come manutentore di Xot (modulo base di tutti gli altri), voglio documentazione senza
duplicati né nomi datati e un `AssetAction` più semplice, senza cambiare nessuna firma
pubblica usata dagli altri moduli.

## Acceptance criteria

- [x] PHPStan `analyse Modules/Xot` a 0 errori prima e dopo.
- [x] Nessun `.md` con data/timestamp nel nome (data spostata in `created:`).
- [x] Un solo indice canonico: [README.md](../README.md); `00-index.md` resta come rimando.
- [x] Affermazioni smentite dal codice corrette (copia asset di `AssetAction`).
- [x] Modifiche al codice solo private, coperte da test.

## Modifiche

**Rinomine (`git mv`, data in `created:`)**: `wiki/redundancy-audit.md`,
`wiki/troubleshooting/phpstan-modules-fix.md`, `wiki/troubleshooting/git-merge-conflict-inventory.md`,
`filament/hasxtable-visibility-fix.md`, `filament/xotbaseresource-violations-fixes.md` (era «january-2026»),
`quality-analysis/phpstan-modules-snapshot.md`, `bmad/stories/module-bmad-audit-baseline.story.md`
e 11 storie `bmad/stories/*-.story.md` (trattino finale residuo di una bonifica precedente) → `*.story.md`.

**Duplicati rimossi** (contenuto già presente nel file canonico, differenze solo di frontmatter):
12 storie `bmad/stories/*-2026MMDD*.story.md`, `docs-100-fleet-merge-.story.md` e
`phpstan-analyse-modules-.story.md` (sottoinsiemi della versione canonica), 2 memorie
`wiki/memories/*-20260928.md`, 7 copie esatte con residuo di data (`*-24`, `*-25`, `09-*`,
`stories/13-dcp-45-*`), file vuoti `index.md` e `migration-standards.md` (link ripuntati a
`migrations-consolidated.md`), `INDEX.md` (variante di maiuscole, contenuto confluito in README).

**Frontmatter**: 6 storie avevano un secondo blocco `---title: "Xot - …"` mai chiuso; fuso nel primo.

**Affermazioni obsolete**: `bmad/architecture.md` diceva che `AssetAction` copia gli asset in
`public_html`; `decision-log.md` (2026-10-08) citava `copyAtomically()`. Corretti/annotati come superati.

**Codice** — `app/Actions/File/AssetAction.php` (solo metodi privati):
eliminato lo stato `private XotData $xot` (azione accodabile senza stato: `XotData::make()` solo per i temi),
proprietà del tema lette in modo tipizzato al posto di `$this->xot->{$ns}`, `in_array` stretto,
ramo `public/` + `resources/` unificato, docblock in italiano.
Test: `tests/Unit/Actions/File/AssetActionsTest.php` +2 casi (asset di tema, asset mancante).

## Aree a rischio NON toccate (per il coordinatore)

- **`AssetAction`, ripiego `resources/`**: restituisce `assets/<modulo>/…` anche se il file sta solo in
  `resources/`, ma il symlink punta a `public/` → URL 404 in produzione. Cambiarlo in un'eccezione è un
  cambio di comportamento per tutti i moduli: serve prima un inventario degli asset solo-`resources/`.
- **Link esterni a Xot rotti dalle rinomine**: `Activity/docs/index.md` → `Xot/docs/index.md` (era vuoto);
  Notify/UI/User `code-redundancy-*.md` → `redundancy-audit-2026-05-26.md`; Gdpr/Tenant/Media/Seo/
  `Themes/Sixteen` → `git-merge-conflict-inventory-2026-04-28.md`; Notify/Lang/Tenant/Media → storie
  `module-bmad-audit-20260928`. Fuori perimetro: da correggere dagli agenti dei rispettivi moduli.
- **Classi base `XotBase*`, `XotData`, service provider**: nessuna modifica (firme usate ovunque).
- **`docs/-integration/`**: file che iniziano con `-` (`--tips.md`…), residuo di un prefisso rimosso;
  vanno rinominati con una migration map, non a mano.
- **`docs/filament/.gitignore`** elenca file tracciati: non ha effetto; da chiarire l'intento.
- **`wiki/index.md`**: `related:` con 6 target dichiarati mancanti.
- `bmad/stories/docs-filename-no-date-bonifica-xot.story.md` è un elenco storico: lasciato con i nomi vecchi.

## Cosa resta

- Correggere i link esterni elencati sopra.
- Decidere sul ripiego `resources/` di `AssetAction` (test + inventario).
- Classificare `consolidated/`, `parcheggio/`, `-integration/` e le coppie `snake_case`/`kebab-case`
  in radice `docs/` (es. `code-quality.md` / `code_quality.md`).
