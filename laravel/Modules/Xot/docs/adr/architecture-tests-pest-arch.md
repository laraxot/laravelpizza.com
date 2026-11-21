---
qmd: "adr pest arch architecture testing preset php security strict types xotbase services debito ignoring falsi verdi nwidart"
title: "ADR — Le regole di architettura si verificano con Pest arch(), con ambito esplicito e debito dichiarato"
type: decision
module: Xot
tags: [adr, architettura, pest, arch, ci, qualita]
created: 2026-11-18
updated: 2026-11-18
status: accepted
issues:
  - "progetto ospite #732"
  - "progetto ospite #733"
supersedes: architecture-rules-phparkitect.md
related:
  - ../../tests/Arch/ArchitectureTest.php
  - ../../tests/Arch/scope.php
---

# ADR: le regole di architettura si verificano con Pest arch()

## Contesto

Le regole di architettura (niente `Services`, mai estendere Filament direttamente ma `XotBase*`, moduli condivisi
agnostici, `declare(strict_types=1)`, niente funzioni di debug) erano scritte nella wiki e verificate da walker Pest fatti a
mano, ognuno col suo codice. Il plugin `pestphp/pest-plugin-arch` (5.0) e' gia' installato ma non era usato.
Documentazione: pestphp.com/docs/arch-testing.

Prima di affidargli le regole l'ho provato sul nostro layout (nwidart: un prefisso PSR-4 per modulo, temi registrati a
runtime). Pest arch e' affidabile solo se si evitano **cinque trappole**, tutte misurate il 2026-11-18 con una classe sonda
che viola la regola:

1. `expect('Modules')` non controlla nulla: Pest risolve i namespace dai prefissi PSR-4 e `Modules\` non lo e'.
   `expect('Modules')->not->toHaveSuffix('Service')` passava con 22 Service presenti.
2. I temi (`Themes\Sixteen`, `Themes\TwentyOne`) non sono nel merge-plugin di Composer: li registra a runtime
   `RegisterRuntimePsr4NamespacesAction`, che richiede l'applicazione. Senza applicazione ogni regola sui temi era vuota.
3. `expect([A, B])->not->toUse(X)` passa se **uno solo** dei target non usa X (`Blueprint::expectToUse` + l'opposto):
   un array nasconde le violazioni degli altri. Una sonda in Geo che usava il modulo del progetto ospite passava.
4. `->not->toUse('Themes')` non vede nulla per la stessa ragione del punto 1: la dipendenza va scritta coi prefissi veri.
5. `ignoring()` confronta per prefisso di stringa (`str_starts_with`): ignorare `...\Render\Block` nasconde anche
   `...\Render\Blocks`, ignorare `AIService` nasconde `AIServicePromptBuilder`.

PHPArkitect (ADR `architecture-rules-phparkitect.md`) non ha le trappole 1, 2 e 5 e ha una baseline; il proprietario del
progetto ha scelto Pest, gia' installato e nella stessa suite, senza dipendenze nuove.

## Decisione

- Le regole stanno in `tests/Arch/` di ogni pacchetto: `Modules/Xot/tests/Arch/ArchitectureTest.php` per quelle comuni,
  `tests/Arch/` del modulo del progetto ospite per quelle che lo nominano (i moduli condivisi restano agnostici).
  Suite `Arch` in `laravel/phpunit.xml` (`Modules/*/tests/Arch`, `Themes/*/tests/Arch`): `vendor/bin/pest --testsuite=Arch`,
  ~25 secondi, nessuna applicazione e nessun database.
- `tests/Arch/scope.php` chiude le trappole:
  - l'ambito si costruisce dai `composer.json` dei pacchetti (`production_namespaces()`), mai `Modules`;
  - registra i prefissi dei temi letti dai loro `composer.json` (`register_theme_namespaces()`);
  - un test verifica che ogni namespace dell'ambito sia un prefisso PSR-4 visibile a Pest.
- Le regole con `not->toUse()` sono una per modulo (ciclo), con dipendenze scritte come prefissi veri.
- Regole attive: preset `php` e `security` di Pest (factory, seeder e test esclusi), `toUseStrictTypes`, niente classi in
  `*\Services`, moduli che non dipendono dai temi, otto famiglie Filament estese solo tramite la base Xot
  (`XOTBASE_FAMILIES`), e, nel modulo del progetto ospite, i moduli condivisi che non dipendono da lui.
- Pest non ha baseline: il debito di oggi e' `ARCH_DEBT`, classe per classe, e puo' solo scendere. Due test lo tengono
  onesto: ogni voce esiste ancora, e nessuna voce nasconde per prefisso una classe che non e' in lista (trappola 5).
- Ogni regola e' stata provata con una violazione iniettata (sonda) prima di essere considerata attiva.

## Alternative scartate

- **PHPArkitect**: niente trappole 1, 2 e 5, baseline nativa; scartato per non aggiungere una dipendenza quando Pest e' gia'
  installato e il proprietario lo preferisce. L'ADR resta come `superseded`.
- **Walker scritti a mano**: restano per cio' che non riguarda classi (documenti, nomi dei file `.md`, cartelle, symlink);
  per le classi ogni guardia reimplementava la lettura dei file.
- **Usare i preset `laravel` e `strict`**: `strict` impone `final` su tutte le classi (incompatibile con le basi `XotBase*`
  estese dai moduli); `laravel` impone metodi standard ai controller e conflitterebbe con le Action. Si prendono `php` e
  `security`.
- **`ListRecords → XotBaseListRecords`**: `ManageRecords` estende `ListRecords`, quindi ogni pagina corretta
  `XotBaseManageRecords` violerebbe la regola, e Pest non ha un «oppure». La famiglia e' fuori elenco.

## Conseguenze

- Debito misurato e visibile in `ARCH_DEBT` (2026-11-18): 12 classi con funzioni di debug, 33 con funzioni del preset
  `security` (quasi tutte `md5`/`uniqid`/`sha1` per chiavi non crittografiche), 3 senza `strict_types`, 22 classi in
  `Services` (#733), 3 estensioni dirette di Filament.
- Corretti subito: `Modules\UI\View\Components\Render\Block` mostrava ai visitatori il contenuto del blocco con `print_r`
  quando la vista mancava (ora solo vista e tipo); `Modules\AI\Services\AIService` usava `md5` per le chiavi di cache (ora
  `xxh128`; la cache AI si rigenera una volta).
- Una deprecazione di `mustache/mustache` (vendor, via `spatie/laravel-database-mail-templates`) compare nel preset `php`:
  non e' codice nostro e non fa fallire la suite.
- La suite `Arch` va nella matrice bloccante della CI. Al 2026-11-18 la CI del progetto ospite non partiva per il limite di spesa
  di GitHub Actions dell'account: finche' non riparte, si lancia a mano prima del push.
- Chi aggiunge una regola la prova con una sonda che la viola; chi aggiunge una voce di debito lo spiega nella PR.
