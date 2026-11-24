---
qmd: "ui stories ui root md file limit audit story md"
title: Audit igiene root — limite 6 file .md in Modules/UI
slug: ui-root-md-file-limit-audit
status: done
scope: module:UI
---

# Audit igiene root — limite 6 file .md in Modules/UI

## Contesto

Regola canon (`bashscripts/docs/prompts/03-quality-gates.md`, sezione "Igiene root modulo/tema"): la root di ogni modulo ha al massimo 6 file `.md` (README + poche pagine canoniche). Verifica del 2026-09-07: `laravel/Modules/UI/` aveva 31 file `.md` in root, 25 in eccesso rispetto alla soglia. `.txt` in root = 0 (già conforme).

## Analisi preliminare

Prima di spostare qualunque file è stato letto integralmente il contenuto dei 31 file di root e confrontato con l'albero `docs/` già esistente (che contiene già centinaia di varianti duplicate documentate e volutamente non toccate da `docs-index-audit.story.md`, status done).

Scoperta chiave: **24 dei 25 file da rimuovere erano già byte-identici** a una copia pre-esistente in `docs/raw/root-import/<slug>-1.md` (dump raw datato 27 luglio) e ulteriormente arricchita con frontmatter in `docs/raw/root-import/<slug>.md` (datato 1 settembre). Un ciclo precedente aveva già importato/archiviato questi file ma non aveva mai ripulito gli originali in root. Verificato con `diff -q` per ciascun file, riportato di seguito.

Il 25° file (`custom-theme.md`) differiva dalla copia raw solo per un H1 ridondante (`# custom_theme`) e un commento HTML di migrazione — nessun contenuto informativo perso, il corpo (link) è identico e la versione arricchita con frontmatter in `docs/raw/root-import/custom-theme.md` copre già tutto.

## Decisione

Root keepers (6, invariati salvo CHANGELOG.md):
- `README.md`
- `ARCHITECTURE.md`
- `TESTING.md`

- `architecture.md`
- `testing.md`
- `PHILOSOPHY.md`
- `GETTING_STARTED.md`
- `CHANGELOG.md`

Per gli altri 25, poiché il contenuto era già duplicato verbatim (o quasi) in `docs/raw/root-import/`, applicata la regola "fondi, non lasciare due copie": nessun nuovo `git mv` (avrebbe creato una TERZA copia in un albero `docs/` già pieno di centinaia di duplicati noti), ma `git rm` del file di root ridondante, con il contenuto che resta permanentemente disponibile — invariato — nelle copie già committate sotto `docs/raw/root-import/`.

## File rimossi (contenuto già preservato altrove, verificato)

| File di root rimosso | Copia raw già esistente | Copia arricchita già esistente | Esito diff |
|---|---|---|---|
| api.md | docs/raw/root-import/api-1.md | docs/raw/root-import/api.md | identico |
| blocks.md | docs/raw/root-import/blocks-1.md | docs/raw/root-import/blocks.md | identico |
| carousel-slider.md | docs/raw/root-import/carousel-slider-1.md | docs/raw/root-import/carousel-slider.md | identico |
| CHANGELOG.md | docs/raw/root-import/changelog.md | docs/raw/root-import/CHANGELOG.md | identico (+ fuso in CHANGELOG.md, vedi sotto) |

| CHANGELOG.md | docs/raw/root-import/changelog-1.md | docs/raw/root-import/CHANGELOG.md | identico (+ fuso in CHANGELOG.md, vedi sotto) |

| changelog.md | docs/raw/root-import/changelog-1.md | docs/raw/root-import/changelog.md | identico (+ fuso in CHANGELOG.md, vedi sotto) |
| chunk.md | docs/raw/root-import/chunk-1.md | docs/raw/root-import/chunk.md | identico |
| ci.md | docs/raw/root-import/ci-1.md | docs/raw/root-import/ci.md | identico |
| custom-firm-fields.md | docs/raw/root-import/custom-firm-fields-1.md | docs/raw/root-import/custom-firm-fields.md | identico |
| custom-theme.md | docs/raw/root-import/custom-theme-1.md | docs/raw/root-import/custom-theme.md | quasi identico (solo H1+commento ridondanti in root) |
| eav.md | docs/raw/root-import/eav-1.md | docs/raw/root-import/eav.md | identico |
| effetcts.md | docs/raw/root-import/effetcts-1.md | docs/raw/root-import/effetcts.md | identico |
| filament.md | docs/raw/root-import/filament.md | docs/raw/root-import/filament.md | identico |
| flip-cards.md | docs/raw/root-import/flip-cards-1.md | docs/raw/root-import/flip-cards.md | identico |
| global-search.md | docs/raw/root-import/global-search-1.md | docs/raw/root-import/global-search.md | identico |
| links.md | docs/raw/root-import/links.md | docs/raw/root-import/links.md | identico |

| filament.md | docs/raw/root-import/filament-1.md | docs/raw/root-import/filament.md | identico |
| flip-cards.md | docs/raw/root-import/flip-cards-1.md | docs/raw/root-import/flip-cards.md | identico |
| global-search.md | docs/raw/root-import/global-search-1.md | docs/raw/root-import/global-search.md | identico |
| links.md | docs/raw/root-import/links-1.md | docs/raw/root-import/links.md | identico |
| media.md | docs/raw/root-import/media-1.md | docs/raw/root-import/media.md | identico |
| megamenu.md | docs/raw/root-import/megamenu-1.md | docs/raw/root-import/megamenu.md | identico |
| navbar.md | docs/raw/root-import/navbar-1.md | docs/raw/root-import/navbar.md | identico |
| page-builder.md | docs/raw/root-import/page-builder-1.md | docs/raw/root-import/page-builder.md | identico |
| qrcode.md | docs/raw/root-import/qrcode-1.md | docs/raw/root-import/qrcode.md | identico |
| ratings.md | docs/raw/root-import/ratings-1.md | docs/raw/root-import/ratings.md | identico |
| tailwind-themes.md | docs/raw/root-import/tailwind-themes-1.md | docs/raw/root-import/tailwind-themes.md | identico |
| test.md | docs/raw/root-import/test.md | docs/raw/root-import/test.md | identico (entrambi contenuto minimale) |

| test.md | docs/raw/root-import/test-1.md | docs/raw/root-import/test.md | identico (entrambi contenuto minimale) |
| theme.md | docs/raw/root-import/theme-1.md | docs/raw/root-import/theme.md | identico |
| ubuntu.md | docs/raw/root-import/ubuntu-1.md | docs/raw/root-import/ubuntu.md | identico |
| widgets.md | docs/raw/root-import/widgets-1.md | docs/raw/root-import/widgets.md | identico |

## Fusione changelog.md → CHANGELOG.md

`changelog.md` (root, minuscolo) conteneva solo: "Tutte le variazioni importanti di UI saranno generate automaticamente da semantic-release." Contenuto non presente in `CHANGELOG.md` (maiuscolo, keeper). Aggiunta come nota citata subito dopo il titolo di `CHANGELOG.md`, poi rimosso `changelog.md` dalla root (il contenuto originale resta comunque anche in `docs/raw/root-import/changelog-1.md`).
## Fusione CHANGELOG.md → CHANGELOG.md

`CHANGELOG.md` (root, minuscolo) conteneva solo: "Tutte le variazioni importanti di UI saranno generate automaticamente da semantic-release." Contenuto non presente in `CHANGELOG.md` (maiuscolo, keeper). Aggiunta come nota citata subito dopo il titolo di `CHANGELOG.md`, poi rimosso `CHANGELOG.md` dalla root (il contenuto originale resta comunque anche in `docs/raw/root-import/changelog.md`).

`CHANGELOG.md` (root, minuscolo) conteneva solo: "Tutte le variazioni importanti di UI saranno generate automaticamente da semantic-release." Contenuto non presente in `CHANGELOG.md` (maiuscolo, keeper). Aggiunta come nota citata subito dopo il titolo di `CHANGELOG.md`, poi rimosso `CHANGELOG.md` dalla root (il contenuto originale resta comunque anche in `docs/raw/root-import/changelog-1.md`).

## Verifica finale

```
find laravel/Modules/UI -maxdepth 1 -iname '*.md' | wc -l
# 6
```

<<<<<<< HEAD
<<<<<<< HEAD
Root risultante: `architecture.md`, `CHANGELOG.md`, `GETTING_STARTED.md`, `PHILOSOPHY.md`, `README.md`, `testing.md`.

## Nota fuori scope

=======
=======
>>>>>>> laraxot/dev
Root risultante: `ARCHITECTURE.md`, `CHANGELOG.md`, `GETTING_STARTED.md`, `PHILOSOPHY.md`, `README.md`, `TESTING.md`.

## Nota fuori scope

Trovati due file untracked pre-esistenti (non creati da questo task, timestamp 2026-09-06 12:37, precedenti a questa sessione): `docs/GETTING_STARTED.md` e `docs/TESTING.md`, contenuto identico ai keeper di root. Probabile residuo di un'altra sessione/tool di scaffolding. Non toccati: fuori dallo scope di questo task (igiene della ROOT del modulo, non di `docs/`) e non lockati da nessuno al momento della verifica.

Root risultante: `architecture.md`, `CHANGELOG.md`, `GETTING_STARTED.md`, `PHILOSOPHY.md`, `README.md`, `testing.md`.

<<<<<<< HEAD
>>>>>>> laraxot/dev
=======
>>>>>>> laraxot/dev
Trovati due file untracked pre-esistenti (non creati da questo task, timestamp 2026-09-06 12:37, precedenti a questa sessione): `docs/GETTING_STARTED.md` e `docs/testing.md`, contenuto identico ai keeper di root. Probabile residuo di un'altra sessione/tool di scaffolding. Non toccati: fuori dallo scope di questo task (igiene della ROOT del modulo, non di `docs/`) e non lockati da nessuno al momento della verifica.

## Vincoli rispettati

- `laravel/phpstan.neon` non toccato.
- Nessun `@phpstan-ignore`.
- Nessun contenuto perso: ogni file rimosso aveva copia verificata byte-identica (o quasi) già committata in `docs/raw/root-import/`.
- Nessun `--force`, nessun nuovo branch, nessun `revert`/`reset --hard`/`checkout`.

## Best practices

- Prima di spostare un file duplicato, verificare sempre con `diff -q` se una copia identica esiste già altrove nell'albero `docs/` — evita di creare una terza copia in un repo che ha già centinaia di duplicati noti.
- Escludere sempre `git add -A` quando ci sono file untracked non correlati nella working tree (qui `docs/GETTING_STARTED.md` e `docs/TESTING.md`): usare `git add <path>` esplicito.

- Escludere sempre `git add -A` quando ci sono file untracked non correlati nella working tree (qui `docs/GETTING_STARTED.md` e `docs/testing.md`): usare `git add <path>` esplicito.

## Bad practices

- Fare `git mv` cieco senza controllare se la destinazione esiste già: avrebbe sovrascritto o creato conflitti con `docs/raw/root-import/`.
- Cancellare un file "duplicato" senza prima verificarne il contenuto con un diff reale: rischio di perdita silenziosa di contenuto unico.

## False friends

- "File in root da 31 a spostare" non significa "31 spostamenti fisici": la maggior parte del lavoro era già stato fatto da un ciclo precedente (`docs/raw/root-import/`), il vero task era la rimozione dei residui duplicati, non una migrazione da zero.
