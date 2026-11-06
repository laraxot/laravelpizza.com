---
title: "Separazione dei metodi modello in trait dedicati"
type: story
module: Xot
status: in-progress
created: 2026-11-05
updated: 2026-11-05
tags: [bmad, eloquent, models, traits, mutators, relationships, refactoring]
qmd: "Laravel Eloquent model mutator helper relation methods dedicated Traits Mutators Relationships extract audit modules themes"
related:
  - ./accessor-twin-contract-audit.story.md
  - ./accessor-twin-same-file-delegation.story.md
references:
  - ../../wiki/rules/accessor-twin-method.md
  - ../../../Sigma/docs/wiki/concepts/scheda-mutator-getter-colocation.md
---
# Separazione dei metodi modello in trait dedicati

## Contesto

L'analisi degli accessor ha mostrato che metodi di mutazione, helper di calcolo e
relazioni Eloquent sono talvolta definiti direttamente nelle classi modello. Le
strutture Sigma e Ptv hanno già `Models/Traits/Mutators` e
`Models/Traits/Relationships`; il loro uso non è uniforme nei moduli e nei temi.

## Regola richiesta

Quando un modello contiene metodi mutator con helper di supporto, spostare l'intero
nucleo in un trait dedicato sotto `app/Models/Traits/Mutators/`. Spostare anche le
relazioni Eloquent definite nel modello in trait dedicati sotto
`app/Models/Traits/Relationships/`. Il modello usa i trait e conserva la stessa
API runtime.

Una coppia `get{X}Attribute()` / `get{X}()` resta nello stesso file quando viene
estratta: accessor e gemello devono rimanere co-locati e l'accessor deve invocare
il gemello. I trait vanno separati per responsabilità e modello, senza aggregatori
che mescolano logiche non correlate.

## Acceptance criteria

- [ ] Censire classi modello di `laravel/Modules/*` e `laravel/Themes/*` con mutator/helper o relazioni inline; classificare i casi, senza usare grep grezzo come risultato finale.
- [ ] Elencare nel report owner Xot i metodi e i relativi path modello/trait, con motivazione e stato.
- [ ] Estrarre mutator e helper correlati in trait `Mutators` dedicati, mantenendo firma, visibilità, chiamanti e comportamento.
- [ ] Estrarre le relazioni Eloquent in trait `Relationships` dedicati, mantenendo nomi, tipi di ritorno e relazione runtime.
- [ ] Mantenere accessor e gemello nello stesso file durante l'estrazione e preservare la regola di delega.
- [ ] Aggiungere test di regressione per classi e trait modificati; aggiornare docs, indici e second brain dei moduli owner.
- [ ] Eseguire Pest e PHPStan per ogni modulo toccato e registrare l'esito; non chiudere batch con gate pendenti.

## Task

- [x] Inventario meccanico dei modelli top-level `Modules/*/app/Models/*.php` (93 file con metodi; Themes senza modelli). Census di classificazione delegato a 3 subagent paralleli per gruppi disgiunti.
- [ ] Consolidare il census in tabella owner/modulo con verdetto EXTRACT/LEAVE.
- [ ] Estrarre mutator e helper correlati in trait `Mutators` dedicati, mantenendo firma, visibilità, chiamanti e comportamento.
- [ ] Estrarre le relazioni Eloquent in trait `Relationships` dedicati, mantenendo nomi, tipi di ritorno e relazione runtime.
- [ ] Mantenere accessor e gemello nello stesso file durante l'estrazione e preservare la regola di delega.
- [ ] Aggiungere test di regressione per classi e trait modificati; aggiornare docs, indici e second brain dei moduli owner.
- [ ] Eseguire Pest e PHPStan per ogni modulo toccato e registrare l'esito; non chiudere batch con gate pendenti.

## Finding registrati durante il census

- **P0 — parse error in 14 modelli** (verificato con `php -l`): `Xot/Log`, `Notify/{MailTemplateLog,MailTemplateVersion,NotificationLog,NotificationTemplate,NotificationTemplateVersion,NotifyTheme}`, `Job/{Frequency,Job,Parameter,Result,Schedule,ScheduleHistory,Task,TaskComment}` — token `public` orfani rimasti dopo estrazione in `Traits/*` (modified non committate). **Owner: `agent-general-accessors`** (task `accessor-methods-trait-extraction`, lock attivi 09:42). NON toccati da questa sessione: fix = rimuovere le righe `public` pendenti nei body modello. Attenzione: PHPStan "No errors" precedente era su HEAD committato, non su working tree.
- `Modules/Incentivi/app/Models/StabiDirigente.php::getNomeDiri()` — **`random_int()` dentro un getter**: la scelta tra fallback anno-precedente (30%) e query SQL legacy (20%) è non deterministica e il risultato viene persistito in `nome_diri`. File **lockato da codex-accessor-leaf** (story `accessor-twin-contract-audit`) al momento del finding — NON toccato. Fix proposto: rimuovere i gate casuali e rendere deterministico il fallback (anno precedente, poi SQL), da concordare con l'owner del modulo.
- `Modules/Lang/app/Models/Traits/PostMutators.php:101` — `'u-'.random_int(1,1000)` in un mutator: verificare se è generazione ID voluta o debito.
