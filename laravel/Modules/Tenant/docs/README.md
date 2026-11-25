---
<<<<<<< HEAD
title: "Tenant: scopo del modulo"
type: concept
module: Tenant
updated: 2026-11-25
qmd: "tenant scopo modulo multi-tenancy host cartella config database connessioni morph map confini"
---

# Tenant

Una sola installazione serve piu' enti (tenant) cambiando **configurazione, non codice**. Il modulo fa tre cose, tutte
all'avvio, prima che esista il resto dell'applicazione:

1. **Riconosce il tenant dall'host**: `foo.example.com` diventa la cartella `config/com/example/foo/`
   ([tenant-resolution](tenant-resolution.md)).
2. **Sovrappone la config del tenant a quella base** (`config/<tenant>/<gruppo>.php` sopra `config/<gruppo>.php`) e permette
   di salvarla ([configuration](configuration.md)).
3. **Riscrive `config('database')` e la morph map**: crea una connessione per ogni modulo copiando la default e la
   *alias* sulla stessa istanza ([database-config-standard](database-config-standard.md)).

In piu' offre i trait Sushi che servono un modello Eloquent da file JSON/CSV/PHP del tenant
([sushi-json-models](sushi-json-models.md)), un registro dei moduli attivi per tenant ([module-registry](module-registry.md)),
i dati dell'ente ([ente-data](ente-data.md)) e un pannello Filament minimo ([admin-ui](admin-ui.md)).

## Cosa NON fa

- **Non isola i dati riga per riga.** Nessun global scope: `TenantSetting` e `TenantSubscription` hanno un `tenant_id`
  stringa senza FK ne' filtro automatico. L'isolamento reale e' per percorso di file (`config/<tenant>/`) e per
  connessione database ([models-and-schema](models-and-schema.md)).
- **Non e' identita'.** Utenti, ruoli e team sono del modulo User; la tabella `tenants` e' creata da User
  (`Modules\User\Models\Tenant`, quello scelto da `XotData::$tenant_class`).
- **Non e' un router HTTP** e non fa query nel boot: il nome del tenant si ricava da host e filesystem prima che il
  database sia configurato.

## Come si usa

```php
// nome del tenant corrente, es. 'local/miosito' (o 'localhost' come ultimo ripiego)
$name = app(\Modules\Tenant\Actions\GetTenantNameAction::class)->execute();

// valore di config con overlay del tenant
$title = app(\Modules\Tenant\Actions\Config\GetTenantConfigValueAction::class)->execute('metatag.title');

// percorso assoluto di un file del tenant (rifiuta assoluti, NUL e `..`)
$path = app(\Modules\Tenant\Actions\Config\GetTenantFilePathAction::class)->execute('xra.php');
```

Le Action si chiamano sempre con `app(X::class)->execute(...)`: non esiste piu' una facade `TenantService`
([conventions](conventions.md)).

## Numeri (verificati il 2026-11-25)

57 file PHP in `app/` (20 Action, 19 file in `Models/`, 9 in `Filament/`), 3 migrazioni, 1 Resource Filament
(`DomainResource`), 65 file PHP di test. Dipendenze da `module.json`: Xot, User, UI.

## Dove si legge il resto

La mappa di tutte le pagine e' in [00-index](00-index.md). Regola di lettura: se documento e codice divergono vale il codice.
=======
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-11-19
qmd: "README"
issues: []
discussions: []
title: "Tenant — Multi-Tenancy"
description: "Modulo per il multi-tenancy, isolamento dati per tenant"
module: "Tenant"
alias: "tenant"
version: "1.0.0"
priority: 2
active: true
status: "core-multi-tenancy"
author: "Team Laraxot"
license: "Proprietary"
php_version: "^8.1"
core_version: "10.0"
dependencies: ["Xot", "User"]
extends: []
extended_by: 0
documentation_date: "2026-05-27"
---

# Tenant — Multi-Tenancy

## Scopo

Tenant è il modulo che gestisce il multi-tenancy dell'ecosistema. Il modello `Tenant` ha `slug`, `domain`, `database`, `settings` e una relazione `users()` (`HasMany`); la relazione molti-a-molti utente↔tenant passa dal pivot `TenantUser` del modulo User. È il layer che permette a più organizzazioni di coesistere in un'unica installazione.

## Religione

- **"Un database per tenant o row-level security"**: due politiche accettate, ma **mai mixate**
- **"Tenant è una primitiva, non un dettaglio"**: ogni modulo deve essere tenant-aware
- **"HasTenants trait su BaseUser"**: la relazione è nel trait, non in ogni modulo
- **"Salvataggio config con Action"**: `SaveTenantConfigAction` è il punto unico
- **"XotBase come fondamento"**: ogni risorsa tenant estende `XotBaseResource`

## Filosofia

Tenant crede che **l'isolamento dei dati sia un diritto, non un optional**. Ogni tenant ha la sua configurazione, le sue risorse, la sua sicurezza. Il sistema è progettato per **scalare orizzontalmente** aggiungendo tenant senza modificare il codice.

## Politica

- **Pivot `TenantUser`** (modulo User): `tenant_id`, `user_id`
- **`SaveTenantConfigAction`**: unico punto per salvare config tenant
- **`HasTenants` trait**: relazione `tenants()` su `BaseUser`
- **Slug + domain**: identificazione tenant tramite slug o dominio
- **`BaseTenant::$connection`**: supporto per database separati

## Zen

> **"Il tenant è un confine. Il confine è una promessa. La promessa è la privacy."**

Lo Zen di Tenant è l'**isolamento**. I dati di un tenant non possono mai essere visti, modificati o cancellati da un altro tenant. È una promessa architetturale, non una feature.

## Perché esiste

Le applicazioni SaaS moderne hanno bisogno di multi-tenancy per servire più clienti con un'unica installazione. Tenant esiste per **gestire questa complessità** in modo standardizzato.

## Cosa Mancherebbe (Gap Analysis)

| Gap | Severità | Suggerimento |
|-----|----------|--------------|
| Manca tenant impersonation | Alta | Aggiungere `ImpersonateTenantAction` |
| Nessun sistema di tenant billing | Alta | Integrare con `Billing` per fatturazione per tenant |
| Manca tenant backup isolato | Media | Aggiungere `TenantBackup` con restore selettivo |
| Nessun sistema di tenant analytics | Media | Aggiungere `TenantAnalytics` per usage tracking |
| Manca cross-tenant reporting | Bassa | Aggiungere `CrossTenantReport` per admin globali |

---

*Documento generato secondo le convenzioni del progetto — modulo `Tenant` — data 2026-05-27*

## Come funziona (verificato sul codice)

- **Risoluzione del tenant**: `Actions/GetTenantNameAction` legge `SERVER_NAME` (o l'header Host, o `app.url`),
  inverte il dominio (`foo.example.com` → `com/example/foo`) e cerca la cartella in `config/`;
  i symlink sono risolti al path reale. Fallback: `localhost`.
- **Config del tenant**: `Actions/Config/GetTenantConfigValueAction` unisce la config base con quella del tenant;
  `Actions/Config/SaveTenantConfigAction` e' il punto unico di scrittura.
- **Database**: `Providers/TenantServiceProvider::registerDB()` crea una connessione per ogni modulo copiando la default
  e la **alias sulla stessa istanza** della default (una sola sessione/transazione); le connessioni dichiarate
  esplicitamente nella config del tenant restano separate.
- **Modelli**: il modello `Tenant` del modulo ha `users()` come `HasMany`; la relazione `tenants()` e la classe
  astratta `BaseTenant` stanno nel modulo **User** (`Models/Traits/HasTenants`, `Models/BaseTenant`).

## Indice della documentazione

Questo README e' l'**unico indice** della cartella `docs/` (rimossi `index.md`, `INDEX.md`, `00-index.md`,
`index-generated.md`: duplicati o generati).

- [Scopo del modulo](./purpose.md)
- [BMAD](./bmad/00-index.md) · [Audit](./bmad/audit.md) · [Piano di miglioramento](./bmad/piano-miglioramento.md)
- [ECC](./ecc/00-index.md)
- [Regole](./rules-index.md)
- [Story](./stories/) · [Audit qualita' corrente](stories/0011-audit-qualita.story.md)
- [Wiki](./wiki/)

Regole sui nomi: kebab-case, **nessuna data nel nome** di file o cartelle (la data va nel frontmatter).
>>>>>>> laraxot/dev
