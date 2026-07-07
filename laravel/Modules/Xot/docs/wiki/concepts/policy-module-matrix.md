# Policy module matrix

## Scopo

Matrice operativa per decidere la base policy per modulo, mantenendo DRY + KISS.

## Criterio

- **Base consigliata: `XotBasePolicy`**
  - moduli tecnici, infrastrutturali, cross-modulo
- **Base consigliata: `UserBasePolicy`**
  - moduli identity/access dove la semantica utente e' primaria

## Matrice modulo -> base policy

| Modulo | Stato osservato | Base consigliata | Priorita' |
|---|---|---|---|
| Xot | policy dirette su `XotBasePolicy` | `XotBasePolicy` | mantenere |
| User | policy prevalenti su `UserBasePolicy` (con alcune su `XotBasePolicy`) | `UserBasePolicy` per dominio identity; `XotBasePolicy` solo eccezioni tecniche | chiarire eccezioni |
| Notify | `NotifyBasePolicy` estende `UserBasePolicy` | `UserBasePolicy` | mantenere |
| Activity | policy dirette su `UserBasePolicy` + `ActivityBasePolicy` locale | `UserBasePolicy` se audit actor-centric, altrimenti `XotBasePolicy` | revisione media |
| Job | mix `JobBasePolicy` locale + alcune policy dirette `UserBasePolicy` | `XotBasePolicy` via base locale, salvo policy identity-specific | revisione media |
| Rating | policy su `XotBasePolicy` | `XotBasePolicy` | mantenere |
| Geo | policy tramite `GeoBasePolicy` locale neutra | `XotBasePolicy` via base locale | mantenere |
| Cms | policy tramite `CmsBasePolicy` locale neutra | `XotBasePolicy` via base locale | mantenere |
| Media | policy tramite `MediaBasePolicy` locale neutra | `XotBasePolicy` via base locale | mantenere |
| Lang | policy tramite `LangBasePolicy` locale neutra | `XotBasePolicy` via base locale | mantenere |
| Gdpr | policy tramite `GdprBasePolicy` locale neutra | `XotBasePolicy` via base locale | mantenere |
| Tenant | policy tramite `TenantBasePolicy` locale | `XotBasePolicy` via base locale, `UserBasePolicy` solo se ACL identity-heavy | revisione leggera |
| Fixcity | presenti policy dirette senza base comune forte | `XotBasePolicy` per business core; `UserBasePolicy` solo dove identity-driven | revisione alta |

## Inventario quantitativo (2026-06-30)

Comando: `bash bashscripts/tools/audit-policy-inventory.sh`

| Modulo | Policy modello | Note |
|--------|----------------|------|
| Job | 15/15 | gold standard — `ExportPolicy extends JobBasePolicy {}` |
| User | 37 | orphan intenzionali: `BaseUserPolicy`, `BaseTeamPolicy` |
| Blog, Predict | 0 | ereditarietà Article / ArticleResource — vedi [policy-module-inventory.md](../../../../../../docs/wiki/concepts/policy-module-inventory.md) |
| Comment, UI, Tenant | gap | remediation = **creare** policy, mai delete altrove |

Hub completo: [policy-module-inventory.md](../../../../../../docs/wiki/concepts/policy-module-inventory.md)

## Note pratiche

- i base policy locali di modulo sono utili, ma dovrebbero derivare da una linea guida esplicita (Xot-first o User-first)
- evitare policy nuove "isolated" senza estendere una base condivisa, salvo eccezioni documentate
- in caso di dubbio, default su `XotBasePolicy`
- **non eliminare** policy modello perché sembrano stub: vedi [model-policy-laravel-contract.md](../../../../../../docs/wiki/concepts/model-policy-laravel-contract.md)

## Miglioramenti consigliati

1. aggiungere in ogni modulo una pagina `policy-governance.md` con:
   - base policy scelta
   - eccezioni
   - motivazione
2. ridurre i casi ibridi non motivati (soprattutto in moduli business)
3. allineare naming dei base policy locali al criterio scelto

## Riferimenti

- [policy base strategy](./policy-base-strategy.md)
- [user policy inheritance boundary](../../../User/docs/wiki/concepts/policy-inheritance-boundary.md)
- [policy rendering boundary](../../../../Themes/Sixteen/docs/wiki/concepts/policy-rendering-boundary.md)
