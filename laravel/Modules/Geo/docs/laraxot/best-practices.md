# Laraxot Best Practices

## Form Schema Best Practices

### Campi da Escludere
- `created_at`: gestito automaticamente da Laravel
- `updated_at`: gestito automaticamente da Laravel
- Qualsiasi campo gestito da traits (es: Updater trait)
- Campi di sistema che non devono essere modificati dall'utente

### Campi da Includere
- Campi del modello che l'utente deve poter modificare
- Relazioni che devono essere gestite attraverso il form
- Campi virtuali necessari per la logica del form

### Implementazione
```php
public static function getFormSchema(): array
{
    return [
        // Campi modificabili dall'utente
        TextInput::make('name')->required(),
        Select::make('type')->options([...]),
        
        // NO: Non includere campi automatici
        // TextInput::make('created_at')
        // TextInput::make('updated_at')
    ];
}
```

## Traduzioni

### Regole Generali
1. MAI rimuovere traduzioni esistenti
2. Le traduzioni servono come documentazione completa del modulo
3. Mantenere anche le traduzioni per campi non presenti nel form
4. Aggiungere nuove traduzioni quando necessario
5. Correggere e migliorare le traduzioni esistenti

### Struttura File Traduzioni
```php
return [
    'resources' => [
        'my_model' => [
            'fields' => [
                // Campi del form
                'name' => 'Nome',
                'type' => 'Tipo',
                
                // Campi automatici (da mantenere)
                'created_at' => 'Data Creazione',
                'updated_at' => 'Ultima Modifica'
            ],
        ],
    ],
];
```

### LangServiceProvider
- Non utilizzare `->label()` nei componenti Filament
- Le etichette vengono gestite automaticamente
- Le traduzioni sono basate sulla struttura del modulo e della classe

## XotBaseResource

### Regole di Estensione
1. Implementare `public static function getFormSchema(): array`
2. NON implementare il metodo `form(Form $form): Form`
3. NON definire `protected static ?string $navigationIcon`
4. La navigazione è gestita interamente da XotBaseResource

### Esempio di Implementazione
```php
class MyResource extends XotBaseResource
{
    protected static ?string $model = MyModel::class;

    public static function getFormSchema(): array
    {
        return [
            TextInput::make('name')->required(),
            Select::make('type')->options([...])
        ];
    }
}
```

## Architettura

### Modelli
- Utilizzare traits per funzionalità comuni
- Implementare relazioni in modo chiaro e documentato
- Definire correttamente i fillable fields

### Forms
- Separare la logica di validazione in Form Requests
- Utilizzare i componenti Filament appropriati
- Implementare la validazione lato client quando possibile

### Views
- Utilizzare Blade components per la riusabilità
- Implementare la localizzazione per tutti i testi
- Seguire una struttura modulare
