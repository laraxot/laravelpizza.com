# MapPicker Must Extend XotBaseField

**Status:** regola permanente  
**Aggiornato:** 2026-04-20

## Regola

`Modules\Geo\Filament\Forms\Components\MapPicker` deve estendere `Modules\Xot\Filament\Forms\Components\XotBaseField`.

Non deve:

- estendere direttamente `Filament\Forms\Components\Field`;
- estendere un picker sibling solo per riuso tecnico;
- spostare la regola nei consumer o nella documentazione senza verificarla nel codice.

## Stato attuale

Audit locale confermato:

- `laravel/Modules/Geo/app/Filament/Forms/Components/MapPicker.php` → `extends XotBaseField`

Quindi il codice e gia allineato. La correzione qui e documentale e di memoria persistente: la regola va ricordata prima di ogni refactor della famiglia picker Geo.

## Motivazione

- `XotBaseField` centralizza il contratto Laraxot per i custom field Filament.
- Riduce coupling architetturale tra componenti fratelli (`MapPicker`, `CoordinatePicker`, `LatitudeLongitudeInput`).
- Mantiene il riuso su trait/composizione, in ottica **DRY + KISS**.
- Evita regressioni dove un refactor apparentemente innocuo cambia la base class e rompe aspettative comuni del framework.

## Checklist rapida

1. aprire il file PHP del field;
2. controllare subito la riga `extends`;
3. se non e `XotBaseField`, correggere prima di lavorare su Blade o JS;
4. aggiornare wiki locale, log e indice se la regola emerge o viene ribadita.

## Backlink

- [map-picker-filament-field](./map-picker-filament-field.md)
- [laraxot-filament-xotbasefield-governance](../../../../docs/wiki/concepts/laraxot-filament-xotbasefield-governance.md)
- [geo wiki log](../log.md)
