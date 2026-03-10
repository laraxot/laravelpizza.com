# Skill: PHPStan Modules Wave

## Trigger

Quando l'obiettivo e' ridurre errori da `phpstan analyse Modules`.

## Workflow rapido

1. Esegui phpstan globale e salva output raw.
2. Seleziona un modulo target per wave.
3. Isola prima i parse blocker: se presenti, sono prioritari rispetto ai type error.
4. Correggi errori tipizzati (property, generics, class not found) dal piu' bloccante.
5. Se il cluster tocca wrapper Passport/Laravel upstream, documenta esplicitamente cosa e' problema runtime e cosa e' problema di typing statico.
6. Valida con phpstan/phpmd/phpinsights/pest sui file toccati.
7. Aggiorna issue + discussion con:
   - errori iniziali,
   - errori risolti,
   - errori residui,
   - prossima wave.

## Heuristiche emerse

- Non mischiare nella stessa wave `Cms`, `Notify`, `Tenant` e `User/Passport` se non c'e' un blocker sintattico condiviso.
- Nei seeder corrotti, cercare subito pattern ricorrenti come `$command` al posto di `$this->command`.
- Nelle factory OAuth, cercare subito `$faker` senza `$this->`, callback `state()` spezzate e array mutilati.
