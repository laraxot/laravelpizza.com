# XotBaseField Calculated View Rule

## Context

I field che estendono `Modules\Xot\Filament\Forms\Components\XotBaseField` non devono dichiarare una property locale:

```php
protected string $view = '...';
```

ma Filament richiede comunque che il `ViewComponent` abbia una view risolvibile.

La soluzione corretta non e' lasciare il componente senza view, ma calcolare la view nel base field.

## Best Practices

- Centralizzare la risoluzione della view in `XotBaseField::getDefaultView()`.
- Derivare la view da namespace modulo + basename componente:
  - `Modules\Geo\...\CoordinatePicker` -> `geo::filament.forms.components.coordinate-picker`
- Lasciare i singoli field puliti e DRY.
- Verificare sempre la URL reale dopo la modifica, perche' l'errore emerge solo a runtime nel renderer Filament.

## Bad Practices

- Dichiarare `protected string $view` in ogni field che estende `XotBaseField`.
- Rimuovere `$view` dai field senza fornire una strategia alternativa nel base class.
- Fare eccezioni “solo per questo componente”: rompe la regola e reintroduce duplicazione.

## False Friends

- “Il field compila senza `$view`, quindi Filament lo risolve da solo.” Falso: `ViewComponent` lancia `LogicException`.
- “La regola no-$view e' sbagliata.” Falso: era incompleta, non sbagliata. La view va calcolata nel base class.
- “Basta correggere un solo picker.” Falso: la regola vale per tutta la famiglia `XotBaseField`.
