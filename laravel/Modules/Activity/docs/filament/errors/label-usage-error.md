# Non utilizzare `->label()` nei componenti Filament

> **NOTA IMPORTANTE**: Questo documento è un riferimento specifico per il modulo Activity. 
> La documentazione principale e completa si trova nel [modulo UI](../../../UI/docs/filament/label-translation-system.md).

## Regola fondamentale

Nel progetto, **non è mai consentito utilizzare il metodo `->label()`** nei componenti Filament. Questa è una regola fondamentale che deve essere rispettata in tutti i moduli, compreso il modulo Activity.

## Errore individuato

Nei file del modulo Activity, sono stati trovati diversi componenti Filament che utilizzano il metodo `->label()` direttamente, violando questa regola. Ad esempio:

```php
// File: Modules/Activity/app/Filament/Resources/SnapshotResource/Pages/ListSnapshots.php
\Filament\Tables\Columns\TextColumn::make('id')
    ->sortable()
    ->label('ID'),
```

## Motivazione

Le etichette sono gestite automaticamente dal `LangServiceProvider`, che determina la chiave di traduzione corretta basandosi su:
- Il namespace della classe
- Il nome del campo
- La struttura predefinita `modulo::fields.nome_campo.label`

Quando si utilizza `->label()` direttamente:
- Si bypassa il sistema di traduzione automatico
- Si rende impossibile la localizzazione centralizzata
- Si crea inconsistenza nel codebase

## Soluzione corretta

Rimuovere tutte le chiamate a `->label()` e definire invece le traduzioni nei file di lingua appropriati:

```php
// ERRATO ❌
\Filament\Tables\Columns\TextColumn::make('id')
    ->sortable()
    ->label('ID')

// CORRETTO ✅
\Filament\Tables\Columns\TextColumn::make('id')
    ->sortable()
```

Con le traduzioni definite in `Modules/Activity/resources/lang/it/snapshot.php`:

```php
return [
    'fields' => [
        'id' => [
            'label' => 'ID'
        ],
        // altri campi...
    ]
];
```

## Verifiche da effettuare nel modulo

Cercare e rimuovere tutte le chiamate a `->label()` nei seguenti file:
- `Modules/Activity/app/Filament/Resources/**/*.php`
- Verificare che esistano i file di traduzione appropriati nella directory `resources/lang`

## Riferimenti

- [Documentazione principale sul sistema di traduzione](../../../UI/docs/filament/label-translation-system.md)
- [LangServiceProvider e AutoLabelAction](../../../Lang/docs/filament/autolabel-system.md)
