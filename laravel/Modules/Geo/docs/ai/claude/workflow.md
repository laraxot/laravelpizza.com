# Workflow Claude Code per PTVX

---

## Workflow Standard

### 1. Setup Iniziale

1. **Apri progetto**: Apri `laravel/` come workspace in Claude Code
2. **Verifica MCP**: Controlla che tutti i server MCP siano attivi
3. **Leggi docs**: Studia `docs/` e `laravel/Modules/{Module}/docs/` del modulo su cui lavori

---

### 2. Sviluppo Modulo per Modulo

**Principio**: Completa un modulo alla volta, poi passa al successivo.

#### Fase 1: Preparazione

```bash
# 1. Studia documentazione modulo
cat laravel/Modules/{Module}/docs/README.md

# 2. Esegui PHPStan per identificare errori
cd laravel
./vendor/bin/phpstan analyse Modules/{Module} --level=10 --memory-limit=-1
```

#### Fase 2: Analisi

- Leggi errori PHPStan
- Categorizza per tipo (argument.type, return.type, ecc.)
- Identifica pattern ripetuti
- Crea roadmap in `Modules/{Module}/docs/phpstan-roadmap.md`

#### Fase 3: Correzione

- Correggi file per file
- Verifica dopo ogni file: PHPStan, PHPMD, PHP Insights
- Aggiorna documentazione del modulo

#### Fase 4: Verifica Finale

```bash
# Verifica completa modulo
./vendor/bin/phpstan analyse Modules/{Module} --level=10
./vendor/bin/phpmd Modules/{Module} text codesize
./vendor/bin/phpinsights analyse Modules/{Module}
```

#### Fase 5: Commit

```bash
git add -A
git commit -m "fix({Module}): risolti errori PHPStan livello 10"
git push
```

---

## Pattern di Utilizzo Claude Code

### 1. Chat per Analisi

**Quando usare**: Per comprendere codice complesso, analizzare errori, ricevere suggerimenti

**Esempio**:
```
Analizza questo errore PHPStan:
"Method getTableActions() should return array<string, ...> but returns array{...}"

Spiega perché si verifica e come risolverlo seguendo le regole Laraxot.
```

---

### 2. Code Generation

**Quando usare**: Per generare codice boilerplate, test, documentazione

**Esempio**:
```
Crea un Action Spatie Queueable per creare un nuovo User seguendo:
- Namespace: Modules\User\Actions
- Estendi pattern Laraxot
- Include validazione con Webmozart Assert
- Documenta in Modules/User/docs/actions.md
```

---

### 3. Refactoring Assistito

**Quando usare**: Per refactoring complessi, migrazione pattern, ottimizzazione

**Esempio**:
```
Refactora questo metodo per ridurre complexity da 15 a < 10:
- Usa Extract Method pattern
- Applica Guard Clauses
- Mantieni compatibilità all'indietro
```

---

### 4. Debugging Assistito

**Quando usare**: Per debugging errori complessi, analisi stack trace

**Esempio**:
```
Analizza questo stack trace e identifica la causa radice:
[stack trace completo]

Suggerisci fix seguendo approccio Fix Don't Ignore.
```

---

## Utilizzo MCP nei Workflow

### Filesystem MCP

**Quando usare**: Quando file risultano bloccati o non accessibili

```
@filesystem read laravel/Modules/User/app/Models/User.php
```

### Sequential Thinking MCP

**Quando usare**: Per analisi complesse che richiedono ragionamento strutturato

```
@sequential-thinking analizza questa funzione e suggerisci ottimizzazioni
```

### MySQL MCP

**Quando usare**: Per query database complesse, verifica schema

```
@mysql query "SELECT * FROM users WHERE email = 'test@example.com'"
```

---

## Best Practices Workflow

### 1. Sempre Inizia da Docs

Prima di modificare codice:
- Leggi `Modules/{Module}/docs/`
- Studia architettura e business logic
- Comprendi "perché" prima di "come"

### 2. Verifica Continua

Dopo ogni modifica:
- PHPStan livello 10
- PHPMD (complexity)
- PHP Insights (quality)

### 3. Documenta Sempre

Dopo ogni modifica importante:
- Aggiorna `Modules/{Module}/docs/`
- Aggiungi collegamenti bidirezionali
- Documenta decisioni architetturali

### 4. Modulo per Modulo

- Completa un modulo prima di passare al successivo
- Quando tutti i moduli sono a posto, verifica tutta la cartella `Modules/`

---

## Collegamenti Correlati

- [Best Practices](./best-practices.md)
- [Configurazione](./configuration.md)
- [Setup MCP](./mcp-setup.md)
- [Workflow Laraxot](../../project/laraxot-methodology.md)
