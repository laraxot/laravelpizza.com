# Convenzioni di Naming per i Wizard Step in Filament

## Regola Fondamentale

Quando si definiscono gli step di un wizard Filament, è necessario seguire queste regole:

1. **Utilizzare stringhe semplici con suffisso '_step'** come identificatori
2. **NON utilizzare `->description()` o `->label()`** sui wizard step
3. **NON utilizzare funzioni di traduzione come `__()`** nell'identificatore dello step

## Implementazione Corretta

```php
// ✅ CORRETTO
protected static function getDocumentsStep(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make('documents_step')
        ->schema([
            // Schema del form
        ]);
}
```

## Implementazioni Errate da Evitare

```php
// ❌ ERRATO: Utilizzo di traduzione nell'identificatore
protected static function getDocumentsStep(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make(__('module::resource.steps.documents.label'))
        ->schema([
            // Schema del form
        ]);
}

// ❌ ERRATO: Manca il suffisso '_step'
protected static function getDocumentsStep(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make('documents')
        ->schema([
            // Schema del form
        ]);
}

// ❌ ERRATO: Utilizzo di ->description()
protected static function getDocumentsStep(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make('documents_step')
        ->description('Carica i tuoi documenti')
        ->schema([
            // Schema del form
        ]);
}

// ❌ ERRATO: Utilizzo di ->label()
protected static function getDocumentsStep(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make('documents_step')
        ->label('Documenti')
        ->schema([
            // Schema del form
        ]);
}
```

## Motivazione

1. **Convenzione di naming coerente**: Facilita l'identificazione degli step nei vari moduli
2. **Evita confusione con metodi non supportati**: Alcuni metodi potrebbero non essere supportati o avere comportamenti inaspettati
3. **Separazione tra identificatore tecnico e etichetta visualizzata**: L'identificatore è un valore tecnico, mentre l'etichetta visualizzata è gestita internamente

## Collegamenti Bidirezionali

- [Best Practices per i Wizard](./wizard-best-practices.md)
- [Clean Code per Wizard Steps](../clean-code/wizard-steps.md)
- [Errori Comuni nei Componenti Filament](../filament-components-errors.md)
