# heretic llm e laraxot

## cos'è heretic (sintesi)

[Heretic](https://github.com/p-e-w/heretic) è un tool open source (AGPL‑3.0) che:

- applica tecniche di **directional ablation / abliteration** ai modelli transformer
- mira a rimuovere o ridurre la “censura” / safety alignment trovando direzioni di rifiuto nei residui e ablando selettivamente le matrici (attention out‑projection, MLP down‑projection)
- ottimizza automaticamente parametri di ablazione con una ricerca bayesiana (Optuna, TPE), bilanciando:
  - riduzione dei *refusal* su prompt “harmful”
  - minima divergenza KL rispetto al modello originale su prompt “harmless”

È uno strumento di **ricerca sui modelli** (interpretabilità e controllo del comportamento) che opera fuori dal runtime Laravel.

## posizione laraxot/<nome progetto>

In questo progetto:

- **non integriamo** Heretic nel codice Laravel (né come dipendenza PHP, né come servizio esterno)
- **non** modifichiamo il comportamento di safety/alignement dei modelli LLM usati dagli strumenti AI (Cursor, Claude, ecc.)
- usiamo Heretic solo come **riferimento concettuale** per:
  - capire meglio come i modelli rappresentano direzioni semantiche nei residui
  - ispirare analisi di qualità (es. separazione tra casi “safe” e “dangerous”) quando progettiamo regole per gli agenti

## linee guida per gli agenti ai

- Heretic è **out of scope** per:
  - generare codice Laravel/PHP
  - alterare safety dei modelli che eseguono il codice agente
  - suggerire agli utenti come “decensorare” LLM in contesti di produzione
- Heretic è **in scope** solo come:
  - esempio di come si possano studiare le direzioni nei residui e l’effetto sui comportamenti del modello
  - promemoria che ogni modifica alla pipeline AI deve essere valutata per:
    - sicurezza
    - licenza (AGPL‑3.0)
    - coerenza con scopi del progetto (<nome progetto> è un sito per meetup, non un laboratorio di abliteration)

## collegamenti

- repo ufficiale: `https://github.com/p-e-w/heretic`
- licenza: **AGPL‑3.0** (non compatibile con semplice embedding di codice in questo progetto)
- docs metodologia AI nel progetto: `bmad-method.md`

