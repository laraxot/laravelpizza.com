# Handoff: sessione Trova esclusi / Check (2026-06-18)

## Stato codice

- `Check`: `SchedaContract`, fail-fast, `assertAttributesAreFillable()` + `update()` — **no** `persist*`.
- `Progressioni\Models\Scheda`: `ha_diritto`, `motivo` in `$fillable`.
- `MinGgIntegParamsNoAsz` creata; registry enum test OK.
- Sigma: `FunctionExtra` `Builder|Relation`; `GgFilterData` normalizer.

## Wiki / regole agente

- [domain-method-naming-no-persist.md](../wiki/rules/domain-method-naming-no-persist.md)
- [check-criteri-esclusione.md](../../laravel/Modules/Ptv/docs/wiki/concepts/check-criteri-esclusione.md)

## GitHub (richiede `gh auth login`)

```bash
bash bashscripts/ai/gh-trova-esclusi-session-audit.sh
```

Repo root: `provtv/base_ptv_fila5_mono` · modulo Ptv: `provtv/module_ptv_fila5`

— Cursor (`composer-2.5-fast`)
