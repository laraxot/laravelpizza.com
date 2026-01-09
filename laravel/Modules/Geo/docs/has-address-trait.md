# Trait HasAddress

## Panoramica

Il trait `HasAddress` fornisce una soluzione standardizzata per la gestione degli indirizzi in tutti i modelli dell'applicazione <main module>. Questo trait implementa il pattern di relazione polimorfica con il modello `Address` del modulo Geo, permettendo a qualsiasi entità di avere uno o più indirizzi associati.

## Motivazione Filosofica

### Principio DRY (Don't Repeat Yourself)

Il codice per la gestione degli indirizzi era ripetuto in vari modelli, violando il principio DRY. Questa ripetizione creava:

- Duplicazione di logica
- Difficoltà di manutenzione
- Incoerenza nell'implementazione
- Maggiore rischio di errori

### Cohesion vs Coupling
Il trait rappresenta un equilibrio tra:

- **Alta coesione**: Raggruppando funzionalità correlate (gestione indirizzi)
- **Basso accoppiamento**: Minimizzando le dipendenze tra moduli

### Principio di Responsabilità Singola
Ogni modello dovrebbe avere una sola responsabilità. La gestione degli indirizzi è una responsabilità distinta che merita la propria astrazione.

## Implementazione Tecnica

Il trait `HasAddress` implementa:

1. **Relazioni polimorfiche**:
   - `addresses()`: Relazione morphMany per gestire più indirizzi
   - `primaryAddress()`: Metodo per ottenere l'indirizzo principale

2. **Metodi di utilità**:
   - `getFullAddress()`: Ottiene l'indirizzo completo formattato
   - `getCity()`: Estrae la città dall'indirizzo principale
   - `getPostalCode()`: Estrae il CAP dall'indirizzo principale
   - `getFormattedAddressAttribute()`: Formatta l'indirizzo in modo leggibile

3. **Gestione degli attributi**:
   - `getContactInfo()`: Raccoglie informazioni di contatto incluso l'indirizzo

## Utilizzo nel Modello Studio

Il modello Studio (e qualsiasi altro modello che necessita di indirizzi) può implementare il trait semplicemente con:

```php
use Modules\Geo\Models\Traits\HasAddress;

class Studio extends Model
{
    use HasAddress;

    // Resto del modello...
}
```

## Vantaggi Architetturali

1. **Standardizzazione**: Tutti i modelli utilizzano la stessa implementazione
2. **Manutenibilità**: Modifiche alla gestione degli indirizzi in un solo punto
3. **Estensibilità**: Facile aggiungere funzionalità relative agli indirizzi
4. **Coerenza**: Comportamento uniforme in tutta l'applicazione

## Riuso di AddressResource nei form di altri moduli

Quando un modello (es. Studio) necessita di gestire indirizzi tramite Filament, è best practice riutilizzare lo schema del form di AddressResource:

```php
'addresses' => Forms\Components\Repeater::make('addresses')
    ->relationship('addresses')
    ->schema(Modules\Geo\Filament\Resources\AddressResource::getFormSchema())
```

### Motivazione filosofica
- **DRY**: Un solo punto di verità per la UI degli indirizzi.
- **Coerenza**: Tutti i moduli presentano la stessa UX per la gestione degli indirizzi.
- **Manutenibilità**: Ogni modifica a AddressResource si propaga ovunque.
- **Zen**: Serenità e semplicità nella manutenzione.

### Best practice
- Non duplicare mai la logica dei form Address nei moduli consumer.
- Aggiornare sempre la documentazione e i collegamenti relativi.

## Riferimenti

- [Address](../app/Models/Address.php)
- [Address Model Italian](address-model-italian.md)
- [Morphs Relationship Patterns](morphs-relationship-patterns.md)
- [HasPlaceTrait](../app/Models/Traits/HasPlaceTrait.php)
- [models/address.md](./models/address.md)
- [address-implementation.md](./address-implementation.md)
- [filament.md](./filament.md)
