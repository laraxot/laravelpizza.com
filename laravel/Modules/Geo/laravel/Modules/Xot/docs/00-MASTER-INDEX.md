# 🌐 Laraxot Master Documentation Index

**Status**: Active / Sanity Layer  
**Last Updated**: 2026-04-14  
**Category**: Global / Architecture  

---

## 🏛 Core Architecture (The Religion)

| Document | Description | Source of Truth |
|---|---|---|
| **[XotBase Philosophy](./XOTBASE_ARCHITECTURE_PHILOSOPHY.md)** | Why we always extend XotBase classes. | ✅ CANONICAL |
| **[Laraxot Commandments](./laraxot-10-commandments-wiki.md)** | The 10 fundamental rules of the project. | ✅ CANONICAL |
| **[Development Philosophy](./philosophy/index.md)** | Principle of forward-only, DRY, KISS, Zen. | ✅ CANONICAL |

---

## 🧩 Filament Framework Patterns (The Zen)

| Document | Category | Purpose |
|---|---|---|
| **[Filament Widget Index](./filament/widgets/index.md)** | Widgets | Central hub for all Wizard and Table widget rules. |
| **[Infolists for Summary](./filament/widgets/infolists-for-summary.md)** | Wizards | Why and how to use Infolists for Wizard summaries. |
| **[AutoLabel Guidelines](../../UI/docs/autolabel-guidelines.md)** | i18n | The "No explicit label" rule explained. |
| **[XotBaseWizardWidget](./filament/widgets/xot-base-wizard-widget-philosophy.md)** | Wizards | Logic cross-cutting for multi-step forms. |

---

## 🏗 Module-Specific Documentation

- **[Fixcity Module](../../Fixcity/docs/INDEX.md)**: Tickets, Wizards, and Frontoffice integration.
- **[Geo Module](../../Geo/docs/INDEX.md)**: Geolocation and Map components.
- **[Predict Module](../../Predict/docs/00-INDEX.md)**: Outcomes and Market logic.

---

## ⚠️ Documentation Hygiene (IMPORTANT)

To prevent redundancy and "Documentation Hell":

1. **Check for existing documents** before creating new ones.
2. **NEVER** create files with suffixes like `-1`, `-copy`, `-conflict` unless explicitly required for temporary merge resolution.
3. **Canonical over Local**: If a rule applies to all modules, it belongs in `Modules/Xot/docs/`. Modules should only link to it.
4. **Logic vs Dress**: 
   - Module docs (`Modules/*/docs/`) = Business rules, logic, endpoints.
   - Theme docs (`Themes/*/docs/`) = Visuals, components, styles.

### 🧹 Candidates for Deletion (Mess Detection)
Files in `Modules/Xot/docs/` that are NOT in this index and have numeric suffixes or "conflict" in the name are likely redundant and should be consolidated or removed.

---

## 🔍 Search Faster

Use the specialized indexes for deep dives:
- [Filament Detailed Index](./filament/index.md)
- [Architecture Detailed Index](./architecture/index.md)
- [PHPStan Fixes Index](./phpstan/index.md)

---

*Ultimo aggiornamento: 2026-04-14 — Mantieni questo indice pulito e autoritativo.*
