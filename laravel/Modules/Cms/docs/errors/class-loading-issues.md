# Errori di Caricamento Classi

## Problema: Riferimenti a Classi Rinominate

### Sintomo
```
include(...PageContentResource.php): Failed to open stream: No such file or directory
```

### Cause Comuni
1. **Service Provider non aggiornato**
   - Registrazione di vecchi nomi di classe
   - Riferimenti hardcoded a classi rinominate
   - Configurazioni non aggiornate

2. **Cache di Composer**
   - Class map non aggiornata
   - Autoloader che cerca vecchi percorsi
   - Cache che mantiene vecchi riferimenti

3. **File di Configurazione**
   - Riferimenti in `config/*.php`
   - Service provider non aggiornati
   - Route che usano vecchi nomi di classe

### Soluzione
1. **Aggiornare Service Provider**
   ```php
   // Da evitare
   use Modules\Cms\Filament\Resources\PageContentResource;
   
   // Corretto
   use Modules\Cms\Filament\Resources\SectionResource;
   ```

2. **Pulire Cache**
   ```bash
   composer dump-autoload
   php artisan config:clear
   php artisan cache:clear
   ```

3. **Verificare Configurazioni**
   - Controllare tutti i file in `config/`
   - Verificare service provider
   - Controllare route e middleware

### Best Practices
1. **Durante Refactoring**
   - Documentare tutti i cambi di namespace
   - Aggiornare tutti i riferimenti
   - Testare in ambiente pulito

2. **Manutenzione**
   - Mantenere documentazione aggiornata
   - Seguire convenzioni di naming
   - Usare strumenti di analisi statica

## Collegamenti
- [Refactoring PageContent → Section](../refactoring/page-content-to-section.md)
- [Gestione Sezioni](../section-management.md)
- [Documentazione Root](../../../../docs/errors.md) 
