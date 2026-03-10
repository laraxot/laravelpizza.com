## Contesto
Richiesta operativa: eseguire `php artisan ide-helper:models -W` dalla cartella `laravel/` e correggere tutte le segnalazioni.

## Governance applicata prima del codice
- aggiornata regola: `docs/rules/ide-helper-models-wave-rule.md`
- aggiornata memory: `docs/memory/ide-helper-models-wave-memory.md`
- aggiornata skill: `docs/skills/ide-helper-models-wave-skill.md`
- aggiornato modulo: `laravel/Modules/User/docs/fix-ide-helper-relation-errors.md`
- aggiornata documentazione tema: `laravel/Themes/Meetup/docs/index.md`

## Piano wave
1. eseguire `php artisan ide-helper:models -W` in `laravel/`
2. raccogliere errori/finding
3. correggere in forward-only (no rollback)
4. quality gate: phpstan, phpmd, phpinsights, Pest se testabile
5. aggiornare issue/discussion con delta completato
