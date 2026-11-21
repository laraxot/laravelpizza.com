---
title: "Continuazione BMAD — Domani (Job)"
type: module-fix
scope: Job
epic: "12"
bmad_version: v3.30.1
updated_at: '2026-09-22'
status: in-progress
related:
  - ./12.3.root-hygiene-conflict-markers.story.md
  - ./12.4.git-hygiene-queue-pid-graphify-out-aaa.story.md
  - ../roadmap-miglioramenti.md
  - ../livewire-widget-epics.md
  - ../livewire-inventory.md
---

# Job — Continuazione Domani

## Stato verificato ora (sessione 2026-09-22)

- `12.1-retire-job-http-livewire` (**done**, riverificato indipendentemente
  oggi): `app/Http/Livewire/Broad.php` e `resources/views/livewire/broad.blade.php`
  assenti, `_components.json` senza entry `broad` (verificato `find`/`grep`
  diretti — solo `job.status`, `schedule.crud`, `schedule.status` registrati),
  zero `dd(` in `app/Http/Livewire/`. La regressione del 21/09 documentata in
  `livewire-inventory.md` risulta risolta.
- `12.3-root-hygiene-conflict-markers` (**done**): marker annidati in
  `README.md`/`.github/contributing.md` risolti da un agente concorrente
  (`cursor-grok`, via lock `Job/README.md.lock` 18:18–18:23), poi
  formalizzato/committato in `02ac30c0` (rimozione `ARCHITECTURE.md`,
  `README.md.backup_20251210_092006`, `Untitled`, 2 blade/php backup datati,
  `lang/it/.php` stub). PHPStan 0 errori.
- `12.4-git-hygiene-queue-pid-graphify-out-aaa` (**done**): `queue.pid`
  untracked (+`*.pid` in `.gitignore`), 8 file `graphify-out/` untracked,
  2 classi stub morte `.aaa` rimosse (`MonitoredScheduledTask*`, zero
  riferimenti, dipendenza `spatie/laravel-schedule-monitor` mai installata).
  Commit `0e6bf4ff`, push `laraxot dev`: `aa0956f3..0e6bf4ff` fast-forward,
  verificato pulito.
- `git status`/`git fetch laraxot`: pulito, `dev` e `laraxot/dev` allineati
  (0 ahead/0 behind) — tutto il lavoro sopra è già sul remoto.
- `docs/roadmap-miglioramenti.md` (analisi qualitativa del 2026-09-01, non
  una story, ma con backlog concreto): ririverificata oggi riga per riga,
  **tutti i problemi elencati sono ancora presenti sul disco**, nessuno
  risolto dalle story 12.3/12.4 (che erano su scope diverso, git-hygiene):
  duplicati case-sensitive in `docs/` (`00-index.md`/`00-INDEX.md`,
  `actions.md`/`ACTIONS.md`, e non menzionato dal doc ma trovato ora anche
  `index-generated.md`/`index_generated.md`/`INDEX_GENERATED.md`, tripli),
  relitto submodule `docs/a.git` (66 byte, punta a
  `../../../../.git/modules/laravel/Modules/Job/modules/docs`),
  `composer.json` con `require-dev: {}` (nessun `larastan`/`pest` locale al
  modulo), `dddx()` vivi/commentati nei due widget, TODO in
  `ExecuteTaskAction`.

## Continuazione — priorità, in ordine

1. **Bug reale, non solo debito**: `app/Actions/ExecuteTaskAction.php:13-19`
   ha `execute()` che lancia sempre `BadMethodCallException` ("not
   implemented yet") — e non è codice morto: è chiamata live da
   `app/Http/Livewire/Schedule/Crud.php:114`
   (`app(ExecuteTaskAction::class)->execute($task_id)`). Qualunque path che
   invoca quell'azione da `Schedule\Crud` fallisce sempre in produzione.
   Decidere: implementare l'esecuzione reale del task o rimuovere il call
   site finché non c'è un'implementazione (vedi `docs/roadmap-miglioramenti.md`
   §1 e `tests/Unit/Actions/ExecuteTaskActionTest.php`, che testa solo
   reflection/struttura della classe, non il comportamento di `execute()`).
2. **`dddx($output)` live (non commentato) in
   `app/Filament/Widgets/ClockWidget.php:89`**, dentro `beginStream()`, un
   metodo pubblico Livewire raggiungibile dalla pagina `JobStatus` (verificato:
   `JobStatus.php` monta `ClockWidget::make()`). Il metodo fa
   `Artisan::call('route:list', [], $output)` (comando non pertinente al
   nome del widget, quasi certamente residuo di copia-incolla da un
   esperimento) seguito da un `dddx()` non guardato — da rimuovere o
   completare secondo l'idea originale (streaming dell'output di
   `queue:listen`, vedi il resto del metodo commentato sotto). Stessa
   sequenza `dddx()` gemella (commentata) in
   `app/Filament/Widgets/QueueListenWidget.php:68-92`, ma quel widget
   **non risulta montato da nessuna parte** (`grep -rn QueueListenWidget`
   trova solo la propria definizione) — verificare se è dead code da
   ritirare o se manca solo il mount.
3. **`docs/12.2` (Cluster B, proposta "candidate", non ancora una story
   vera)**: `livewire-widget-epics.md:17` propone il ritiro di `Job\Status`
   + `JobMonitor`/`job-monitor.blade.php` verso una pagina nativa
   `JobStatus`, con un gap esplicito da decidere prima
   (`saveEnv`/`dummyAction`). Non c'è ancora un file `12.2.*.story.md` —
   se si procede, crearlo seguendo il formato di 12.3/12.4 invece di
   lasciarlo come riga di tabella.
4. **Duplicati case-sensitive in `docs/`** (rischio concreto su filesystem
   case-insensitive, non solo estetico): `00-index.md`/`00-INDEX.md`,
   `actions.md`/`ACTIONS.md`, `index-generated.md`/`index_generated.md`/
   `INDEX_GENERATED.md` (tris, non solo doppio). Verificare quale versione è
   aggiornata con `git log -p` su ciascuna coppia prima di eliminare (non
   assumere che la maiuscola vinca — memoria
   `feedback-case-collision-decide-per-pair.md`).
5. **Relitto submodule `docs/a.git`**: contenuto
   `gitdir: ../../../../.git/modules/laravel/Modules/Job/modules/docs` —
   verificare se quel path in `.git/modules/` esiste ancora prima di
   cancellare il file (`docs/roadmap-miglioramenti.md` §2 lo segnala,
   non ancora verificato se il target esiste).
6. **`composer.json` `require-dev: {}`**: il modulo non può certificarsi da
   solo fuori dal monorepo (nessun `larastan/larastan`, `pestphp/pest`
   locale). Basso rischio/priorità ma a costo quasi zero se allineato ad
   altri moduli satellite.
7. **Debito PHPMD/PHPInsights pre-esistente**, non toccato da 12.3/12.4
   (`docs/coverage.md`): 124 righe di finding PHPMD (`UnusedFormalParameter`
   su parametri Policy prefissati `_`, `CyclomaticComplexity` su
   `Schedule::getArguments()` 13/10 e `FormatSeconds::formatSeconds()` 11/10),
   PHPInsights style/architecture da rivedere. Pest **non eseguibile**
   in questa sessione: `10.100.200.53:3306` irraggiungibile — nessun
   baseline di coverage reale esiste ancora per il modulo, va creato alla
   prima occasione con DB raggiungibile.

## Second brain

`qmd query` su "Job ExecuteTaskAction ClockWidget dddx Broad regression"
prima di riprendere; `qmd update` dopo ogni chiusura.
