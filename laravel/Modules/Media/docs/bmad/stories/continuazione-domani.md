---
title: "Continuazione BMAD — Domani (Media)"
type: module-fix
scope: Media
epic: "5"
bmad_version: v3.30.1
updated_at: '2026-09-22'
status: in-progress
related:
  - ./readme-changelog-conflict-markers.story.md
  - ./cleanup-media-2026-09-22.story.md
  - ../../../Xot/docs/bmad/stories/cleanup-all-modules.story.md
---

# Media — Continuazione Domani

## Stato verificato ora (sessione 2026-09-22)

- Marker di conflitto committati: **risolti**. `git log --oneline -20` mostra
  la sequenza reale: `61140006` (pulizia marker residui in `docs/`),
  `8c0ca799` (rimozione `.code-workspace` duplicati), `1381294e` (rimosso
  `test11.txt` vuoto dalla root), `a3cf02a1` (marker in `README.md` +
  `CHANGELOG.md` risolti, `graphify-out/` aggiunto a `.gitignore`).
  Riverificato ora con grep ricorsivo su tutta l'albero (esclusi
  vendor/node_modules/graphify-out): **0 marker residui** (`<<<<<<<`,
  `=======`, `>>>>>>>`) in tutto il modulo.
- `docs/bmad/stories/readme-changelog-conflict-markers.story.md` ha ancora
  `status: review` ma il lavoro descritto è **verificato applicato**:
  `README.md` ha il frontmatter `id: module-media-readme` (lato scelto),
  `CHANGELOG.md` ha le entry `0.1.0-dev.1`/`0.1.0-dev.2` pulite, `.gitignore:191`
  contiene `graphify-out/`. Story da marcare `done` da chi la possiede
  (non toccata qui, non è tra i file assegnati).
- `git status --short`: pulito, solo `docs/bmad/stories/continuazione-domani.md`
  non tracciato (questo file). Nessun lock attivo in
  `docs/bmad/stories/*.lock`.

## Bug reale trovato in app/ (non in nessuna story esistente)

`app/Conversions/VideoGenerators/Webm.php:16` ha una `dddx([...])` **attiva**
(non commentata) dentro `convert()`, con `${$pathToImageFile}` (variabile
variabile su una stringa path — quasi certamente un bug di battitura, non
l'intento) e l'estensione file volutamente storpiata in `.webmXXX`
(`pathinfo($file, PATHINFO_FILENAME).'.webmXXX'`). Coerente con
`app/Filament/Actions/Table/ConvertAction.php:34`, dove l'azione Filament
`format => webm01|webm02` non converte nulla e lancia sempre
`throw new \RuntimeException('Removed debug dddx')` — la conversione webm è
stata disattivata di proposito perché rotta, ma il debug non è mai stato
ripulito. Nessuna story BMAD copre questo file.

## Altri segnali reali in app/ (grep mirato)

- Duplicazione: `app/Services/SubtitleService.php` e
  `app/Actions/Stream/SubtitleService.php` sono identici (`diff` mostra solo
  il `namespace` diverso: `Modules\Media\Services` vs
  `Modules\Media\Actions\Stream`). Nessuna delle due FQCN è referenziata
  altrove in `app/` (grep su `use ...SubtitleService` vuoto) — probabile
  refactor incompleto post `f4a106a9` ("finalize Services/Support ->
  QueueableAction conversion"). Da decidere quale tenere ed eliminare l'altra.
- `app/Services/SubtitleService.php.bak` è **tracciato in git**
  (`git ls-files` lo conferma, aggiunto in `f4a106a9`) — file `.bak` non
  dovrebbe stare nel repo.
- `docs/bmad/stories/cleanup-media-2026-09-22.story.md` è un template
  generico (Understand/Plan/Implement/Verify/Document) senza `status` e
  senza riferimenti concreti — non risulta collegato a nessun lavoro reale
  svolto finora; verificare se va chiuso come "mai eseguito" o riempito con
  contenuto reale.

## Continuazione — priorità

1. **Webm.php / ConvertAction.php** — decidere: (A) implementare davvero la
   conversione webm→immagine e rimuovere `dddx`+RuntimeException, o (B)
   rimuovere del tutto il generatore Webm se il formato non è più
   supportato da Spatie MediaLibrary in uso. Toccare solo questi 2 file.
2. **Duplicato SubtitleService** — stabilire quale namespace è quello
   corrente (`Actions/Stream` sembra il pattern QueueableAction più recente
   vista `f4a106a9`), eliminare l'altro e il `.bak` tracciato.
3. **readme-changelog-conflict-markers.story.md** — chi la possiede la marchi
   `done` (lavoro già verificato sopra), non riaprire l'analisi.
4. **cleanup-media-2026-09-22.story.md** — valutare se chiuderla (mai
   eseguita) o trasformarla in una story reale con task concreti.

## Second brain

`qmd query` su "Media Webm dddx conversion RuntimeException removed" prima di
riprendere; `qmd update` dopo ogni chiusura.
