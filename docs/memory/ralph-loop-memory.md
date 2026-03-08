# Ralph Loop - Guida per LaravelPizza

**Data**: 08-03-2026

## Cos'e' Ralph Loop

Ralph Loop e' una tecnica di sviluppo AI che fa lavorare l'agente in loop fino al completamento. Nome derivato da Ralph Wiggum Simpsons (" deiI'm in danger!").

### Concetto Base

```
# Esegui una volta:
/ralph-loop "Il tuo task" --completion-promise "DONE"

# OpenCode automaticamente:
# 1. Lavor sul task
# 2. Finisce di rispondere
# 3. Il plugin intercetta lo stato idle
# 4. Il plugin rimanda lo STESSO prompt
# 5. Ripete fino al completamento
```

## Installazione

```bash
# Copia i file nella config OpenCode
cp plugin/* ~/.config/opencode/plugin/
cp command/* ~/.config/opencode/command/
```

## Comandi

### /ralph-loop
Avvia un Ralph loop nella sessione corrente.

```bash
/ralph-loop "Implementa feature X. Requirements: [...]. Output: <promise>COMPLETE</promise>" --max-iterations 50
```

### /cancel-ralph
Cancella il loop attivo.

### /ralph-help
Aiuto dettagliato.

## Best Practices

### 1. Criteri di Completamento Chiari

```
# SBAGLIATO:
"Build a todo API and make it good."

# CORRETTO:
"Build a REST API for todos.
When complete:
- All CRUD endpoints working
- Input validation in place
- Tests passing
- Output: <promise>COMPLETE</promise>"
```

### 2. Obiettivi Incrementali

```
# SBAGLIATO:
"Create a complete e-commerce platform."

# CORRETTO:
"Phase 1: User authentication (JWT, tests)
Phase 2: Product catalog
Phase 3: Shopping cart
Output: <promise>COMPLETE</promise>"
```

### 3. Self-Correction

```
"Implement feature X following TDD:
1. Write failing tests
2. Implement feature
3. Run tests
4. If any fail, debug and fix
5. Repeat until all green
Output: <promise>COMPLETE</promise>"
```

### 4. Safety Net

```
# Sempre usare --max-iterations come protezione
/ralph-loop "Try to implement feature X" --max-Iterations 20
```

## Quando Usare Ralph

### Buono per:
- Task ben definiti con criteri chiari
- Task che richiedono iterazione (es. test che passano)
- Greenfield projects
- Verifica automatica (test, linter)

### Non buono per:
- Task che richiedono giudizio umano
- Operazioni one-shot
- Task con criteri non chiari
- Debugging produzione

## In LaravelPizza

Per usare Ralph con questo progetto:

```bash
cd /var/www/_bases/base_laravelpizza

/ralph-loop "Fix failing tests in Modules/Meetup. Run tests, analyze failures, fix bugs. Output: <promise>COMPLETE</promise>" --max-iterations 30
```

## Riferimenti

- Originale: https://ghuntley.com/ralph/
- OpenCode plugin: https://github.com/rot13maxi/opencode-ralph
