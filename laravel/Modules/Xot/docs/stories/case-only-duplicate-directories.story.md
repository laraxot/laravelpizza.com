---
title: "[STORY] Cartelle che differiscono solo per maiuscole: fusione nel lato canonico"
type: story
module: Xot
bmad: true
status: done
priority: high
created: 2026-11-19
updated: 2026-11-19
tags: [case-sensitivity, psr-4, nwidart, cartelle, collisioni, forward-only]
qmd: "collisioni maiuscole minuscole cartelle duplicate database Factories factories pt_BR pt_br Notify .github ISSUE_TEMPLATE config/Config tests unit Unit"
related:
  - ./sync-unrelated-histories-repair.story.md
  - ../../../../../docs/wiki/rules/no-case-only-variations.md
  - ../../../../../docs/wiki/rules/case_sensitive_naming_critical.md
  - ../../tests/Unit/CaseCollisionsDoNotGrowTest.php
---

# Cartelle che differiscono solo per maiuscole

Chiude il punto aperto «debito di nomi per maiuscole» della
[story della sync](./sync-unrelated-histories-repair.story.md).

## Perché

Su Linux `Seeders/` e `seeders/` convivono; su macOS e Windows il clone sovrascrive una cartella con
l'altra e quale vince dipende dall'ordine di checkout. Il runtime ne legge una sola: l'altra è
codice morto che diverge in silenzio (qui le copie «morte» erano spesso le più aggiornate).

## Criterio per scegliere il lato canonico

1. **Quello che il runtime carica davvero**: PSR-4 del `composer.json` del modulo e `namespace`
   dichiarato nei file (classi sotto `app/` e `tests/`), loader di `XotBaseServiceProvider`
   (`config/*.php` non ricorsivo), nomi di vista usati nel codice (`xot::components.…`).
2. Convenzioni esterne obbligatorie: GitHub legge solo `.github/ISSUE_TEMPLATE` e
   `.github/DISCUSSION_TEMPLATE`.
3. Cartelle di root del modulo e `docs/` in minuscolo.
4. Contenuto: se l'altro lato ha righe o file in più, si portano nel canonico **prima** di cancellare.

## Esito per coppia

| Coppia | Vince | Evidenza | Azione |
|---|---|---|---|
| Cms, Comment, Tenant `database/{Factories,Migrations,Seeders}` | minuscolo | PSR-4 `database/factories/`, `database/seeders/`; generator nwidart | Già tolte dal commit di sync `0a47fd6bf6`. Verificato: i file maiuscoli erano vuoti (0 byte) o versioni più vecchie e non tipizzate di quelli minuscoli (`definition()` senza `: array`, `CmsDatabaseSeeder` senza i seeder per modello). Nessuna migrazione persa, nessun nome di migrazione cambiato. Tolti qui i residui vuoti `database/{factories/Factories,migrations/Migrations,seeders/Seeders}/.gitkeep` di Cms |
| Cms `resources/views/{Composers,composers}` | nessuno dei due | `ThemeComposer` dichiara `Modules\Cms\View\Composers` → PSR-4 `app/View/Composers/ThemeComposer.php`, che esiste, è più recente e ha gli stessi metodi | Tolte entrambe le copie (identiche fra loro, mai caricate) |
| Xot `resources/views/{Components,components}` | `components` | `Dashboard\Item` rende `xot::components.dashboard.item`; componenti anonimi Blade | Tolto `Components` (identico) |
| Xot `lang/{pt_BR,pt_br}` | `pt_BR` | codice locale di Laravel/laravel-lang; Activity, UI, User usano `pt_BR` | Tolto `pt_br` (15 file identici) |
| Geo `app/{DataTransferObjects,datatransferobjects}` | `DataTransferObjects` | `namespace Modules\Geo\DataTransferObjects`, test `LocationDTOTest` | Tolto il minuscolo (identico) |
| Job `app/{Entities,entities}` | `Entities` | cartelle di classi PascalCase | Tolto il minuscolo (solo `.gitkeep`) |
| Notify `.github/{ISSUE_TEMPLATE,DISCUSSION_TEMPLATE}` | maiuscolo | GitHub | 3 template presi dal minuscolo (solo righe aggiunte), poi tolto |
| Notify `.github/{ISSUES,DISCUSSIONS,ISSUE_CONTENT,DISCUSSION_CONTENT}` | maiuscolo | convenzione degli altri moduli (`ISSUES` ×2, `DISCUSSIONS` ×2) | 4 file presi dal minuscolo (superset), `*_CONTENT` identici; tolto il minuscolo |
| Notify `config/{Config,config}` (e `Config/Config`, `config/Config`) | `config/*.php` piatto | `XotBaseServiceProvider` fa `glob(config/*.php)`; il `config.php` piatto è un superset (layout, social, template) | Tolte entrambe le cartelle annidate |
| Job `tests/{feature,unit}` | `Feature`, `Unit` | PSR-4 `tests/`, `phpunit.xml` | Tolti i minuscoli (solo `.gitkeep`) |
| Lang `tests/{unit,Unit}` | `Unit` | `unit/models/BaseModelLangTest.php` identico; `unit/actions/ReadTranslationFileActionTest.php` è la versione prima del refactor degli helper in `TestCase` e si aspetta `'boolean_false' => ''`, mentre la versione in `Unit` (11/11 verdi) si aspetta `'0'` | Tolto `unit` |
| Activity `tests/tests/{Feature,Unit,feature,unit}` | nessuno | `tests/tests` è un annidamento accidentale con solo `.gitkeep` | Tolta `tests/tests` |
| User `tests/Feature/Database/{Migrations,migrations}` | `Migrations` | la copia minuscola dichiara `namespace …\Database\Migrations` | Il contenuto più ricco (namespace, `describe`, controllo sul proprietario unico di `users` e `socialite_users`, helper `userMigrationFiles()`) spostato in `Migrations/`; tolto il vecchio file senza namespace |
| Geo `docs/{CONCEPTS,concepts}`, `modules/IndennitaResponsabilita`, `oauth/OAuth`, `performance/Performance`, `workbench/app/Models` | minuscolo | docs in minuscolo | Contenuto identico o già contenuto nel minuscolo; tolto il maiuscolo. Nessun link puntava ai percorsi maiuscoli |

Inventario finale delle cartelle: **zero** coppie.

## Verifiche

- `composer dump-autoload -o`: nessun nuovo avviso PSR-4 sui percorsi toccati. Restano avvisi
  preesistenti su `User/tests/Fixtures/UserPhpstanTraitProbes.php`,
  `Geo/tests/Fixtures/Traits/GeoPhpstanTraitProbes.php` (più classi per file) e sul pacchetto
  `coolsam/panel-modules` duplicato in `Xot/packages`.
- `php -l` sul test User modificato: ok.
- PHPStan `analyse` di Cms, Xot, Geo, Job, Notify, Lang, Activity e User (cache pulita): **0 errori**.
- Pest: `CaseCollisionsDoNotGrowTest` verde; la baseline
  (`bashscripts/tools/audit/case-collisions-baseline.txt`) è scesa da 1221 a 1179.
  `LocationDTOTest` 7/7, `ReadTranslationFileActionTest` 11/11, `BaseModelLangTest` 8/8.

## Punti aperti

- [ ] `User/tests/Feature/Database/Migrations/UserMigrationSyntaxTest.php`: il primo test di ogni
      esecuzione fallisce nel bootstrap del DB di test (`Cannot drop table 'categories'`, vincolo
      `reports_category_foreign`, migrazione `Fixcity/…create_categories_table.php`). Quando il DB
      sarà sistemato, «user model has one canonical owner migration» resterà rosso: esistono ancora
      `2026_10_22_000001_repair_users_type_state_columns.php`,
      `2026_11_11_000001_add_digital_identity_columns_to_users_table.php` e una seconda
      `2026_11_17_114812_create_users_table.php`. Va deciso nella story del modulo User, guardando
      la tabella `migrations`, mai rinominando né togliendo a mano.
- [ ] Le collisioni di **file** restano: 2435 percorsi (circa 1180 gruppi), per lo più `docs/`
      (`README.md`/`readme.md`, `INDEX.md`/`index.md`, `CONTRIBUTING.md`/`contributing.md` in 15
      moduli), più residui `.up`, `.test`, `.wip` in `app/` di Cms, Notify, Geo, Xot, viste email
      di Notify in camelCase/minuscolo e asset Leaflet di Geo. Si bonificano con
      `python3 bashscripts/tools/audit/audit-case-collisions.py --fix-identical` per gli identici
      e a mano per i differenti. Il cricchetto della guardia impedisce che crescano.
- [ ] Ogni modulo toccato è anche un repo a sé: le cancellazioni vanno portate nei
      `laraxot/module_<m>_fila5` (branch `dev`), altrimenti il prossimo mirror al root le riporta.
