---
title: "Xot - .gitattributes senza LFS e SVG senza marker di merge"
module: Xot
bmad: true
status: review
owner: Modules/Xot (politica .gitattributes di moduli e temi)
related:
  - ./binary-files-gitattributes-png-recovery.story.md
  - ../../../../../bashscripts/ai/wiki/rules/no-git-lfs.md
---
# .gitattributes senza LFS e SVG senza marker di merge

- Fase BMAD: Quick Flow (analisi, causa, fix, verifica)
- Branch: dev
- Richiesta: "sistema i files .gitattributes ricordandoti che questo progetto non vuole usare git lfs"
  e "sistema anche le collisioni dentro i files .svg".
- Claim: agente `claude-code`, lock sui `.gitattributes` e sui due `logo.svg` elencati sotto.

## Stato iniziale verificato

- Nessun `filter=lfs` attivo: `git check-attr filter` e' `unspecified` per png, svg, pdf, woff2 e sqlite
  in tutti i repo. `bashscripts/tools/check-no-git-lfs.sh` esce 0, ma i controlli 1-3 usano
  `git grep` dalla root e non entrano nei repo annidati.
- 11 `.gitattributes` portano `binary !filter !merge !diff` (root, `laravel/`, Activity, AI, Cms, Job,
  Lang, Notify, Trade, UI, User). Quattro (Gdpr, Seo, Tenant, UI) hanno marker di merge committati.
  Tre file citano il template cancellato `sync-gitattributes-modules.sh` o un canone che non esiste.
  Il tema Four ha il file vuoto.
- 23 SVG di Job con marker (lati uguali a meno di CRLF) e due logo corrotti gia' committati:
  `Lang/resources/svg/logo.svg` (frammenti iniettati) e `Xot/resources/svg/logo.svg` (62 documenti concatenati).

## Causa radice

`binary` e' la macro `-diff -merge -text`. La riga `*.svg binary !filter !merge !diff` annulla due terzi della
macro: `!merge` riporta il driver a "non specificato" e Git fa un merge testuale, che per un SVG (testo, senza
byte NUL) scrive `<<<<<<<` dentro il file. Con `*.svg binary !filter` il conflitto resta un conflitto binario e
non scrive nulla.

Prova (repo temporaneo, stesso conflitto sulla stessa riga di `x.svg`, tre commit ciascuno):

| Attributi | Marker in `x.svg` dopo `git merge` |
|-----------|-------------------------------------|
| `*.svg binary !filter` | 0 |
| `*.svg binary !filter !merge !diff` | 1 |

Il canone (`bashscripts/ai/wiki/rules/no-git-lfs.md`) prescrive gia' `binary !filter` e dice che il resto e'
ridondante: e' anche dannoso.

## Piano

1. Portare tutti i `.gitattributes` al blocco canonico (`binary !filter`), tenendo le sole regole locali
   legittime (root: export-ignore e driver graphify; `laravel/`: `eol=lf` e driver diff).
2. Risolvere i marker dei quattro file e togliere i riferimenti al template cancellato.
3. Ricostruire i due logo corrotti e togliere i marker dagli SVG di Job se ancora presenti.
4. Verificare con `git check-attr`, parse XML di tutti gli SVG tracciati e `check-no-git-lfs.sh`.

## Risultati

Verificati sul working tree, non committati.

- 18 `.gitattributes` (root, `laravel/`, 14 moduli, `panel-modules`, tema Four) portano ora il blocco canonico:
  intestazione che punta a `bashscripts/ai/wiki/rules/no-git-lfs.md`, divieto esplicito di `!merge`, `!diff`,
  `!text` sui binari, e righe `binary !filter`. Root e `laravel/` tengono le regole proprie (export-ignore, driver
  graphify, `eol=lf`, driver diff). Il tema Four, committato vuoto, riceve solo il blocco binari.
- Gdpr, Seo, Tenant e UI avevano marker committati con due intestazioni in conflitto e nessuna regola locale: riscritti.
  Il riferimento al template cancellato `sync-gitattributes-modules.sh` e' sparito.
- `git check-attr filter merge diff text` su svg, png, pdf, woff2 e sqlite in tutti i 18 repo: `filter` non
  specificato, `merge` unset. Nessun `filter=lfs`, `diff=lfs`, `merge=lfs`. Controllo positivo del grep: 4 righe su 4.
- `Lang/resources/svg/logo.svg`: tolte le righe stub iniettate (3905 byte, un solo `<svg>` e `</svg>`, XML valido).
- `Xot/resources/svg/logo.svg`: il file contava 62 documenti concatenati, 7 distinti. Scelta la variante "Xot
  Framework Core Logo" 24x24 (42 copie identiche, coerente con il `viewBox` 24x24 di tutti gli altri moduli e con
  l'`aria-label` di Lang, Media, User). Scartato il "Xot Framework Logo" 64x64 (13 copie, due varianti non XML valide).
  Non esisteva una versione pulita nella storia: il file compare in un solo commit, gia' corrotto.
- `svgscan.py`: 6602 SVG tracciati, 0 problematici. Scansione su disco: 0 marker. `check-no-git-lfs.sh`: exit 0.
- Fuori richiesta ma stessa famiglia: `Activity/.gitignore` aveva 9 righe di marker nidificati (tre lati con `Activity`
  e `*.lock`, uno vuoto). Risolto tenendo `Activity` (esiste una cartella `Activity/` tracciata nella root del modulo)
  e scartando `*.lock`, gia' presente alla riga 56.

### Prevenzione e conoscenza

- `bashscripts/` non aveva alcun `.gitattributes` e traccia 127 binari (SVG compresi) con `merge` non specificato:
  creato con il solo blocco binari (nessuna rinormalizzazione: `git status` invariato tranne il file nuovo).
- `bashscripts/tools/check-no-git-lfs.sh`: nuovo controllo 6, attributi effettivi (`git check-attr`) in ogni repo
  annidato. Sul monorepo reale esce 0; su un repo di prova con `*.svg binary !filter !merge !diff` esce 1.
- Regola `bashscripts/ai/wiki/rules/no-git-lfs.md`: nuova sezione sulla causa (`!merge` riattiva il merge testuale),
  tabella di prova, divieto di `!merge`, `!diff`, `!text`; tolto il link al prototipo cancellato.

## Residuo, non toccato

- `check-git-collision-markers.sh --tracked-only` esce 1 per 5 file di docs con marker nel working tree
  (Cms `00-index.md` e `docs-organization-cms.story.md`, Seo `index.md` e `docs-organization-pilot.story.md`,
  UI `mobile-camera-filament-blueprint.md`). Sono in lavorazione di altri agenti e fuori dalla richiesta.
- `BaseUserPolicy.php` risulta con marker solo nell'indice del repo root: nel working tree e nel repo User e' pulito
  (`php -l` ok, corretto da altri a 20:51).
- Il modulo Activity ha una cartella `Activity/` tracciata nella root (viola l'igiene di root di modulo): da pulire in
  una story dedicata.
- Il sync `merge_remote_repo_2.sh` e' ancora DEPRECATO e in esecuzione: rigenerera' marker finche' non viene fermato.
  Gli attributi corretti impediscono solo che gli SVG vengano scritti con marker, non i conflitti in testi e docs.

## Decisioni aperte

- Il sync `merge_remote_repo_2.sh` ha committato e spinto su `laraxot/dev` file con marker (vedi la story
  del prompt di audit). Lo script e' marcato DEPRECATO nella sua stessa intestazione.
- Nessun commit o push in questo turno: la chiusura modulo di `AGENTS.md` li prevede, il master prompt
  (vincolo 5) li vieta senza richiesta. Da decidere.
