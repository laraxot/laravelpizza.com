<<<<<<< .merge_file_ZTsTQv
# Activity vs Platform.AuditLog — Mappatura e Gap Analysis
=======
---
title: "Activity vs Platform.AuditLog: Mappatura e Gap Analysis"
type: note
status: draft
updated: 2026-10-07
tags: [docs, activity]
qmd: "activity vs platform.auditlog   mappatura e gap analysis activity"
---
# Activity vs Platform.AuditLog: Mappatura e Gap Analysis
>>>>>>> .merge_file_2b6Wsl

> Ultimo aggiornamento: 2026-07-23

## Panoramica

| Aspetto | Gestionale Commesse | Base Workorder Fila5 |
|---------|-------------------|---------------------|
| **Modulo SRC** | `Modules/Platform` (parziale: `AuditLog`) | `Modules/Activity` |
| **Ruolo** | Audit logging delle azioni utente | Tracciamento attività event-sourced con snapshot |
<<<<<<< .merge_file_ZTsTQv
| **Stato mapping** | VICINO — Activity è più ricco, copre AuditLog ~90% | |
=======
| **Stato mapping** | VICINO: Activity è più ricco, copre AuditLog ~90% | |
>>>>>>> .merge_file_2b6Wsl

---

## Cosa fa Platform.AuditLog (SRC)

<<<<<<< .merge_file_ZTsTQv
- **Modello `AuditLog`** — tabella `audit_logs`
=======
- **Modello `AuditLog`**: tabella `audit_logs`
>>>>>>> .merge_file_2b6Wsl
- Campi: `user_id`, `action` (string), `auditable_type` (morph), `auditable_id` (morph), `old_values` (json), `new_values` (json), `ip_address`, `user_agent`
- **Filament Resource**: `AuditLogResource` (read-only: List + View)
- Logga modifiche a modelli, login/logout, azioni utente
- Nessun event sourcing, nessuno snapshot

## Cosa fa Activity (nostro)

- **Modelli**: `Activity`, `Snapshot`, `StoredEvent`, `TestModel`
- **Filament Resources**: `ActivityResource`, `SnapshotResource`, `StoredEventResource`
<<<<<<< .merge_file_ZTsTQv
- **Pattern event sourcing** — `StoredEvent` tiene la cronologia eventi, `Snapshot` cattura stato aggregato a un punto nel tempo
- **Activity restore** — possibilità di ripristinare stato da eventi + snapshot
=======
- **Pattern event sourcing**: `StoredEvent` tiene la cronologia eventi, `Snapshot` cattura stato aggregato a un punto nel tempo
- **Activity restore**: possibilità di ripristinare stato da eventi + snapshot
>>>>>>> .merge_file_2b6Wsl
- Più ricco e complesso del semplice audit log

---

## Gap Analysis

| Funzionalità | Platform.AuditLog | Activity (nostro) | Gap |
|-------------|------------------|-------------------|-----|
| Log modifiche model | ✅ `auditable` morph + `old_values/new_values` | ✅ `StoredEvent` | **Equivalente** (pattern diverso) |
| Log login/logout | ✅ `action` field | ✅ `Activity` model | **Equivalente** |
| UI read-only audit log | ✅ `AuditLogResource` (List + View) | ✅ `ActivityResource` | **Equivalente** | 
| Event sourcing | ❌ | ✅ `StoredEvent` + `Snapshot` | Nostro extra |
| Activity restoration | ❌ | ✅ Da eventi/snapshot | Nostro extra |
| Platform settings (stesso modulo) | ✅ `PlatformSetting` | ❌ (vedi Tenant) | Non compete |

---

## Note

<<<<<<< .merge_file_ZTsTQv
- **Activity è già superiore** a AuditLog — non serve creare nulla
- Il gap vero è che Platform ha anche `PlatformSetting` (settings key-value) — quello va mappato su Tenant/Xot
=======
- **Activity è già superiore** a AuditLog: non serve creare nulla
- Il gap vero è che Platform ha anche `PlatformSetting` (settings key-value): quello va mappato su Tenant/Xot
>>>>>>> .merge_file_2b6Wsl
- Activity è già usato in produzione su base_workorder_fila5
- Nessuna azione necessaria su Activity

---

## Riferimenti

- SRC Platform: `/var/www/_bases/gestionale_commesse/Modules/Platform/`
- Nostro: `/var/www/_bases/base_workorder_fila5/laravel/Modules/Activity/`
- Story: `docs/wiki/skills/bmad-create-story/stories/gestionale-commesse-module-parity.story.md`
