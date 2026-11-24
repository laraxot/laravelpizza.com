---
title: "[STORY] tests/graphify-out/ ignorata in tutti i moduli e temi, cartella Activity rimossa"
type: story
status: done
priority: medium
created: 2026-11-24
updated: 2026-11-24
module: Xot
tags: [gitignore, graphify, activity, sync, multi-progetto]
qmd: "graphify out tests ignored all modules"
---

# [STORY] tests/graphify-out/ ignorata in tutti i moduli e temi, cartella Activity rimossa

## User Request

«la cartella tests/graphify-out/ deve essere messa in tutti i .gitignore dei moduli e dei temi e poi cancellata, come sempre prima devi capire il perche' e fare tutto con bmad + ecc + second brain».

## Analysis

**Cos'e'.** `Modules/Activity/tests/graphify-out/` conteneva sei file (364 KB): `graph.json` (181 nodi, 281 archi), `graph.html`, `manifest.json` (100 file di test), `.graphify_labels.json(.sig)` e `.graphify_root`. E' il grafo di conoscenza che graphify costruisce sulle cartelle di test di Activity: derivato, rigenerabile, senza valore come sorgente.

**Perche' c'era.** `.graphify_root` conteneva `/var/www/_bases/base_ptvx_fila5/laravel/Modules/Activity/tests`: un graphify lanciato nel progetto gemello **ptvx**, con `tests/` come bersaglio, che ha scritto l'output accanto al bersaglio invece che nella radice. I sei file sono stati committati nel repo del modulo Activity e sono arrivati qui dal remote `laraxot` condiviso fra i progetti (stessa causa dei marker di conflitto: [sync-unrelated-histories-repair](./sync-unrelated-histories-repair.story.md)). Il percorso assoluto di un altro progetto dentro un file versionato e' un segnale in piu' che non doveva essere tracciato.

**Perche' la regola esistente non bastava.** Dodici repo avevano gia' `graphify-out/` non ancorato (copre qualsiasi profondita'), ma Activity la aveva eppure teneva i file: un `.gitignore` non toglie dall'indice cio' che e' gia' tracciato, e `git check-ignore` non segnala i file tracciati senza `--no-index`. Sette repo non avevano nessuna regola su graphify (Chart, CloudStorage, Gdpr, Limesurvey, Quaeris, Setting, Tenant). Ogni modulo e' un repo a se': non vede il `.gitignore` della radice.

## Implementation

- Regola esplicita `tests/graphify-out/` aggiunta, con una riga di commento, in 15 `.gitignore`: Activity, AI, Chart, CloudStorage, Cms, Gdpr, Geo, Lang, Limesurvey, Notify, Quaeris, Setting, Tenant, User e `Themes/Zero`. Gia' presente in Job, Media, UI, Xot (nella forma `/tests/graphify-out/`).
- Quattro `.gitignore` avevano marker di conflitto committati dalla sync (Geo, Lang, Media, Notify; Media annidati). Sono liste additive: tolte solo le righe di marker, tenuti entrambi i lati, due righe duplicate (`tests/coverage-*.*`, `docs/screenshots/`) ridotte a una. Backup prima; confronto insiemistico in PHP dopo: 0 righe perse, 0 marker.
- Cancellata `Modules/Activity/tests/graphify-out/` (backup nello scratchpad). Nel repo Activity restano **6 cancellazioni non committate**: le registra il commit del modulo.

## Verification

`git -C <repo> check-ignore --no-index -v tests/graphify-out/graph.json` in tutti e 19 i repo: ignorato, con la riga che lo ignora. Controllo negativo `tests/Unit/ExampleTest.php`: non ignorato (in AI c'e' una negazione esplicita `!tests/**`, la regola nuova viene dopo e vince). Marker residui nei `.gitignore` di moduli e temi: 0.

## Open

- `DbForge` ha il worktree vuoto (solo `.git`) e nessun `.gitignore`: non creato. Da fare quando il modulo viene riportato.
- `Modules/Job/docs/graphify/graphify-out` e `Modules/UI/docs/graphify/graphify-out` sono altri output graphify, sotto `docs/graphify` (gia' ignorato da una regola dedicata): non toccati, non chiesti.
- Finche' ptvx lancia graphify su `tests/` e committa, la cartella puo' tornare nei repo che non hanno ancora la regola: ora ce l'hanno tutti, e un file ignorato non entra piu' con `git add -A`.
- Collegata: [coverage-artifacts-gitignore-all-modules](./coverage-artifacts-gitignore-all-modules.story.md).
