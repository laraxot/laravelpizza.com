# Docs Root Location Memory

Snapshot 2026-03-02:
- `laravel/docs` rimosso.
- documentazione globale consolidata in `docs/`.

Invarianti:
1. Nessuna nuova documentazione globale sotto `laravel/docs`.
2. I path relativi nei docs modulo/tema devono includere un livello `../` in piu rispetto al vecchio layout.
3. Ogni nuova regola/memory/skill globale va creata in `docs/rules`, `docs/memory`, `docs/architecture`.
