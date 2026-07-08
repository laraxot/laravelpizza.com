# PHPStan Configuration - Theme Zero

## Regola Fondamentale

**SOLO `laravel/phpstan.neon` è la configurazione valida.**

### ❌ VIETATO
- Creare file `phpstan*.json` nei temi
- Creare configurazioni alternative `phpstan.neon.dist`
- Committare file di output PHPStan

### ✅ PERMESSO
- Usare `laravel/phpstan.neon` (configurazione centralizzata)
- File di output temporanei (esclusi da .gitignore)

## Configurazione Centralizzata

```
laravel/
└── phpstan.neon          # UNICA configurazione valida
```

## Output Files

I file di output PHPStan (es: `phpstan_themes_zero_filtered.json`) sono:
- File temporanei di analisi
- Da escludere nel `.gitignore`
- **MAI committati nel repository**

## .gitignore Aggiornamento

Aggiungere al `.gitignore` del tema:
```
# PHPStan output files
phpstan*.json
```

## Esecuzione Analisi

```bash
cd ./laravel
./vendor/bin/phpstan analyse --level=10
```

## Riferimenti

- [PHPStan Level 10 Guidelines](../../docs/phpstan-level10.md)
- [Root phpstan.neon](../../laravel/phpstan.neon)
