---
title: "Ignorare e rimuovere gli artefatti generati nei pacchetti"
type: story
module: Xot
status: done
created: 2026-11-24
updated: 2026-11-24
tags: [bmad, ecc, second-brain, coverage, docs, gitignore, modules, themes]
qmd: "coverage artifacts docs archive screenshots gitignore modules themes cleanup"
---

# Story — artefatti generati fuori dai repository dei pacchetti

## Perché

I report `tests/coverage-*.*`, gli archivi legacy in `docs/archive/` e le immagini in `docs/screenshots/` non appartengono alla superficie mantenuta dei pacchetti. Se restano tracciati aumentano il rumore nei diff, diventano obsoleti e mescolano evidenze temporanee con sorgenti e documentazione canonica.

## GitHub (tracciamento)

- Canon: [module_xot_fila5#150](https://github.com/laraxot/module_xot_fila5/issues/150)
- Chiusura TwentyOne: [theme_twentyone_fila5#9](https://github.com/laraxot/theme_twentyone_fila5/issues/9)
- Chiusura Two: [theme_two_fila5#2](https://github.com/laraxot/theme_two_fila5/issues/2)

## Acceptance criteria

- [x] Ogni modulo con `module.json` ignora esattamente `tests/coverage-*.*` nel proprio `.gitignore`.
- [x] Ogni modulo e tema ignora `docs/archive/` e `docs/screenshots/` nel proprio `.gitignore`.
- [x] Nessun file coperto dai tre pattern resta nel working tree o nell'indice dei pacchetti.
- [x] La regola è verificata con `git check-ignore` e una scansione filesystem/index.
- [x] I cambiamenti sono committati e pubblicati su `dev`; i commit concorrenti sono di Marco, quindi non ricadono nella regola `Refs #<n>` riservata ai commit degli agenti.

## Scope e coordinamento

| File | Proprietario | Stato |
|---|---|---|
| `Modules/*/.gitignore` | `codex-root` | verificato |
| `Modules/User/tests/coverage-*.*` | `codex-root` | rimossi |
| `Modules/*/docs/{archive,screenshots}/` | `codex-root` | rimossi |
| `Themes/*/.gitignore`, `Themes/*/docs/{archive,screenshots}/` | `codex-root` | verificato/rimossi |

## Evidenze

- Second Brain healthcheck eseguito; sorgenti wiki presenti. QMD disponibile in `~/.npm-global/bin` ma assente dal `PATH` iniziale, quindi richiamato con `PATH` esplicito.
- Censiti 19 moduli reali (`module.json`); `Modules/DbForge` escluso perché directory Git vuota senza manifest di modulo.
- Prima della modifica: pattern assente in 19/19; sette XML corrispondenti presenti e tracciati nel modulo User.
- Verifica finale: 25 pacchetti, zero errori; tutte le sonde sono ignorate e scansione filesystem/index vuota.
- `cd laravel && composer harness:check`: 42 test, 63 assertion, tutti verdi.

## Chiusura

Dopo l'autenticazione di `gh` sono state aperte le issue puntuali. Durante la chiusura Marco ha committato e pubblicato
in concorrenza gli ultimi due temi: TwentyOne `2eff07e`, Two `d584c35`. Il tentativo dell'agente ha trovato entrambi i
working tree già puliti e non ha creato commit vuoti. Test pacchetto finali: TwentyOne 2 test/11 assertion; Two 2 test/232
assertion, tutti verdi.
