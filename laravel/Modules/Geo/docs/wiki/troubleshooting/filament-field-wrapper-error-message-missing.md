# filament field-wrapper error-message missing

## Sintomo

Su `/it/tests/segnalazione-crea` compare:

- `InvalidArgumentException`
- `Unable to locate a class or view for component [filament-forms::field-wrapper.error-message]`

## Causa radice

Nel componente Blade `CoordinatePicker` era presente un riferimento legacy:

- `<x-filament-forms::field-wrapper.error-message :path="$statePath" />`

In Filament v5 questo sub-component non e' disponibile con quel nome, quindi il
rendering del wizard va in errore prima di arrivare al submit.

## Fix applicato

- Rimosso il riferimento legacy da:
  - `Modules/Geo/resources/views/filament/forms/components/coordinate-picker.blade.php`

Il wrapper campo (`$getFieldWrapperView()`) resta responsabile della resa
strutturale del field, evitando dipendenze Blade non compatibili.

## Guardrail

- Evitare invocazioni dirette a sub-component interni non documentati/stabili
  (`x-filament-forms::field-wrapper.*`) nei custom field.
- Prima di introdurre override di errore custom, verificare i component alias
  effettivamente esposti dalla versione Filament in uso.
