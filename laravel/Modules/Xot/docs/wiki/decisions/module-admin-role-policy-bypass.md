---
title: "Il ruolo {modulo}::admin gestisce tutto il suo modulo (policy before)"
type: decision
module: Xot
tags: [policy, permessi, ruoli, filament, pannelli]
created: 2026-11-09
updated: 2026-11-11
status: accepted
qmd: "XotBasePolicy before module admin role cms::admin lang::admin PermissionDoesNotExist pannello vuoto"
related:
  - ../../../app/Models/Policies/XotBasePolicy.php
  - ../../../app/Models/Policies/Concerns/RequiresOperationalPermissions.php
  - ./security-middleware-csrf-order.md
---

# ADR: chi apre il pannello di un modulo ne gestisce i dati

## Contesto

L'accesso a un pannello Filament richiede il ruolo `{modulo}::admin`
(`user:assign-module`). Le policy dei modelli invece usavano regole diverse:

| Modulo | Regola nelle policy | Effetto per chi ha solo `{modulo}::admin` |
|---|---|---|
| Cms, Media, Lang, Geo, Job, Activity, Tenant, Xot | `$user->hasPermissionTo('menu.viewAny')` | **500** `PermissionDoesNotExist` (permesso mai creato) |
| Gdpr | idem (prima del fix `hasPermissionToOrCreate`) | 500, poi pannello vuoto |
| Rating | `hasRole(['hr-manager','evaluator'])` (ruoli di un altro progetto) | pannello vuoto |

Solo `super-admin` (bypass in `before()`) vedeva i pannelli. Le figure del manuale
(redattore, moderatore, traduttore, responsabile privacy) non potevano lavorare.

## Decisione

`before()` concede tutto a chi ha il ruolo `{modulo}::admin` del modulo della policy:

- `XotBasePolicy::before()` ricava il modulo dal namespace (`Modules\{Modulo}\...`) → `strtolower({Modulo}).'::admin'`.
- Le basi che non estendono `XotBasePolicy` (Activity, Cms, Gdpr, Geo, Job, Lang, Media, Tenant, UI)
  hanno lo stesso controllo con il ruolo scritto per esteso.

Restrizioni più fini (es. solo lettura) si fanno con ruoli/permessi dedicati, non lasciando
policy che lanciano eccezioni.

## Conseguenze

- `{modulo}::admin` = amministratore completo dei dati di quel modulo (inclusa cancellazione).
  Per `user::admin` restano i blocchi di `BaseUserPolicy` (niente azioni distruttive su sé stessi).
- I moduli condivisi vengono sincronizzati dai repository upstream (`laraxot/module_*_fila5`):
  la modifica va portata anche lì, altrimenti la prossima sincronizzazione la cancella.

## Eccezioni (2026-11-10)

Il bypass non vale dove `{modulo}::admin` serve solo ad aprire il pannello e i permessi veri dipendono da ruoli di dominio.

### Moduli con permessi operativi

Nei moduli in cui il ruolo del pannello serve solo a entrare e i permessi dicono chi fa cosa, il bypass e' un
problema. Roosko, Waste, Warehouse, Processing, Weighing, Labeling e Rentri distinguono operatore di piazzale,
accettazione e responsabile tecnico. Con il bypass, l'operatore (che ha `roosko::admin` per usare la pagina di
scansione) poteva rettificare pesi ed eliminare conferimenti.

Quelle policy usano il trait `Concerns\RequiresOperationalPermissions`: `moduleAdminRole()` restituisce null,
quindi passa solo il super-admin. Test: Roosko `AuthorizationTest` ("il ruolo del pannello ... non concede
abilita' operative").

### Casi dove l'override e' scritto per esteso

- **Fixcity** (`Modules/Fixcity/app/Policies/BasePolicy.php`): tutti gli operatori hanno `fixcity::admin`; con il bypass
  un operatore poteva cancellare segnalazioni. Decidono i ruoli `operator`, `supervisor`, `admin`; passa a priori solo
  `super-admin`. Test: `TicketDeletionAuthorizationTest` ("operator who also has the panel role").
- **User** (`Modules/User/app/Models/Policies/BaseUserPolicy.php`): `user::admin` non deve poter modificare un super-admin.

Un modulo nuovo che assegna `{modulo}::admin` a chi non deve gestire tutto il modulo usa il trait
`RequiresOperationalPermissions` se i permessi sono operativi, oppure fa lo stesso override di `before()`.
Tolta anche `Modules/Fixcity/app/Models/Policies/TicketPolicy.php`: non registrata, concedeva tutto e Laravel l'avrebbe
trovata da sola se mancasse `Gate::policy()`.
