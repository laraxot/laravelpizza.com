# Linee Guida per l'Implementazione di getInfolistSchema

## Requisiti Fondamentali

La funzione `getInfolistSchema()` deve **sempre** restituire un array con chiavi di tipo stringa. Questo documento fornisce le linee guida per garantire un'implementazione corretta e coerente in tutto il progetto.

## Implementazione Corretta

### Struttura Base

L'unico approccio corretto per implementare `getInfolistSchema()` è utilizzare array associativi con chiavi di tipo stringa:

```php
/**
 * Restituisce lo schema dell'infolist per la visualizzazione dei dettagli del record.
 *
 * @return array<string, \Filament\Infolists\Components\Component>
 */
protected function getInfolistSchema(): array
{
    return [
        'id' => TextEntry::make('id'),
        'nome' => TextEntry::make('nome'),
        'email' => TextEntry::make('email'),
        // Altri componenti...
    ];
}
```

### Documentazione PHPDoc Corretta

Per PHPStan livello 9 e superiore, è fondamentale documentare correttamente il tipo di array restituito:

```php
/**
 * Restituisce lo schema dell'infolist per la visualizzazione dei dettagli del record.
 *
 * @return array<string, \Filament\Infolists\Components\Component>
 */
protected function getInfolistSchema(): array
```

## Esempi Pratici

### Struttura con Sezioni e Griglie

```php
/**
 * Restituisce lo schema dell'infolist per la visualizzazione dei dettagli del record.
 *
 * @return array<string, \Filament\Infolists\Components\Component>
 */
protected function getInfolistSchema(): array
{
    return [
        'informazioni_personali' => Section::make('Informazioni Personali')
            ->schema([
                'grid0'=>Grid::make(['default' => 2])
                    ->schema([
                        'nome'=>TextEntry::make('nome')
                            ,
                        'cognome'=>TextEntry::make('cognome')
                            ,
                        'email'=>TextEntry::make('email')
                            ,
                        'telefono'=>TextEntry::make('telefono')
                            ,
                    ]),
            ]),
        
        'dettagli_account' => Section::make('Dettagli Account')
            ->schema([
                // Altri componenti...
            ]),
    ];
}
```

### Struttura con Componenti Personalizzati

```php
/**
 * Restituisce lo schema dell'infolist per la visualizzazione dei dettagli del record.
 *
 * @return array<string, \Filament\Infolists\Components\Component>
 */
protected function getInfolistSchema(): array
{
    return [
        'info_personali' => Section::make('Informazioni Personali')
            ->schema([
                // Componenti per informazioni personali...
            ]),
        'dettagli_account' => Section::make('Dettagli Account')
            ->schema([
                // Componenti per dettagli account...
            ]),
        'preferenze' => Section::make('Preferenze')
            ->schema([
                // Componenti per preferenze...
            ]),
    ];
}
```

## Vantaggi dell'Uso di Chiavi di Tipo Stringa

1. **Accesso Diretto ai Componenti**: Le chiavi di tipo stringa consentono di accedere direttamente ai componenti dell'array
2. **Maggiore Leggibilità**: Il codice è più chiaro e facile da comprendere
3. **Prevenzione di Errori**: Evita problemi quando si accede ai componenti tramite chiave
4. **Compatibilità con PHPStan**: Aiuta a superare le verifiche di PHPStan di livello 9 e 10

## Casi Speciali

### Combinazione di Components e Layouts

Quando si utilizzano sia componenti di visualizzazione che componenti di layout (Section, Grid, etc.), è importante mantenere sempre chiavi di tipo stringa:

```php
/**
 * Restituisce lo schema dell'infolist per la visualizzazione dei dettagli del record.
 *
 * @return array<string, \Filament\Infolists\Components\Component>
 */
protected function getInfolistSchema(): array
{
    return [
        'identificativo' => TextEntry::make('id'),
        'informazioni' => Section::make('Informazioni')
            ->schema([
                // Componenti all'interno della sezione...
            ]),
    ];
}
```

### Array con Sezioni Generate Dinamicamente

Quando si generano sezioni dinamicamente, è importante assegnare chiavi stringa significative:

```php
/**
 * Restituisce lo schema dell'infolist per la visualizzazione dei dettagli del record.
 *
 * @return array<string, \Filament\Infolists\Components\Component>
 */
public function getInfolistSchema(): array
{
    $sections = [];

    // Aggiungiamo dinamicamente le sezioni con chiavi stringa
    $sections['informazioni_base'] = Section::make('Informazioni Base')
        ->schema([
            // Componenti...
        ]);

    if ($this->record->hasDocuments()) {
        $sections['documenti'] = Section::make('Documenti')
            ->schema([
                // Componenti per documenti...
            ]);
    }

    return $sections;
}
```

## Migrando da Array Numerici ad Array Associativi

Se hai implementazioni esistenti che utilizzano array numerici, segui questi passaggi per correggerle:

1. Identifica tutti i componenti nell'array
2. Assegna a ciascun componente una chiave stringa significativa
3. Aggiorna il PHPDoc per specificare `@return array<string, \Filament\Infolists\Components\Component>`
4. Testa la vista per assicurarti che funzioni correttamente

### Prima:
```php
return [
    TextEntry::make('id'),
    TextEntry::make('nome'),
];
```

### Dopo:
```php
return [
    'id_entry' => TextEntry::make('id'),
    'nome_entry' => TextEntry::make('nome'),
];
```

## Migliori Pratiche

1. **Usa SEMPRE Chiavi di Tipo Stringa**: Non utilizzare mai array sequenziali con indici numerici impliciti
2. **Documentazione PHPDoc Accurata**: Specifica sempre `@return array<string, \Filament\Infolists\Components\Component>`
3. **Nomi Significativi per le Chiavi**: Scegli nomi di chiave che riflettano il contenuto o lo scopo del componente
4. **Rispetta la Struttura di Filament**: Segui le convenzioni di Filament per la struttura dei componenti

## Conclusione

Seguendo queste linee guida, garantirai un'implementazione corretta e coerente del metodo `getInfolistSchema()`, facilitando la manutenzione del codice e prevenendo errori di tipo rilevati da PHPStan. Ricorda: usa **sempre** chiavi di tipo stringa per gli array restituiti. 