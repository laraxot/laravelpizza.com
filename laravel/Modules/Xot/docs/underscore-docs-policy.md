# Underscore Docs Policy

## Regola

Nel repository `base_predict_fila5` la cartella `_docs/` non deve mai esistere dentro `laravel/Modules/*`.

Anche le varianti annidate come `docs/_docs/` sono vietate.

## Path corretti

- documentazione viva del modulo: `Modules/<Module>/docs/`
- eventuale documentazione di progetto condivisa: `laravel/project_docs/`

## Perche'

- `_docs/` e' un contenitore ambiguo e non canonico
- favorisce rigenerazioni sporche e contenuti duplicati
- rende meno chiaro quale documentazione e' viva e quale e' scarto

## Regola operativa

1. I `.gitignore` dei moduli devono contenere `_docs/`.
2. Se compare una cartella `_docs/`, va rimossa.
3. La documentazione utile va migrata o mantenuta solo in `docs/`.
