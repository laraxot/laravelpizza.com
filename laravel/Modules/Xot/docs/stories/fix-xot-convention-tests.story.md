---
title: "Xot - fix-xot-convention-tests.story.md"
module: Xot
bmad: true
status: in-progress
---
# Fix dei test di convenzione Xot (Docs, Architecture, Bmad, Filament, hygiene)

**Ambito:** `laravel/Modules/Xot/tests/Unit/{Docs,Architecture,Bmad,Filament}`,
`ModuleRootHygieneTest.php`, `CaseCollisionsDoNotGrowTest.php`. Questi test non misurano logica di
business: misurano convenzioni del repo. Un fallimento e' una violazione reale oppure un test che
controlla una convenzione non piu' valida. Ogni classe di problema qui sotto dichiara regola, file,
decisione ed esito verificato.

**Regola generale:** non si disattivano test, non si usano `@phpstan-ignore` o baseline, non si
cancellano storie. Le soglie a cricchetto si abbassano solo quando il debito scende davvero. Le
bonifiche che toccano contenuto tracciato (cartelle, traduzioni, namespace condivisi) restano
bloccate finche' non c'e' una conferma esplicita: vedi "Deferito".

## Classi di problema

### 1. Nomi dei file in docs/chat con data

- **Regola:** `bashscripts/ai/wiki/rules/docs-chat-filename-no-dates.md` e
  `markdown-filename-conventions.md` (nessuna data nel nome `.md`).
- **Test:** `Docs/ChatFilenameNoDatesTest.php` (tetto zero).
- **Trovato:** 70 file in `docs/chat/` con data nel nome (regressione: la bonifica del 2026-10-15
  era stata azzerata da commit successivi).
- **Decisione:** rinomina con lo strumento canonico `bashscripts/tools/docs/md-filenames.py apply
  --only docs/chat`. Nessun `retire`, nessuna cancellazione, collisioni assenti. Riscritti 136
  riferimenti in 75 file. Mappa in `scratchpad/chat-map.json`.
- **Esito:** `check --paths docs/chat` = 0 violazioni; test verde. Residuo fuori scope: un link
  stale in `laravel/docs/chat/INDEX.md` (punta a `conversione-txt-md-docs-2026-08-24.md`, file che
  non vive in quella cartella), gia' rotto prima di questo lavoro.

### 2. Riferimenti dei CLAUDE.md a file inesistenti

- **Regola:** `Docs/InstructionReferencesExistTest.php`.
- **Trovato:** `rating-resource.php` come esempio di naming (non un file); `tasks/lessons.md`
  richiesto dal workflow globale di `.claude/CLAUDE.md`, mai creato.
- **Decisione:** l'esempio di naming diventa `rating-resource` senza estensione (e' un pattern, non
  un file). `tasks/lessons.md` creato come registro lezioni, con puntatore al second brain.
- **Esito:** test verde.

### 3. Soglie a cricchetto superate in discesa

- **Regola:** i tetti (`MODULE_DOCS_HOST_NAME_FILE_BASELINE`, `STORY_NUMBER_COLLISION_BASELINE`)
  scendono con la bonifica; il test fallisce se scendono di oltre 100 / 10 senza aggiornarli.
- **Decisione:** tetti aggiornati al debito misurato: 1642 -> 1261 (documenti di modulo con nome
  ospite), 74 -> 57 (collisioni di numero story). Nessun aumento.
- **Esito:** test verde.

### 4. Strumento di collisioni case mancante

- **Regola:** `CaseCollisionsDoNotGrowTest.php` chiama `bashscripts/tools/audit/audit-case-collisions.py`
  e legge `case-collisions-baseline.txt`. Entrambi non esistevano in git.
- **Decisione:** creato lo strumento (sola lettura, `git ls-files`, gruppi per minuscolo, `--json`).
  Baseline = stato misurato, 948 gruppi (137 identici, 811 con contenuto diverso). Il test pretende
  che non cresca.
- **Esito:** test verde. La bonifica dei 948 gruppi resta un lavoro separato.

### 5. Codice Filament che estende classi Filament direttamente

- **Regola:** `Filament/NeverExtendFilamentDirectlyTest.php`: si estende la XotBase
  (`XotBaseTextColumn`, `XotBaseIconColumn`, `XotBaseSelectColumn`, `XotBaseFilter`,
  `XotBaseSelectFilter`, `XotBaseRelationManager`, `XotBaseSection`).
- **File (15 + 9):** Media (2 colonne icona), Incentivi (1 RelationManager), IndennitaCondizioniLavoro
  (2 colonne, 1 filtro), Ptv (6 filtri/colonne, 3 RelationManager, 6 Section), Progressioni (3 Section).
- **Decisione:** riscrittura meccanica `extends` + `use` (script in scratchpad, idempotente).
- **Correzione di un fatale:** `XotBaseRelationManager::form()` e' `final` e delega a
  `getFormSchema()`. `Ptv/.../AszEffRelationManager.php` sovrascriveva `form()`: spostato il corpo in
  `getFormSchema(): array` (stesso schema, `TextEntry::make('id')`).
- **Esito:** `NeverExtendFilamentDirectlyTest` verde. Senza la correzione di `form()` la suite
  Pest moriva al boot per `Cannot override final method`.

### 6. Cartella Activity duplicata

- **Regola:** `FilamentSchemasTablesStructureTest.php` (una sola classe Table per Resource).
- **Trovato:** `Activity/app/Filament/Resources/ActivityResource/Tables/ActivitysTable.php`, typo
  senza riferimenti e senza uso (`ActivitiesTable` e' la classe viva; il doc `Activity/docs/scopo.md`
  lo indica come codice morto da cancellare).
- **Decisione:** cancellato il duplicato morto.

### 7. Job: lista comandi non risolvibile

- **Trovato:** `FormSchemaBelongsToFormClassTest` falliva su `Job ScheduleForm`
  (`Unresolvable dependency ... $version` su `Illuminate\Console\Application`).
- **Decisione:** `GetCommandsAction` usa il contratto `Illuminate\Contracts\Console\Kernel::all()`
  invece di costruire `Console\Application` a mano.
- **Esito:** il caso Job non compare piu' nel test.

### 8. Cartelle di tooling e hygiene dei moduli (ModuleRootHygieneTest)

- **Regola:** `Xot/docs/bmad/stories/module-root-hygiene.story.md` e le richieste utente del
  2026-09-29 e 2026-10-27 (righe `.gitignore`). Un solo `*.code-workspace` chiamato
  `_module_<nome>_fila5.code-workspace`.
- **Decisione (eseguita):** aggiunte in `.gitignore` le righe `/.github/skills/`, `docs/graphify`,
  `resources/lang` nei repo dei moduli che non le avevano (Activity, Job, Lang, Notify, Rating,
  Tenant, User). Rinominati 10 workspace al nome canonico (Activity, Job, Lang, Media, Notify,
  Rating, Tenant, UI, User, Xot). Modifiche nei repo annidati, non committate.
- **Deferito (6 check):** la cartella `Notify/.github/skills` (1846 file tracciati), le cartelle
  `docs/graphify` di Lang, Notify, Rating (1 README tracciato ciascuna) e le `resources/lang` di Lang
  e Notify (translation tracciati, da verificare se sono caricati). Rimozione = cancellazione di
  contenuto tracciato: serve conferma esplicita dell'utente.

## Deferito (richiede decisione o lavoro dedicato)

| Test | Fallimenti | Motivo |
|---|---|---|
| `Docs/ModuleCodeIsProjectAgnosticTest` | 2 | Nomi di progetti ospiti (`fixcity`, `quaeris`) in codice di modulo: 44 file in User, Notify, Tenant, Media, UI, Job, Activity, Xot. Include connessioni DB (`fixcity`), namespace `Modules\Fixcity` in User (modulo assente in questo checkout), stringhe di brand in `User/lang`, e `database_path('*_data.sqlite')` cablato in 4 TestCase. Richiede scelte di config e di prodotto. |
| `Architecture/NoServicesTest`, `NoJobsTest`, `DatasFolderConventionTest` | 9 | 5 cartelle `Services` (Performance, Ptv, Sigma, Pdnd x2), `Support` (Ptv, Sigma), `Data` (Ptv), `Jobs` (IndennitaCondizioniLavoro), 109 file con namespace `Services`. Refactor verso Action, con owner moduli attivi: serve story per modulo. |
| `Bmad/StoryEpicAndOwnedScopeTest` | 2 | Epic orfani: 86 (soglia 85), una story in piu' dal 2026-09-08 (epic 9-18 non in `docs/epics.md`). Owned File/Module Scope: 539 story senza campo (soglia 348), cresciute con le story nuove. Non si alza la soglia: serve planning (`bmad-correct-course`) e il campo va compilato per story. |
| `Filament/FilamentSchemasTablesStructureTest` | 1 | `IndennitaCondizioniLavoro/AssenzaResource` e' un doppione legacy (`getFormSchemaOld`, nessun `Schemas/AssenzaForm.php`) dello stesso model `Assenza` di Progressioni. Decidere se cancellarlo o migrarlo. |
| `Filament/FormSchemaBelongsToFormClassTest` | 1 | `Incentivi ProjectForm` interroga la connessione test remota (10.100.200.53): tabella `employees` assente in `ptv_lara_test`. Problema d'ambiente, non di codice. |

## Esito verificato

- Pest (ultima run dei file toccati): Docs 4 file su 5 verdi (ModuleCodeIsProjectAgnostic rosso,
  deferito); `CaseCollisionsDoNotGrowTest` verde; `NeverExtendFilamentDirectlyTest` verde;
  `ExportPdfActionTest` e `ExportXlsActionTest` verdi; `Bmad` 2 rossi (deferiti);
  `ModuleRootHygieneTest` 6 rossi (deferiti); `FilamentSchemasTablesStructureTest` 1 rosso (deferito);
  `FormSchemaBelongsToFormClassTest` 1 rosso (deferito, ambiente); `Architecture` 9 rossi (deferiti).
- PHPStan `Modules/Xot`: 1 errore in `tests/Feature/Actions/Pdf/GetPdfContentByRecordActionTest.php:75`
  (`cast.string`). Il file non e' stato toccato da questa story (risulta modificato da un'altra
  sessione): fuori scope, da correggere nella sessione che lo ha in carico.
- Lint `php -l` su tutti i file PHP modificati: nessun errore.
