# Riutilizzo degli Schemi Form tra Moduli

## Principio DRY nella Definizione dei Form

Uno dei principi fondamentali nella progettazione di <main module> è l'applicazione rigorosa del principio DRY (Don't Repeat Yourself). Questo si applica anche alla definizione degli schemi dei form Filament, in particolare per entità che condividono strutture comuni come gli indirizzi.

## Pattern di Condivisione degli Schemi Form

### Contesto del Problema

Quando più modelli hanno bisogno di gestire entità simili (es. indirizzi), tradizionalmente si verificano due approcci problematici:

1. **Duplicazione del codice**: Ogni risorsa definisce il proprio schema form completo
2. **Accoppiamento eccessivo**: Dipendenze dirette tra moduli che violano la separazione delle responsabilità

### Soluzione Architettonica

Il pattern di condivisione degli schemi form risolve questi problemi attraverso:

1. **Definizione centralizzata**: Lo schema completo è definito nella risorsa principale (es. `AddressResource`)
2. **Riutilizzo attraverso i moduli**: Altri moduli richiamano lo schema attraverso metodi statici
3. **Personalizzazione contestuale**: Adattamenti locali dove necessario

## Implementazione in <main module>

### Definizione dello Schema in AddressResource

```php
// In Modules\Geo\Filament\Resources\AddressResource
public static function getFormSchema(): array
{
    return [
        'route' => Forms\Components\TextInput::make('route')->required(),
        'locality' => Forms\Components\TextInput::make('locality')->required(),
        // Altri campi dell'indirizzo
    ];
}
```

### Riutilizzo in StudioResource

```php
// In Modules\<main module>\Filament\Resources\StudioResource
public static function getFormSchema(): array
{
    return [
        // Altri campi specifici dello Studio
        
        'addresses' => Forms\Components\Repeater::make('addresses')
            ->relationship('addresses')
            ->schema(AddressResource::getFormSchema()),
    ];
}
```

## Vantaggi Filosofici

1. **Coesione semantica**: Ogni modulo mantiene la responsabilità per i propri concetti
2. **Accoppiamento ridotto**: Le dipendenze sono esplicite e dirette a interfacce stabili
3. **Principio aperto-chiuso**: Estensioni senza modificare il codice esistente
4. **Singola fonte di verità**: Modifiche alle definizioni dei campi in un solo punto

## Considerazioni Implementative

### Gestione delle Traduzioni

Le etichette dei campi devono seguire la convenzione di traduzione appropriata:

```php
// Errato
'route' => Forms\Components\TextInput::make('route')
    ->label('Indirizzo'),

// Corretto
'route' => Forms\Components\TextInput::make('route')
    ->label('address-resource.fields.route'),
```

### Personalizzazioni Contestuali

In alcuni casi, potrebbe essere necessario personalizzare alcuni aspetti dello schema:

```php
// Personalizzazione parziale
$addressSchema = AddressResource::getFormSchema();
$addressSchema['locality'] = Forms\Components\TextInput::make('locality')
    ->label('studio-resource.fields.city')
    ->required()
    ->columnSpan(2);
```

## Riferimenti

- [address-resource.md](address-resource.md)
- [pattern-filament-pages.md](../project_docs/pattern-filament-pages.md)
- [AddressResource](../app/Filament/Resources/AddressResource.php)
- [StudioResource](../../<main module>/app/Filament/Resources/StudioResource.php)
