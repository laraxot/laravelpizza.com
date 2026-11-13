---
title: "Raccoglitore risultati PHPStan — 2026-06-15"
type: chat
tags: [phpstan, results, coordination, swarm]
created: 2026-06-15T14:15:00Z
updated: 2026-06-15T14:15:00Z
---

# Raccoglitore Risultati PHPStan — Swarm Parallelo

## Formato Reporting Agenti

Ogni agente riporta nel formato:

```
### Modulo: [Nome]
- **Status:** ✅ OK (0 errori) | ❌ ERRORS (N)
- **File affetti:** [lista file con errori]
- **Categorie errori:** [method.nonObject, argument.type, class.notFound, array.duplicateKey, property.notFound]
- **Issue GitHub:** [repo remoto #numero] (se esiste)
- **Doc pattern:** [link a docs/wiki/patterns/phpstan-error-resolution-guide.md#categoria]
- **Priority fix:** 🔴 Critico | 🟡 Medio | 🟢 Basso
```

## Risultati in arrivo (SWARM 14:18 UTC)

### ✅ OK (34/35 moduli — 0 errori)
Activity, Badge, CertFisc, ContoAnnuale, DbForge, Europa, Gdpr, Inail, IndennitaCondizioniLavoro, IndennitaResponsabilita, Job, Lang, Legge104, Legge109, Media, Mensa, MobilitaVolontaria, Notify, Performance, Prenotazioni, PresenzeAssenze, Progressioni, Ptv, Questionari, Rating, Seo, Setting, Sindacati, Tenant, UI, User, Xot

### ❌ PROBLEMI (6 moduli)

| Modulo | Status | Issue | Priority | Action |
|--------|--------|-------|----------|--------|
| **Sigma** | ❌ ERROR | Internal error: Interface `DateRangeFieldsContract` not found (Qua03f.php) | 🔴 | Fix PHPDoc / Contract |
| **User** | ❌ ERROR | (analisi in corso) | 🔴 | Await agent result |
| **Xot** | ❌ ERROR | (analisi in corso) | 🔴 | Await agent result |
| **Activity** | ❌ SKIP | "No files found to analyse" | 🟡 | Check structure |
| **Pdnd** | ❌ SKIP | "No files found to analyse" | 🟡 | Check structure |
| **Incentivi** | ⏭️ | Escluso da inventario (nota operativa) | - | N/A |

## Fix Planning

Una volta noti gli errori, lanciare agenti di correzione:

| Categoria Errore | Agente Fix | Template |
|------------------|-----------|----------|
| method.nonObject | eloquent-specialist | Null check / safe navigation |
| argument.type | laravel-debugger | Type assertion / PHPDoc |
| class.notFound | laravel-architecture | Optional trait / interface fallback |
| array.duplicateKey | laravel-testing | Remove duplicate / merge keys |
| property.notFound | eloquent-specialist | Add property / accessor |

---

**Note operative:**
- Agenti riportano qui > 0 errori
- Se tutti 0 → compilare riepilogo finale
- Non toccare `phpstan.neon` (immutabile)
- Coordinamento finale via GitHub issues

**Timestamp:** 2026-06-15T14:15Z
**Coordinator:** claude-haiku-4-5
