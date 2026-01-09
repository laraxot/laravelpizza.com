# Best Practices per i Wizard in Filament

## Regola Fondamentale: Estrazione dei Metodi per gli Step

Quando si implementa un `Wizard` in Filament, **non inserire mai direttamente** gli step all'interno del metodo `make()`, ma **sempre utilizzare metodi dedicati** che restituiscano un oggetto `Forms\Components\Wizard\Step`.

### Approccio Corretto

```php
// ✅ CORRETTO
public static function getFormSchemaWidget(): array
{
    return [
        Forms\Components\Wizard::make([
            self::getPersonalDataStep(),
            self::getContactsStep(),
            self::getPrivacyStep(),
        ])
        ->skippable(false)
    ];
}

protected static function getPersonalDataStep(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make('Dati Personali')
        ->icon('heroicon-o-user')
        ->description('Inserisci i tuoi dati personali')
        ->schema([
            // ...componenti del form
        ]);
}
```

### Approccio da Evitare

```php
// ❌ ERRATO
public static function getFormSchemaWidget(): array
{
    return [
        Forms\Components\Wizard::make([
            Forms\Components\Wizard\Step::make('Dati Personali')
                ->icon('heroicon-o-user')
                ->description('Inserisci i tuoi dati personali')
                ->schema([
                    // ...componenti del form
                ]),
            Forms\Components\Wizard\Step::make('Contatti')
                ->icon('heroicon-o-envelope')
                ->description('Inserisci i tuoi contatti')
                ->schema([
                    // ...componenti del form
                ]),
            // ...altri step
        ])
        ->skippable(false)
    ];
}
```

## Motivazioni

### 1. Separazione delle Responsabilità

Ogni step di un wizard rappresenta una fase logica distinta del processo. Estrarre ciascuno step in un metodo dedicato rispetta il principio di **Single Responsibility** (Responsabilità Singola) del SOLID, assegnando a ciascun metodo la responsabilità di definire un singolo step.

### 2. Leggibilità e Manutenibilità

- **Riduzione della complessità**: Il metodo principale `getFormSchemaWidget()` diventa più snello e facile da leggere
- **Nomi descrittivi**: I metodi come `getPersonalDataStep()` o `getContactsStep()` comunicano chiaramente il loro scopo
- **Navigazione del codice**: È più facile trovare e navigare tra i diversi step usando l'IDE

### 3. Riutilizzabilità

- Gli step possono essere facilmente riutilizzati in altri wizard o form
- Facilita la creazione di varianti di wizard che condividono alcuni step

### 4. Testabilità

- Ogni step può essere testato in isolamento
- Semplifica la scrittura di test unitari specifici per ciascuno step

### 5. Collaborazione nel Team

- Diversi sviluppatori possono lavorare contemporaneamente su step diversi
- Riduce i conflitti di merge quando più persone modificano lo stesso file

### 6. Scalabilità

- Facilita l'aggiunta, la rimozione o la riorganizzazione degli step
- Permette di gestire wizard complessi con molti step senza perdere in leggibilità

## Esempi Pratici

### Esempio di Implementazione Completa

```php
class PatientResource extends XotBaseResource
{
    public static function getFormSchemaWidget(): array
    {
        return [
            Forms\Components\Wizard::make([
                self::getPersonalDataStep(),
                self::getDocumentsStep(),
                self::getPreVisitStep(),
                self::getPrivacyStep(),
            ])
            ->skippable(false)
            ->submitAction(new HtmlString(self::getSubmitButton()))
        ];
    }

    protected static function getPersonalDataStep(): Forms\Components\Wizard\Step
    {
        return Forms\Components\Wizard\Step::make('Dati Personali')
            ->icon('heroicon-o-user')
            ->description('Inserisci i tuoi dati personali')
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->label('Nome')
                    ->required(),
                Forms\Components\TextInput::make('last_name')
                    ->label('Cognome')
                    ->required(),
                // ...altri campi
            ]);
    }

    // ...altri metodi per gli step
}
```

## Gestione di Step Condizionali

L'estrazione in metodi dedicati facilita anche la gestione di step condizionali:

```php
public static function getFormSchemaWidget(): array
{
    $steps = [
        self::getPersonalDataStep(),
        self::getContactsStep(),
    ];

    if (auth()->user()->hasRole('doctor')) {
        $steps[] = self::getMedicalInfoStep();
    }

    $steps[] = self::getPrivacyStep();

    return [
        Forms\Components\Wizard::make($steps)
            ->skippable(false)
    ];
}
```

## Collegamenti Bidirezionali

- [Filament Resources Structure](../filament-resources-structure.md)
- [Form Components](../form-components.md)
- [Filament Best Practices](../../Xot/docs/filament-best-practices.md)
