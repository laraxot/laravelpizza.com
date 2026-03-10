# Skill: Remove Log::info

## Trigger
Quando compare richiesta esplicita "no Log::info" o audit logging-performance.

## Azioni
1. Cercare solo codice runtime (`*.php`, escluso `docs/**`).
2. Sostituire `Log::info(` con alternativa minima (`Log::debug(` o rimozione).
3. Validare con quality gates sui file toccati.
4. Aggiornare issue/discussion con elenco file e motivazione.
