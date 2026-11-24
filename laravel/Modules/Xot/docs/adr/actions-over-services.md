---
title: "ADR — La logica applicativa si scrive come Spatie QueueableAction, non come Service"
type: decision
status: accepted
created: 2025-09-22
updated: 2026-11-24
module: Xot
tags: [adr, actions, queueable-action, services, harness]
qmd: "adr actions over services queueable action spatie no services rule legacy AI Geo Job"
related:
  - ../rules/action-behavioral-contract.md
  - ./architecture-tests-pest-arch.md
---

# ADR: Actions, non Services

## Contesto

Ogni modulo Laraxot ha `app/Actions/` (800 classi nel checkout del 2026-11-24) e la regola di progetto
`no-services-rule` vieta classi `*Service` per la logica applicativa. Restano però Services legacy in produzione:
`Modules/AI/app/Services` (5 classi, tra cui `AIService`), `Modules/Geo/app/Services` (8, tra cui `GeoService` e
`GoogleMapsService`), `Modules/Job/app/Services/ScheduleService.php`. Un agente che aggiunge un'operazione accanto a
quelle esistenti copia la forma del file più vicino: se il vicino è un Service, nasce un Service nuovo.
Che forma ha un'operazione applicativa nuova, sapendo che i Services legacy restano finché qualcuno non li migra?

## Driver della decisione

- Un'operazione = un file: il contratto di comportamento e i suoi test hanno un solo bersaglio, citato con `@contract`.
- L'autorizzazione sta in una Policy, visibile nel punto che avvia l'operazione, non sparsa nei Service.
- Transazione e audit stanno nello stesso punto dell'operazione, così si vedono in revisione.
- Nessuna riscrittura forzata del legacy: i Services in produzione funzionano e hanno chiamanti; la loro correzione
  non è un prerequisito per scrivere codice nuovo nella forma giusta.

## Decisione

- Ogni operazione applicativa nuova è una classe in `Modules/<Modulo>/app/Actions/<Area>/<Verbo><Oggetto>Action.php`
  con `use Spatie\QueueableAction\QueueableAction;` e un solo metodo pubblico `execute(...)`; si invoca con
  `app(XAction::class)->execute(...)` o `->onQueue()->execute(...)`.
- L'Action vive nel modulo del suo dominio, mai in Xot per comodità (`AI/Ollama` → `Modules/AI`).
- Un'Action che scrive dati, chiama servizi esterni o ha effetti collaterali ha il contratto in `docs/contracts/` e
  `@contract` nel docblock ([regola](../rules/action-behavioral-contract.md)).
- I Services legacy elencati sopra **non sono un modello**: si correggono se rotti, non si estendono con metodi pubblici
  nuovi; la loro migrazione ad Actions è una story del modulo owner.

## Alternative scartate

- **Estendere i Services esistenti** (`GeoService::nuovoMetodo()`): veloce, ma un file con dieci operazioni non ha un
  contratto per operazione né un test mirato, e perpetua la forma che vogliamo eliminare.
- **Job Laravel per ogni operazione**: duplicano le Action (stessa logica, classe diversa); `QueueableAction` dà la coda
  senza seconda classe.
- **Logica nei controller / componenti Livewire**: niente controller nel front office (Folio + Volt), e la logica nelle
  viste non si riusa da Filament, console e code.

## Conseguenze

- Buono: un'operazione = un file = un contratto = un group di test; un agente sa dove cercare e cosa imitare.
- Buono: la stessa Action gira sincrona, in coda, da Filament, da console.
- Cattivo: per un periodo convivono due stili in AI, Geo e Job; chi legge `app/` deve sapere che i Services sono debito.
- Cattivo: molte classi piccole; serve la disciplina del nome (`<Verbo><Oggetto>Action`) per ritrovarle.

## Conferma

- In revisione: una classe nuova sotto `app/Services/`, o un metodo pubblico nuovo in un Service legacy, si respinge
  con un rimando a questo ADR.
- Ogni Action applicativa usa il trait `Spatie\QueueableAction\QueueableAction`; non si introduce un Job Laravel
  parallelo per la stessa operazione ([queueable-actions-over-jobs](queueable-actions-over-jobs.md)).
- Ogni Action nuova che scrive dati, chiama servizi esterni o ha effetti collaterali ha `@contract` nel docblock e il
  suo contratto in `docs/contracts/` ([contract-docblock-reference](contract-docblock-reference.md)).

## Verifica

- `cd laravel && vendor/bin/pest Modules/Xot/tests/Arch/ArchitectureTest.php`: le classi in `Services` sono elencate
  come debito in `Modules/Xot/tests/Arch/debt.php`; una classe `Services` nuova fuori elenco fa fallire la suite.
- In revisione: un metodo pubblico nuovo in un Service legacy si respinge con un rimando a questo ADR.
