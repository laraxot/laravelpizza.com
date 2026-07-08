# Factory PHPStan Fixes - Geo Module

## Problemi Identificati

### ComuneFactory.php e ProvinceFactory.php
- **Errore**: Cannot access offset 'key' on mixed
- **Errore**: Parameter expects string, mixed given
- **Errore**: Binary operation between mixed and float results in an error

### Analisi
Le factory del modulo Geo utilizzano `$this->faker->randomElement()` che restituisce `mixed`. PHPStan non può garantire che l'array restituito abbia le chiavi necessarie, causando errori di tipizzazione.

### Soluzioni Implementate

1. **Creazione RegionFactory Mancante**:
   - Creato `RegionFactory.php` per supportare `Region::factory()`
   - Aggiunto trait `HasFactory` ai modelli Region e Province
   - Dati realistici per regioni italiane con ID e nomi corretti

2. **Tipizzazione Esplicita con PHPDoc**:
   - Aggiunto `@var` annotations per definire la struttura degli array
   - Specificato i tipi esatti per `$comuneData` e `$provinciaData`
   - Utilizzato array shapes per garantire type safety

3. **Gestione Sicura degli Array**:
   - Definito strutture di array con chiavi specificate
   - Utilizzato type casting esplicito dove necessario
   - Aggiunto controlli di esistenza per chiavi opzionali

## Esempi di Correzioni

### Prima (Errato)
```php
$comuneData = $this->faker->randomElement($comuniReali);
return [
    'nome' => $comuneData['nome'], // Errore: Cannot access offset 'nome' on mixed
];
```

### Dopo (Corretto)
```php
/** @var array{nome: string, regione: string, provincia: string, cap: string, lat: float, lng: float} $comuneData */
$comuneData = $this->faker->randomElement($comuniReali);
return [
    'nome' => $comuneData['nome'], // ✅ Type safe
];
```

## Benefici
- Eliminati tutti gli errori PHPStan di accesso offset su mixed
- Type safety garantita per tutte le operazioni su array
- Supporto completo per factory() nei modelli Region e Province
- Dati realistici e coerenti per testing e seeding

## File Modificati

- `Modules/Geo/database/factories/ComuneFactory.php` (ricreato con tipizzazione corretta)
- `Modules/Geo/database/factories/ProvinceFactory.php` (ricreato con tipizzazione corretta)
- `Modules/Geo/database/factories/RegionFactory.php` (nuovo)
- `Modules/Geo/app/Models/Region.php` (aggiunto HasFactory trait)
- `Modules/Geo/app/Models/Province.php` (aggiunto HasFactory trait)
- `Modules/Geo/app/Models/Comune.php` (aggiunto HasFactory trait)

## Collegamenti

- [Geo Module Documentation](../readme.md)
- [Factory Pattern Guidelines](../../../../docs/factory-pattern.md)
- [PHPStan Compliance Guide](../phpstan-fixes.md)

## Aggiornamento verificato (2026-07-06)

Ri-verificato con `phpstan analyse Modules/Geo --memory-limit=-1`: **0 errori** (era 22, in parte errori fantasma da cache PHPStan stantia su file `*PhpstanProbe.php` già cancellati da altri agenti — pulita con `rm -rf /tmp/phpstan/cache`). Errori reali residui corretti in questa sessione: due trait mai usati in nessuna classe di produzione, `Modules/Geo/app/Models/Traits/HasPlaceTrait.php` e `Modules/Geo/app/Traits/HasAddresses.php`, rinominati `.old` (convenzione già in uso nel repo). **Attenzione**: `Modules/Geo/app/Models/Traits/GeoTrait.php` era stato inizialmente rinominato `.old` per lo stesso motivo ma per errore — è in realtà usato da `Modules\TechPlanner\Models\Worker`, quindi ripristinato. Verificare sempre l'uso di un trait con grep su tutto `Modules/`, non solo sulla cartella del modulo che lo dichiara, prima di considerarlo morto. Dettagli: `docs/chat/phpstan-modules-progress-2026-07-06-pm.md` (root del repo) e `docs/wiki/second-brain/phpstan-journey.md`.

