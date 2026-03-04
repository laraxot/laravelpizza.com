# Sushi Implementation for Comune Model

## Overview

This document outlines the implementation of the [calebporzio/sushi](https://github.com/calebporzio/sushi) package for the `Comune` model in the Geo module.

## Why Sushi?

- **Performance**: In-memory SQLite database for faster queries
- **Simplicity**: Eliminates the need for database migrations
- **Version Control**: Data is stored in JSON files
- **Development Experience**: Faster development cycles

## Policy aggiornata: niente trait per una sola classe
Non ha senso creare un trait come ComuneSushiTrait se viene usato solo in un modello. I trait vanno creati solo se riutilizzati in più classi. Se la logica è specifica di un solo modello, va implementata direttamente nella classe. Motivazione: semplicità, KISS, manutenibilità, evitare complessità inutile. Collegamento a docs/xot.md.

## Implementation Details

### File Structure

```plaintext
Modules/Geo/
├── app/
│   ├── Models/
│   │   └── Comune.php
│   └── Traits/
│       └── ComuneSushiTrait.php
├── database/
│   └── content/
│       ├── comuni/
│       │   ├── 1.json
│       │   ├── 2.json
│       │   └── ...
│       └── comuni.json
└── docs/
    └── sushi-implementation-guide.md
```

### Migration Steps

1. **Create JSON Files**

   - Convert existing data into individual JSON files
   - Store in `database/content/comuni/`

2. **Update Composer**

   ```bash
   composer require calebporzio/sushi
   ```

3. **Update Model**

   - Use the `ComuneSushiTrait` trait
   - Implement `getSushiRows()`
   - Add schema definition

4. **Testing**

   - Unit tests for all queries
   - Performance benchmarks
   - Memory usage tests

## Performance Considerations

- **Memory Usage**: Keep an eye on memory with large datasets
- **Cache Strategy**: Implement proper caching
- **Lazy Loading**: Consider lazy loading for large datasets

## Maintenance

- Update JSON files via migrations
- Monitor memory usage
- Regular performance testing
