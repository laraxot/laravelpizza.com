# Testing Rules Summary

## Regole Fondamentali dei Test

### 1. **Pest Testing Mandatory**
- **MAI** usare PHPUnit class-based (`class Test extends TestCase`)
- **SEMPRE** usare Pest functional syntax (`test()`, `it()`)
- I test devono essere scritti in formato Pest, non PHPUnit

### 2. **NO RefreshDatabase - MAI**
- **MAI** usare `use RefreshDatabase` nei test
- **MAI** usare `RefreshDatabase` trait
- Utilizzare `.env.testing` con SQLite in-memory
- Usare `DatabaseTransactions` se necessario (raro)

### 3. **Configurazione Testing**
- Tutti i test devono leggere `.env.testing`
- PHPStan usa configurazione da `phpstan.neon` (non passare livello come parametro)
- Script di conversione vanno in `bashscripts/`, non nella root di Laravel

### 4. **XotBase/LangBase Extension**
- **MAI** estendere classi Filament direttamente
- **SEMPRE** estendere `XotBase*` o `LangBase*` a seconda del modulo
- Controllare se il modulo è multilingue prima di scegliere

### 5. **property_exists() Prohibition**
- **MAI** usare `property_exists()` con modelli Eloquent
- Usare `isset()` per proprietà magiche

## Struttura dei Test

### File di Configurazione
- `.env.testing` - configurazione ottimizzata per test veloci
- `phpunit.xml` - configurazione principale
- `phpstan.neon` - configurazione PHPStan (livello già impostato)

### Directory dei Test
```
laravel/tests/              # Test principali
laravel/Modules/*/tests/    # Test dei moduli
laravel/Themes/*/tests/     # Test dei temi
```

### File Pest
Ogni modulo può avere il proprio `Pest.php` con:
- Estensioni personalizzate
- Helper functions
- Custom expectations

## Comandi Importanti

### PHPStan
```bash
# ❌ ERRATO - Non passare il livello
./vendor/bin/phpstan analyse --level=8 Modules

# ✅ CORRETTO - Usa configurazione da phpstan.neon
./vendor/bin/phpstan analyse Modules --memory-limit=-1
```

### Testing
```bash
# Run all tests
composer test

# Run Pest tests
./vendor/bin/pest

# Test specific module
cd Modules/ModuleName && ./vendor/bin/pest
```

### Conversione PHPUnit → Pest
```bash
# Script di conversione (in bashscripts/)
php bashscripts/test_conversion/convert_phpunit_to_pest.php
```

## Errori Comuni da Evitare

### ❌ Errori Gravi
1. Usare `RefreshDatabase` in qualsiasi test
2. Scrivere test PHPUnit class-based invece di Pest
3. Passare livello a PHPStan come parametro
4. Mettere script nella root di Laravel invece che in `bashscripts/`
5. Estendere classi Filament direttamente invece di XotBase/LangBase

### ✅ Best Practices
1. Usare `.env.testing` con SQLite in-memory
2. Scrivere test in formato Pest functional
3. Usare `DatabaseTransactions` invece di `RefreshDatabase`
4. Seguire la struttura esistente dei test
5. Documentare le regole nei file `docs/` dei moduli

## Documentazione

Ogni modulo e tema deve documentare:
1. Regole specifiche del modulo
2. Configurazione testing
3. Esempi di test corretti
4. Errori comuni da evitare

I file di documentazione vanno nelle cartelle `docs/` dentro ogni modulo/tema.
