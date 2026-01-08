# Riepilogo Analisi PHPMD - Tutti i Moduli

**Data**: 2025-12-23  
**Strumento**: PHPMD (PHP Mess Detector)  
**Rules**: codesize, unusedcode, naming, design, controversial, cleancode

## 📊 Statistiche Generali

**Output completo**: `/tmp/phpmd_all_modules.txt`

## 🔍 Tipi di Warning per Frequenza

(La frequenza verrà popolata dopo analisi completa)

### Warning Più Comuni

1. **StaticAccess** - Uso di accesso statico (Assert, Arr, etc.)
   - Priorità: Bassa (accettabile per utility)
   - Azione: Nessuna (pattern standard Laravel)

2. **Cyclomatic Complexity** - Complessità ciclomatica alta
   - Priorità: Media
   - Azione: Monitorare, refactoring se >15

3. **UnusedFormalParameter** - Parametri non utilizzati
   - Priorità: Bassa (se prefisso `_`)
   - Azione: Prefisso `_` se richiesto da interfaccia

4. **ShortVariable** - Nomi variabili corti
   - Priorità: Bassa (accettabile per loop variables)
   - Azione: Nessuna se variabili standard

## 📝 Strategia

### Problemi da Correggere (Alta Priorità)

- UnusedLocalVariable (variabili non utilizzate)
- Errori logici evidenti
- Codice morto

### Problemi da Monitorare (Media Priorità)

- Cyclomatic Complexity >15
- NPath Complexity >500
- CouplingBetweenObjects >15

### Problemi da Ignorare (Bassa Priorità)

- StaticAccess per utility (Assert, Arr)
- ShortVariable per loop (`$i`, `$e`)
- UnusedFormalParameter con prefisso `_`
- CamelCaseVariableName per variabili legacy

## ✅ Validazione PHPStan

**Prima di qualsiasi modifica**: Verificare che PHPStan passi ancora (0 errori livello max)
