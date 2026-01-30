# Standard Form Schema in Filament

## Struttura Base

```php
public function getFormSchema(): array
{
    return [
        'personal_info' => [
            'label' => ['label' => 'Informazioni Personali'],
            'icon' => 'heroicon-o-user',
            'fields' => [
                // campi del form
            ],
        ],
    ];
}
```

## Regole Generali

1. **Struttura Label**:
   - Usare sempre il formato array con chiave 'label'
   - Esempio: `'label' => ['label' => 'Nome Campo']`

2. **Icone**:
   - Utilizzare icone Heroicon
   - Mantenere consistenza tra risorse simili

3. **Campi**:
   - Raggruppare logicamente i campi correlati
   - Utilizzare sezioni per migliorare l'organizzazione
   - Implementare validazioni appropriate

## Wizard Steps

Per form multi-step:

```php
protected function getSteps(): array
{
    return [
        Step::make('Dati Personali')
            ->icon('heroicon-o-user')
            ->schema([
                // schema del primo step
            ]),
        // altri step
    ];
}
```

## Validazione

- Utilizzare le regole di validazione Laravel
- Implementare validazioni custom quando necessario
- Aggiungere messaggi di errore personalizzati

## Best Practices

1. **Organizzazione**:
   - Un campo per riga per maggiore leggibilità
   - Commentare sezioni complesse
   - Utilizzare costanti per valori ripetuti

2. **Riutilizzo**:
   - Creare metodi helper per schemi comuni
   - Utilizzare trait per funzionalità condivise

3. **Traduzioni**:
   - Tutte le label devono essere tradotte
   - Utilizzare file di traduzione separati per ogni risorsa

## Esempio Completo

```php
public function getFormSchema(): array
{
    return [
        'personal_info' => [
            'label' => ['label' => 'patient::form.sections.personal_info'],
            'icon' => 'heroicon-o-user',
            'fields' => [
                TextInput::make('name')
                    ->translateLabel()
                    ->required(),
                DatePicker::make('birth_date')
                    ->translateLabel()
                    ->required(),
            ],
        ],
        'contact_info' => [
            'label' => ['label' => 'patient::form.sections.contact_info'],
            'icon' => 'heroicon-o-phone',
            'fields' => [
                TextInput::make('email')
                    ->translateLabel()
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->translateLabel()
                    ->tel()
                    ->required(),
            ],
        ],
    ];
}
``` 