# Utilizzo di PHPStan nel Modulo Chart

## Introduzione

Questo documento descrive come utilizzare PHPStan per l'analisi statica del codice nel modulo Chart, incluse le best practices, le convenzioni di documentazione e le linee guida per la risoluzione degli errori.

## Convenzioni di Documentazione

### Principi Generali

1. **Genericità**: I report e la documentazione PHPStan devono essere generici e riutilizzabili
   - Non includere mai riferimenti specifici al progetto (nomi di progetto, percorsi assoluti specifici, ecc.)
   - Utilizzare placeholder o variabili per riferimenti specifici al progetto
   - Mantenere una documentazione generica e adattabile

2. **Percorsi**: Utilizzare percorsi relativi o placeholder generici
   - Formato corretto: `{project_root}/laravel/Modules/Chart/...`
   - Evitare percorsi assoluti specifici come `/var/www/html/project_name/...`

3. **Versionamento**: I report PHPStan devono essere versionati
   - Includere sempre la data dell'analisi
   - Mantenere la cronologia dei report per tracciare i progressi

## Struttura dei Report

Ogni report di livello PHPStan deve seguire questa struttura:

```markdown

# Rapporto PHPStan Livello X per il modulo Chart

Data analisi: YYYY-MM-DD HH:MM:SS

## Riepilogo

Trovati N errori al livello X.

## Errori e suggerimenti

### File: `{project_root}/laravel/Modules/Chart/path/to/file.php`

#### Linea Y: Descrizione dell'errore

**Suggerimento generale**: Rivedi il codice per assicurarti che:
- Tutte le classi/interfacce utilizzate siano importate correttamente
- I tipi siano dichiarati e utilizzati in modo coerente
- Le variabili siano inizializzate prima dell'uso
- I nomi di metodi e proprietà siano corretti

## Soluzioni Implementate

1. **Problema**: Descrizione del problema
   **Soluzione**: Descrizione della soluzione implementata
   **File**: `path/to/file.php`
   **Commit**: ID del commit (se disponibile)

## Collegamenti Bidirezionali

- [README PHPStan](README.md) - Panoramica dell'analisi PHPStan
- [Livello X-1](level_X-1.md) - Livello precedente
- [Livello X+1](level_X+1.md) - Livello successivo
- [README del Modulo](../README.md) - Documentazione principale del modulo
```

## Best Practices

1. **Risoluzione degli Errori**:
   - Risolvere gli errori partendo dal livello più basso
   - Documentare le soluzioni implementate
   - Aggiornare i report dopo ogni risoluzione

2. **Aggiornamento dei Report**:
   - Aggiornare i report dopo ogni esecuzione di PHPStan
   - Mantenere la cronologia delle modifiche
   - Documentare le decisioni architetturali

3. **Integrazione Continua**:
   - Eseguire PHPStan come parte del processo CI/CD
   - Bloccare i merge se PHPStan fallisce
   - Mantenere un livello minimo di conformità

## Collegamenti Bidirezionali

- [README del Modulo Chart](../README.md) - Documentazione principale del modulo
- [README PHPStan](phpstan/README.md) - Panoramica dell'analisi PHPStan
- [Bottlenecks](../bottlenecks.md) - Analisi delle performance
- [Convenzioni di Naming](../../../../docs/standards/file_naming_conventions.md) - Standard per la nomenclatura dei file

## Collegamenti tra versioni di phpstan-usage.md
* [phpstan-usage.md](../../Notify/docs/phpstan-usage.md)

