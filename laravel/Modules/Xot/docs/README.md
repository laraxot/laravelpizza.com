# Modulo Xot - Documentazione

## Overview

Il modulo **Xot** è il nucleo fondativo dell'intero progetto [PROJECT_NAME] platform. Fornisce classi base, trait, servizi e configurazioni condivise da tutti gli altri moduli.

## Architettura

### Classi Base Principali

| Classe | Scopo | Estende |
|--------|-------|---------|
| `XotBaseModel` | Modello base per tutti i moduli | `Illuminate\Database\Eloquent\Model` |
| `XotBaseMigration` | Migrazioni anonime standardizzate | `Illuminate\Database\Migrations\Migration` |
| `XotBaseResource` | Risorse Filament base | `Filament\Resources\Resource` |
| `XotBaseServiceProvider` | ServiceProvider modulare | `Illuminate\Support\ServiceProvider` |
| `XotBaseWidget` | Widget Filament base | `Filament\Widgets\Widget` |
| `XotBaseWizardWidget` | Widget con form wizard multi-step (Filament `Wizard` / `Step`) | `XotBaseWidget` |

### Trait Fondamentali

- `HasXotTable`: Gestione tabelle Filament centralizzata
- `InteractsWithForms`: Gestione form nei widget
- `RelationX`: Relazioni many-to-many estese

## Collegamenti
- [Vite Configuration](./vite-configuration.md)
- [Theme Assets Workflow](./theme-assets-workflow.md)
- [BMAD Method (progetto)](../../../docs/bmad/setup-guide.md) — processo AI/agile e artefatti `_bmad-output/`

- [Documentazione Root](../../../docs/XOT_MODULE.md)
- [Regole Architettura](./architecture/)
- [PHPStan Configuration](./phpstan/)

## Regole Critiche

1. **MAI estendere direttamente classi Laravel/Filament** - Usare sempre wrapper Xot
2. **Configurazione PHPStan solo in `laravel/phpstan.neon`**
3. **Tutte le migrazioni devono usare classi anonime**

## Backlinks

- [User Module](../User/docs/)
- [UI Module](../UI/docs/)
- [Tenant Module](../Tenant/docs/)

## LLM Wiki Workflow

- Canonical wiki layer: [../../../../docs/wiki/README.md](../../../../docs/wiki/README.md)
- Governance page: [../../../../docs/wiki/concepts/llm-wiki-governance.md](../../../../docs/wiki/concepts/llm-wiki-governance.md)


## Standard Rules & Workflow

- [[BMAD Method](../../../../docs/wiki/concepts/bmad-method.md)]
- [[Context Engineering](../../../../docs/wiki/concepts/context-engineering.md)]
- [[LLM Wiki Governance](../../../../docs/wiki/concepts/llm-wiki-governance.md)]
