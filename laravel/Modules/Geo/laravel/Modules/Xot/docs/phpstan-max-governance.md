# PHPStan Max Governance

## Scopo

Nel progetto `base_predict_fila5` PHPStan non si usa a livelli intermedi come obiettivo finale.
La governance corretta e' una sola: **livello MAX sempre**.

## Regola

- Il target di qualita' static analysis e' sempre `--level=max` oppure la configurazione equivalente gia' allineata al massimo livello.
- Documenti, rules, memories, skills e checklist non devono suggerire livelli inferiori come standard operativo.
- Un riferimento a level 2, level 5, level 9 o level 10 puo' esistere solo come contesto storico, archivio o tappa di migrazione, mai come quality gate corrente.

## Implicazioni operative

1. Dopo ogni edit PHP si esegue PHPStan sul perimetro cambiato con livello massimo.
2. Se il modulo usa una configurazione centralizzata, la configurazione deve restare allineata al massimo livello supportato.
3. Se un documento riporta un livello inferiore come regola attiva, va corretto subito.
4. Se il problema rivela un gap sistemico, va aperta o aggiornata una GitHub Issue.

## Anti-pattern

- "Eseguire l'analisi PHPStan a livello 2"
- "Partire da level 5 come standard del progetto"
- "Chiudere il task con phpstan locale a livello ridotto"

## Collegamenti

- [Xot docs index](./README.md)
- [Project error-fix workflow](../../../../docs/project/ERROR_FIX_WORKFLOW.md)
- [GitHub issue #1](https://github.com/laraxot/base_predict_fila5/issues/1)
- [GitHub discussion #2](https://github.com/laraxot/base_predict_fila5/discussions/2)
