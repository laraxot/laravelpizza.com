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

- [Geo Module Documentation](../README.md)
- [Factory Pattern Guidelines](../../../docs/factory-pattern.md)
- [PHPStan Compliance Guide](../phpstan-fixes.md)

*Ultimo aggiornamento: 2025-01-06*
