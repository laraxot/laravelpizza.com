# Risorsa Filament per il Modello Address

## Panoramica

La risorsa `AddressResource` fornisce un'interfaccia amministrativa per la gestione degli indirizzi nel sistema <main module>. Questa risorsa rispetta le convenzioni architetturali del progetto e implementa le funzionalità CRUD complete per il modello `Address`.

## Struttura

### File Principali

1. **AddressResource.php**
   - Classe principale che estende `XotBaseResource`
   - Definisce gli schemi di form, tabelle e filtri
   - Implementa relazioni e operazioni sui dati

2. **Pages/ListAddresses.php**
   - Estende `XotBaseListRecords`
   - Visualizza elenco paginato degli indirizzi
   - Implementa filtri e azioni in batch

3. **Pages/CreateAddress.php**
   - Estende `XotBaseCreateRecord`
   - Form per la creazione di nuovi indirizzi

4. **Pages/EditAddress.php**
   - Estende `XotBaseEditRecord`
   - Form per la modifica degli indirizzi esistenti

5. **Pages/ViewAddress.php**
   - Estende `XotBaseViewRecord`
   - Visualizzazione dettagliata di un indirizzo

## Convenzioni Rispettate

### Namespace

```php
namespace Modules\Geo\Filament\Resources;
```

### Estensioni di Classi

- Risorse estendono `Modules\Xot\Filament\Resources\XotBaseResource`
- Pagine estendono le classi base corrispondenti nel namespace `Modules\Xot\Filament\Resources\Pages`

### Traduzioni

- Tutte le etichette e i messaggi utilizzano i file di traduzione
- Nessun uso di `->label()` diretto
- Struttura delle chiavi di traduzione: `address-resource.fields.nome_campo`

### Schema dei Form e delle Tabelle

- Array associativi con chiavi stringhe
- Tipo restituito documentato correttamente
- Validazione dei dati tramite regole Laravel

## Funzionalità Specifiche

1. **Integrazione con Google Maps**
   - Visualizzazione degli indirizzi su mappa
   - Geocoding per la conversione degli indirizzi in coordinate
   - Autocompletamento degli indirizzi durante l'inserimento

2. **Gestione Relazioni Polimorfiche**
   - Visualizzazione dell'entità correlata (modello a cui appartiene l'indirizzo)
   - Filtro per tipo di entità

3. **Visualizzazione Gerarchica**
   - Raggruppamento per regione, provincia, comune
   - Filtri gerarchici (es. selezionare prima la regione, poi la provincia)

4. **Validazione Specializzata**
   - Controllo formato CAP italiano
   - Verifica esistenza comuni e province

## Considerazioni Filosofiche

La progettazione di questa risorsa riflette principi fondamentali:

1. **Coesione Semantica**: Tutte le funzionalità relative agli indirizzi sono centralizzate
2. **Singola Responsabilità**: Ogni componente ha uno scopo chiaro e definito
3. **Estensibilità**: L'architettura permette future espansioni senza modificare il core
4. **Consistenza**: L'interfaccia è coerente con le altre risorse del sistema

## Riuso nei moduli consumer

Quando un altro modulo (es. StudioResource) deve gestire indirizzi, è best practice riutilizzare lo schema del form di AddressResource:

```php
'addresses' => Forms\Components\Repeater::make('addresses')
    ->relationship('addresses')
    ->schema(Modules\Geo\Filament\Resources\AddressResource::getFormSchema())
```

### Motivazione
- DRY: nessuna duplicazione di logica
- Coerenza UI tra tutti i moduli
- Manutenzione centralizzata

## Riferimenti

- [../app/Models/Address.php](../app/Models/Address.php)
- [../../Xot/app/Filament/Resources/XotBaseResource.php](../../Xot/app/Filament/Resources/XotBaseResource.php)
- [filament.md](./filament.md)
- [models/address.md](./models/address.md)
