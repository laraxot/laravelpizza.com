# Sistema di Traduzione in il progetto

## LangServiceProvider

Il `LangServiceProvider` è il cuore del sistema di traduzione e gestisce automaticamente le label dei componenti Filament.

### Funzionamento

1. **Caricamento Traduzioni**
   - Le traduzioni sono caricate dai file nella cartella `lang` di ogni modulo
   - Supporta sia file PHP che JSON
   - Usa il nome del modulo in minuscolo come namespace delle traduzioni

2. **Gestione Automatica Label**
   - Non si usa mai il metodo `->label()` direttamente sui componenti
   - Le label sono gestite automaticamente dal provider
   - Usa i file di traduzione per tutte le etichette

3. **Struttura File Traduzioni**
```php
return [
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Inserisci il tuo nome completo',
        ],
    ],
];
```

### Componenti Supportati

- `Filament\Forms\Components\Field`
- `Filament\Tables\Columns\Column`
- `Filament\Forms\Components\Placeholder`
- `Filament\Infolists\Components\Entry`
- `Filament\Tables\Filters\BaseFilter`
- `Filament\Forms\Components\Wizard\Step`

## Best Practices

1. **Mai Usare label() Direttamente**
   ```php
   // ❌ Errato
   TextInput::make('first_name')->label('Nome')
   
   // ✅ Corretto
   TextInput::make('first_name') // Label da file traduzione
   ```

2. **Struttura Traduzioni**
   - Usa array nidificati per organizzare le traduzioni
   - Separa label, placeholder, help e altre proprietà
   - Mantieni coerenza nella struttura tra i moduli

3. **Namespace Traduzioni**
   - Usa il nome del modulo come namespace
   - Organizza le traduzioni per entità/risorsa
   - Mantieni una gerarchia logica

4. **Manutenibilità**
   - Centralizza le traduzioni nei file lang
   - Evita testo hardcoded nel codice
   - Facilita il supporto multilingua

## Collegamenti
- [Form Components](../Patient/docs/filament-form-components.md)
- [Wizard Structure](../Patient/docs/filament-wizard-structure.md)
- [Best Practices](../Xot/docs/filament-best-practices.md)

## Vedi Anche
- [Laravel Translations](https://laravel.com/docs/localization)
- [Filament i18n](https://filamentphp.com/docs/internationalization) 
