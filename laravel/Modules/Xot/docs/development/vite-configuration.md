# Configurazione Vite

## Problema
Durante l'analisi statica con PHPStan, potrebbe verificarsi l'errore:
```
Vite manifest not found at: /path/to/public/assets/chart/manifest.json
```

## Causa
Questo errore si verifica quando:
1. Il manifest di Vite non è stato generato
2. Il percorso del manifest non è corretto nella configurazione
3. L'ambiente di sviluppo non è completamente configurato

## Soluzione

### 1. Generare il manifest
```bash
npm run build
```

### 2. Configurare il percorso corretto
In `config/vite.php`:
```php
return [
    'manifest_path' => public_path('build/manifest.json'),
    'build_path' => public_path('build'),
];
```

### 3. Configurazione per PHPStan
Per evitare questo errore durante l'analisi PHPStan, aggiungere al file `phpstan.neon`:
```yaml
parameters:
    bootstrapFiles:
        - %currentWorkingDirectory%/vendor/larastan/larastan/bootstrap.php
    ignoreErrors:
        - '#Vite manifest not found#'
```

## Best Practices
1. Mantenere sempre aggiornato il manifest di Vite
2. Utilizzare percorsi relativi nella configurazione
3. Verificare la presenza del manifest prima del deployment

## Collegamenti
- [Documentazione Vite](docs/tools/vite.md)
- [Configurazione Build](docs/deployment/build-configuration.md) 