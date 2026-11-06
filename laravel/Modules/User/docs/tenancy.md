---
title: Tenancy Filament in Laraxot (area cliente)
type: guide
module: User
updated: 2026-11-05
related: [Xot/docs/panel-provider.md, Xot/docs/stories/tenancy-pannelli.story.md, stories/tenancy-chiave-stringa-scope-qualificato.story.md]
qmd: "tenancy tenant cliente area cliente cantieri HasTenants InteractsWithTenant TenantScope filament 5 hasTenancy"
---

# Tenancy Filament in Laraxot (area cliente)

## Scopo

Un cliente entra e vede **solo i suoi dati** (es. i cantieri in Roosko). Il super
admin continua a gestire tutto dai pannelli di gestione dei moduli, senza filtri.

## Decisione: tenancy nativa di Filament, database unico

| | Filament 5 nativa (scelta) | tomatophp/filament-tenancy |
|---|---|---|
| Isolamento | colonna `tenant_id` + scope | un database per tenant (stancl/tenancy) |
| Infrastruttura | nessuna | utente DB con permesso di creare database, connessione `dynamic`, migrazioni per tenant |
| Report trasversali del super admin | query normali | query su N database |
| Problemi noti | — | `route:cache` rompe la connessione dinamica |

Per "il cliente vede i suoi cantieri" il database unico basta ed e' piu' semplice
(KISS). Da tomatophp prendiamo le idee, non il pacchetto:

- **pannello centrale vs pannello tenant** → in Laraxot: pannelli di gestione dei moduli
  (`$hasTenancy = false`) e pannello cliente (`$hasTenancy = true`);
- **impersonate dal pannello centrale** → candidato a una story futura (il super admin
  apre l'area cliente "come" quel cliente per supporto);
- **utenti sincronizzati con il tenant** → in Laraxot e' la pivot `TenantUser`
  (`XotData::getTenantPivotClass()`).

## I pezzi

| Pezzo | Dove | Ruolo |
|---|---|---|
| Modello tenant | `XotData::getTenantClass()` (default `Modules\User\Models\Tenant`, chiave stringa UUID, `slug`) | il "cliente" |
| Utente | `BaseUser` + trait `HasTenants` | `getTenants()` per lo switcher, `canAccessTenant()` blocca gli ID altrui nell'URL |
| Pannello | `XotBasePanelProvider::$hasTenancy` | chiama `->tenant(getTenantClass(), slugAttribute: 'slug')` |
| Modello dei dati del cliente | `BaseInteractsWithTenant` o trait `InteractsWithTenant` | relazione `tenant()`, `TenantScope`, `tenant_id` automatico in creazione |

## Rendere un modello "del cliente"

```php
class Worksite extends BaseInteractsWithTenant {}
```

Migrazione: la chiave del tenant e' una stringa, quindi `tenant_id` va dichiarato stringa
come `tenants.id` (`$table->string('tenant_id')->nullable()->index()`), **mai** `unsignedBigInteger`.

Cosa ottieni:

- nel pannello cliente le resource sono filtrate da Filament tramite la relazione
  `tenant()` (nome di default che Filament cerca) e i record nuovi vengono associati;
- `TenantScope` filtra anche le query fuori dalle resource (widget, select, azioni,
  relation manager) quando c'e' un tenant corrente, con la colonna qualificata
  (`tabella.tenant_id`) per non rompersi nelle join;
- nei pannelli di gestione non c'e' tenant corrente: nessun filtro, il super admin vede tutto.

## Checklist di sicurezza (dalla documentazione Filament 5)

1. **Scoping non e' autorizzazione**: servono comunque le policy. `canAccessTenant()` e'
   il controllo sull'URL, non sui record.
2. **Validazione**: `unique`/`exists` di Laravel ignorano gli scope → nel pannello cliente
   usare `->scopedUnique()` / `->scopedExists()`.
3. **`withoutGlobalScopes()`** toglie anche l'isolamento. Per togliere altri scope usare
   `withoutGlobalScopes([...])`; l'accesso cross-tenant voluto va autorizzato a parte.
4. **Livewire**: relation manager, widget, select di modali e proprieta' pubbliche non
   rifanno il binding sul tenant → affidarsi a `TenantScope` o controllare a mano.
5. **Query builder** (`DB::table()`) non applica gli scope Eloquent.
6. **Middleware tenant** che aggiungono scope a modelli senza resource:
   `->tenantMiddleware([...], isPersistent: true)`, altrimenti girano solo al primo caricamento.
7. **Registrazione tenant**: nel pannello cliente resta spenta. I clienti li crea il super
   admin; un utente senza tenant non deve poter crearsene uno.

## Riferimenti

- https://filamentphp.com/docs/5.x/users/tenancy
- https://github.com/tomatophp/filament-tenancy
- `Modules/Xot/docs/panel-provider.md` — `$hasTenancy`, `$componentsDirectory`
