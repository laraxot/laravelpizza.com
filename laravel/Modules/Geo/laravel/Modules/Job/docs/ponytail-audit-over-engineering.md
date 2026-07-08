# Ponytail audit — Job (over-engineering)

**Ultimo run:** 2026-06-30 (re-run #2)  
**Modulo:** code, schedule, import/export job.  
**Hub:** [../../../../docs/audit/ponytail-audit.md](../../../../docs/audit/ponytail-audit.md)  
**Remediation:** [../../../../docs/project/ponytail-audit-remediation.md](../../../../docs/project/ponytail-audit-remediation.md)  
**GitHub monorepo:** [Issue #221](https://github.com/laraxot/base_predict_fila5/issues/221) · [Discussion #222](https://github.com/laraxot/base_predict_fila5/discussions/222) · [Discussion #228](https://github.com/laraxot/base_predict_fila5/discussions/228)

## Findings

| # | Tag | Cosa | Path | Stato |
|---|-----|------|------|-------|
| J2 | `delete`→`.bak` | `Config.bak` se presente | `Config.bak/` | ✅ assente su disco |

## ⛔ Fuori perimetro audit (non tagliare)

| Area | Motivo |
|------|--------|
| `app/Models/Policies/*Policy.php` | Contratto Laravel/Filament: una policy per modello (`ExportPolicy`, `ImportPolicy`, …). Anche `class XPolicy extends JobBasePolicy {}` senza metodi è **valida** — la logica può stare in `JobBasePolicy::before()` o nei metodi ability del singolo file. **Mai delete.** |

Vedi [wiki/concepts/model-policy-laravel-contract.md](./wiki/concepts/model-policy-laravel-contract.md).

## Collegamenti

- [00-INDEX.md](./00-INDEX.md)
- [Xot audit](../../Xot/docs/ponytail-audit-over-engineering.md)
- [model-policy-laravel-contract.md](./wiki/concepts/model-policy-laravel-contract.md)
- [policy-restoration-incident.md](./policy-restoration-incident.md)
