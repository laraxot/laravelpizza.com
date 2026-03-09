# Verification Gate Skill

## Goal

Assicurare che ogni claim di completamento sia supportato da verifica concreta.

## Checklist

1. Run test/lint pertinenti.
2. Salvare output essenziale (pass/fail/blocker).
3. Aggiornare issue/discussion con evidenza.
4. Verificare che il workflow usato non abbia scritto artefatti in `/tmp`.
5. Solo allora marcare step come completato.

## Gate minimi per file PHP

Se e' stato modificato un file PHP:

1. eseguire `phpstan`;
2. eseguire `phpmd`;
3. eseguire `phpinsights`;
4. valutare il test Pest associato;
5. creare o aggiornare il test se il comportamento e' testabile.
