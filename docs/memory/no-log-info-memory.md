# Memory: No Log::info

- Regola attiva: `Log::info(...)` non ammesso nel codice runtime.
- Sessione 2026-03-10: sostituite occorrenze runtime `Log::info(` con `Log::debug(` in moduli attivi.
- Ogni nuova PR deve evitare regressioni su questa regola.
