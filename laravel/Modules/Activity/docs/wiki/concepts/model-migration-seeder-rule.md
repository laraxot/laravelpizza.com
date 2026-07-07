---
name: model-migration-seeder-rule
description: Implementation of 1 model = 1 migration + 1 seeder rule for Activity module
metadata:
  type: reference
---

# Regola: 1 Modello = 1 Migration + 1 Seeder — Modulo Activity

## Stato Attuale (2026-06-30)

| Elemento | Count | Note |
|----------|-------|------|
| Modelli Concrete | 3 (Activity, Snapshot, StoredEvent) | BaseModel è astratto |
| Migrations | 15 | Include 3 duplicate + _bak |
| Seeders | 3 | Corretto |

## Aree da Risolvere

### 1. Migrations Duplicate
```
2023_03_31_103350_create_activity_table.php
2023_03_31_103351_create_activity_table.php
2024_01_01_000001_create_activity_table.php
2024_01_01_000002_create_activity_table.php
2026_06_10_141000_create_activity_table.php
```

**Azione**: Mantieni solo `2026_06_10_141000_create_activity_table.php` (la più recente)

### 2. Seeders Mancanti
- ActivitySeeder ✓
- SnapshotSeeder ✓
- StoredEventSeeder ✓

## Piano di Risoluzione

1. [x] Rinomina migration duplicate in migration_bak (conferma utente)
2. [ ] Verifica PHPStan dopo pulizia
3. [ ] Aggiorna MigrationSeederRule nel modulo

## Dettaglio Modelli

| Modello | Table | Migration | Seeder | Status |
|--------|-------|-----------|--------|--------|
| Activity | activities | ✓ | ✓ | ✅ Completo |
| Snapshot | snapshots | ✓ | ✓ | ✅ Completo |
| StoredEvent | stored_events | ✓ | ✓ | ✅ Completo |
| BaseModel | N/A | ❌ | ❌ | ✅ Base astratto |

## Policy
| Modello | Policy |
|--------|--------|
| Activity | ActivityPolicy |
| Snapshot | SnapshotPolicy |
| StoredEvent | StoredEventPolicy |

## Note Architetturali
- Le policies seguono il modello 1:1 con i modelli
- BaseModel è astratto (no table)