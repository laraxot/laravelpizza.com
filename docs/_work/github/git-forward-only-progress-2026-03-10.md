Aggiornamento governance `git forward-only`.

- Rafforzata la regola globale in `docs/rules/git-forward-only-rule.md`.
- Aggiornate le memory operative in `docs/memory/pre-edit-docs-first-memory.md` e `docs/memory/ralph-loop-and-forward-only-memory.md`.
- Aggiunta skill dedicata `docs/skills/git-forward-only-skill.md`.
- Riallineata la documentazione locale in `Modules/Xot/docs/git-forward-only-rule.md`.
- Regola resa esplicita: vietati `git checkout -- <file>`, `git restore <file>`, `git reset --hard` e qualunque restore wholesale di file storici nel workspace condiviso.
- Uso corretto di git: studio del contratto con `git show`, poi fix minima forward-only nel codice corrente.

Nel perimetro `Notify` la rimozione di `Modules/Notify/app/Http/Controllers/NotificationTrackingController.php` resta coerente con questa governance: file legacy orfano, nessun restore, solo avanzamento e test di regressione.
