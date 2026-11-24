---
title: "Support to Queueable Actions"
type: note
status: in-progress
updated: 2026-11-20

status: draft
updated: 2026-10-22
tags: [docs, xot, plans]
qmd: "support to queueable actions xot"
---
# Support to Queueable Actions

## Intent

`app/Support` mixed registries, schema probes, formatters, adapters and domain
operations under a name that does not describe their lifecycle. The migration
assigns each responsibility to its owning module and exposes executable use
cases through Spatie Queueable Actions.

## Rules

- No directory named `Support` remains anywhere below a production module
  `app/` root. Test fixtures may use `tests/Support` because those helpers are
  test infrastructure, not application behavior.
- Actions live under the owning module's `app/Actions` namespace and expose a
  typed `execute()` method.
- Existing domain APIs are preserved through the already-canonical Actions;
  callers and tests are migrated together, without compatibility classes in
  `Support`.
- Pure multi-operation contracts and infrastructure adapters remain adapters or
  contracts when they are not use cases; they are not forced into a fake queue.
- No `Support` namespace is retained under production `app`; technical code is
  named by its role (`Adapters`, `Infrastructure`, `Contracts`) and executable
  behavior is exposed by an Action.
- A class is not made queueable merely because it was previously placed in a
  Support folder. Queueability belongs to an application use case; framework
  builders and pure infrastructure keep their native role in a semantic
  namespace.
- Seeder fixtures are named by their purpose (`Database/Seeders/Demo`), so
  deterministic demo data remains explicit without pretending it is an
  asynchronous application use case.
- The migration must preserve localization, nullable behavior, serialization,
  and Filament panel configuration.

## Work sequence

1. Inventory each Support class and all callers.
2. Reuse existing Actions where an equivalent already exists.
3. Convert only the remaining executable responsibility to a typed Action.
4. Migrate imports, tests and module documentation.
5. Prove no Support directories or namespaces remain, then run PHPStan and
   focused tests.

## Verification gates

```bash
find laravel/Modules -type d -path '*/app/*/Support' -o -type d -path '*/app/Support'
rg -n '^(namespace|use) (Modules|Themes|App)\\[^;]*\\Support([\\; ]|\\\\)' laravel/Modules laravel/Themes
cd laravel && ./vendor/bin/phpstan analyse Modules --memory-limit=1G
```

The first two commands must return no active application references. Runtime
tests remain subject to the configured test database and are reported as
unverified if that external dependency is unavailable.


## Status 2026-10-22

Production `app/Support` = **0**. Faux-Action cleanup: Geo config → `Infrastructure\Config`;
AI registry → `Adapters`; Blog ArticleDelegates morto rimosso. Ratchet: `NoServicesTest`.
Process: `docs/second-brain/process/no-app-support-queueable-actions.md`.

## Status 2026-11-20: erano tornate

Lo stato del 2026-10-22 diceva «Production `app/Support` = 0». Il 2026-11-20 le
cartelle erano **sei**, con 11 file, e `NoServicesTest` rosso su entrambe le
asserzioni che le sorvegliano. Stesso fenomeno dei `Services` cancellati lo
stesso giorno (base_quaeris_fila5#247): i moduli sono repo separati e il pull le
riporta.

Le classi erano nove (gli altri due dei file che `NoServicesTest` elencava —
`TenantScope.php` e `InteractsWithTenant.php` — **usavano** quel namespace senza
starci dentro). Otto delle nove non avevano chiamanti di produzione, e per
ognuna esisteva il successore o la copia canonica.

| file | esito |
|---|---|
| `AI/app/Support/AiJsonResponseDecoder` | terza copia del decoder; canonica `Actions/AiJsonResponseDecoderAction` |
| `AI/app/Support/PredictionDraftFallbackTemplates` | canonica `Actions/PredictionDraftFallbackTemplatesAction` |
| `AI/app/Support/ScalarCaster` | zero riferimenti, in nessuna forma |
| `AI/app/Actions/Support/MakeAIRequestAction` | gemello morto del vivo in `Actions/`: `handle()` oltre `execute()`, `sleep()` nudo |
| `AI/app/Actions/Support/RequestChatCompletionAction` | zero riferimenti; `sleep()` nudo anche dopo l'ultimo tentativo |
| `Geo/app/Support/GeoMapDataset` | zero riferimenti |
| `Geo/app/Actions/Geo/Support/GeoMapDatasetAction` | zero riferimenti |
| `Geo/app/Filament/Forms/Components/Support/CoordinatePickerHelpers` | copia rimasta indietro: il vivo e' in `Components/`, che `XotBaseCoordinateField` risolve **senza `use`** perche' e' nel proprio namespace |

La nona era viva: `User/app/Support/AuthenticatedTenantKey`, chiamata da
`Models\Scopes\TenantScope:32` e da `Models\Traits\InteractsWithTenant:54`,
quindi nel percorso di ogni query sui modelli con tenancy.

**Non** e' diventato una Action, seguendo la regola scritta qui sopra: non e' un
caso d'uso, e' un risolutore sincrono dentro uno scope Eloquent, e renderlo
accodabile aggiungerebbe una risoluzione dal container a ogni query. E' andato in
`User/app/Infrastructure/Tenant/`, sul precedente di
`Geo/app/Infrastructure/Config` citato nello stato di ottobre.

Nel passaggio e' emerso che il suo docblock descriveva **un altro progetto**:
elencava «cameriere, cassa, cucina, bar, HACCP» e parlava di «ristorante», in un
progetto di sondaggi. Il modulo e' condiviso e si era portato dietro il dominio
di chi l'aveva scritto per primo. Il codice e' generico (prende il primo tenant),
la descrizione no: riscritta in termini di organizzazione, con la nota che quel
`first()` diventa un bug silenzioso il giorno in cui un utente appartiene a due.

Esito: `NoServicesTest` **8 asserzioni su 8 verdi**, da 6 rosse della mattina.
`phpstan analyse`: `[OK] No errors`.

Il cancello di verifica di questo piano, rimisurato:

```
find laravel/Modules/*/app laravel/Themes -type d -name Support     (vuoto)
```
