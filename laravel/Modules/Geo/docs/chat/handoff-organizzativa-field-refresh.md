# Handoff: FieldRefresh su `gg_presenza_dalal` (Organizzativa / Ptv)

## Stato

**Chiuso in codice.** Il `BadMethodCallException` su `getGgPresenzaDalal()` era dovuto alla chiamata dinamica senza verifica; ora l’azione controlla il record e `method_exists` prima di invocare il getter.

## Cosa è in repo

- `laravel/Modules/Xot/app/Filament/Actions/Form/FieldRefreshAction.php`: guard su record, `method_exists($record, $action)`, notifiche `invalid_record` / `method_missing` / `success`.
- `laravel/Modules/Xot/lang/it/field_refresh_action.php` e `en/field_refresh_action.php`: messaggi incluso `method_missing` e placeholder `:name` / `:value` per il successo.
- `laravel/Modules/Performance/docs/action-update-gg-presenza-dalal.md`: fonte di verità business (Sigma mutator, niente duplicazione formula).

## Catena modello

- `Organizzativa` → `BaseIndividualeModel` → trait `EnteMatrDateRangeMutator` → `getGgPresenzaDalal(): ?int`.
- Suffisso Filament `FieldRefreshAction::make('gg_presenza_dalal')` → metodo `getGgPresenzaDalal` (Studly corretto).

## Se riappare “metodo mancante”

1. Verificare che il Livewire riceva davvero un’istanza del modello atteso (non array / ID grezzo).
2. Verificare che il modello includa ancora `EnteMatrDateRangeMutator` (nessun refactor che lo tolga dalla base).
3. Cache config/view dopo deploy: `php artisan optimize:clear`.

## Collegamenti

- [README chat](./README.md)
- [Action gg presenza dalal](../../laravel/Modules/Performance/docs/action-update-gg-presenza-dalal.md)
- [EnteMatrDateRangeMutator](../../laravel/Modules/Sigma/app/Models/Traits/Mutators/EnteMatrDateRangeMutator.php)

*Sessione consolidata: 2026-05*
