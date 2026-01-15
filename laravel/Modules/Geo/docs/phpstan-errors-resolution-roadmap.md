# Geo Module - PHPStan Level 10 Errors Resolution Roadmap

## 📊 Stato Attuale

**Data Analisi**: Gennaio 2025  
**PHPStan Level**: 10  
**Totale Errori**: 189 errori in 20 file  
**Comando**: `./vendor/bin/phpstan analyse Modules/Geo --level=10`

## 🎯 Obiettivo

Ridurre gli errori PHPStan a **0** mantenendo la funzionalità esistente e rispettando i principi DRY + KISS.

## 📈 Distribuzione Errori per Tipo

1. **method.nonObject**: 51 errori (27.0%) - Chiamate a metodi su mixed
2. **argument.type**: 29 errori (15.3%) - Problemi con tipi degli argomenti
3. **property.nonObject**: 26 errori (13.8%) - Accesso a proprietà su mixed
4. **classConstant.notFound**: 22 errori (11.6%) - Costanti di classe non trovate
5. **return.type**: 20 errori (10.6%) - Problemi con tipi di ritorno
6. **Altri**: 41 errori (21.7%)

## 🔍 Top 10 File con Più Errori

1. `AddressItemEnum.php` - **67 errori** ⚠️ **CRITICO**
2. `Address.php` - 25 errori
3. `Locality.php` - 21 errori
4. `Province.php` - 12 errori
5. `Comune.php` - 11 errori
6. `Region.php` - 11 errori
7. `AddressField.php` - 6 errori
8. `AddressResource.php` - 6 errori
9. `OSMMapWidget.php` - 6 errori
10. `HasAddress.php` (vari contesti) - 5 errori

## 🚨 File Critico: AddressItemEnum.php

**67 errori** concentrati in un singolo file! Questo è il file più problematico di tutto il progetto.

**Analisi preliminare**:
- Probabilmente problemi con:
  - Costanti di classe non trovate (classConstant.notFound)
  - Metodi chiamati su mixed (method.nonObject)
  - Proprietà su mixed (property.nonObject)
  - Tipi di ritorno (return.type)

**Strategia**:
1. Analizzare completamente la struttura dell'enum
2. Verificare che tutte le costanti siano definite correttamente
3. Aggiungere type hints espliciti
4. Verificare che i metodi restituiscano i tipi corretti
5. Aggiungere PHPDoc completo

## 🎯 Pattern di Errori Identificati

### Pattern 1: Chiamate a Metodi su Mixed (51 errori - 27.0%)

**Problema**: Metodi chiamati su variabili di tipo `mixed`.

**Causa**: 
- Query builder che restituiscono `mixed` invece di tipi specifici
- Risultati di API esterne (Google Maps, Bing Maps) senza type hints
- Variabili senza type hints espliciti

**Soluzione**:
- Aggiungere type hints espliciti ai risultati delle query
- Usare `@var` annotations per specificare i tipi
- Implementare type casting appropriato
- Creare DTO per i risultati delle API esterne

### Pattern 2: Problemi con Tipi degli Argomenti (29 errori - 15.3%)

**Problema**: Argomenti di tipo `array|string|null` passati dove è richiesto un tipo specifico.

**Soluzione**:
- Usare `SafeStringCastAction` per le traduzioni
- Aggiungere type casting esplicito
- Verificare null safety

### Pattern 3: Accesso a Proprietà su Mixed (26 errori - 13.8%)

**Problema**: Accesso a proprietà su variabili di tipo `mixed`.

**Causa**: 
- Risultati di API esterne senza type hints
- Oggetti dinamici senza definizione di classe

**Soluzione**:
- Creare classi/DTO per i risultati delle API
- Usare `@var` annotations
- Implementare type casting appropriato

### Pattern 4: Costanti di Classe Non Trovate (22 errori - 11.6%)

**Problema**: Costanti di classe non riconosciute da PHPStan.

**Causa**: 
- Costanti definite in classi base non riconosciute
- Costanti in enum non riconosciute (probabilmente in AddressItemEnum)

**Soluzione**:
- Verificare che le costanti siano definite correttamente
- Aggiungere `@const` annotations se necessario
- Verificare che gli enum siano definiti correttamente

## 🗺️ Roadmap di Risoluzione

### Fase 1: Fix AddressItemEnum (Priorità Critica) ⚠️

**Obiettivo**: Risolvere i 67 errori in `AddressItemEnum.php`.

**Task**:
1. Analizzare completamente la struttura dell'enum
2. Verificare che tutte le costanti siano definite correttamente
3. Aggiungere type hints espliciti a tutti i metodi
4. Verificare che i return types siano corretti
5. Aggiungere PHPDoc completo con `@method` annotations se necessario
6. Verificare che l'enum estenda correttamente `BackedEnum` o `UnitEnum`
7. Testare le funzionalità dopo ogni modifica

**Tempo stimato**: 4-6 ore

**⚠️ IMPORTANTE**: Questo file è critico. Ogni modifica deve essere testata accuratamente.

### Fase 2: Fix Modelli Geografici (Priorità Alta)

**Obiettivo**: Risolvere errori nei modelli geografici.

**Task**:
1. `Address.php` (25 errori)
   - Fix metodi su mixed
   - Fix proprietà su mixed
   - Aggiungere type hints
2. `Locality.php` (21 errori)
   - Fix metodi su mixed
   - Fix return types
3. `Province.php` (12 errori)
4. `Comune.php` (11 errori)
5. `Region.php` (11 errori)

**Tempo stimato**: 4-5 ore

### Fase 3: Fix Metodi su Mixed (Priorità Alta)

**Obiettivo**: Risolvere i 51 errori di metodi su mixed.

**Task**:
1. Identificare tutti i file con errori `method.nonObject`
2. Aggiungere type hints espliciti
3. Usare `@var` annotations
4. Implementare type casting appropriato

**Tempo stimato**: 3-4 ore

### Fase 4: Fix Proprietà su Mixed (Priorità Media)

**Obiettivo**: Risolvere i 26 errori di proprietà su mixed.

**Task**:
1. Creare DTO per i risultati delle API esterne (Google Maps, Bing Maps)
2. Aggiungere type hints espliciti
3. Usare `@var` annotations

**Tempo stimato**: 2-3 ore

### Fase 5: Fix Tipi degli Argomenti (Priorità Media)

**Obiettivo**: Risolvere i 29 errori di tipi degli argomenti.

**Task**:
1. Usare `SafeStringCastAction` per le traduzioni
2. Aggiungere type casting esplicito
3. Verificare null safety

**Tempo stimato**: 2-3 ore

### Fase 6: Fix Costanti di Classe (Priorità Media)

**Obiettivo**: Risolvere i 22 errori di costanti non trovate.

**Task**:
1. Verificare che tutte le costanti siano definite correttamente
2. Aggiungere `@const` annotations se necessario
3. Verificare che gli enum siano definiti correttamente

**Tempo stimato**: 1-2 ore

### Fase 7: Fix File Rimanenti (Priorità Bassa)

**Obiettivo**: Risolvere errori rimanenti.

**Task**:
1. `AddressField.php` (6 errori)
2. `AddressResource.php` (6 errori)
3. `OSMMapWidget.php` (6 errori)
4. `HasAddress.php` (5 errori)

**Tempo stimato**: 2-3 ore

### Fase 8: Verifica Finale e Testing

**Obiettivo**: Verificare che tutti gli errori siano risolti.

**Task**:
1. Eseguire PHPStan completo sul modulo
2. Verificare che non ci siano regressioni
3. Eseguire test funzionali
4. **Test integrazione Google Maps** (CRITICO)
5. **Test integrazione Bing Maps** (CRITICO)
6. Aggiornare documentazione

**Tempo stimato**: 1-2 ore

## 📝 Best Practices da Applicare

1. **Sempre usare type hints espliciti** per parametri e return types
2. **Usare `@var` annotations** per variabili di tipo mixed
3. **Creare DTO** per i risultati delle API esterne
4. **Verificare null safety** prima di chiamare metodi su oggetti
5. **Usare `SafeStringCastAction`** per le traduzioni
6. **Testare dopo ogni fix** per evitare regressioni
7. **Verificare integrazione API** dopo ogni modifica

## ⚠️ Note Importanti

Il modulo Geo integra API esterne (Google Maps, Bing Maps). Qualsiasi modifica deve:
- Mantenere la compatibilità con le API
- Testare le integrazioni
- Verificare che i DTO siano corretti
- Documentare i cambiamenti

**File critico**: `AddressItemEnum.php` con 67 errori richiede attenzione particolare.

## 🔗 Collegamenti Correlati

- [PHPStan Error Resolution Roadmap](./phpstan-error-resolution-roadmap.md) - Roadmap precedente
- [PHPStan Roadmap Geo](./phpstan-roadmap-geo.md) - Roadmap alternativa
- [Bing Maps Action Fix](./phpstan-bing-maps-action-fix-roadmap.md)

## ✅ Checklist di Verifica

Prima di considerare completata la risoluzione:

- [ ] Tutti i file elencati sono stati corretti
- [ ] **AddressItemEnum.php completamente risolto** (67 errori)
- [ ] PHPStan Level 10 passa senza errori
- [ ] Test funzionali passano
- [ ] Test integrazione Google Maps passano
- [ ] Test integrazione Bing Maps passano
- [ ] Documentazione aggiornata
- [ ] Code review completata

---

*Roadmap creata il: Gennaio 2025*  
*Ultimo aggiornamento: Gennaio 2025*  
*⚠️ File critico: AddressItemEnum.php (67 errori)*
