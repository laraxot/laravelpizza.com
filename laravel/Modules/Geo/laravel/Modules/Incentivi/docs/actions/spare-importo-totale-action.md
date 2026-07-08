# SpareImportoTotaleAction

## Overview
The `SpareImportoTotaleAction` is a Spatie Queueable Action responsible for calculating and distributing the total incentive fund based on the project amount and the incentive type.

## Purpose
In the PTVX Incentivi module, the incentive fund is not a fixed amount but depends on a percentage of the total project value. This percentage varies based on the "Tipologia" (Type) of the incentive and the project's budget range, as defined in the `CapitalPercentage` model.

## Logic
1.  **Retrieve Parameters:** It takes the project `amount`, and Filament's `Get` and `Set` utilities.
2.  **Lookup Percentage:** It queries the `CapitalPercentage` table to find the record where the `tipologia` matches and the `amount` falls within the defined range (`da` and `a`).
3.  **Calculate Fund:**
    *   Calculates the `percentuale_fondo` (Fund Percentage).
    *   Calculates the `importo_effettivo_fondo` (Actual Fund Amount) as `amount * percentage / 100`.
4.  **Split Components:**
    *   `componente_incentivante` (Incentive Component): 80% of the actual fund.
    *   `componente_innovazione` (Innovation Component): 20% of the actual fund.
5.  **Update Form:** Uses the `Set` utility to update the Filament form state in real-time.

## Usage
Typically invoked within a Filament form's `afterStateUpdated` hook for the `importo_totale` or `tipo` fields.

```php
TextInput::make('importo_totale')
    ->afterStateUpdated(fn ($state, Get $get, Set $set) => app(SpareImportoTotaleAction::class)->execute((float)$state, $get, $set))
```

## Dependencies
- `Modules\Incentivi\Models\CapitalPercentage`
- `Spatie\QueueableAction\QueueableAction`
