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

## AddressColumn come colonna Filament riusabile

Oltre allo schema di form, il modulo Geo espone anche una colonna tabellare riusabile per gli indirizzi:

- **Classe**: `Modules\Geo\Filament\Tables\Columns\AddressColumn`
- **View**: `geo::filament.tables.columns.address`
- **Pattern**:
  - Estende `ViewColumn` e segue lo stesso approccio di `ContactColumn` nel modulo Notify (ViewColumn + Blade view dedicata).
  - La Blade view compone l indirizzo partendo da `full_address` (se presente) oppure dai singoli campi `address`, `city`, `province`, `postal_code`, `country`.
  - È pensata come componente condiviso tra moduli consumer, ad esempio:

    ```php
    use Modules\Geo\Filament\Tables\Columns\AddressColumn;

    // ...
    'address' => AddressColumn::make('full_address'),
    ```

- **Filosofia**:
  - Geo è il modulo sorgente per tutte le primitive di indirizzo (migrazioni, enum, form schema, colonne tabellari).
  - I moduli consumer (come Meetup) non definiscono varianti locali di AddressColumn ma la riusano, mantenendo un solo punto di verità e semplificando manutenzione e refactor.

## AddressItemEnum e icone dei campi contatto

`AddressItemEnum` non gestisce solo le componenti strettamente geografiche (route, locality, postal_code, ecc.), ma anche alcuni campi di contatto associati all indirizzo:

- `fax`, `mobile`, `pec`, `whatsapp`, `email`, `notes`

Per ognuno di questi casi:

- Le proprietà `label`, `description`, `icon`, `color` sono risolte tramite i file di lingua del modulo Geo:

  - `Modules/Geo/lang/it/address_item_enum.php`
  - `Modules/Geo/lang/en/address_item_enum.php`
  - `Modules/Geo/lang/de/address_item_enum.php`

- Il metodo `getIcon()` dell enum ritorna il valore della chiave `*.icon`, che viene passato come `prefixIcon` ai `TextInput` generati da `AddressItemEnum::getFormSchema()`.

### Nota operativa

- Se manca una traduzione (es. `fax.icon`), Filament/BladeUI cercherà un icona con nome uguale alla chiave (`geo::address_item_enum.fax.icon`) e genererà un errore `SvgNotFound`.
- Per aggiungere nuovi item a `AddressItemEnum` è quindi **obbligatorio**:
  - Aggiornare **tutte** le lingue in `lang/*/address_item_enum.php` con `label`, `description`, `icon`, `color`.
  - Documentare la scelta delle icone in questo file o in una doc dedicata agli enum Geo.

## Riferimenti

- [../app/Models/Address.php](../app/Models/Address.php)
- [../../Xot/app/Filament/Resources/XotBaseResource.php](../../Xot/app/Filament/Resources/XotBaseResource.php)
- [filament.md](./filament.md)
- [models/address.md](./models/address.md)
