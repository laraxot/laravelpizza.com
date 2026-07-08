# Mago - Integrazione Completa Modulo Sigma

> **File**: `Modules/Sigma/docs/development/mago-integration-complete.md`  
> **Ultimo aggiornamento**: Gennaio 2025  
> **Status**: ✅ Active  
> **Riferimento**: [Mago Installation Guide](../../Xot/docs/development/mago-installation-guide.md)

## 🎯 Panoramica

Questo documento descrive l'integrazione completa di **Mago** nel modulo Sigma per migliorare la qualità del codice attraverso tutti gli strumenti disponibili.

## 📋 Strumenti Mago Disponibili

### 1. Formatter

**Scopo**: Formattazione automatica del codice PHP secondo standard PSR-12.

**Utilizzo**:
```bash
# Formatta singolo file
mago format Modules/Sigma/app/Models/Scheda.php

# Formatta directory completa
mago format Modules/Sigma/app

# Formatta con write (modifica file)
mago format Modules/Sigma/app --write

# Formatta con check (solo verifica)
mago format Modules/Sigma/app --check
```

**Benefici**:
- Codice formattato uniformemente
- Conformità PSR-12 automatica
- Riduzione conflitti Git per formattazione

### 2. Linter

**Scopo**: Identificazione errori di sintassi, stile e code smells.

**Utilizzo**:
```bash
# Lint singolo file
mago lint Modules/Sigma/app/Models/Scheda.php

# Lint directory completa
mago lint Modules/Sigma/app

# Lint con output dettagliato
mago lint Modules/Sigma/app --verbose

# Lint con fix automatici (quando disponibili)
mago lint Modules/Sigma/app --fix
```

**Regole Configurate** (in `mago.toml`):
- `ambiguous-function-call`: Disabilitato
- `literal-named-argument`: Disabilitato
- `halstead`: Soglia complessità 7000
- Integrazioni: Symfony, Laravel

**Benefici**:
- Identificazione precoce problemi
- Conformità standard Laravel/Symfony
- Miglioramento qualità codice

### 3. Static Analyzer

**Scopo**: Analisi statica avanzata per identificare bug e problemi logici.

**Utilizzo**:
```bash
# Analizza singolo file
mago analyze Modules/Sigma/app/Models/Scheda.php

# Analizza directory completa
mago analyze Modules/Sigma/app

# Analisi approfondita
mago analyze Modules/Sigma/app --deep

# Analisi con output JSON
mago analyze Modules/Sigma/app --format json
```

**Configurazione** (in `mago.toml`):
- `find-unused-definitions`: false
- `find-unused-expressions`: false
- `analyze-dead-code`: true
- `check-throws`: true
- `allow-possibly-undefined-array-keys`: true
- `perform-heuristic-checks`: true

**Benefici**:
- Identificazione bug prima dell'esecuzione
- Analisi dead code
- Verifica throws exceptions
- Controlli euristici avanzati

### 4. Lexer

**Scopo**: Tokenizzazione codice PHP per analisi lessicale.

**Utilizzo**:
```bash
# Tokenizza file
mago lexer Modules/Sigma/app/Models/Scheda.php

# Output JSON
mago lexer Modules/Sigma/app/Models/Scheda.php --format json

# Check sintassi
mago lexer Modules/Sigma/app/Models/Scheda.php --check-syntax
```

**Benefici**:
- Identificazione problemi sintassi
- Analisi encoding
- Verifica caratteri speciali

### 5. Parser

**Scopo**: Costruzione AST (Abstract Syntax Tree) per analisi strutturale.

**Utilizzo**:
```bash
# Parse file
mago parser Modules/Sigma/app/Models/Scheda.php

# Output JSON
mago parser Modules/Sigma/app/Models/Scheda.php --format json

# Analisi struttura
mago parser Modules/Sigma/app/Models/Scheda.php --analyze-structure
```

**Benefici**:
- Analisi struttura classi
- Verifica metodi
- Controllo relazioni

### 6. AST

**Scopo**: Analisi completa combinando lexer e parser.

**Utilizzo**:
```bash
# AST completo
mago ast Modules/Sigma/app/Models/Scheda.php

# Output JSON
mago ast Modules/Sigma/app/Models/Scheda.php --format json

# Analisi profonda
mago ast Modules/Sigma/app/Models/Scheda.php --deep-analysis

# Analisi complessità
mago ast Modules/Sigma/app/Models/Scheda.php --complexity
```

**Benefici**:
- Analisi completa codice
- Identificazione pattern problematici
- Analisi complessità ciclomatica

### 7. Check (Tutto Insieme)

**Scopo**: Esegue formatter, linter e analyzer in sequenza.

**Utilizzo**:
```bash
# Check completo
mago check Modules/Sigma/app

# Check con fix automatici
mago check Modules/Sigma/app --fix

# Check con output dettagliato
mago check Modules/Sigma/app --verbose
```

**Benefici**:
- Workflow completo in un comando
- Identificazione tutti i problemi
- Fix automatici quando possibile

## 🔄 Workflow Completo per Modulo Sigma

### Fase 1: Formattazione

```bash
# Formatta tutto il modulo
mago format Modules/Sigma/app --write

# Verifica modifiche
git diff Modules/Sigma/app
```

### Fase 2: Linting

```bash
# Lint completo
mago lint Modules/Sigma/app --verbose > mago-lint-report.txt

# Analizza report
cat mago-lint-report.txt | grep -E "ERROR|WARNING"
```

### Fase 3: Analisi Statica

```bash
# Analisi completa
mago analyze Modules/Sigma/app --deep > mago-analyze-report.txt

# Identifica problemi critici
cat mago-analyze-report.txt | grep -E "CRITICAL|ERROR"
```

### Fase 4: Analisi AST

```bash
# AST completo per file critici
mago ast Modules/Sigma/app/Models/Traits/Extras/FunctionExtra.php --format json > function-extra-ast.json

# Analisi complessità
mago ast Modules/Sigma/app/Models/Traits/Extras/FunctionExtra.php --complexity
```

### Fase 5: Check Completo

```bash
# Check completo con fix
mago check Modules/Sigma/app --fix --verbose > mago-check-report.txt
```

## 📊 Script Automatizzato

```bash
#!/bin/bash
# scripts/mago-sigma-complete.sh

MODULE="Sigma"
MODULE_PATH="Modules/$MODULE/app"
OUTPUT_DIR="Modules/$MODULE/docs/mago-analysis"

mkdir -p "$OUTPUT_DIR"

echo "=== Mago Complete Analysis for $MODULE Module ==="
echo "Output directory: $OUTPUT_DIR"
echo ""

# Step 1: Format
echo "Step 1: Formatting..."
mago format "$MODULE_PATH" --write
echo "✅ Formatting complete"

# Step 2: Lint
echo "Step 2: Linting..."
mago lint "$MODULE_PATH" --verbose > "$OUTPUT_DIR/lint-report.txt"
echo "✅ Linting complete"

# Step 3: Analyze
echo "Step 3: Static Analysis..."
mago analyze "$MODULE_PATH" --deep > "$OUTPUT_DIR/analyze-report.txt"
echo "✅ Static analysis complete"

# Step 4: AST Analysis (sample files)
echo "Step 4: AST Analysis..."
for file in "$MODULE_PATH/Models/Traits/Extras/FunctionExtra.php" \
            "$MODULE_PATH/Models/Traits/Extras/MassExtra.php" \
            "$MODULE_PATH/Models/Scheda.php"; do
    if [ -f "$file" ]; then
        rel_path="${file#$MODULE_PATH/}"
        output_file="$OUTPUT_DIR/${rel_path//\//-}-ast.json"
        mkdir -p "$(dirname "$output_file")"
        mago ast "$file" --format json --deep-analysis > "$output_file" 2>&1
    fi
done
echo "✅ AST analysis complete"

# Step 5: Check Complete
echo "Step 5: Complete Check..."
mago check "$MODULE_PATH" --fix --verbose > "$OUTPUT_DIR/check-report.txt"
echo "✅ Complete check done"

# Generate Summary
cat > "$OUTPUT_DIR/summary.md" << EOF
# Mago Analysis Summary - $MODULE Module

Generated: $(date)

## Analysis Results

- **Formatting**: Applied
- **Linting**: See lint-report.txt
- **Static Analysis**: See analyze-report.txt
- **AST Analysis**: See *-ast.json files
- **Complete Check**: See check-report.txt

## Next Steps

1. Review lint-report.txt for linting issues
2. Review analyze-report.txt for static analysis issues
3. Review AST files for structural analysis
4. Apply fixes incrementally
5. Verify with PHPStan level 10
EOF

echo ""
echo "✅ Analysis complete. Results in $OUTPUT_DIR"
```

## 🎯 Integrazione con PHPStan

### Workflow Combinato

```bash
#!/bin/bash
# scripts/mago-phpstan-workflow.sh

FILE=$1

# Step 1: Mago Format
echo "Step 1: Mago Format"
mago format "$FILE" --write

# Step 2: Mago Lint
echo "Step 2: Mago Lint"
mago lint "$FILE" --verbose

# Step 3: Mago Analyze
echo "Step 3: Mago Analyze"
mago analyze "$FILE" --deep

# Step 4: PHPStan
echo "Step 4: PHPStan Level 10"
./vendor/bin/phpstan analyse "$FILE" --level=10 --memory-limit=2G
```

## 📈 Risultati Attesi

### Miglioramenti Qualità Codice

1. **Formattazione Uniforme**: Tutto il codice formattato secondo PSR-12
2. **Riduzione Code Smells**: Identificazione e correzione problemi stilistici
3. **Identificazione Bug**: Analisi statica per trovare bug potenziali
4. **Miglioramento Struttura**: Analisi AST per ottimizzare struttura codice

### Integrazione con PHPStan

- **Mago**: Screening iniziale veloce (formattazione, linting base)
- **PHPStan**: Analisi approfondita type safety (livello 10)

## 🔗 Collegamenti Correlati

- [Mago Installation Guide](../../Xot/docs/development/mago-installation-guide.md)
- [Mago Lexer-Parser Reference](../../Xot/docs/development/mago-lexer-parser-reference.md)
- [Mago Workflow](./mago-workflow.md)
- [PHPStan Level 10 Strategy](./phpstan-level10-strategy.md)

---

**Ultimo aggiornamento**: Gennaio 2025  
**Versione**: 1.0  
**Status**: ✅ Active

