---
title: "Rimozione @phpstan-ignore dal modulo User"
type: story
module: User
status: review
created: 2026-10-30
updated: 2026-10-30
tags: [phpstan, static-analysis, traits, ignore-removal]
qmd: "phpstan-ignore trait.unused HasTeams InteractsWithTenant"
---

# Rimozione @phpstan-ignore dal modulo User

Regola del progetto: mai `@phpstan-ignore`, mai baseline. Corretta la causa radice, nessun cambio di comportamento in produzione.

## Esito

Annotazioni in `Modules/User/app`: 6 prima, 1 dopo.

| File | Prima | Dopo | Intervento |
|---|---|---|---|
| `Models/Traits/HasRoles.php` | `trait.unused` | 0 | Tolta: il trait e' usato da `HasRolesTraitFixture` (analizzata). |
| `Models/Traits/HasPasswordExpiry.php` | `trait.unused` | 0 | Tolta: usato da `HasPasswordExpiryFixture`. |
| `Providers/Traits/HasPassportConfiguration.php` | `trait.unused` | 0 | Tolta: usato da fixture e da `UserExecuteCoverage50Test`. |
| `Models/Traits/InteractsWithTenant.php` | `ignore-next-line` | 0 | `config()` restituiva `mixed` a `belongsTo()`: ora `Assert::stringNotEmpty` + `Assert::subclassOf(Model::class)` (convenzione gia' usata in `PassportServiceProvider`). Con valore valido (default `Tenant::class`) il comportamento e' identico. |
| `Models/Traits/HasTeams.php` | `method.notFound, return.type` | 0 | Causa: il mock di test `tests/Unit/Models/Traits/MockUserWithTeams.php` (non usato da nessun test) non forniva `hasPermissionTo()`. Aggiunto al mock, stessa firma di `UserContract` e della fixture gemella. |
| `Models/Traits/HasTeamsMembershipAdministration.php` | `trait.unused` | 1 | Non rimosso, vedi sotto. |

Nota tecnica: la regola `trait.unused` non e' mai riportata quando si analizzano singoli file. Va verificata analizzando directory (trait + fixture). Le directory `Models/Traits`, `Providers/Traits` e `tests/Unit/Traits` risultano pulite per i trait toccati.

## Non rimosso (con motivo)

- `HasTeamsMembershipAdministration`: nessuna classe, in nessun percorso (app, tests, Themes), lo usa. Rimuovere l'annotazione farebbe fallire PHPStan. Codice morto o API per progetti esterni: da decidere con il proprietario del modulo, non cancellato.

## Non verificato

- Nessun test Pest eseguito (database con dati reali).
- Analisi PHPStan completa di `Modules` non eseguita (compito del coordinatore).
- Comportamento di `InteractsWithTenant::tenant()` con `tenant.tenant_model` invalido: ora `InvalidArgumentException` invece dell'errore di Eloquent.
