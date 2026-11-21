---
title: "Decision log — Tenant"
type: decision-log
status: active
updated: 2026-11-16
module: Tenant
tags: [docs, tenant, bmad]
created: 2026-10-06
qmd: "decision log Tenant host tenant admin bypass sushi json config alias connessioni file path"
---

# Decision log — Tenant

Verificate sul codice il 2026-11-16. Finding: [audits/tenant-audit.md](./audits/tenant-audit.md).

| ID | Decisione | Stato | Perché | Evidenza |
|---|---|---|---|---|
| D-01 | Il tenant si riconosce dall'host (`SERVER_NAME`, poi `getHost()`), con fallback al default | Attiva, da rivedere (TEN-P1-01) | strategia meno invasiva; ma l'host è input del client | [GetTenantNameAction.php](../../app/Actions/GetTenantNameAction.php) |
| D-02 | La config per ente vive in `config/<tenant>/` e si legge via Action | Attiva | cambiare ente = cambiare configurazione, non codice | [GetTenantConfigPathAction.php](../../app/Actions/Config/GetTenantConfigPathAction.php) |
| D-03 | I percorsi per-tenant passano da `GetTenantFilePathAction`, mai da `base_path()`; rifiuta assoluti, `\0`, `..` | Attiva | `base_path()` ignora il tenant: errore muto | [GetTenantFilePathAction.php](../../app/Actions/Config/GetTenantFilePathAction.php) |
| D-04 | Le connessioni di modulo sono alias della connessione default (una sessione, una transazione); restano separate solo quelle esplicite nella config del tenant | Attiva | transazioni atomiche multi-modulo | `TenantServiceProvider::aliasModuleConnectionsToDefault()` |
| D-05 | Nessuna riconnessione DB sotto test | Attiva | non rompere l'isolamento dei test | `TenantServiceProvider::reconnectDatabaseUnlessTesting()` |
| D-06 | `tenant::admin` e `super-admin` superano le policy del modulo | Attiva (ADR Xot `module-admin-role-policy-bypass`), perimetro da fissare con test (TEN-P1-02) | chi apre il pannello gestisce il modulo | [TenantBasePolicy.php](../../app/Models/Policies/TenantBasePolicy.php) |
| D-07 | Config come JSON/CSV/array letti via Sushi | Attiva | la config è un dato, interrogabile come tabella | `app/Models/Traits/SushiTo*.php` |
| D-08 | Servizi = Action (`app/Services` non esiste) | Attiva | regola PTVX actions-over-services | `rg` 0 service; 19 Action |
| D-09 | Proposta: `TrustHosts` attivo o vhost esplicito | PROPOSTA (Epic A) | chiude TEN-P1-01 | — |
| D-10 | Proposta: `password` con cast `encrypted` + `$hidden`, migrazione additiva | PROPOSTA (Epic C) | chiude TEN-P1-03 | — |

## Formato delle nuove voci

- **ID** progressivo `D-NN`, **Decisione** in una riga.
- **Stato:** PROPOSTA, ATTIVA (approvata), RIFIUTATA, OBSOLETA.
- **Perché:** motivo e alternative considerate; **Evidenza:** file o simbolo reale.
