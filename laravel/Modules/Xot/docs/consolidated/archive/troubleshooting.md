# Risoluzione Problemi PHPStan

## Errore Vite Manifest

### Problema
Durante l'esecuzione di PHPStan si verifica l'errore:
```
Vite manifest not found at: /path/to/public/assets/chart/manifest.json
```

### Soluzioni Temporanee

#### 1. Ignorare l'errore
Aggiungere al file `phpstan.neon`:
```yaml
parameters:
    ignoreErrors:
        - '#Vite manifest not found#'
```

#### 2. Analizzare un modulo alla volta
Invece di analizzare tutti i moduli insieme, analizzare un modulo specifico:
```bash
./vendor/bin/phpstan analyse Modules/NomeModulo
```

#### 3. Disabilitare temporaneamente il bootstrap di Larastan
Modificare `phpstan.neon`:
```yaml
parameters:
    bootstrapFiles:
        - phpstan_bootstrap.php  # File di bootstrap personalizzato
```

### Soluzione Permanente

1. Assicurarsi che il manifest di Vite sia generato:
```bash
npm run build
```

2. Configurare correttamente il percorso del manifest in `config/vite.php`

3. In ambiente di sviluppo, mantenere sempre aggiornato il manifest con:
```bash
npm run dev
```

## Altri Problemi Comuni

### 1. Errori di Tipo
- Utilizzare type hints appropriati
- Documentare i tipi con PHPDoc
- Utilizzare strict_types=1

### 2. Dipendenze
- Verificare che tutte le dipendenze siano installate
- Controllare la compatibilità delle versioni
- Utilizzare Composer per gestire le dipendenze

### 3. Configurazione
- Mantenere il livello di analisi appropriato
- Configurare correttamente i paths
- Gestire le esclusioni quando necessario

## Best Practices

1. Iniziare con un livello di analisi basso (0-3)
2. Aumentare gradualmente il livello
3. Documentare le decisioni di ignore
4. Mantenere un registro degli errori risolti
5. Aggiornare regolarmente la documentazione

## Collegamenti
- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)
- [Larastan Documentation](https://github.com/nunomaduro/larastan)
- [Vite Configuration](../development/vite-configuration.md) 