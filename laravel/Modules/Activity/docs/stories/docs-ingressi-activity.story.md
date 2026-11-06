---
title: "[STORY] Ingressi di docs/ del modulo Activity allineati al codice"
type: story
status: done
priority: medium
created: 2026-10-14
updated: 2026-10-14
module: Activity
tags: [docs, bmad, indice, readme, link, doc-010, doc-002]
qmd: "activity docs ingressi readme 00-index indice canonico stale link non risolti famiglie radice 890 file"
related:
  - ../../../Fixcity/docs/stories/dcp-56-organizzazione-docs-moduli-e-temi.story.md
  - ../../../../../bmad-output/docs-architecture/module-theme-docs-contract.md
---

# Ingressi di docs/ del modulo Activity allineati al codice

Fase BMAD: documentazione e qualita' (DOC-010 e DOC-002 del piano `bmad-output/stories/docs-organization/`).

## Richiesta

Studiare il modulo Activity, confrontare con il codice gli ingressi di `docs/` (`README.md`, `00-INDEX.md`, `index.md`, `INDEX.md`, wiki di primo livello) e correggerli solo con fatti verificati. L'indice deve dichiarare le directory canoniche, evidence e legacy e linkare solo file esistenti. Niente spostamenti, rinomine o cancellazioni; niente `dups --fix`. Contratto: `bmad-output/docs-architecture/module-theme-docs-contract.md`.

## Analisi

Cosa fa il modulo (da `app/`, non dai docs): registra e mostra l'activity log di Spatie ActivityLog (`Models\Activity`, connessione `activity`, tabella `activity_log`), espone modelli e Resource per event sourcing (`StoredEvent`, `Snapshot`), 29 Action in `app/Actions` (tra cui `LogActivityAction`, usata da `Fixcity/.../ChangeTicketPriorityAction.php`) e la pagina Log che legge `storage/logs`. Non ha rotte attive, non ha Widget.

Stato dei docs il 2026-10-14: 890 `.md` (377 nella radice, 513 in 40 sottocartelle), 68 senza frontmatter, 101 segnaposto con `canonical:`, 63 gruppi di nomi in collisione nella radice (148 file).

Falsi trovati negli ingressi, confrontati con il codice:

| File | Affermazione falsa | Prova |
|---|---|---|
| `docs/README.md` | tre versioni concatenate, nessun frontmatter, segnaposto "[DESCRIZIONE SPECIFICA DA COMPLETARE]" | lettura del file |
| `docs/ARCHITECTURE.md` | Repositories, Services, Commands, Projections | `app/` ha Actions, Adapters, Console, Contracts, Datas, Enums, Events, Exceptions, Filament, Http, Listeners, Models, Providers, Support, Traits, View |
| `docs/API.md` | `execute(array $data): Activity` | `LogActivityAction` prende i dati nel costruttore, `execute(): Activity` |
| `docs/readme.md` | `ActivityStatsWidget`, `EventStore`, tempo reale, punteggio qualita' 85% | `app/Filament` non ha `Widgets`; `routes/*.php` sono solo commenti |
| `docs/00-INDEX.md` | link a `actions-calling-actions-pattern.md` e a 5 file di `docs/` radice del repo inesistenti; "Module Version 2.3.0" | `module.json` non ha versione |
| `docs/index.md` | 40 link a `tasks/` e `roadmap/tasks/`, piu' `docs-archive-policy.md` | file rimossi nei commit `7e00cedf` e `a871d44e` (2026-10-08) |
| `docs/INDEX.md` | "698 file, Root 292, Tasks 36" | conteggio reale 890, 377, 0 |
| `docs/wiki/INDEX.md` | "Total Pages: 5"; 3 link rotti | `wiki/` ha 118 `.md` |
| `docs/wiki/README.md` | badge e testo "Core module for the FixCity Platform" copiati dal README del modulo | lettura |

## Modifiche

Riscritti (sostituzione dell'intero contenuto guardata da sha1 e mtime; versione precedente in `git show HEAD:<percorso>`): `docs/README.md` (identita', cosa contiene davvero con percorsi, quick start, limiti), `docs/00-INDEX.md` (misure, lettura essenziale, stato delle cartelle, famiglie della radice con conteggi, documenti non attendibili), `docs/INDEX.md` (solo inventario numerico), `docs/wiki/README.md`.

Modificati con sostituzioni mirate: `docs/index.md` (le voci `tasks/` e `roadmap/tasks/` e `docs-archive-policy.md` sono una nota con commit e comando `git show` per recuperarle; conteggio file aggiornato), `docs/wiki/INDEX.md` (3 link, piede di pagina), `docs/readme.md` (3 link annotati), `docs/wiki/log.md` (4 link annotati, nuova voce del 2026-10-14), `docs/ARCHITECTURE.md` (aggiunto frontmatter, un link annotato).

Marcati `stale` con `docs-organizer.py stale --fix` (contenuto non riscritto): `API.md`, `readme.md`, `ARCHITECTURE.md` (a mano, mancava il frontmatter), `00-index.md`, `wiki/00-INDEX.md`, `wiki/00-index.md`, `wiki/index.md`; come `stub`: `00-index.md`, `wiki/00-index-documentation.md`.

## Verifica

Link non risolti (`docs-organizer.py --busy-minutes 0 links docs --by-name`, sola lettura), solo sui file toccati:

| File | Prima | Dopo |
|---|---|---|
| `README.md`, `00-INDEX.md`, `INDEX.md`, `index.md`, `wiki/INDEX.md`, `wiki/README.md` (ingressi canonici) | 50 | 0 |
| `readme.md`, `wiki/log.md` (annotati: lo strumento li conta ancora) | 7 | 7 |
| `ARCHITECTURE.md` (annotato) | 1 | 1 |
| copie stale `00-index.md`, `wiki/00-INDEX.md`, `wiki/00-index.md`, `wiki/index.md` | 50 | 50 |
| Totale file toccati | 108 | 58 |

Intero modulo: 1.195 prima, 1.145 dopo. Nota: alle 07:38 lo stesso comando senza `--busy-minutes 0` riportava 5 eventi, perche' salta in silenzio i file modificati da meno di 10 minuti.

- PHPStan: `cd laravel && ./vendor/bin/phpstan analyse Modules/Activity --memory-limit=3G` esce con 0 (2026-10-14, `phpstan.neon` del progetto).
- Frontmatter YAML: i 16 file riscritti o marcati si leggono con `yaml.safe_load`. Restano blocchi `---` spuri nel corpo di `readme.md` (1), `wiki/00-index.md` (2) e `wiki/log.md` (1): `frontmatter` li elenca come interventi manuali e non sono stati toccati.
- Tutti i link dei quattro file riscritti verificati con `os.path.exists` prima della scrittura (0 mancanti).
- Pest non rieseguito: non verificato che i 100 file di test passino.

## Decisioni

- `00-INDEX.md` e' l'unico indice canonico; nessun indice con nome alternativo e' stato creato. Le copie con altre maiuscole sono marcate, non cancellate.
- `links --annotate` non e' stato lanciato: lo strumento lavora sull'intera cartella (nessun filtro per file) e avrebbe toccato centinaia di file non miei. Le 8 annotazioni sono state fatte a mano.
- I link morti delle copie stale non sono stati riscritti: sono copie, la loro sorte (superseded o rimozione) spetta a DOC-004 e DOC-006.

## Aperto

- Codice: `LoginListener::handle()` vuoto (gli accessi non sono registrati); con `user` nullo `LogActivityAction` scrive `causer_id` ma non `causer_type`; quattro migrazioni `create_activity_table` accanto a quella "unica"; la connessione `activity` e' dichiarata nei modelli ma non trovata in `laravel/config/database.php`.
- Docs: 1.145 riferimenti non risolti nel resto della cartella (193 in `duplicate-methods-analysis.md`, 64 in `lang-link.md`); 63 file ancora senza frontmatter e 90 per cui `frontmatter` in dry-run vuole ancora aggiungere chiavi; 36 file di `tasks/` da decidere se ripristinare dalla storia git.
- `use_cases/` (119 file) descrive progetti esterni (bank, shop, prediction market): da valutare in DOC-004.
