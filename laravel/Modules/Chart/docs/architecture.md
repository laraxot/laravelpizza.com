# Geo Module Architecture

## Overview
The Geo module is responsible for managing all geographical data and functionality across the application. It provides a centralized way to handle locations, addresses, and geographical hierarchies.

## Key Components

### Models
- `Region`: Represents a geographical region (e.g., Lombardy, Lazio)
- `Province`: Represents a province within a region
- `City`: Represents a city within a province
- `Cap`: Represents a postal code (CAP) for a city
- `Address`: Handles complete address information (con **campi separati per regione e provincia**, vedi sezione dedicata)
- `Location`: Manages geographical coordinates and locations
- `Place`: Represents points of interest with geographical data

### Relationships
- Region has many Provinces
- Province belongs to a Region and has many Cities
- City belongs to a Province and has many CAPs
- CAP belongs to a City

## Usage in Other Modules

Other modules should import and use the Geo module's models instead of maintaining their own geographical data. For example:

```php
use Modules\Geo\Models\City;
use Modules\Geo\Models\Province;
use Modules\Geo\Models\Region;
```

## Data Management

### Migrations
All geographical data migrations are stored in the Geo module's `database/migrations` directory. These include:
- Region, Province, City, and CAP tables
- Location and Place related tables
- Any geographical indexes and relationships

### Seeders
Seeders for geographical data are provided to populate the database with initial data.

## Best Practices
1. Always use the Geo module's models for geographical data
2. Don't create duplicate geographical models in other modules
3. Use the provided relationships to navigate geographical hierarchies
4. Keep all geographical business logic within this module

## Related Documentation
- [Geo Module API Reference](./api.md)
- [Data Models](./models.md)
- [Migrations](./migrations.md)

## Separazione regione e provincia negli indirizzi italiani

Per tutti gli indirizzi italiani è obbligatorio:
- Salvare **regione** e **provincia** come campi separati (mai concatenati)
- La provincia va sempre salvata come sigla (es. MI), la regione come nome completo (es. Lombardia)
- Seguire la struttura e i mapping descritti in [place-address-schemaorg.md](./place-address-schemaorg.md)

## Perché tutti i modelli Geo DEVONO estendere BaseModel (e NON Model)?

### Filosofia
- **Centralizzazione**: BaseModel incapsula tutte le policy, i trait, le convenzioni e le regole comuni a TUTTI i modelli geografici. Questo garantisce coerenza, DRY, e facilita la manutenzione.
- **Connessione dedicata**: BaseModel imposta la connessione `geo` per tutti i modelli, separando i dati geografici dal resto dell'applicazione (multi-db ready, multi-tenant ready).
- **Trait Updater**: Tutti i modelli ereditano la gestione automatica di updated_by, created_by, ecc. (audit trail, accountability, trasparenza).
- **Override centralizzato**: Qualsiasi logica trasversale (snakeAttributes, perPage, timestamps, fillable, casts, ecc.) viene gestita in un solo punto.

### Religione
- **Non avrai altro Model all'infuori di BaseModel**: la purezza architetturale si ottiene solo eliminando le eccezioni e le derive. Ogni deviazione è fonte di caos e bug futuri.

### Politica
- **Governance del dato**: separare i modelli geografici dal resto del dominio permette policy di backup, restore, replica, caching e performance dedicate.
- **Facilità di refactoring**: se domani cambi DB, caching, policy, basta toccare BaseModel.

### Zen
- **Un solo punto di verità**: meno codice, meno errori, più serenità.
- **La via del modulo**: ogni modulo ha la sua BaseModel, ogni BaseModel è figlia della sua filosofia.

### Best practice
- **Mai** estendere direttamente Model nei modelli del modulo Geo.
- **Sempre** estendere BaseModel.
- **Aggiornare la documentazione e Xot/docs in caso di modifica della policy.

> Vedi anche: Xot/docs/standards/coding-standards.md, Xot/docs/filosofia.md, Xot/docs/zen.md

## Perché usare nullableUuidMorphs('model') invece di nullableMorphs('addressable')?

### Logica e motivazione
- In un sistema multi-tenant e multi-modello, alcuni modelli (es. User) usano UUID come chiave primaria, altri usano integer.
- `nullableUuidMorphs('model')` crea due colonne: `model_type` (string) e `model_id` (uuid, nullable), permettendo di collegare sia modelli con chiave integer che uuid.
- `nullableMorphs('addressable')` crea sempre `addressable_id` come integer, causando errori o incoerenze con modelli a chiave uuid.
- Non esiste (ad oggi) un metodo Laravel `nullableStringMorphs`, quindi la scelta più compatibile e forward-proof è `nullableUuidMorphs`.
- Il nome 'model' è semantico, neutro, e coerente con la filosofia del modulo Geo (vedi anche Place, Location, ecc.).

### Filosofia
- **Universalità**: la relazione polimorfica deve poter collegare qualsiasi modello, senza vincoli di tipo chiave.
- **Neutralità semantica**: 'model' è più generico e riusabile di 'addressable', 'placeable', ecc.
- **Futuro-proof**: se domani tutti i modelli passano a uuid, la struttura è già pronta.

### Religione
- **Non avrai altro morph all'infuori di model**: la purezza architetturale si ottiene solo eliminando le derive e le eccezioni.

### Politica
- **Inclusività**: ogni modello, uuid o integer, è benvenuto nella relazione.
- **Governance**: la struttura è pronta per ogni evoluzione futura del dominio.

### Zen
- **Un solo morph per domarli tutti**: meno codice, meno errori, più serenità.

### Best practice
- Usare sempre `$table->nullableUuidMorphs('model')` per le relazioni polimorfiche in Geo.
- Non usare mai `$table->nullableMorphs('addressable')` o simili.
- Documentare sempre la scelta e aggiornarla in caso di evoluzione di Laravel.

---

## Perché non usare $table->timestamps() ma updateTimestamps($table, true)?

- La funzione custom `updateTimestamps($table, true)` aggiunge sia i timestamps standard (`created_at`, `updated_at`) sia (se configurato) i soft deletes (`deleted_at`), e può gestire anche colonne custom come `created_by`, `updated_by`.
- Usare solo `$table->timestamps()` sarebbe limitante e non garantirebbe la coerenza con la policy di audit trail e accountability del progetto.
- La centralizzazione della logica dei timestamps in una funzione custom permette di cambiare policy in un solo punto.

---

> Vedi anche: Xot/docs/standards/coding-standards.md, Xot/docs/filosofia.md, Xot/docs/zen.md
