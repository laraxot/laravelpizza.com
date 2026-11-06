---
title: "Xot: studio del codice e riordino degli ingressi docs"
type: story
status: done
created: 2026-10-14
updated: 2026-10-14
module: Xot
tags: [docs, organizzazione, xot, bmad, link, stale]
related: [bmad-output/stories/docs-organization/README.md, bmad-output/docs-architecture/module-theme-docs-contract.md, laravel/Modules/Fixcity/docs/stories/dcp-56-organizzazione-docs-moduli-e-temi.story.md, laravel/Modules/Xot/docs/stories/dcp-45-isolamento-db-test-pest-scratch.story.md]
qmd: "xot docs studio ingressi README 00-INDEX stale link rotti marker merge pest sqlite comandi artisan"
---

# Xot: studio del codice e riordino degli ingressi docs

Fase BMAD: documentazione e qualita' (DOC-010 e DOC-002 del piano `bmad-output/stories/docs-organization/`).

## Richiesta

Studiare `laravel/Modules/Xot`, confrontare il codice con `docs/` (254 file `.md`, 71 voci nella radice, 70-81% di link rotti nell'audit),
correggere gli ingressi con soli fatti verificati e marcare cio' che e' falso. Non spostare, rinominare o cancellare.

## Analisi

- Il canonico e' `00-INDEX.md` (non esiste `index.md` in radice e non va creato). `README.md` era un elenco di link con qmd rotto.
- Codice: 595 file PHP in `app/` (Actions 240, Filament 152, Models 45, Datas 24, Contracts 23, Console 19), 85 classi `XotBase*`, 9 migration,
  199 file `*Test.php`, `lang/it` 192 file e `lang/en` 107.
- Scoperte che i docs non dicevano:
  - `php artisan list` mostra 8 comandi `xot:` (10 sui 18 con `$signature`); `XotServiceProvider::registerCommands()` registra solo
    `GenerateFilamentResources`;
  - `routes/web.php` e `routes/api.php` sono vuote; `routes/seo.php` e `routes/web_seo.php` non sono caricati e nominano controller
    inesistenti;
  - `config/xot.php` contiene percorsi di un altro progetto (`/var/www/html/exa/base_orisbroker_fila5`) che nessun file legge;
  - restano in Xot `app/Actions/AI/Ollama` (2 file), `ContextCompressorAction` (esiste anche in `Modules/AI`) e
    `Actions/Geo/GetDistanceExpressionAction.php`, contro la voce di `wiki/log.md` del 2026-07-24 che li dava tolti;
  - i test non partono: su `tests/Unit/Docs` 10 su 10 falliscono con `SQLiteDatabaseDoesNotExistException` in `tests/XotBaseTestCase.php`
    `setUp` (tre ricette provate, stesso esito; contesto in DCP-45).
- Documenti smentiti dal codice e marcati `stale`: `wiki/architecture.md`, `wiki/Architecture.md` (`getFormSchemaImplementation()` assente,
  trait inesistenti sul `BaseModel`, 0 test `arch()`), `standards/README.md` e `standards/readme.md` (62 e 60 link verso altri progetti,
  sezione STI sul modulo Patient che non esiste), `governance/docs-structure.md` (dice che README.md e' l'unico ingresso, il contratto ne
  vuole due).
- Link: 738 eventi `unresolved` con `--busy-minutes 0` (con il filtro di default 61, perche' salta i file toccati da meno di 10 minuti).
  Per sezione: wiki 160, phpstan 149, standards 141, bmad 121, consolidated 118, architecture 26, radice 16, rules 6, filament 1. Per forma
  del percorso: 226 altri percorsi relativi, 224 file mancanti nella stessa cartella, 147 con un segmento `Modules/` scritto come se la base
  fosse la radice del repo, 59 che iniziano con `docs/`, 41 `../<dir>/docs/` con `<dir>` che non e' un modulo, 37 con modulo esistente e
  file inesistente, 4 cartelle.
- Marker di merge: 24 file `.md` con righe `<<<<<<< `/`>>>>>>> ` fuori dai blocchi di codice, tutti in `stories/` (9) e `bmad/stories/` (15).
- YAML non valido: `decision-log.md` e `investigation/investigation.md` avevano `links: {github_issue: #XXX}` (il `#` apre un commento e la
  parentesi graffa non si chiude); 29 file con lo stesso difetto in tutti i `docs/` di moduli e temi.

## Modifiche (solo in `laravel/Modules/Xot/docs/`)

| File | Modifica |
|---|---|
| `README.md` | identita' e ownership, conteggi del codice, quick start (PHPStan, comandi `xot:`), limiti verificati; front matter corretto |
| `00-INDEX.md` | canoniche, evidence, legacy con conteggi; problemi noti con cause dei link; marker di merge; story recenti |
| `wiki/log.md` | voce 2026-10-14 |
| `decision-log.md` | voce 2026-10-14; YAML valido |
| `investigation/investigation.md` | YAML valido |
| `wiki/architecture.md`, `wiki/Architecture.md`, `standards/README.md`, `standards/readme.md`, `governance/docs-structure.md` | `status: stale` con motivo (`docs-organizer.py stale --fix`) |
| `wiki/index.md` (50), `wiki/log.md` (45), `wiki/concepts/index.md` (20), `wiki/concepts/INDEX.md` (8), `bmad/readme.md` (11), `bmad/index.md` (1) | link non risolti annotati `target mancante`: 135 annotazioni |

Nessun file spostato, rinominato o cancellato; nessun `dups --fix`; le story con marker non sono state toccate.

## Verifica

```
phpstan analyse Modules/Xot (da laravel/)      exit 0, nessun errore (2026-10-14)
find: app/*.php 595, app/Actions 240, tests *Test.php 199, docs *.md 254
php artisan list --raw | grep -c '^xot:'       8
docs-organizer links --by-name --busy-minutes 0 (dry-run), eventi unresolved
  perimetro 738 -> 738 (le annotazioni non riducono il conteggio: il tool conta anche i link gia' annotati)
  README.md 0 -> 0   00-INDEX.md 0 -> 0   decision-log.md 0 -> 0   wiki/log.md 45 -> 45 (annotati)
  wiki/index.md 50 -> 50 (annotati)   wiki/concepts/index.md 20 -> 20   wiki/concepts/INDEX.md 8 -> 8   bmad/readme.md 11 -> 11   bmad/index.md 1 -> 1
```

Pest non verificato come verde: vedi Aperto 1.

## Decisioni

- `wiki/index.md` e `bmad/index.md` restano indici di sezione; l'unico indice del modulo e' `00-INDEX.md`.
- Documenti smentiti: `stale` con motivo, non riscritti. Link senza bersaglio: annotati, non inventati.

## Aperto

1. Isolamento del DB nei test (DCP-45): i test Xot non partono con `pest-scratch-db.sh`.
2. 24 story con marker di merge: da risolvere con chi le possiede.
3. Comandi `xot:` non registrati (8 dei 18 con `$signature` sono invisibili a `php artisan list`: causa non verificata).
4. `config/xot.php` con percorsi di un altro progetto; `routes/seo.php` e `routes/web_seo.php` morti.
5. Migration map per `consolidated/` (34 copie con suffisso) e per le due versioni divergenti di `architecture/` e `wiki/architecture/`.
6. Difetto del tool: l'evento `unresolved` non distingue un link gia' annotato.