---
title: "Indice ADR — Xot"
type: index
status: active
owner: Xot
created: 2026-11-23
updated: 2026-11-25
qmd: "xot adr indice decisioni canonico superseded numerazione doppia BMAD MADR 0039 0040 0041 no docs archive story filenames NNNN"
---

# Indice ADR — Xot

Inventario di tutti gli ADR del pacchetto **Xot** (esclusi `README.md`, `index.md` e `0000-template.md`). Lo stato è quello della frontmatter di ciascun file. Formato e sezioni obbligatorie: [README](README.md); modello: [0000-template](0000-template.md); governance dei contratti: [0012](0012-behavioral-contract-governance.md).

Totale: **31** ADR, di cui **22** canonici e **9** superseded (nessun file cancellato).

| N. | Titolo | Stato | Canonico / superseded | File |
|---|---|---|---|---|
| 0001 | Le operazioni di business nuove si scrivono come Queueable Actions | accepted | canonico | [0001-actions-over-services.md](0001-actions-over-services.md) |
| 0002 | Le operazioni applicative usano Queueable Actions, non Job duplicati | accepted | canonico | [0002-queueable-actions-over-framework-jobs.md](0002-queueable-actions-over-framework-jobs.md) |
| 0003 | Pest e' il formato e il runner dei test applicativi | accepted | canonico | [0003-pest-as-test-runner.md](0003-pest-as-test-runner.md) |
| 0004 | Ogni modello persistente ha una migrazione owner | accepted | canonico | [0004-one-model-one-migration.md](0004-one-model-one-migration.md) |
| 0005 | Le decisioni vivono nella documentazione dell'owner | accepted | canonico | [0005-owner-local-documentation.md](0005-owner-local-documentation.md) |
| 0006 | Nessun Livewire standalone: usare Filament Widget | superseded | superseded → [0008-filament-widgets-over-standalone-livewire.md](0008-filament-widgets-over-standalone-livewire.md) | [0006-no-standalone-livewire-widgets.md](0006-no-standalone-livewire-widgets.md) |
| 0006 | I moduli estendono i punti base Xot del framework | accepted | canonico; stesso numero 0006 di una decisione diversa (superseded da 0008): il numero resta doppio, nessuna rinumerazione | [0006-xot-base-extension-points.md](0006-xot-base-extension-points.md) |
| 0007 | Il TestCase Pest si lega nel file di test che lo usa | accepted | canonico | [0007-module-local-pest-testcase-binding.md](0007-module-local-pest-testcase-binding.md) |
| 0008 | No standalone Livewire, usa Filament widget | accepted | canonico | [0008-filament-widgets-over-standalone-livewire.md](0008-filament-widgets-over-standalone-livewire.md) |
| 0009 | Bootstrap Laravel 13 minimale e discovery dei moduli | accepted | canonico | [0009-laravel-bootstrap-provider-registry.md](0009-laravel-bootstrap-provider-registry.md) |
| 00010 | No ticket logic in PageSlugMiddleware | superseded | superseded → [0010-no-ticket-logic-in-page-slug-middleware.md](0010-no-ticket-logic-in-page-slug-middleware.md) | [00010-no-ticket-logic-in-page-slug-middleware.md](00010-no-ticket-logic-in-page-slug-middleware.md) |
| 0010 | Ticket logic rimossa da PageSlugMiddleware | accepted | canonico; decisione di Cms/Fixcity, moduli assenti in questo checkout (deroga di verifica) | [0010-no-ticket-logic-in-page-slug-middleware.md](0010-no-ticket-logic-in-page-slug-middleware.md) |
| 00011 | @contract docblock reference on Actions | superseded | superseded → [0011-contract-docblock-reference.md](0011-contract-docblock-reference.md) | [00011-contract-docblock-reference.md](00011-contract-docblock-reference.md) |
| 0011 | @contract docblock reference su Actions | accepted | canonico | [0011-contract-docblock-reference.md](0011-contract-docblock-reference.md) |
| 0012 | Governance dei Behavioral Contract con invarianti verificabili | accepted | canonico | [0012-behavioral-contract-governance.md](0012-behavioral-contract-governance.md) |
| 0013 | I dati sono sacri: mai migrate:fresh/reset/rollback/force, mai RefreshDatabase, test solo con .env.testing | accepted | canonico | [0013-dati-sacri-migrazioni-e-test.md](0013-dati-sacri-migrazioni-e-test.md) |
| 0014 | La risoluzione "mista" dei conflitti Git e' l'ultima spiaggia, non la strategia | accepted | canonico | [0014-merge-misto-ultima-spiaggia.md](0014-merge-misto-ultima-spiaggia.md) |
| 0015 | mixed solo come ultima spiaggia: tipi veri, narrowing al confine, motivazione scritta | accepted | canonico | [0015-mixed-solo-come-ultima-spiaggia.md](0015-mixed-solo-come-ultima-spiaggia.md) |
| — | mixed nei contratti PHP e' ammesso solo come ultima spiaggia | superseded | superseded → [0015-mixed-solo-come-ultima-spiaggia.md](0015-mixed-solo-come-ultima-spiaggia.md) | [0028-mixed-is-last-resort.md](0028-mixed-is-last-resort.md) |
| — | Harness minimo per gli agenti: ambiente leggibile, memoria verificabile, guard sulle azioni vietate | accepted | canonico, senza numero | [0018-agent-harness.md](0018-agent-harness.md) |
| — | Le regole architetturali sulle classi si verificano con PHPArkitect, con baseline | superseded | superseded → [0020-architecture-tests-pest-arch.md](0020-architecture-tests-pest-arch.md) | [0019-architecture-rules-phparkitect.md](0019-architecture-rules-phparkitect.md) |
| — | Le regole di architettura si verificano con Pest arch(), con ambito esplicito e debito dichiarato | accepted | canonico, senza numero | [0020-architecture-tests-pest-arch.md](0020-architecture-tests-pest-arch.md) |
| — | Auth register Livewire tenant URL defaults | accepted | canonico, senza numero | [0021-auth-register-livewire-tenant-url-defaults.md](0021-auth-register-livewire-tenant-url-defaults.md) |
| — | Un modello persistente, una migrazione di creazione | superseded | superseded → [0004-one-model-one-migration.md](0004-one-model-one-migration.md) | [0031-one-model-one-migration.md](0031-one-model-one-migration.md) |
| — | Pest come framework di test | superseded | superseded → [0003-pest-as-test-runner.md](0003-pest-as-test-runner.md) | [0033-pest-over-phpunit.md](0033-pest-over-phpunit.md) |
| — | Il TestCase di modulo si lega in ogni file di test, mai con uses()->in() nel Pest.php del modulo | superseded | superseded → [0007-module-local-pest-testcase-binding.md](0007-module-local-pest-testcase-binding.md) | [0034-pest-testcase-binding-per-file.md](0034-pest-testcase-binding-per-file.md) |
| — | Queueable Actions al posto di Job duplicati | superseded | superseded → [0002-queueable-actions-over-framework-jobs.md](0002-queueable-actions-over-framework-jobs.md) | [0035-queueable-actions-over-jobs.md](0035-queueable-actions-over-jobs.md) |
| — | Xot — entrypoint route no-op canonico | accepted | canonico, senza numero | [0036-route-entrypoints-canonical-empty.md](0036-route-entrypoints-canonical-empty.md) |
| — | Protocollo delle chiavi di traduzione | accepted | canonico, senza numero | [0037-translation-key-protocol.md](0037-translation-key-protocol.md) |
| 0039 | BMAD stories use MADR (same spirit as harness ADR template) | accepted | canonico; filename clause → [0040](0040-bmad-stories-numbered-filenames.md) | [0039-bmad-stories-use-madr.md](0039-bmad-stories-use-madr.md) |
| 0040 | BMAD stories use numbered filenames (NNNN-slug.story.md) | accepted | canonico | [0040-bmad-stories-numbered-filenames.md](0040-bmad-stories-numbered-filenames.md) |
| 0041 | No docs archive folders — restore via Git only | accepted | canonico; root pointer → [docs/adr/0006](../../../../../docs/adr/0006-no-docs-archive-folders.md) | [0041-no-docs-archive-folders.md](0041-no-docs-archive-folders.md) |

## Note sui duplicati

- **Numero 0006 doppio**: `0006-xot-base-extension-points` (estensione dei punti base Xot) e `0006-no-standalone-livewire-widgets` sono decisioni diverse. La seconda è la formulazione precedente della decisione consolidata nel canonico 0008 e per questo è superseded; la prima resta canonica e conserva il numero 0006.
- **Numerazione a cinque cifre** (`00010`, `00011`): refusi dei canonici `0010` e `0011`, marcati superseded.
- **Alias senza numero** (`one-model-one-migration`, `queueable-actions-over-jobs`, `pest-over-phpunit`, `pest-testcase-binding-per-file`): mantenuti perché esistono link ai loro nomi; il canonico è la versione numerata.
- **`architecture-rules-phparkitect`**: sostituito da `architecture-tests-pest-arch`.
- Decisioni diverse con nomi simili ma non duplicate: `0002-queueable-actions-over-framework-jobs` (cosa si scrive) vs `0001-actions-over-services` (dove vive la logica); `0003-pest-as-test-runner` vs `0007-module-local-pest-testcase-binding` (runner vs binding del TestCase).

## Decisioni precedenti (formato libero, non ancora ADR)

- [module-admin-role-policy-bypass](../wiki/decisions/module-admin-role-policy-bypass.md)
- [security-middleware-csrf-order](../wiki/decisions/security-middleware-csrf-order.md)

## Authoring

Usare il [README](README.md). Non creare un ADR per un dettaglio locale di implementazione o per un'ipotesi non verificata; una decisione nuova supera la vecchia, non la riscrive.
