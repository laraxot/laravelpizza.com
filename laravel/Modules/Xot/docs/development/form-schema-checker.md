# Form Schema Checker

## Perché
Lo script `check_form_schema.php` è stato creato per garantire che tutte le classi che estendono `XotBaseResource` implementino correttamente il metodo `getFormSchema`. Questo è fondamentale per mantenere la consistenza nell'implementazione dei form in Filament.

## Cosa
Lo script:
1. Scansiona ricorsivamente la directory specificata alla ricerca di file PHP
2. Identifica le classi che estendono `XotBaseResource`
3. Verifica la presenza del metodo `getFormSchema`
4. Genera un report dettagliato delle classi che non implementano il metodo
5. Registra i risultati in un file di log

## Implementazione
Lo script utilizza:
- Type hints rigorosi per garantire la type safety
- Le funzioni sicure di `thecodingmachine/safe` per una gestione robusta degli errori
- PHPStan livello 9 per garantire la massima qualità del codice
- Gestione appropriata dei tipi nullabili e controlli di tipo

## Come
```bash
php check_form_schema.php
```

## Output
Lo script produce:
- Un report a console che mostra:
  - Il numero totale di classi controllate
  - Le classi che mancano del metodo `getFormSchema`
- Un file di log con timestamp che registra i risultati del controllo

## Sicurezza e Robustezza
- Utilizzo di `declare(strict_types=1)` per type checking rigoroso
- Gestione sicura dei file tramite `Safe\file_get_contents` e `Safe\file_put_contents`
- Controlli di tipo espliciti per gli oggetti `SplFileInfo`
- Gestione appropriata dei valori di ritorno nullable

## Collegamenti Correlati
- [Filament Best Practices](../FILAMENT_BEST_PRACTICES.md)
- [XotBaseResource Documentation](../architecture/xot_base_resource.md)
- [PHPStan Configuration](../phpstan-usage.md) 