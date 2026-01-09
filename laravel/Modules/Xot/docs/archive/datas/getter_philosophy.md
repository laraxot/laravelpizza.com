# Filosofia dei Metodi Getter in Xot

## Principi Fondamentali

### 1. Semantica vs. Implementazione
I metodi getter devono riflettere il loro scopo semantico, non solo l'implementazione. Per esempio:
- ❌ `getLogoHeader()` - riflette l'implementazione
- ✅ `getBrandLogo()` - riflette lo scopo semantico

### 2. Coerenza con il Dominio
I nomi dei metodi devono essere coerenti con il dominio dell'applicazione:
- Usa termini del dominio (es. "brand" invece di "header")
- Evita termini tecnici quando non necessari
- Mantieni la coerenza con il linguaggio del business

### 3. Incapsulamento
I metodi getter devono nascondere i dettagli di implementazione:
- Non esporre la struttura interna dei dati
- Fornire un'interfaccia pulita e semantica
- Permettere modifiche future all'implementazione

## Esempi Pratici

### Logo
```php
// ❌ Riflette l'implementazione
->brandLogo($metatag->getLogoHeader())

// ✅ Riflette lo scopo semantico
->brandLogo($metatag->getBrandLogo())
```

### Colori
```php
// ❌ Riflette la struttura dei dati
->colors($metatag->getColors())

// ✅ Riflette lo scopo semantico
->colors($metatag->getThemeColors())
```

## Linee Guida per l'Implementazione

1. **Naming**
   - Usa nomi che descrivono lo scopo, non l'implementazione
   - Mantieni la coerenza con il dominio
   - Evita prefissi/suffissi tecnici non necessari

2. **Documentazione**
   - Documenta sempre lo scopo semantico del metodo
   - Spiega il contesto d'uso
   - Fornisci esempi pratici

3. **Mantenimento**
   - Rivedi periodicamente i nomi dei metodi
   - Aggiorna la documentazione quando cambia lo scopo
   - Mantieni la retrocompatibilità quando possibile

## Collegamenti
- [Convenzioni di Naming](../naming-conventions.md)
- [Documentazione MetatagData](../datas/metatagdata.md)
- [Linee Guida Filament](../filament-best-practices.md) 
