# Development Guidelines - Xot Module

## Panoramica
Questo documento fornisce linee guida generali per lo sviluppo e la qualità del codice nel progetto <nome progetto>.

## PHPStan Best Practices

### Type Safety
- Utilizzare sempre `declare(strict_types=1);`
- Type hints espliciti per tutti i parametri e return types
- Gestione corretta dei tipi `mixed` con type casting appropriato

### Best Practices PHPStan
- Evitare accesso statico a proprietà di istanza
- Utilizzare type hints specifici invece di `mixed` quando possibile
- Aggiungere commenti PHPDoc per type casting quando necessario

### Architettura Modulare
- Mantenimento dei confini dei moduli
- Rispetto delle responsabilità di ogni classe
- Documentazione delle decisioni architetturali

## Correzioni Implementate

### Moduli Corretti
- [FormBuilder FieldOption Model](../FormBuilder/project_docs/phpstan-corrections.md)
- [Lang Console Commands](../Lang/project_docs/phpstan-corrections.md)

## Principi di Correzione

### Type Safety
- Utilizzare sempre `declare(strict_types=1);`
- Type hints espliciti per tutti i parametri e return types
- Gestione corretta dei tipi `mixed` con type casting appropriato

### Best Practices PHPStan
- Evitare accesso statico a proprietà di istanza
- Utilizzare type hints specifici invece di `mixed` quando possibile
- Aggiungere commenti PHPDoc per type casting quando necessario

### Architettura Modulare
- Mantenimento dei confini dei moduli
- Rispetto delle responsabilità di ogni classe
- Documentazione delle decisioni architetturali

## Collegamenti Correlati

- [FormBuilder PHPStan Corrections](../FormBuilder/project_docs/phpstan-corrections.md)
- [Lang PHPStan Corrections](../Lang/project_docs/phpstan-corrections.md)
- [Xot Architecture](./architecture.md)

## Note per Sviluppo Futuro

1. **Type Safety**: Mantenere sempre type hints espliciti
2. **Static Properties**: Evitare accesso statico a proprietà di istanza
3. **Mixed Types**: Gestire sempre i tipi `mixed` con type casting appropriato
4. **Documentation**: Aggiornare sempre la documentazione dopo correzioni significative 
