---
title: "ADR Xot 0014: mixed solo come ultima spiaggia"
type: story
status: review
module: Xot
epic: quality-gates
story_id: xot-adr-mixed-ultima-spiaggia
created: 2026-11-24
updated: 2026-11-24
tags: [adr, phpstan, mixed, boundary, safe-cast, webmozart-assert]
qmd: "adr 0014 mixed ultima spiaggia xot narrowing boundary Safe cast action Webmozart Assert psalm-assert ignoreErrors baseline livello max audit 37 file"
related:
  - ../../adr/0014-mixed-last-resort.md
  - ../../adr/INDEX.md
  - ./phpstan-xot-test-fixtures-generics-mixed.story.md
  - ./phpstan-modules-bootstrap-duplicate-lines.story.md
---

# ADR Xot 0014: `mixed` solo come ultima spiaggia

## Obiettivo

Una decisione scritta, nel modulo Xot (nucleo trasversale, gia' sede degli ADR di governance), che dice quando `mixed`
e' ammesso e cosa si fa al suo posto. Prima la regola era sparsa nelle story `*-mixed-type-reduction` di Job, Media, UI,
Notify, User, Tenant e Lang, nel prompt `bashscripts/docs/prompts/37-phpstan.md` e in
`Notify/docs/mixed-type-ultima-spiaggia.md`, senza un posto canonico.

## Richiesta utente (verbatim)

«aggiorna docs/adr del modulo piu' adatta spiegando che i mixed li utilizziamo solo come ultima spiaggia»

## Acceptance criteria

- [x] ADR numerato nel modulo owner, con frontmatter e `qmd`: `adr/0014-mixed-last-resort.md`.
- [x] Riga 0014 in `adr/INDEX.md` (totale 27: 19 canonici, 8 superseded).
- [x] Ogni numero citato nell'ADR e' stato misurato il 2026-11-24 (vedi sotto).
- [x] Una affermazione sbagliata corretta prima della chiusura (vedi "Incidenti").
- [ ] `qmd update` dopo le modifiche `.md`.
- [ ] Guard automatico sui `mixed` (test `arch()`): non esiste, dichiarato come debito nell'ADR.

## Cosa e' successo

L'ADR `0014-mixed-last-resort.md` era gia' nel working tree (non tracciato, ultima modifica 21:02) quando l'ho cercato,
scritto da un'altra sessione: `INDEX.md` era passato da 26 a 27 ADR. Non ne ho scritto un secondo, ho esteso quello.

Aggiunto da questa story, tutto verificato:

| Aggiunta | Prova |
|----------|-------|
| `level: max` = PHPStan 2.3.7, baseline off, `ignoreErrors` vuoto, `reportUnmatchedIgnoredErrors: true` | `laravel/phpstan.neon` righe 2, 15, 21, 55; `composer show phpstan/phpstan` |
| 37 file in `Modules/*/app` dichiarano `mixed`, 15 in Xot | `grep -rIlE '(: mixed\b\|@(param\|return\|var) mixed\b)'` |
| `Safe*CastAction` in 95 file, `Safe\` in 272, `Webmozart\Assert` in 395 | `grep -rIl` sui sorgenti `Modules/*/app` |
| Cast nudi su `mixed` e `@var` inline vietati; `@phpstan-ignore*`/baseline/`ignoreErrors` sempre rifiutati | prompt 37 riga 65 e regola progetto "gli errori vanno corretti, non ignorati" |
| Dove `mixed` e' legittimo (ingresso delle `Safe*CastAction`, `config()`, `json_decode()`, `selectOne()`, `pluck()`) e dove no (firma pubblica) | `Safe*CastAction::execute(mixed $value): string`; doc Notify |
| `Assert::integer($raw)` restringe `mixed` a `int` per PHPStan | probe isolato, vedi sotto |

## Incidenti e lezioni

- **Affermazione sbagliata scritta e corretta.** Avevo scritto nell'ADR che `Webmozart\Assert` non restringe il tipo
  perche' l'estensione `phpstan-webmozart-assert` non e' installata. L'avevo dedotto dall'assenza dell'estensione,
  senza provarlo. Il sorgente ha 48 `@psalm-assert` e PHPStan li legge. Prova: file isolato fuori dal progetto con
  `Assert::integer($raw); takesInt($raw)` (nessun errore) e funzione di controllo senza `Assert` (1 errore
  `argument.type` alla riga attesa). Senza il controllo negativo un output vuoto non avrebbe dimostrato nulla.
  Lezione: "l'estensione non c'e'" non implica "la funzione non c'e'".
- Il gate dei fatti ha bloccato la prima Edit finche' non ho fatto una ricerca vera dei riferimenti all'ADR.

## Debito aperto (non mio, non toccato)

- `Notify/docs/mixed-type-ultima-spiaggia.md` ha 4 righe di marker di merge (`.merge_file_*`, `HEAD`, `laraxot/dev`) nel
  frontmatter, e 3 link morti: `Xot/docs/quality/phpstan-rules.md`, `Xot/docs/safe-casting-actions.md`,
  `Xot/docs/stories/5.10.mixed-narrowing-campaign.story.md` (nessuno dei tre esiste). Un `.md` non rompe PHPStan.
  Va corretto dal proprietario del modulo Notify, poi collegato a questo ADR.
- `bashscripts/docs/prompts/37-phpstan.md` riga 123 dice "`Safe*CastAction` o `Assert`": coerente con la prova, nessuna
  modifica necessaria.
- Guard `arch()` che conti i `mixed` fuori dalle `Safe*CastAction`: da progettare (audit di riferimento: 37 file).

## Verifica

Solo documentazione: nessun PHP toccato da questa story. Pest non pertinente. Controllo ripetibile:
`grep -rIlE '(: mixed\b|@(param|return|var) mixed\b)' --include='*.php' laravel/Modules/*/app | wc -l`.
