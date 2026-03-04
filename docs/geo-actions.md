# Geo Actions Architecture

**Date**: [DATE]

## Overview
This document describes the reusable actions available in the Geo module.

## UpdateCoordinatesFromAddressAction
- **Type**: Spatie Queueable Action
- **Namespace**: `Modules\Geo\Actions`
- **Purpose**: Fetches latitude and longitude for a given model based on its address fields and safely updates the record.
- **Dependencies**: `GetAddressDataFromFullAddressAction`.
- **Status**: In uso e riferimento unico per tutti i moduli (TechPlanner, Job, Tenant, ecc.).

## UpdateCoordinatesBulkAction
- **Type**: Filament Bulk Action (riusabile)
- **Namespace**: `Modules\Geo\Filament\Actions`
- **Purpose**: Orchestrates UI flow (modals, notifications) and delegates work to `UpdateCoordinatesFromAddressAction`.
- **Usage**:
  ```php
  use Modules\Geo\Filament\Actions\UpdateCoordinatesBulkAction;

  public function getTableBulkActions(): array
  {
      return [
          UpdateCoordinatesBulkAction::make(),
      ];
  }
  ```

## Backlog DRY + KISS
- [ ] Estrarre un DTO condiviso (es. `UpdateCoordinatesResultData`) per conteggi success/error.
- [ ] Documentare la policy “mai logica inline nelle Page Filament”: tutte le bulk action devono vivere in `Modules\Geo\Filament\Actions`.
- [ ] Programmare integrazione con notifiche broadcast per mostrare in tempo reale l’avanzamento (utile per dataset > 500 record).
