# Analisi PHPMD - Tutti i Moduli

**Data**: 2025-12-23
**Strumento**: PHPMD (PHP Mess Detector)
**Rules**: codesize, unusedcode, naming, design, controversial, cleancode

## 📊 Risultati Generali

**Output completo salvato in**: `/tmp/phpmd_all_modules.txt`

## 🔍 Categorizzazione Warning PHPMD

### Tipi di Warning Comuni

1. **Cyclomatic Complexity**: Complessità ciclomatica alta (>10)
2. **NPath Complexity**: Complessità NPath alta (>200)
3. **StaticAccess**: Uso di accesso statico (es. `Assert::string()`)
4. **CouplingBetweenObjects**: Accoppiamento tra oggetti alto (>13)
5. **UnusedLocalVariable**: Variabili locali non utilizzate
6. **ShortVariable**: Nomi variabili troppo corti (<3 caratteri)
7. **CamelCaseVariableName**: Nomi variabili non in camelCase
8. **UnusedFormalParameter**: Parametri formali non utilizzati

### Priorità

- **Bassa**: Warning stilistici (naming, unused parameters con `_` prefix)
- **Media**: Complexity warning (da monitorare ma non critici)
- **Alta**: Errori logici (unused variables, coupling eccessivo)

## 📝 Note

I warning PHPMD sono spesso informativi e non bloccanti. Focus su:
- Problemi che possono causare bug
- Code smells che impattano manutenibilità
- Pattern che violano principi SOLID
