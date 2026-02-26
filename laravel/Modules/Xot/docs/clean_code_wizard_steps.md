# Clean Code: Wizard Steps come Funzioni dedicate

## Regola
Non inserire mai direttamente `Forms\Components\Wizard\Step::make()` dentro `Forms\Components\Wizard::make([...])`. Ogni step deve essere generato da una funzione dedicata che restituisce una istanza di `Wizard\Step`.

## Motivazione
- **Leggibilità**: Ogni step ha un nome descrittivo e il codice del wizard è più chiaro.
- **Manutenibilità**: Gli step possono essere modificati senza toccare la logica principale del wizard.
- **Riuso**: Uno step può essere riutilizzato in più wizard o risorse.
- **Testabilità**: Funzioni isolate facilitano il testing.
- **Coerenza**: Uniforma lo stile tra tutti i moduli e le risorse.

## Esempio
```php
// CORRETTO
Forms\Components\Wizard::make([
    static::getPersonalStep(),
    static::getContactsStep(),
])

protected static function getPersonalStep(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make('Dati personali')
        ->schema([...]);
}
```

## Collegamenti
- [Applicazione e nota nel modulo Patient](../../Patient/docs/clean-code-wizard-steps.md)

**Questa regola è trasversale e vincolante per tutti i moduli.**

## Collegamenti tra versioni di clean-code-wizard-steps.md
* [clean-code-wizard-steps.md](../../Patient/docs/clean-code-wizard-steps.md)

