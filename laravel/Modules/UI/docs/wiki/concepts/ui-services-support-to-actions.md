---
title: "UI Services and Support to Actions mapping"
type: concept
module: UI
tags: [ui, actions, adapters, queueable-action, migration]
created: 2026-07-13
updated: 2026-07-13
qmd: "UI module services support converted to actions adapters queueable action"
issues: []
discussions: []
related:
  - ../../Xot/docs/wiki/concepts/queueable-action-trait-mandatory.md
  - ../../Xot/docs/wiki/concepts/no-app-support-queueable-actions.md
---

# UI Services/Support → Actions/Adapters mapping

## Riepilogo conversione

Tutti i file in `app/Services/` e `app/Support/` del modulo UI sono stati convertiti o rimossi.

Revisione 2026-07-13 (reconciliation pass): gli stub `ComponentAction`, `ThemeAction` e
`UIAction` creati dalla prima migrazione sono stati **eliminati**, non mantenuti. Motivo:
i `Service` legacy corrispondenti (`ComponentService`, `ThemeService`) erano già classi
vuote senza alcun metodo, quindi non c'era logica da preservare; `UIService::asset()` era
un semplice passthrough verso `Modules\Xot\Actions\File\AssetAction::execute()` senza
alcun valore aggiunto e senza chiamanti in produzione. Mantenere questi wrapper avrebbe
violato sia YAGNI sia la regola "un solo `execute()` pubblico, nessun metodo statico
accessorio" (violata da `UIAction`, che aveva sia `asset()` statico sia un `execute(): void {}`
vuoto solo per conformarsi al trait).

Nota bene: `GetThemeAction`, `SetThemeAction`, `IsThemeAction`, `GetThemePathAction`
vivono nel modulo **Xot** (`Modules/Xot/app/Actions/Theme/`), non in UI. Non sono
correlati al vecchio `Modules\UI\Services\ThemeService` (che era già vuoto): sostituiscono
invece `Modules\Xot\Services\ThemeService` (archiviato). Nessuna duplicazione tra i due.

## Mapping

| Legacy path | Nuovo path | Tipo | Note |
|-------------|-----------|------|------|
| `Services/ComponentService.php` | *(eliminato)* | — | classe vuota, nessun caller, nessuna Action creata |
| `Services/ThemeService.php` | *(eliminato)* | — | classe vuota, nessun caller, nessuna Action creata |
| `Services/UIService.php` | *(eliminato)* | — | `asset()` era solo passthrough di `Xot\Actions\File\AssetAction`; nessun caller in produzione, chiamare direttamente `app(AssetAction::class)->execute($path)` se serve |
| `Services/Map/NullMapService.php` | `Adapters/Map/NullMapServiceAdapter.php` | Adapter | implementa `MapServiceContract` |
| `Services/Map/NullGeocodingService.php` | `Adapters/Map/NullGeocodingServiceAdapter.php` | Adapter | implementa `GeocodingServiceContract` |

## Chiamanti aggiornati

Nessun chiamante PHP in `Modules/*` o `Themes/*` da aggiornare: i Service non avevano
consumer in codice produzione, e i loro stub Action (rimossi in questa revisione)
non avevano a loro volta consumer.

## File eliminati

- `app/Services/` (directory intera, prima migrazione)
- `app/Support/` (non presente nel modulo UI)
- `app/Actions/ComponentAction.php`, `app/Actions/ThemeAction.php`, `app/Actions/UIAction.php`
  (stub introdotti dalla prima migrazione, eliminati in questa revisione perché privi di
  logica non duplicata altrove e privi di chiamanti)

## Controlli

- Nessun marker di conflitto git nei file toccati.
- Phpstan, Phpmd, Phpinsights e Pest eseguiti su `Modules/UI`.
