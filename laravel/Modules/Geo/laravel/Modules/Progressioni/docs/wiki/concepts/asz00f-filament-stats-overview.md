---
title: "Concetto — stats overview Asz00f (assenze Sigma attive)"
type: concept
tags: [asz00f, filament, stats-overview, sigma, progressioni]
related:
  - ../../../Sigma/docs/wiki/concepts/asz-scheda-relationship.md
  - ../../filament-resource-schemas-tables.md
  - ../../filament-version.md
---

# Stats overview Asz00fResource

## Scopo

Nella lista Filament `Asz00fResource` mostrare un riepilogo rapido delle **assenze Sigma attive** prima della tabella CRUD.

Riferimento Filament 5: [stats overview widgets](https://filamentphp.com/docs/5.x/widgets/stats-overview).

## Business logic

| Concetto | Regola |
| :--- | :--- |
| Record attivo | `aszann = ''` — non annullato, non annualizzato |
| Conteggio | `COUNT(*)` sui record attivi |
| Minimi `asz2kd` | 10 valori **distinti** più bassi (`asz2kd > 0`), formato `YYYYMMDD` |
| Massimi `asz2ka` | 10 valori **distinti** più alti (`asz2ka > 0`), formato `YYYYMMDD` |

Il global scope su `BaseAsz00f` filtra già `aszann = ''`; l'action ripete il filtro per esplicitare la regola di dominio.

## Implementazione

| Componente | Path |
| :--- | :--- |
| Action | `app/Actions/GetAsz00fActiveStatsAction.php` |
| DTO | `app/Datas/Asz00fActiveStatsData.php` |
| Widget | `app/Filament/Resources/Asz00fResource/Widgets/Asz00fStatsOverview.php` |
| Wire lista | `ListAsz00fs::getHeaderWidgets()` |
| Registrazione | `Asz00fResource::getWidgets()` |

Estende `XotBaseStatsOverviewWidget`; polling disabilitato (`$pollingInterval = null`) per evitare query ripetute su tabella Sigma voluminosa.

## Card mostrate

1. **Record attivi** — totale con `aszann` vuoto
2. **10 asz2kd più bassi** — primo valore in evidenza, altri 9 in descrizione
3. **10 asz2ka più alti** — stesso pattern

## Filtri tabella

Su `ListAsz00fs` (come `ListRatings`):

- `getTableFiltersLayout()` → `FiltersLayout::Dropdown` (hook `HasXotTable`, **senza** override di `table()`)
- filtro `ricerca` con campi opzionali `ente`, `matr`, `asztip`, `aszcod`
- pulsante **Applica** nella modale filtri (default Filament)

## Collegamenti

- [Relazione asz su schede](../../../Sigma/docs/wiki/concepts/asz-scheda-relationship.md)
- [Scaffold Filament Progressioni](../../filament-resource-schemas-tables.md)
- [Widget stats base Xot](../../../Xot/docs/filament/xotbase-stats-overview-widget.md)
