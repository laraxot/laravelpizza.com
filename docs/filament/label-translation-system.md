# Sistema di Traduzione Automatica delle Etichette (Label) in Filament

## Regola Fondamentale

> **NON UTILIZZARE MAI IL METODO ->label() NEI COMPONENTI FILAMENT**

Le etichette sono gestite automaticamente dal `LangServiceProvider` e dai file di traduzione del modulo. Usare `->label()` direttamente sovrascrive questo meccanismo, causando inconsistenze e difficoltà di manutenzione.

## Come Funziona

Il sistema di traduzione automatica delle etichette funziona in questo modo:

1. Il `LangServiceProvider` registra handler per i componenti Filament (Field, Column, Filter, ecc.)
2. Quando un componente viene creato, l'`AutoLabelAction` determina automaticamente:
   - Da quale modulo proviene il componente
   - Il nome del campo/componente
   - La chiave di traduzione appropriata

3. La struttura delle chiavi di traduzione segue questa convenzione:
   ```
   modulo::fields.nome_campo.label
   ```

4. Se una traduzione non esiste, viene creata automaticamente

## Vantaggi

- **Coerenza**: Tutte le etichette seguono lo stesso formato
- **Manutenibilità**: Separazione tra codice e testo
- **Multilinguismo**: Facile gestione delle traduzioni
- **Automatizzazione**: Nessun lavoro manuale richiesto

## Implementazione Corretta

```php
// ERRATO ❌
Forms\Components\TextInput::make('first_name')
    ->label('Nome')
    ->required();

// CORRETTO ✅
Forms\Components\TextInput::make('first_name')
    ->required();
```

Le traduzioni vanno definite nel file di traduzione del modulo, ad esempio:

```php
// resources/lang/it/patient.php
return [
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'help' => 'Inserisci il nome',
        ],
        // altri campi...
    ],
];
```

## Debugging

Se vedi un'etichetta come `FIX:modulo::fields.nome_campo.label`, significa che il sistema non ha trovato una traduzione e ha generato automaticamente una chiave. Controlla che:

1. I file di traduzione esistano nella posizione corretta
2. La struttura delle chiavi di traduzione sia corretta
3. Il `LangServiceProvider` sia stato registrato correttamente

## Collegamenti

- [Implementazione del LangServiceProvider](Modules/Lang/app/Providers/LangServiceProvider.php)
- [AutoLabelAction](Modules/Lang/app/Actions/Filament/AutoLabelAction.php)
- [Documentazione Filament sui Form](https://filamentphp.com/docs/3.x/forms/fields/getting-started)
