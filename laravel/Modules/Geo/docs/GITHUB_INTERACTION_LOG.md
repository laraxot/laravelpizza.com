# GitHub Interaction Log — Module Geo

**Data:** 2026-06-03  
**Agent:** AI Agent  
**Scope:** Aggiornamento completo issues e discussions

---

## Issues Aggiornate

### STORY-123 — Cluster Stability
- **#28** — Marker cluster vibrate/flee → Fix dettagliato
- **#27** — Cluster scappano al hover → Link a #28, risolto
- **#24** — Marker scompaiono al pan/zoom → Root cause: `refreshClusters()` race condition

### STORY-122 — GPS Centering
- **#26** — GPS center + cluster stabili → Pattern lat/lng implicito (NO center-on-gps)
- **#25** — Marker stabili + GPS → Risolto (pattern implicito)

### STORY-121 — Map Visibility
- **#23** — SSoT tickets.json → Verificato, 12 marker funzionanti
- **#22** — filterByTypes → Allineato a facet GeoJSON
- **#21** — IT/EN/mobile parity → Verificato
- **#19** — Map component verification → Completato

### Design & Architecture
- **#17** — No CSS dominio → Verificato
- **#16** — Design Comuni CSS class names → Verificato
- **#14** — Map legend colors → Completato
- **#13/#12** — Icona trash dimensioni → Fix 80x80px
- **#11** — Map-filter-lit sidebar → Completato
- **#9** — Studio farmshops.eu → Pattern applicati
- **#4** — Segnalazioni-elenco marker → Completato
- **#3** — Legacy map shims → Rimossi
- **#2** — .old backup files → Puliti
- **#1** — COPILOT Redundancy → Aggiornato

---

## Discussions Aggiornate

| # | Titolo | Commento |
|---|--------|----------|
| D29 | Fix cluster fleeing hover | ✅ STORY-123 risolto |
| D20 | STORY-110 parity | ✅ Completato |
| D18 | RULE CSS class names | ✅ Verificato |
| D15 | STORY-094 legend | ✅ Funzionante |
| D10 | Map-filter-lit sidebar | ✅ Fixato |
| D6 | Lat/lng implicito | ✅ Pattern implementato (no center-on-gps) |
| D5 | Pattern architetturali | ✅ STORY-122/123/124 risolti |

---

## Comandi Utilizzati

```bash
# Issues
cd /var/www/_bases/base_fixcity_fila5
gh issue list --repo laraxot/module_geo_fila5 --state all
gh issue comment <number> --repo laraxot/module_geo_fila5 --body "..."

# Discussions (GraphQL)
curl -s -X POST "https://api.github.com/graphql" \
  -H "Authorization: bearer $(gh auth token)" \
  -H "Content-Type: application/json" \
  -d '{"query": "mutation { addDiscussionComment(...) }"}'
```

---

## Lessons Learned

1. **Issue Duplicates:** #27 e #28 erano duplicate — cross-referenziare
2. **Discussion IDs:** Necessario usare GraphQL API con `node_id` (es: `D_kwDOQ9bm1M4Amu_q`)
3. **Comment Format:** JSON escapato richiesto per GraphQL
4. **Pattern Documentation:** Ogni fix deve avere issue GitHub correlata

---

## Prossimi Passi Suggeriti

1. Chiudere issues risolte (#28, #27, #25, #24, etc.)
2. Aggiornare labels (add `resolved`, `verified`)
3. Creare milestone per STORY-121/122/123
