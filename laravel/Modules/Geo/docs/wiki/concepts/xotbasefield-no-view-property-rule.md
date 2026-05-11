# XotBaseField No $view Property Rule (Geo)

## Regola

I campi Geo che estendono `Modules\Xot\Filament\Forms\Components\XotBaseField` non devono definire `protected string $view`.

La view viene calcolata da `XotBaseField::getView()` usando `GetViewByClassAction`.

## Best practices

- Tenere il Blade in `Modules/Geo/resources/views/filament/forms/components/<nome>.blade.php` (con naming coerente al resolver).
- Evitare override locali: se il mapping non torna, si sistema il resolver, non il componente.

## Bad practices

- Aggiungere `$view` "al volo" quando qualcosa non renderizza: e' un fix fragile e non DRY.

## False friends

- Filament upstream spesso usa `$view`, ma in Laraxot/XotBaseField il contratto e' diverso.
