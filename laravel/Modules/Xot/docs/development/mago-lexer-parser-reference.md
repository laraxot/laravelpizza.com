# Mago Lexer-Parser Command Reference - Guida Completa

> **File**: `Modules/Xot/docs/development/mago-lexer-parser-reference.md`  
> **Ultimo aggiornamento**: Gennaio 2025  
> **Status**: ✅ Active  
> **Riferimento**: https://mago.carthage.software/tools/lexer-parser/command-reference

## 🎯 Panoramica

Questa guida documenta i comandi **lexer** e **parser** di Mago, strumenti fondamentali per l'analisi statica del codice PHP.

## 📚 Mago Lexer - Tokenizzazione PHP

### Cos'è il Lexer

Il **lexer** di Mago tokenizza il codice PHP, convertendo il codice sorgente in una sequenza di token che rappresentano gli elementi lessicali del linguaggio.

### Comando Base

```bash
# Tokenizza un file PHP
mago lexer path/to/file.php

# Tokenizza con output formattato
mago lexer path/to/file.php --format json

# Tokenizza con dettagli completi
mago lexer path/to/file.php --verbose
```

### Opzioni Disponibili

```bash
# Output formato JSON
mago lexer file.php --format json

# Output formato testo leggibile
mago lexer file.php --format text

# Include informazioni posizione token
mago lexer file.php --include-position

# Include informazioni contesto
mago lexer file.php --include-context
```

### Esempio di Utilizzo

```bash
# Analizza un file del modulo Sigma
mago lexer Modules/Sigma/app/Models/Scheda.php

# Output esempio:
# Token: T_OPEN_TAG (<?php)
# Token: T_WHITESPACE
# Token: T_DECLARE
# Token: T_OPEN_PARENTHESIS
# Token: T_STRING (strict_types)
# ...
```

### Utilizzo per Debugging

```bash
# Identifica problemi di sintassi
mago lexer file.php --check-syntax

# Verifica encoding
mago lexer file.php --check-encoding

# Analizza caratteri speciali
mago lexer file.php --analyze-special-chars
```

## 📚 Mago Parser - Parsing AST

### Cos'è il Parser

Il **parser** di Mago costruisce un Abstract Syntax Tree (AST) dal codice PHP tokenizzato, permettendo analisi strutturali avanzate.

### Comando Base

```bash
# Parse un file PHP in AST
mago parser path/to/file.php

# Parse con output JSON
mago parser path/to/file.php --format json

# Parse con dettagli completi
mago parser path/to/file.php --verbose
```

### Opzioni Disponibili

```bash
# Output formato JSON (AST completo)
mago parser file.php --format json

# Output formato testo (albero leggibile)
mago parser file.php --format text

# Include informazioni posizione nodi
mago parser file.php --include-position

# Include informazioni tipo nodi
mago parser file.php --include-types

# Include informazioni scope
mago parser file.php --include-scope
```

### Esempio di Utilizzo

```bash
# Analizza struttura di un file
mago parser Modules/Sigma/app/Models/Scheda.php

# Output esempio:
# AST Root
#   └── Stmt_Namespace
#       └── Stmt_Use
#       └── Stmt_Class
#           ├── Stmt_Property
#           ├── Stmt_ClassMethod
#           └── ...
```

### Utilizzo per Analisi Strutturale

```bash
# Analizza struttura classi
mago parser file.php --analyze-classes

# Analizza metodi
mago parser file.php --analyze-methods

# Analizza relazioni
mago parser file.php --analyze-relationships

# Analizza dipendenze
mago parser file.php --analyze-dependencies
```

## 🔧 Comando AST - Analisi Completa

### Comando AST

Il comando `ast` combina lexer e parser per fornire un'analisi completa:

```bash
# Analisi AST completa
mago ast path/to/file.php

# AST con formato JSON
mago ast path/to/file.php --format json

# AST con informazioni dettagliate
mago ast path/to/file.php --verbose
```

### Opzioni AST

```bash
# Include informazioni token
mago ast file.php --include-tokens

# Include informazioni nodi
mago ast file.php --include-nodes

# Include informazioni metadati
mago ast file.php --include-metadata

# Analisi profonda
mago ast file.php --deep-analysis
```

### Esempio Completo

```bash
# Analisi completa di un file
mago ast Modules/Sigma/app/Models/Scheda.php --format json > scheda-ast.json

# Analisi con output leggibile
mago ast Modules/Sigma/app/Models/Scheda.php --format text
```

## 🎯 Utilizzo Pratico nel Progetto

### Workflow Analisi File

```bash
#!/bin/bash
# scripts/mago-analyze-file.sh

FILE=$1

if [ -z "$FILE" ]; then
    echo "Usage: $0 <file.php>"
    exit 1
fi

echo "=== Mago Lexer Analysis ==="
mago lexer "$FILE" --format text

echo ""
echo "=== Mago Parser Analysis ==="
mago parser "$FILE" --format text

echo ""
echo "=== Mago AST Analysis ==="
mago ast "$FILE" --format json > "${FILE%.php}-ast.json"
echo "AST saved to ${FILE%.php}-ast.json"
```

### Analisi Batch Modulo

```bash
#!/bin/bash
# scripts/mago-analyze-module.sh

MODULE=$1

if [ -z "$MODULE" ]; then
    echo "Usage: $0 <module-name>"
    exit 1
fi

MODULE_PATH="Modules/$MODULE/app"

echo "=== Analyzing $MODULE with Mago ==="

# Trova tutti i file PHP
find "$MODULE_PATH" -name "*.php" -type f | while read -r file; do
    echo "Analyzing: $file"
    
    # Lexer analysis
    mago lexer "$file" --format json > "${file%.php}-lexer.json" 2>/dev/null
    
    # Parser analysis
    mago parser "$file" --format json > "${file%.php}-parser.json" 2>/dev/null
    
    # AST analysis
    mago ast "$file" --format json > "${file%.php}-ast.json" 2>/dev/null
done

echo "Analysis complete. JSON files created."
```

## 📊 Interpretazione Risultati

### Output Lexer

```json
{
  "tokens": [
    {
      "type": "T_OPEN_TAG",
      "value": "<?php",
      "line": 1,
      "column": 1
    },
    {
      "type": "T_WHITESPACE",
      "value": "\n",
      "line": 1,
      "column": 6
    }
  ]
}
```

### Output Parser

```json
{
  "ast": {
    "type": "Stmt_Namespace",
    "name": {
      "type": "Name",
      "parts": ["Modules", "Sigma", "Models"]
    },
    "stmts": [
      {
        "type": "Stmt_Class",
        "name": "Scheda",
        "extends": {
          "type": "Name",
          "parts": ["BaseModel"]
        }
      }
    ]
  }
}
```

### Output AST

```json
{
  "file": "Scheda.php",
  "namespace": "Modules\\Sigma\\Models",
  "classes": [
    {
      "name": "Scheda",
      "extends": "BaseModel",
      "methods": [
        {
          "name": "getGgAnno",
          "visibility": "public",
          "returnType": "int"
        }
      ],
      "properties": [
        {
          "name": "fillable",
          "visibility": "protected",
          "type": "array"
        }
      ]
    }
  ]
}
```

## 🔍 Analisi Avanzate

### Identificazione Pattern

```bash
# Identifica pattern specifici
mago ast file.php --pattern "accessor-methods"
mago ast file.php --pattern "relationship-methods"
mago ast file.php --pattern "scope-methods"
```

### Analisi Complessità

```bash
# Analizza complessità ciclomatica
mago ast file.php --complexity

# Analizza profondità annidamento
mago ast file.php --nesting-depth

# Analizza lunghezza metodi
mago ast file.php --method-length
```

### Analisi Dipendenze

```bash
# Identifica dipendenze
mago ast file.php --dependencies

# Analizza import
mago ast file.php --imports

# Analizza namespace
mago ast file.php --namespaces
```

## 🚀 Integrazione con PHPStan

### Pre-Analisi con Mago

```bash
#!/bin/bash
# scripts/mago-phpstan-workflow.sh

FILE=$1

# Step 1: Analisi Mago (veloce)
echo "Step 1: Mago AST Analysis"
mago ast "$FILE" --format json > "${FILE%.php}-mago.json"

# Step 2: Identifica problemi strutturali
echo "Step 2: Structural Analysis"
mago ast "$FILE" --analyze-structure

# Step 3: PHPStan (dettagliato)
echo "Step 3: PHPStan Analysis"
./vendor/bin/phpstan analyse "$FILE" --level=10
```

## 📚 Best Practices

### 1. Usa Lexer per Debugging Sintassi

```bash
# Identifica problemi di sintassi rapidamente
mago lexer file.php --check-syntax
```

### 2. Usa Parser per Analisi Strutturale

```bash
# Analizza struttura prima di PHPStan
mago parser file.php --analyze-structure
```

### 3. Usa AST per Analisi Completa

```bash
# Analisi completa prima di refactoring
mago ast file.php --deep-analysis
```

### 4. Integra nel Workflow

```bash
# Pre-commit hook
mago ast --changed-files | grep -q "ERROR" && exit 1
```

## 🔗 Collegamenti Correlati

- [Guida Generale Mago e Rector](./mago-rector-guide.md)
- [Utilizzo nel Modulo Sigma](../../Sigma/docs/development/mago-rector-usage.md)
- [PHPStan Workflow](../rules/phpstan-workflow.md)

---

**Ultimo aggiornamento**: Gennaio 2025  
**Versione**: 1.0  
**Status**: ✅ Active  
**Riferimento**: https://mago.carthage.software/tools/lexer-parser/command-reference

