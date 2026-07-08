# Mago Workflow per Modulo Sigma

> **File**: `Modules/Sigma/docs/development/mago-workflow.md`  
> **Ultimo aggiornamento**: Gennaio 2025  
> **Status**: ✅ Active  
> **Riferimento**: [Mago Lexer-Parser Reference](../../Xot/docs/development/mago-lexer-parser-reference.md)

## 🎯 Panoramica

Questo documento descrive il workflow completo per utilizzare **Mago** come prima scrematura degli errori PHPStan nel modulo Sigma.

## 📋 Prerequisiti

### Installazione Mago

```bash
# Installazione tramite Cargo (Rust)
cargo install mago

# Verifica installazione
mago --version
```

### Configurazione

Il file `mago.toml` è già presente nella root Laravel con configurazione base.

## 🔄 Workflow Completo

### Fase 1: Analisi Lexer (Tokenizzazione)

**Obiettivo**: Identificare problemi di sintassi e tokenizzazione

```bash
# Analizza tutti i file PHP del modulo Sigma
find Modules/Sigma/app -name "*.php" -type f | while read file; do
    echo "=== Lexer: $file ==="
    mago lexer "$file" --check-syntax 2>&1 | grep -E "ERROR|WARNING" || echo "OK"
done
```

**Output atteso**:
- Errori di sintassi
- Problemi di encoding
- Caratteri speciali problematici

### Fase 2: Analisi Parser (Struttura)

**Obiettivo**: Identificare problemi strutturali del codice

```bash
# Analizza struttura di tutti i file
find Modules/Sigma/app -name "*.php" -type f | while read file; do
    echo "=== Parser: $file ==="
    mago parser "$file" --analyze-structure 2>&1 | grep -E "ERROR|WARNING" || echo "OK"
done
```

**Output atteso**:
- Problemi di struttura classi
- Metodi malformati
- Relazioni problematiche

### Fase 3: Analisi AST (Completa)

**Obiettivo**: Analisi completa per identificare pattern problematici

```bash
# Analisi AST completa
find Modules/Sigma/app -name "*.php" -type f | while read file; do
    echo "=== AST: $file ==="
    mago ast "$file" --deep-analysis --format json > "${file%.php}-ast.json" 2>&1
    
    # Analizza complessità
    mago ast "$file" --complexity 2>&1 | grep -E "high|critical" || echo "OK"
done
```

**Output atteso**:
- Complessità ciclomatica elevata
- Metodi troppo lunghi
- Dipendenze circolari

### Fase 4: Identificazione Pattern Problematici

**Obiettivo**: Identificare pattern che causano errori PHPStan

```bash
#!/bin/bash
# scripts/mago-identify-phpstan-issues.sh

MODULE_PATH="Modules/Sigma/app"

echo "=== Identificazione Pattern Problematici ==="

# Pattern 1: Binary operations con mixed
echo "Pattern 1: Binary operations"
find "$MODULE_PATH" -name "*.php" -exec mago ast {} --pattern "binary-operations" \; | grep -i "mixed"

# Pattern 2: Property access su mixed
echo "Pattern 2: Property access"
find "$MODULE_PATH" -name "*.php" -exec mago ast {} --pattern "property-access" \; | grep -i "mixed"

# Pattern 3: Method calls su mixed
echo "Pattern 3: Method calls"
find "$MODULE_PATH" -name "*.php" -exec mago ast {} --pattern "method-calls" \; | grep -i "mixed"

# Pattern 4: Return types mancanti
echo "Pattern 4: Return types"
find "$MODULE_PATH" -name "*.php" -exec mago ast {} --pattern "missing-return-types" \;
```

## 🎯 Utilizzo Pratico

### Script Completo Analisi

```bash
#!/bin/bash
# scripts/mago-sigma-analysis.sh

MODULE="Sigma"
MODULE_PATH="Modules/$MODULE/app"
OUTPUT_DIR="Modules/$MODULE/docs/mago-analysis"

mkdir -p "$OUTPUT_DIR"

echo "=== Mago Analysis for $MODULE Module ==="
echo "Output directory: $OUTPUT_DIR"
echo ""

# Step 1: Lexer analysis
echo "Step 1: Lexer Analysis..."
find "$MODULE_PATH" -name "*.php" -type f | while read file; do
    rel_path="${file#$MODULE_PATH/}"
    output_file="$OUTPUT_DIR/${rel_path//\//-}-lexer.json"
    mkdir -p "$(dirname "$output_file")"
    mago lexer "$file" --format json > "$output_file" 2>&1
done
echo "✅ Lexer analysis complete"

# Step 2: Parser analysis
echo "Step 2: Parser Analysis..."
find "$MODULE_PATH" -name "*.php" -type f | while read file; do
    rel_path="${file#$MODULE_PATH/}"
    output_file="$OUTPUT_DIR/${rel_path//\//-}-parser.json"
    mkdir -p "$(dirname "$output_file")"
    mago parser "$file" --format json > "$output_file" 2>&1
done
echo "✅ Parser analysis complete"

# Step 3: AST analysis
echo "Step 3: AST Analysis..."
find "$MODULE_PATH" -name "*.php" -type f | while read file; do
    rel_path="${file#$MODULE_PATH/}"
    output_file="$OUTPUT_DIR/${rel_path//\//-}-ast.json"
    mkdir -p "$(dirname "$output_file")"
    mago ast "$file" --format json --deep-analysis > "$output_file" 2>&1
done
echo "✅ AST analysis complete"

# Step 4: Generate summary
echo "Step 4: Generating Summary..."
cat > "$OUTPUT_DIR/summary.md" << EOF
# Mago Analysis Summary - $MODULE Module

Generated: $(date)

## Files Analyzed
$(find "$MODULE_PATH" -name "*.php" -type f | wc -l) PHP files

## Analysis Results
- Lexer: $(find "$OUTPUT_DIR" -name "*-lexer.json" | wc -l) files
- Parser: $(find "$OUTPUT_DIR" -name "*-parser.json" | wc -l) files
- AST: $(find "$OUTPUT_DIR" -name "*-ast.json" | wc -l) files

## Next Steps
1. Review AST analysis for structural issues
2. Identify patterns causing PHPStan errors
3. Apply fixes incrementally
EOF

echo "✅ Analysis complete. Results in $OUTPUT_DIR"
```

### Esecuzione

```bash
# Esegui analisi completa
bash scripts/mago-sigma-analysis.sh

# Oppure manualmente
cd laravel
find Modules/Sigma/app -name "*.php" -exec mago ast {} --format json \;
```

## 📊 Interpretazione Risultati

### Problemi Identificati da Mago

1. **Sintassi**: Errori di parsing
2. **Struttura**: Problemi di struttura AST
3. **Complessità**: Metodi troppo complessi
4. **Dipendenze**: Dipendenze circolari o problematiche

### Mapping a Errori PHPStan

| Problema Mago | Errore PHPStan Correlato |
|---------------|-------------------------|
| Binary operation con mixed | `binaryOp.invalid` |
| Property access su mixed | `property.nonObject` |
| Method call su mixed | `method.nonObject` |
| Return type mancante | `return.typeMissing` |

## 🔄 Integrazione con PHPStan

### Workflow Combinato

```bash
#!/bin/bash
# scripts/mago-phpstan-workflow.sh

FILE=$1

# Step 1: Mago AST (veloce)
echo "Step 1: Mago AST Analysis"
mago ast "$FILE" --deep-analysis > "${FILE%.php}-mago.json"

# Step 2: Identifica problemi strutturali
echo "Step 2: Structural Issues"
mago ast "$FILE" --analyze-structure | grep -E "ERROR|WARNING"

# Step 3: PHPStan (dettagliato)
echo "Step 3: PHPStan Analysis"
./vendor/bin/phpstan analyse "$FILE" --level=10 --memory-limit=2G

# Step 4: Confronta risultati
echo "Step 4: Compare Results"
# Confronta problemi identificati da Mago con errori PHPStan
```

## 🎯 Best Practices

### 1. Usa Mago per Screening Iniziale

```bash
# Screening rapido prima di PHPStan
mago ast Modules/Sigma/app --deep-analysis > mago-report.json
```

### 2. Identifica Pattern Comuni

```bash
# Identifica pattern che causano errori PHPStan
mago ast file.php --pattern "mixed-types"
mago ast file.php --pattern "missing-types"
```

### 3. Integra nel Workflow

```bash
# Pre-commit hook
mago ast --changed-files | grep -q "ERROR" && exit 1
```

## 🔗 Collegamenti Correlati

- [Mago Lexer-Parser Reference](../../Xot/docs/development/mago-lexer-parser-reference.md)
- [Rector Laravel Workflow](./rector-workflow.md)
- [PHPStan Level 10 Strategy](./phpstan-level10-strategy.md)

---

**Ultimo aggiornamento**: Gennaio 2025  
**Versione**: 1.0  
**Status**: ✅ Active

