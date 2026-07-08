---
title: "UI Module Documentation"
type: documentation
tags: [module, documentation]
created: 2026-06-05
updated: 2026-06-05
---

# Modulo UI - Componenti Condivisi

## Overview

Il modulo **UI** fornisce componenti Blade, widget Filament e asset condivisi per tutti i moduli e temi.

## Struttura Componenti

```
resources/views/components/ui/
├── buttons/
│   ├── primary.blade.php
│   └── secondary.blade.php
├── cards/
│   ├── base.blade.php
│   └── collapsible.blade.php
├── forms/
│   ├── input.blade.php
│   └── select.blade.php
└── layout/
    ├── container.blade.php
    └── divider.blade.php
```

## Utilizzo

```blade
<x-ui::ui.button type="primary">
    Salva
</x-ui::ui.button>

<x-ui::ui.card>
    Contenuto
</x-ui::ui.card>
```

## Widget Filament

- `CalendarWidget`: FullCalendar integration
- `StatsOverviewWidget`: Statistiche dashboard
- `ChartWidget`: Grafici integrati

## Collegamenti

- [Regole Posizionamento](../../.cursor/rules/ui-components-rules.mdc)
- [Filament Widgets](./widgets/)

## Regole Fondamentali

1. **MAI posizionare componenti in root** - Usare solo `Modules/UI/resources/views/components/ui/`
2. **Prefisso obbligatorio** - Usare `<x-ui::ui.componente />`
3. **PHPDoc completo** per ogni componente

## Backlinks

- [Xot Base](../Xot/docs/)
- [User Module](../User/docs/)

## AI Workflows
- [AI Methodologies](./ai-methodologies.md)
||||||| parent of 9a84589 (.)
    case LIST = 'list';
    case GRID = 'grid';

    public function getLabel(): string
    {
        return $this->transClass(self::class, $this->value . '.label');
    }
}
```

## ✅ Stato Qualità

- **PHPStan Level 10**: ✅ Compliant
- **Translation Standards**: ✅ 100%
- **Componenti**: 50+ Blade components
- **Widget**: 20+ Filament widgets

## 📚 Documentazione

- [Components Guide](components.md)
- [TableLayoutEnum Guide](table-layout-enum-complete-guide.md)
- [Filament Components](filament-components.md)

## 🔗 Moduli Collegati

- [Xot Module](../xot/docs/readme.md) - Framework core
- [User Module](../user/docs/readme.md) - Gestione utenti
- [Lang Module](../lang/docs/readme.md) - Traduzioni

---

**🔄 
**📦 Versione**: 4.1.0

## 🔁 CI & Semantic Versioning
Workflow: `.github/workflows/semantic-versioning.yml`

## 📄 License
MIT


## Standard Rules & Workflow

- [[BMAD Method](../../../../docs/wiki/concepts/bmad-method.md)]
- [[Context Engineering](../../../../docs/wiki/concepts/context-engineering.md)]
- [[LLM Wiki Governance](../../../../docs/wiki/concepts/llm-wiki-governance.md)]

## Documentation

- [On-Demand Pattern](./ON-DEMAND-PATTERN.md) — Pattern per caricamento efficiente
- [QMD Setup](./QMD-SETUP.md) — Configurazione ricerca locale
- [Performance](./PERFORMANCE-OPTIMIZATION.md) — Metriche e best practice
- [Project Structure](./PROJECT-STRUCTURE.md) — Directory layout