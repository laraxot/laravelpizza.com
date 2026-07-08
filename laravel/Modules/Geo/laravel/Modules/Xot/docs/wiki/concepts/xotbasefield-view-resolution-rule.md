---
name: xotbasefield-view-resolution-rule
description: XotBaseField resolves its Blade view dynamically; child fields must not set $view
type: concept
---

# XotBaseField View Resolution Rule

## Regola

Qualsiasi campo Filament che estende `Modules\Xot\Filament\Forms\Components\XotBaseField` NON deve dichiarare `protected string $view` (o varianti) per forzare la view.

La view viene risolta dinamicamente da `XotBaseField::getView()` tramite l'azione `GetViewByClassAction`.

## Best practices

- Lasciare che `XotBaseField::getView()` risolva la view in modo centralizzato (DRY).
- Mettere il Blade nella posizione canonica che `GetViewByClassAction` si aspetta (KISS).
- Se serve cambiare il mapping, farlo a livello azione/resolver, non nel singolo field.

## Bad practices

- Definire `$view` nei figli per "far funzionare" un componente: crea fork nascosti e rompe la consistenza.
- Copiare/incollare view path in ogni field: aumenta drift e rende difficile refactor.

## False friends

- In Filament classico molti componenti usano `$view`: qui non e' il contratto owner.
- Il fatto che un Blade esista non significa che il path sia quello giusto: il resolver puo' usare convenzioni e naming.

## File coinvolti

- `laravel/Modules/Xot/app/Filament/Forms/Components/XotBaseField.php`
