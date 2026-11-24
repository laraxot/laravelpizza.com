# Perfection Audit — User Module

**Data**: 2026-09-01
**Scope**: `laravel/Modules/User/docs/`
**Metodo**: BMAD document-project + fix_docs_naming_convention.sh

---

## TL;DR

User ha **1,465 file .md** (100% uppercase) con **48 stub vuoti**. Terzo modulo per bloat. Tutti i file violano `kebab-case.md`.

**Stato attuale**: lontano dalla perfezione. Bonifica urgente.

---

## Numeri

| Metrica | Valore | Soglia salute |
|---------|--------|---------------|
| File .md totali | 1,465 | <150 |
| Stub (<100 byte) | 48 | 0 |
| Uppercase .md | 1,465 (100%) | 0 (eccetto README.md) |

---

## Problemi P0

### P0.1 — 100% uppercase
Tutti i file in `User/docs/` sono maiuscoli.

### P0.2 — 48 stub vuoti
Residui di iterazioni agenti.

### P0.3 — Nessun indice consolidato

---

## Piano bonifica

Identico a Notify (vedi `PERFECTION_AUDIT.md` in Notify/docs/).

### Fase 1 — Emergency
```bash
find laravel/Modules/User/docs -name "*.md" -size -100c -delete
```

### Fase 2 — Rename ricorsivo
```bash
find laravel/Modules/User/docs -type f -name "*.md" \
  -not -name "README.md" \
  | while read f; do
      dir=$(dirname "$f")
      base=$(basename "$f" .md)
      lower=$(echo "$base" | tr '[:upper:]' '[:lower:]' | tr '_' '-')
      mv "$f" "$dir/$lower.md"
  done
```

### Fase 3 — Consolidamento
Merge file duplicati in un solo indice.

---

## Soglia di accettabilità

| Metrica | Target |
|---------|--------|
| File .md totali in User/docs | <150 |
| Stub vuoti | 0 |
| File uppercase (no README) | 0 |
| Indice consolidato | 1 (`00-index.md`) |

---

## Riferimenti

- `laravel/Modules/docs/DOCUMENTATION_AUDIT.md`
- `docs/super-mucca/SKILL.md`