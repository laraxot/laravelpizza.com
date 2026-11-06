---
title: "Meetup: studio dello stato reale e correzione degli ingressi docs"
type: story
status: done-with-open-decisions
created: 2026-10-14
updated: 2026-10-14
theme: Meetup
owner: theme:Meetup
related:
  - ../00-INDEX.md
  - ../README.md
  - ./docs-organization-pilot.story.md
  - ../../../Sixteen/docs/bmad/stories/docs-studio-stato-e-ingressi.story.md
  - ../../../../../bmad-output/stories/docs-organization/DOC-010.module-theme-quality.story.md
tags: [docs, meetup, bmad, ingressi, verifica, legacy, doc-010, doc-002]
qmd: "meetup docs studio stato legacy guscio senza codice pub_theme sixteen Modules/Meetup assente ResolvePageAction link ripuntati"
---

# Meetup: studio dello stato reale e correzione degli ingressi docs

Fase BMAD: manutenzione documentale (DOC-010, DOC-002). Segue il pilota del 2026-10-08 ([story](docs-organization-pilot.story.md)), che aveva lasciato aperta la domanda "il tema e' satellite: che cosa fare del wiki locale?".

## Richiesta
Stabilire con prove se Meetup e' un tema vivo o legacy e correggere `README.md` e `00-INDEX.md`, senza cancellare, spostare o rinominare.

## Analisi
Il README del pilota dichiarava `status: active` e "tema satellite di Fixcity". La realta' e' piu' povera:

- **Nessun codice.** Il tema contiene `package.json` (`laraxot/theme-meetup-fila5`, `0.0.0`, privato), `.releaserc.json`, `.gitignore`, `.github/workflows/` vuota, `scripts/ci/contributor-lines-report.mjs`, `resources/mail-layouts/test-layout.html` (una riga di HTML di prova) e `docs/`. Mancano `composer.json`, `theme.json`, `app/`, view, css, js, `lang/`, `tests/`, Vite. Creato dal commit `bc58be108` (2026-06-12).
- **Non e' usato.** `pub_theme = Sixteen` nei 4 `laravel/config/**/xra.php`; `public_html/themes/` ha solo `Sixteen`; non e' in `gitmodules.ini`; non e' nei namespace PSR-4 di `RegisterRuntimePsr4NamespacesAction`.
- **Il modulo Meetup non esiste.** `laravel/Modules/` non ha `Meetup`; `Modules/Cms/app/Actions/ResolvePageAction.php` cita `Modules\Meetup\Models\Event` e `Profile` (riferimenti a classi assenti).
- Il dossier BMAD dice lo stesso in forma di domanda: `status: support-decision-required`, "decide whether it supports public civic flows or is demo-only".

## Modifiche (solo `laravel/Themes/Meetup/docs/`)
- `README.md`: il paragrafo "tema satellite" ora dichiara l'intento e subito dopo lo stato reale ("guscio senza codice"), con tabella domanda/risposta/prova (6 righe); `updated`, `qmd`.
- `00-INDEX.md`: stato in cima ("legacy, non attivo"), conteggio file portato a 37, tabella di classificazione delle cartelle, riga della story.
- `wiki/index.md`: 4 link ripuntati a bersagli esistenti (`ai-harness-theme-discipline.md` x2, `xotbase-check.md`, `coordinate-picker-state-binding-rule.md`); tolte le 4 annotazioni "target mancante" del 2026-10-08 che con il ripuntamento sono diventate false; 10 annotazioni del pilota restano valide.
- `wiki/log.md`: voce datata. Un'annotazione duplicata che avevo aggiunto per errore (stessa data diversa) e' stata rimossa in 11 punti.

## Verifica
`docs-organizer.py --busy-minutes 0 links ... --by-name` sui file toccati (`wiki/index.md`, `wiki/log.md`, `README.md`, `00-INDEX.md`): 15 -> 11 eventi (misura finale con la story creata: 0 eventi sulla story); perimetro Meetup 34 -> 30. I 10 rimasti in `wiki/index.md` sono annotati (cartelle `entities/`, `sources/`, `comparisons/`, `decisions/`, `_archive/`, `.gitkeep` x2, `llm-wiki.txt`, `theme-vite-build.md`, `coordinate-picker-filament5-save-pattern.md`). Controllo indipendente: 0 link non annotati rotti nei file toccati. Copertura dell'indice: 36 `.md` presenti, tutti elencati.

## Decisioni
- Meetup e' classificato legacy: la domanda "wiki locale" del pilota si chiude cosi': il wiki e' un guscio di stub, non va esteso.
- `README.md` mantiene `status: active` come stato del documento, non del tema.

## Aperto
- Archiviare il guscio o rilanciarlo (decisione di prodotto, dossier BMAD).
- Unificare `bmad/README.md` e `bmad/bmad-dossier.md` (duplicati, a cura del proprietario BMAD).
- Il riferimento `Modules\Meetup\...` in `ResolvePageAction.php` e' codice applicativo: fuori perimetro, segnalato.
