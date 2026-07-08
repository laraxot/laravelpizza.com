# Mago Integration Status - Modulo Sigma

> **Data**: Gennaio 2025  
> **Status**: ✅ Installato e Pronto all'Uso  
> **Versione**: 1.0.0-rc.4  
> **Path**: `mago`  
> **Filosofia**: "Mago per velocità, PHPStan per profondità"

## 🎯 Panoramica

**Mago** è una toolchain PHP scritta in Rust che offre strumenti ad alte prestazioni per:
- Formattazione codice (10-100x più veloce di Laravel Pint)
- Linting veloce (pre-analisi prima di PHPStan)
- Analisi AST (debugging problemi sintassi)
- Architectural Guard (controllo struttura)

## 📋 Status Installazione

### ✅ Installazione Completata

**Metodo Utilizzato**: Shell Installer (consigliato per Linux)

**Comando Eseguito**:
```bash
curl --proto '=https' --tlsv1.2 -sSfO https://carthage.software/mago.sh && bash mago.sh
```

**Risultato**:
- ✅ Mago installato in: `mago`
- ✅ Versione: `1.0.0-rc.4`
- ✅ Eseguibile direttamente: `./mago` o `mago`

**Verifica Installazione**:
```bash
cd laravel
./mago --version
# Output: mago 1.0.0-rc.4
```

### Metodi Installazione Alternativi

Secondo la [guida ufficiale](https://mago.carthage.software/guide/installation), Mago può essere installato anche con:

#### 1. Composer (PHP Project)
```bash
composer require --dev "carthage-software/mago:^1.0.0-rc.4"
```

#### 2. Versione Specifica
```bash
curl --proto '=https' --tlsv1.2 -sSfO https://carthage.software/mago.sh && bash mago.sh --version=1.0.0-rc.4
```

#### 3. Cargo (Rust)
```bash
cargo install mago
mago self-update  # Aggiorna alla versione più recente
```

**Nota**: Il metodo shell installer è consigliato per la maggior parte degli utenti macOS e Linux.

## 🔧 Utilizzo Pratico per Modulo Sigma

### Path Mago nel Progetto

**Path Assoluto**:
```bash
mago
```

**Uso Relativo dalla Root Laravel**:
```bash
cd laravel
./mago [comando]
```

### 1. Analisi AST per Debugging

**Comando**:
```bash
cd laravel

# Analisi AST di file problematici
./mago ast --names Modules/Sigma/app/Models/Traits/Extras/FunctionExtra.php

# Analisi token stream per problemi sintassi
./mago ast --tokens Modules/Sigma/app/Models/Traits/Extras/FunctionExtra.php --json > debug-function-extra.json

# Analisi simboli e namespace
./mago ast --names Modules/Sigma/app/Models/Scheda.php
```

**Utilizzo**:
- Identificare problemi sintassi complessi prima di PHPStan
- Debugging namespace e import resolution
- Analisi struttura AST per refactoring

### 2. Linting Veloce

**Comando**:
```bash
cd laravel

# Quick lint check su tutto il modulo
./mago lint Modules/Sigma/app/

# Linting con output JSON
./mago lint Modules/Sigma/app/ --json > lint-results.json
```

**Utilizzo**:
- Pre-commit hooks veloci
- Quick check durante sviluppo
- Identificazione problemi comuni rapidamente

### 3. Formattazione Veloce

**Comando**:
```bash
cd laravel

# Formattazione tutto il modulo
./mago format Modules/Sigma/app/

# Formattazione dry-run (preview)
./mago format Modules/Sigma/app/ --check
```

**Utilizzo**:
- Formattazione veloce prima di commit
- Alternativa/complemento a Laravel Pint
- Pre-commit hooks ad alta velocità

### 4. Analisi Statica

**Comando**:
```bash
cd laravel

# Analisi statica completa
./mago analyze Modules/Sigma/app/

# Analisi con configurazione (se mago.toml presente)
./mago analyze Modules/Sigma/app/ --config mago.toml
```

**Utilizzo**:
- Pre-analisi prima di PHPStan
- Identificazione problemi comuni rapidamente
- Complemento a PHPStan per velocità

## 📊 Workflow Integrato Previsto

```
┌─────────────────────────────────────────────────────┐
│      WORKFLOW CON MAGO INTEGRATO                      │
│                                                      │
│  1. Mago AST (Debugging Sintassi)                   │
│     ↓                                                │
│  2. Mago Lint (Quick Check)                         │
│     ↓                                                │
│  3. Mago Format (Formattazione Veloce)              │
│     ↓                                                │
│  4. Rector Laravel (Refactoring)                    │
│     ↓                                                │
│  5. PHPStan Level 10 (Type Safety Completa)         │
│     ↓                                                │
│  6. PHPMD (Code Smells)                              │
│     ↓                                                │
│  7. PHP Insights (Architecture)                    │
│     ↓                                                │
│  8. ✅ Code Ready                                    │
└─────────────────────────────────────────────────────┘
```

## 🎯 Vantaggi Mago

### Performance

- **10-100x più veloce** di strumenti PHP equivalenti
- Scritto in Rust per massima performance
- Ideale per pre-commit hooks e CI/CD veloci

### Precisione

- Analisi AST completa
- Token stream per debugging low-level
- Name resolution per namespace debugging

### Integrazione

- Compatibile con workflow esistenti
- Output JSON per integrazione tool
- Complemento perfetto a PHPStan

## 📝 Note Implementative

### Quando Usare Mago

✅ **DO**:
- Pre-analisi veloce prima di PHPStan
- Formattazione veloce pre-commit
- Debugging problemi sintassi complessi
- Quick linting durante sviluppo

❌ **DON'T**:
- Sostituire completamente PHPStan (complementare)
- Analisi type safety completa (usa PHPStan)
- Refactoring complesso (usa Rector)

### Strategia Integrazione

1. **Pre-Analisi**: Mago per identificare problemi rapidamente
2. **Formattazione**: Mago per velocità, Laravel Pint per consistenza Laravel
3. **Linting**: Mago per quick check, PHPStan per profondità
4. **Debugging**: Mago AST per problemi sintassi complessi

## 🔗 Collegamenti

- [Mago Overview](https://mago.carthage.software/tools/overview)
- [Mago Lexer & Parser](https://mago.carthage.software/tools/lexer-parser/command-reference)
- [Mago e Rector Usage](./mago-rector-usage.md) - Guida completa strumenti
- [Workflow Completo](./workflow-completo.md) - Workflow integrato

## ✅ Checklist Integrazione

- [x] Installazione Mago completata (Shell Installer)
- [x] Verificare funzionamento base (`./mago --version`)
- [ ] Testare comandi AST su file sample
- [ ] Testare linting su modulo Sigma
- [ ] Testare formattazione su modulo Sigma
- [ ] Testare analisi statica su modulo Sigma
- [ ] Integrare in workflow CI/CD
- [ ] Documentare risultati e pattern identificati

---

**Ultimo Aggiornamento**: Gennaio 2025  
**Status**: ✅ Installato e pronto all'uso  
**Prossimi Passi**: Utilizzare Mago per migliorare modulo Sigma

