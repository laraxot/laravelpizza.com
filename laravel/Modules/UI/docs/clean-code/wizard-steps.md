# Gestione degli Step nei Wizard Filament

## Collegamenti Bidirezionali
- [Best Practices UI](../best-practices.md)
- [Errori Comuni UI](../filament-components-errors.md)
- [Implementazione Corretta](../examples/correct-implementation.md)
- [Form Schema Rules](../form-schema-rules.md)

## Regola: Separazione degli Step

### ❌ NON FARE
```php
Forms\Components\Wizard::make([
    Forms\Components\Wizard\Step::make('step_one')
        ->schema([
            // ... schema ...
        ]),
    Forms\Components\Wizard\Step::make('step_two')
        ->schema([
            // ... schema ...
        ]),
]);
```

### ✅ FARE
```php
Forms\Components\Wizard::make([
    self::getStepOne(),
    self::getStepTwo(),
]);

protected static function getStepOne(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make('step_one')
        ->schema([
            // ... schema ...
        ]);
}

protected static function getStepTwo(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make('step_two')
        ->schema([
            // ... schema ...
        ]);
}
```

## Motivazioni

1. **Separazione delle Responsabilità**:
   - Ogni step è una unità logica indipendente
   - Migliore organizzazione del codice
   - Facilita il testing di ogni step

2. **Riusabilità**:
   - Gli step possono essere riutilizzati in altri wizard
   - Possibilità di estendere o modificare singoli step
   - Condivisione di step tra risorse diverse

3. **Manutenibilità**:
   - Codice più facile da leggere e mantenere
   - Modifiche localizzate a singoli step
   - Riduzione della complessità ciclomatica

4. **Testing**:
   - Test unitari più semplici
   - Possibilità di mockare singoli step
   - Migliore copertura dei test

5. **Estendibilità**:
   - Facile aggiungere nuovi step
   - Possibilità di override in classi figlie
   - Composizione dinamica del wizard

## Best Practices

1. **Naming**:
   - Usare nomi descrittivi per i metodi degli step
   - Prefissare con `get` i metodi degli step
   - Mantenere coerenza nel naming

2. **Organizzazione**:
   - Un metodo per ogni step
   - Raggruppare step correlati
   - Documentare lo scopo di ogni step

3. **Validazione**:
   - Validazione specifica per ogni step
   - Regole di business isolate
   - Gestione errori localizzata

## Esempi di Implementazione

```php
class DoctorResource extends XotBaseResource
{
    protected static function getPersonalInfoStep(): Forms\Components\Wizard\Step
    {
        return Forms\Components\Wizard\Step::make('personal_info')
            ->label('Informazioni Personali')
            ->schema([
                // ... schema ...
            ]);
    }

    protected static function getContactsStep(): Forms\Components\Wizard\Step
    {
        return Forms\Components\Wizard\Step::make('contacts')
            ->label('Contatti')
            ->schema([
                // ... schema ...
            ]);
    }

    public static function getFormSchemaWidget(): array
    {
        return [
            'wizard' => Forms\Components\Wizard::make([
                self::getPersonalInfoStep(),
                self::getContactsStep(),
            ]),
        ];
    }
}
```

## Note Importanti

1. Questa convenzione è obbligatoria per tutti i wizard
2. Ogni step deve essere un metodo separato
3. I metodi degli step devono essere `protected static`
4. Mantenere la documentazione di ogni step

## Collegamenti Correlati

- [Documentazione Filament Forms](https://filamentphp.com/docs/3.x/forms/layout/wizard)
- [Best Practices Forms](../forms/best-practices.md)
- [Clean Code Guidelines](../../../docs/clean-code.md)
