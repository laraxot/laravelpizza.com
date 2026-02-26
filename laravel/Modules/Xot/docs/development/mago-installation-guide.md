# Mago - Guida Installazione Completa

> **File**: `Modules/Xot/docs/development/mago-installation-guide.md`  
> **Ultimo aggiornamento**: Gennaio 2025  
> **Status**: ✅ Active  
> **Riferimento**: https://mago.carthage.software/guide/installation

## 🎯 Panoramica

Questa guida documenta l'installazione completa di **Mago**, suite di strumenti PHP scritta in Rust per migliorare la qualità del codice.

## 📋 Prerequisiti

### Metodo 1: Installazione con Script Shell (Consigliato)

**Per macOS e Linux**:

```bash
# Installazione automatica tramite script
curl --proto '=https' --tlsv1.2 -sSf https://carthage.software/mago.sh | bash
```

Lo script:
- Scarica automaticamente l'ultima versione di Mago
- Installa Mago in `~/.cargo/bin/` o `~/.local/bin/`
- Aggiunge automaticamente al PATH se necessario

**Verifica installazione**:
```bash
mago --version
```

### Metodo 2: Installazione con Cargo (Rust)

**Prerequisiti**:
- Rust e Cargo installati (https://rustup.rs/)

```bash
# Installazione tramite Cargo
cargo install mago

# Verifica installazione
mago --version
```

### Metodo 3: Download Binario Precompilato

**Per Windows e altre piattaforme**:

1. Visita https://github.com/carthage-software/mago/releases
2. Scarica l'archivio appropriato per la tua piattaforma
3. Estrai l'eseguibile
4. Posiziona l'eseguibile in una directory nel tuo PATH

**Esempio Linux**:
```bash
# Download ultima release
wget https://github.com/carthage-software/mago/releases/latest/download/mago-x86_64-unknown-linux-gnu.tar.gz

# Estrai
tar -xzf mago-x86_64-unknown-linux-gnu.tar.gz

# Sposta in PATH
sudo mv mago /usr/local/bin/

# Verifica
mago --version
```

## 🔧 Configurazione Post-Installazione

### Verifica PATH

Assicurati che Mago sia nel tuo PATH:

```bash
# Verifica posizione
which mago

# Se non trovato, aggiungi al PATH
export PATH="$HOME/.cargo/bin:$PATH"
# Oppure
export PATH="$HOME/.local/bin:$PATH"

# Aggiungi permanentemente al ~/.bashrc o ~/.zshrc
echo 'export PATH="$HOME/.cargo/bin:$PATH"' >> ~/.bashrc
source ~/.bashrc
```

### Configurazione Progetto

Il file `mago.toml` è già presente nella root Laravel con configurazione ottimizzata:

```toml
# Welcome to Mago!
# For full documentation, see https://mago.carthage.software/tools/overview
php-version = "8.2.0"

[source]
paths = ["app/", "database/factories/", "database/seeders/", "tests/"]
includes = ["vendor"]
excludes = []

[formatter]
print-width = 120
tab-width = 4
use-tabs = false

[linter]
integrations = ["symfony", "laravel"]

[linter.rules]
ambiguous-function-call = { enabled = false }
literal-named-argument = { enabled = false }
halstead = { effort-threshold = 7000 }

[analyzer]
find-unused-definitions = false
find-unused-expressions = false
analyze-dead-code = true
check-throws = true
allow-possibly-undefined-array-keys = true
perform-heuristic-checks = true
```

## ✅ Verifica Installazione

### Test Base

```bash
# Verifica versione
mago --version

# Verifica comandi disponibili
mago --help

# Test formattazione
mago format --help

# Test linting
mago lint --help

# Test analisi
mago analyze --help
```

### Test su File di Esempio

```bash
# Crea file di test
echo '<?php declare(strict_types=1); class Test { public function test() { return "test"; } }' > test.php

# Test formattazione
mago format test.php

# Test linting
mago lint test.php

# Test analisi
mago analyze test.php

# Rimuovi file di test
rm test.php
```

## 🚀 Strumenti Disponibili

### 1. Formatter

Formatta automaticamente il codice PHP secondo standard predefiniti.

```bash
# Formatta singolo file
mago format path/to/file.php

# Formatta directory
mago format Modules/Sigma/app

# Formatta con output
mago format Modules/Sigma/app --write
```

### 2. Linter

Identifica errori di sintassi, stile e problemi comuni.

```bash
# Lint singolo file
mago lint path/to/file.php

# Lint directory
mago lint Modules/Sigma/app

# Lint con output dettagliato
mago lint Modules/Sigma/app --verbose
```

### 3. Static Analyzer

Analisi statica avanzata del codice per identificare problemi.

```bash
# Analizza singolo file
mago analyze path/to/file.php

# Analizza directory
mago analyze Modules/Sigma/app

# Analisi approfondita
mago analyze Modules/Sigma/app --deep
```

### 4. Lexer

Tokenizza il codice PHP per analisi lessicale.

```bash
# Tokenizza file
mago lexer path/to/file.php

# Output JSON
mago lexer path/to/file.php --format json
```

### 5. Parser

Costruisce AST (Abstract Syntax Tree) dal codice.

```bash
# Parse file
mago parser path/to/file.php

# Output JSON
mago parser path/to/file.php --format json
```

### 6. AST

Analisi completa combinando lexer e parser.

```bash
# AST completo
mago ast path/to/file.php

# Output JSON
mago ast path/to/file.php --format json
```

### 7. Check (Tutto Insieme)

Esegue formatter, linter e analyzer in sequenza.

```bash
# Check completo
mago check Modules/Sigma/app

# Check con fix automatici
mago check Modules/Sigma/app --fix
```

## 🔗 Collegamenti Correlati

- [Mago Lexer-Parser Reference](./mago-lexer-parser-reference.md) - Reference comandi lexer/parser
- [Mago e Rector Guide](./mago-rector-guide.md) - Guida generale Mago e Rector
- [Mago Workflow Sigma](../../Sigma/docs/development/mago-workflow.md) - Workflow specifico modulo Sigma

## 📚 Risorse Esterne

- [Mago Official Documentation](https://mago.carthage.software/guide/)
- [Mago Installation Guide](https://mago.carthage.software/guide/installation)
- [Mago GitHub Repository](https://github.com/carthage-software/mago)
- [Mago Releases](https://github.com/carthage-software/mago/releases)

---

**Ultimo aggiornamento**: Gennaio 2025  
**Versione**: 1.0  
**Status**: ✅ Active

