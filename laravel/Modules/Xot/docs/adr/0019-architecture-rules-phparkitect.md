---
qmd: "adr phparkitect regole architetturali pest arch deptrac phpat baseline services xotbase dipendenze moduli"
title: "ADR — Le regole architetturali sulle classi si verificano con PHPArkitect, con baseline"
type: decision
module: Xot
tags: [adr, architettura, phparkitect, pest, ci, qualita]
created: 2026-11-18
updated: 2026-11-24
status: superseded by 0020-architecture-tests-pest-arch.md
superseded_by: 0020-architecture-tests-pest-arch.md
issues:
  - "progetto ospite #732"
  - "progetto ospite #733"
related:
  - ../../tests/Unit/Architecture/NoServicesTest.php
  - ../../tests/Unit/Docs/ModuleCodeIsProjectAgnosticTest.php
  - ../rules/action-behavioral-contract.md
---

> Superseded da [0020-architecture-tests-pest-arch.md](0020-architecture-tests-pest-arch.md): PHPArkitect con baseline sostituito da Pest arch(). Nessuna decisione nuova: il canonico prevale, questo file non va esteso.

# ADR: le regole architetturali sulle classi si verificano con PHPArkitect, con baseline

> **Superseded** il 2026-11-18 da [architecture-tests-pest-arch](0020-architecture-tests-pest-arch.md): si usa Pest arch(),
> gia' installato. Le misure qui sotto restano valide e motivano le protezioni di `tests/Arch/scope.php`.

## Contesto

Le regole di architettura dei moduli sono scritte nella wiki (niente `Services`, un caso d'uso e' un'Action, mai estendere
Filament direttamente ma `XotBase*`, moduli condivisi agnostici, il tema dipende dai moduli e non il contrario). Oggi le
verificano test Pest scritti a mano che camminano sul filesystem e cercano stringhe (`tests/Unit/Architecture/*`,
`ModuleCodeIsProjectAgnosticTest`): ogni guardia reimplementa il proprio walker.

Misure del 2026-11-18 su `dev`:

- **Le guardie esistenti sono rosse e nessuno se n'e' accorto.** `NoServicesTest` fallisce 7 test su 8: dopo il commit
  `8a8f309737` («mirror al root di moduli e temi») esistono di nuovo `app/Services` in AI, Geo, Job, Seo, UI, Xot. Il test
  non e' nelle suite bloccanti della CI (`phpunit.xml` ne aveva tre, nessuna di Xot) e richiede MariaDB anche se legge solo
  file.
- **Pest `arch()` (gia' installato, `pestphp/pest-plugin-arch` 5.0) da' falsi verdi in questo layout.**
  `arch()->expect('Modules')->not->toHaveSuffix('Service')` passa, mentre `expect('Modules\Geo')` fallisce su
  `GeoDataService`: Pest risolve i namespace dalla mappa PSR-4 di Composer, e nwidart registra un prefisso per modulo
  (`Modules\Geo\` → `Modules/Geo/app/`), non `Modules\`. Una regola scritta su `Modules` non controlla nulla, in silenzio.
- **PHPArkitect 1.3.1, prova fuori dal repository** con cinque regole vere su `Modules/` (esclusi `vendor`, `tests`,
  `database`): 6 secondi, nessun database, 89 violazioni. Di queste, 22 classi in `Modules\*\Services` (le stesse della
  guardia rossa), 54 classi in `Actions` senza suffisso `Action`, 13 Resource che non estendono *direttamente*
  `XotBaseResource` (falsi positivi: estendono `LangBaseResource`, che a sua volta la estende; con `IsA` al posto di `Extend`
  spariscono). Zero violazioni su «i moduli condivisi non dipendono dal modulo del progetto» e «i moduli non dipendono da
  `Themes`».
- Un solo file Blade di Xot (`resources/views/rss/feed.blade.php`) rompe il parser: va escluso il percorso `resources/`.

## Decisione

Proposta (da confermare, aggiunge una dipendenza di sviluppo):

1. `phparkitect/phparkitect` in `require-dev` di `laravel/composer.json`; configurazione unica `laravel/phparkitect.php`,
   di proprieta' di Xot, che legge le cartelle (`ClassSet::fromDir`) e non dipende dall'autoload: niente falsi verdi.
2. Le regole sulle **classi** (namespace, dipendenze, ereditarieta', nomi, `final`, attributi) passano a PHPArkitect:
   niente `Services`/`Support`, `IsA XotBaseResource` per le Resource, agnosticita' dei moduli condivisi, moduli che non
   dipendono dai temi, Action con suffisso `Action`.
3. Le violazioni di oggi vanno in `phparkitect-baseline.json` (`generate-baseline`): la CI blocca solo le **nuove**; ogni
   correzione si chiude con `prune-baseline`, cosi' la baseline puo' solo scendere.
4. Job CI dedicato e bloccante, senza database; lo stesso comando nel pre-commit.
5. Restano in Pest le regole che non riguardano classi: contratti e ADR (`tests/Unit/Docs`), nomi dei file `.md`, pagine
   del tema, symlink degli asset, stringhe di progetto nei documenti.

## Alternative scartate

- **Pest `arch()`**: gia' installato e nella stessa suite, ma con i namespace radice dei moduli non vede nulla (misurato
  sopra) e non ha una baseline: con 89 violazioni si potrebbe introdurre solo con lunghe liste `ignoring()`. Resta buono
  per regole puntuali su un singolo modulo (`expect('Modules\Geo')`).
- **Lasciare le guardie scritte a mano**: funzionano solo se girano. Oggi non girano in CI e sono rosse; ogni nuova regola
  costa un walker in piu'.
- **Deptrac**: ragiona per strati (dominio, infrastruttura); qui le regole sono per modulo e per convenzione di nome,
  esprimibili ma con una configurazione YAML piu' lunga e meno leggibile da chi scrive codice PHP.
- **PHPat** (estensione di PHPStan): sfrutta PHPStan, gia' a zero in CI, ma lega le regole architetturali all'analisi piu'
  lenta del progetto (minuti su tutti i moduli) e non ha una baseline separata da quella di PHPStan.

## Driver della decisione

- evitare di perdere la motivazione storica della migrazione a Pest arch();
- conservare la traccia del confronto fra strumenti e del debito che ha richiesto la sostituzione;
- rendere esplicito che questo ADR non autorizza nuove configurazioni PHPArkitect.

## Conferma

Questo ADR e' verificato come `superseded` dal link a
`0020-architecture-tests-pest-arch.md`. Nuove regole architetturali sulle classi
devono essere aggiunte alla suite Pest arch() e non a una configurazione
PHPArkitect separata.

## Conseguenze

- Una dipendenza di sviluppo in piu'; nessun codice di produzione cambia.
- Le regole diventano una lista leggibile in un file, con il «perche'» (`because()`) che compare nell'errore: un agente AI
  sa dove guardare prima di scrivere una classe.
- Debito visibile e misurabile: il numero di righe della baseline. Primo obiettivo: le 22 classi `Services` (story Xot sulla
  migrazione ad Action).
- Rischio: la «mirror al root» riporta codice vecchio dai repository dei moduli; la baseline lo intercetta solo se il job CI
  gira. Il job CI del progetto ospite oggi non parte (limite di spesa di GitHub Actions dell'account): finche' non riparte,
  il pre-commit e' l'unico punto di controllo.
