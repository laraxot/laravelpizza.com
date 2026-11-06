---
title: "User: studio del modulo, ingressi docs e cause dei link rotti"
type: story
status: done
created: 2026-10-14
updated: 2026-10-14
module: User
tags: [docs, organizzazione, user, link, bmad]
related: [bmad-output/stories/docs-organization/README.md, bmad-output/docs-architecture/module-theme-docs-contract.md, laravel/Modules/Fixcity/docs/stories/dcp-56-organizzazione-docs-moduli-e-temi.story.md]
qmd: "user docs studio ingressi 00-INDEX README link rotti cause campione duplicati archive generated index phpstan"
---

# User: studio del modulo, ingressi docs e cause dei link rotti

Fase BMAD: documentazione e qualita' (DOC-010 e DOC-002 del piano `bmad-output/stories/docs-organization/`).

## Richiesta

Studiare `laravel/Modules/User`, confrontare codice e `docs/`, correggere gli ingressi con fatti verificati e spiegare perche' i link
sono rotti in massa (audit di partenza: 3360 file `.md`, 1538 nella radice, 16149 link, 56% rotti, 632 stub, 1100 corpi duplicati).
Vietato spostare, rinominare o cancellare file e lanciare `dups --fix`.

## Analisi

**Il modulo.** `Modules\User`: 50 modelli e 39 policy, 14 trait, 59 Actions, 232 file Filament (26 risorse), 14 componenti Livewire,
16 comandi Artisan, 102 migrazioni, 32 cartelle `lang/`, 316 file in `tests/` (185 `.php`). Rotte caricate: `POST /logout`,
`POST /api/user/login`, `GET /api/v2/user`, `GET /api/v2/logout` e 111 rotte del pannello `/user/admin` (461 rotte totali nel progetto).
`routes/web_tall.php` e `routes/socialite.php` non risultano caricati; `routes/auth.php` e' tutto commentato.

**Cosa diceva il falso.**
- Stack: "PHP 8.3+, Laravel 11/12" contro `laravel/composer.json` PHP `^8.4`, Laravel 13.35.
- "Level 10 Compliant" e "Module Version 2.5.0": PHPStan segnala 3 errori `argument.type` in `lang/{de,en,es}/validation.php` riga 8, nessuno
  in `app/`; nessuna versione in `module.json` o `composer.json`.
- Proprieta' dello schema `profiles` assegnata a un modulo WorkOrder che non esiste; `create_profiles_table` ha 6 file attivi in User, 2 in
  Fixcity, 1 in Blog.
- Regola "no Log:: in Actions, Models, Widget" vera per `RegisterWidget` ma violata: 35 chiamate in 9 file `.php` di `app/` (37 in 10 se si
  contiene il backup `LogoutWidget.php.corrected`).
- `README.md` da 2352 righe: il corpo e' ripetuto due volte (righe 155-1253 e 1257-2352) e contiene un front matter incollato da `readme.md`.
- Collegamenti a file rinominati (`*-2026-03-10.md` senza data), a `todo.md` (stub il cui canonico `Themes/docs/shared-components/todo.md` non esiste).

**Ingressi.** Il canonico per contratto e' `00-INDEX.md`. `00-index.md` era una copia byte per byte (collisione di maiuscole), `00-index.md` una
variante; `INDEX.md` (6915 righe) e `index.md` (3419) sono elenchi generati dell'albero, come `archive/index.md`, `_archive/INDEX.md` e i due di
`wiki/integrations/_da-riconciliare/`.

**Link non risolti.** Misura con `--busy-minutes 0`: 14194 eventi in 1740 file (con il filtro di default il tool ne mostra 11, perche' salta
i file toccati da meno di 10 minuti). Campione di 200 eventi (seed 20261014), controllato sul disco e su `git log`:

| Causa | Campione | Popolazione |
|---|---|---|
| Bersaglio esistente in 2 o piu' copie (45 in 2 copie, 76 in 3-5, 18 in 6-20): il tool non puo' scegliere | 139 (69,5%) | 10022 (70,6%) |
| Mai esistito, nessuna traccia in git ne' per nome (es. `hasteams-consolidated.md` -> `./refactor-checklist.md`) | 14 (7%) | 1011 (7,1%) |
| File non `.md` assente (`Modules/User/app/Models/BaseTeam.php`, json, immagini) | 11 (5,5%) | 761 (5,4%) |
| Verso altri moduli, temi o `docs/` della radice: profondita' sbagliata, minuscole (`../../../xot/docs/...`), moduli assenti (SaluteOra 85, Patient 65, Chart 64, Dental 19, Quaeris 19, WorkOrder 5; Predict 0), `Themes/docs/shared-components/` (369, cartella inesistente), `docs/` radice (144) | 33 (16,5%) | 2217 (15,6%) |
| Esisteva in git e poi e' stato spostato, rinominato o cancellato | 3 (1,5%) | 164 (1,2%) |
| Cartella inesistente | 0 | 19 (0,1%) |

Concentrazione: 6 elenchi generati contengono 7763 eventi (54,7%); i 10 file peggiori 8608 (60,6%). La causa dominante e' la duplicazione dei
documenti (`archive/` 711 file, `_archive/` 244, `_integration/` 36, `wiki/`), non percorsi sbagliati: per questo `--by-name` ha gia' esaurito
cio' che e' risolvibile senza decisione umana.

## Modifiche (solo in `laravel/Modules/User/docs/`)

| File | Modifica |
|---|---|
| `00-INDEX.md` | ingresso unico: identita' e contenuto reale (tabella con path), stato PHPStan, versione non verificata, mappa canonico/evidence/legacy, ingressi duplicati, cause dei link, link rotti annotati (5 -> 0 non risolti), front matter valido |
| `README.md` | 11 note datate "Nota 2026-10-14" con le smentite, avviso in testa sui difetti strutturali, requisiti corretti, 40 link non risolti annotati `target mancante`; il testo originale non e' stato cancellato |
| `wiki/log.md` | voce 2026-10-14 |
| `stories/docs-user-studio-e-ingressi.story.md` | questa story |

Nessun file spostato, rinominato o cancellato; nessun `dups --fix`; `INDEX.md`, `index.md`, `00-index.md`, `00-index.md` non toccati (recenti e
da trattare con DOC-004).

## Verifica

```
phpstan analyse Modules/User (da laravel/)   exit 1: 3 errori
  Modules/User/lang/de/validation.php:8  argument.type  array_replace_recursive expects array, mixed given
  Modules/User/lang/en/validation.php:8  idem
  Modules/User/lang/es/validation.php:8  idem
php artisan route:list --json               461 rotte; user/admin 111; POST logout -> Volt\LogoutAction
conteggi find/ls: modelli 50, policy 39, trait 14, Actions 59, migrazioni 102, lang 32, console 16, test 185 .php su 316 file
docs-organizer links --by-name --busy-minutes 0 (dry-run)
  perimetro: 14194 -> 14189 eventi unresolved (14189 sono nei file non toccati)
  00-INDEX.md 5 -> 0   README.md 40 -> 40 (tutti e 40 annotati sulla riga: il tool non riconosce le annotazioni)
```

Non rieseguiti i test Pest di User (con la config cache colpiscono il database di sviluppo; ricetta `pest-scratch-db`).

## Decisioni

- Il canonico e' `00-INDEX.md`; gli altri ingressi si dichiarano non canonici e si lasciano per la migration map.
- Si annotano i link non risolti, non si inventano bersagli.
- I numeri dei link si dichiarano sempre con `--busy-minutes 0` e il valore del filtro.

## Aperto

1. Migration map per i 1538 file nella radice e le copie in `archive/`, `_archive/`, `_integration/` (DOC-004, DOC-006): e' la causa del 70,6% dei link.
2. Rigenerare o marcare `superseded` i 6 elenchi generati (7763 link non risolti).
3. Tre errori PHPStan in `lang/{de,en,es}/validation.php` riga 8 (codice, fuori da questa story).
4. Decidere chi possiede lo schema `profiles` (User, Fixcity o Blog) e la sorte delle 6 migrazioni attive di User.
5. 35 chiamate `Log::` in `app/` contro la regola dichiarata.
6. `README.md`: eliminare la ripetizione del corpo (righe 1257-2352) quando sara' ammessa una modifica distruttiva.
7. Difetti del tool: `--annotate` senza filtro per file; l'evento `unresolved` non distingue un link gia' annotato; `stale` rifiuta i file senza
   front matter.
