---
title: "[STORY] bashscripts e .claude fuori dal versionamento del root, ADR dei pacchetti conformi"
type: story
module: Xot
bmad: true
status: in-progress
priority: medium
created: 2026-11-24
updated: 2026-11-24
issues: [252]
tags: [git, gitignore, bashscripts, claude, adr, docs]
qmd: "bashscripts claude gitignore git rm cached adr conformita PackagesHaveContractsAndAdrTest marker README"
related:
  - ../adr/bashscripts-e-claude-fuori-dal-versionamento.md
  - ../../tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php
---

# bashscripts e .claude fuori dal versionamento del root, ADR conformi

## Scopo

Il root non deve versionare `bashscripts` (repo a sé) né `.claude` (symlink a `bashscripts/ai/.agents`), e le cartelle
`docs/adr` dei pacchetti devono rispettare le regole che il test `PackagesHaveContractsAndAdrTest` già codifica
(nome senza numero né data, `type: decision`, `status`, cinque sezioni, elenco nel `README.md`). La decisione e le
misure stanno nell'ADR collegato: qui solo il lavoro e la chiusura.

## Criteri di accettazione

1. `git ls-files -s bashscripts` e `git ls-files .claude` vuoti; `git check-ignore -v bashscripts .claude` li copre;
   `git ls-files -c -i --exclude-standard` non elenca nulla sotto `bashscripts/` né `.claude/`.
2. Il disco non cambia: `bashscripts/.git` e `bashscripts/ai/.agents` presenti.
3. Ogni `docs/adr` di modulo e tema: zero marker, `README.md` come unico indice (niente `INDEX.md`), ogni ADR con
   `type: decision`, `status` valido, le cinque sezioni, nome senza numero né data, elencato nel `README.md`.
4. Nessuna decisione cancellata: un ADR numerato con gemello senza numero si fonde nel gemello e il numerato si
   rinomina in avanti (`git mv`), con i rimandi aggiornati; un ADR senza gemello si rinomina e basta.
5. Una decisione non si inventa: un pacchetto senza ADR reale resta segnalato come aperto.

## Fatto (24/11)

- Indice: `git rm --cached bashscripts` (voce symlink verso `../base_ptvx_fila5/bashscripts/`), disco intatto.
- `.gitignore`: aggiunta la riga `bashscripts` accanto a `bashscripts/` (due righe per nome, come in `guard.yml`);
  tolta la riga fusa `laravel/bootstrap/cache/*bashscripts/`.
- `.claude`: già non tracciato (0 file) e coperto dalla riga `.claude`: nessuna modifica.
- ADR `bashscripts-e-claude-fuori-dal-versionamento.md` in Xot.
- Misura iniziale degli ADR (replica in sola lettura del test, senza Pest): 259 non conformità in 14 pacchetti.

## Esito ADR e contratti (24/11, 16:17 UTC, misura sul disco)

Replica in sola lettura di tutti i casi di `PackagesHaveContractsAndAdrTest` (README, cinque sezioni, nome, elenco,
ADR sostanziale, path in `## Verifica`), senza Pest:

- ADR: da 259 non conformità a 0. Contratti: da 47 a 0. Marker in `docs/adr` e `docs/contracts`: 0.
- Fusioni "numerato in gemello" in Xot (nessuna decisione cancellata): `0001`→`actions-over-services`,
  `0002`→`queueable-actions-over-jobs`, `0003`→`pest-over-phpunit`, `0004`→`one-model-one-migration`,
  `0006`+`0008`→`filament-widgets-over-standalone-livewire`, `0007`→`pest-testcase-binding-per-file`; i doppi `0010`/`00010` e
  `0011`/`00011` in un solo file ciascuno. Template e `INDEX.md` degli ADR tolti, il README è l'unico indice.
- Un nuovo ADR vero: `Limesurvey/docs/adr/per-survey-tables-use-dynamic-models.md` (dall'ADR-001 della radice).
- ADR sostanziale aggiunto (Driver + Conferma, contenuto ricavato dal codice) in AI, Gdpr, Job, Tenant, Themes/Zero.

## Aperti

- **Senza ADR sostanziale: Chart, CloudStorage, Setting.** Il test lo pretende e nessuna decisione reale è documentata:
  Chart ha `docs/decisioni/widget-frontend-decision.md` che si contraddice e cita percorsi di un altro progetto (serve la
  lettura voluta dal proprietario); CloudStorage e Setting hanno solo la voce modello "Initial commit".
- **Il lavoro e' volatile finche' la sync gira senza guardia:** alle 16:14 Lang ha ripreso 26 file di codice con marker e il
  README ADR con marker annidati (`git merge-file`); ripristinato dal blob committato `4b1524db`, ma il prossimo merge puo'
  rifarlo. Vedi la tabella di coordinamento di `sync-unrelated-histories-repair.story.md`.
- Decisioni scoperte dalle lane, da sciogliere dai proprietari: `laravel-bootstrap-provider-registry` resta `proposed` (4
  provider ancora in `bootstrap/providers.php`); 12 moduli hanno ancora `app/Http/Livewire` contro
  `NoLivewireDirectoriesInModulesTest`; `no-service-geo-integrations` dice che `BaseGeoService` va rimosso ma e' ancora nel
  debito di `Geo/tests/Arch/debt.php`; User `frontoffice-login-page-ownership` dice che `resources/views/pages` e' assente,
  oggi esiste con `wire:submit="authenticate"`; `.harness/memory/lessons.md` e `composer harness:check` citati dalle
  docs non esistono.
- Contratti: `Cms` ha due contratti sulla stessa Action (`page-resolution-action`, `resolve-page-action`); `Lang` ha tre
  documenti sullo stesso switcher; gli `INDEX.md` legacy di Quaeris, Activity, Cms, User, UI, Lang, Media, Notify sono in
  parte sbagliati; Setting, Limesurvey, Chart e CloudStorage non hanno contratti (23 Action in Chart, tra cui
  `ApplyPlotStyleAction`, usata anche da Quaeris).
- **Baseline PHPStan bloccata** da `.env.testing` mancante (vedi la story di sync dei peer): niente misure di tipo.

## Coordinamento

Una lane per pacchetto, nessun pacchetto in due lane; sono file `docs/adr` e `docs/contracts` e non toccano il codice dei
peer. Ogni file si controlla con `stat -c %Y` prima di scrivere (sotto 120 s è caldo, si salta). Le lane non fanno
`git commit`.

## Verifica

La replica del test e `git ls-files -c -i --exclude-standard` vanno rifatte prima di ogni commit, perche' la sync puo'
rimettere i marker. Pest su `PackagesHaveContractsAndAdrTest` solo con via libera dell'utente (vedi memoria sui database
di test, e `.env.testing` oggi assente).
