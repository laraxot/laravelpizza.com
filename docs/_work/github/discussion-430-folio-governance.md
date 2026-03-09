Progress update: studiato `laravel/folio` dalla fonte primaria e riallineata la governance runtime del progetto.

Punti fissati:

- mount Folio dal provider applicativo, non da route group classico duplicato;
- fallback route come meccanismo di dispatch del frontoffice;
- metadata inline `name()/middleware()/render()` come contratto ufficiale del page file;
- wildcard params della file route gia' disponibili alla pagina / Volt;
- debug frontoffice da fare ricostruendo prima mount path, middleware reali e file matchato.

Nuove fonti canoniche salvate:

- `docs/rules/laravel-folio-governance-rule.md`
- `docs/memory/laravel-folio-runtime-memory.md`
- `docs/skills/laravel-folio-debug-skill.md`
- `laravel/Modules/Cms/docs/folio-runtime-governance.md`
- `laravel/Themes/Meetup/docs/laravel-folio-governance.md`
