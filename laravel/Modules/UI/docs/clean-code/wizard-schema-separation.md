# Separazione dello Schema dagli Step nei Wizard Filament

## Regola Fondamentale

Quando si implementano gli step di un wizard Filament, è necessario **separare la definizione dello schema dalla definizione dello step stesso**. Questo è un'applicazione del principio di Responsabilità Singola (SRP) del Clean Code.

## Implementazione Corretta

```php
// ✅ CORRETTO: Schema definito in un metodo separato
protected static function getPrivacyStep(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make('privacy_step')
        ->schema(self::getPrivacyStepSchema());
}

protected static function getPrivacyStepSchema(): array
{
    return [
        Forms\Components\View::make('patient::privacy-policy')
            ->columnSpanFull(),
        Forms\Components\Checkbox::make('privacy_acceptance')
            ->required()
            ->columnSpanFull(),
        Forms\Components\Checkbox::make('newsletter')
            ->columnSpanFull(),
    ];
}
```

## Implementazione Errata

```php
// ❌ ERRATO: Schema definito inline nello step
protected static function getPrivacyStep(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make('privacy_step')
        ->schema([
            Forms\Components\View::make('patient::privacy-policy')
                ->columnSpanFull(),
            Forms\Components\Checkbox::make('privacy_acceptance')
                ->required()
                ->columnSpanFull(),
            Forms\Components\Checkbox::make('newsletter')
                ->columnSpanFull(),
        ]);
}
```

## Principi Clean Code Applicati

### 1. Single Responsibility Principle (SRP)
Ogni metodo deve avere una sola responsabilità:
- `getPrivacyStep()`: Creare e configurare lo step del wizard
- `getPrivacyStepSchema()`: Definire la struttura dei campi del form

### 2. Livelli di Astrazione Coerenti
All'interno di un metodo, tutti gli elementi dovrebbero essere allo stesso livello di astrazione. Mescolando la configurazione dello step (alto livello) con la definizione dei singoli campi (basso livello), si viola questo principio.

### 3. Evitare Metodi Lunghi
I metodi lunghi sono difficili da comprendere, testare e mantenere. Separare lo schema riduce significativamente la lunghezza dei metodi degli step.

### 4. Don't Repeat Yourself (DRY)
Lo schema separato può essere riutilizzato in più contesti:
- Nei diversi wizard che condividono gli stessi campi
- Nelle diverse modalità di visualizzazione (edit, create, import)
- Nei test unitari specifici per lo schema

### 5. Self-Documenting Code
I nomi dei metodi come `getPrivacyStepSchema()` documentano chiaramente lo scopo del codice, migliorando la leggibilità.

## Vantaggi Pratici

1. **Manutenibilità migliorata**:
   - Modifiche allo schema non richiedono modifiche al metodo dello step
   - Chiara separazione tra configurazione dello step e definizione dei campi

2. **Testabilità**:
   - Lo schema può essere testato indipendentemente dallo step
   - I test possono focalizzarsi su un singolo aspetto alla volta

3. **Riusabilità**:
   - Lo schema può essere facilmente riutilizzato in altri contesti
   - Facilita la creazione di varianti dello stesso schema

4. **Leggibilità**:
   - Metodi più brevi e con una chiara responsabilità
   - Nomi descrittivi che indicano lo scopo di ciascun metodo

## Risorse Clean Code

- [Clean Code di Robert C. Martin (Uncle Bob)](https://www.amazon.it/Clean-Code-Handbook-Software-Craftsmanship/dp/0132350882)
- [The Single Responsibility Principle](https://blog.cleancoder.com/uncle-bob/2014/05/08/SingleReponsibilityPrinciple.html)
- [Clean Code - Funzioni](https://ddelfio.medium.com/cosa-ho-imparato-leggendo-il-libro-clean-code-di-robert-c-martin-87ebdd6290f0)

## Collegamenti Bidirezionali

- [Wizard Step Naming](../filament/wizard-step-naming.md)
- [Best Practices per i Wizard](../filament/wizard-best-practices.md)
- [Errori Comuni nei Componenti Filament](../filament-components-errors.md)
