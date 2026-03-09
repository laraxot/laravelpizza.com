Aggiornamento governance Schema.org a livello pagina.

Nuova regola fissata:
- le pagine pubbliche devono dichiarare il page type `schema.org` corretto;
- `WebPage` e' la base, ma le pagine profilo devono usare `ProfilePage`;
- dettaglio entity e listing devono valutare sottotipi come `ItemPage` e `CollectionPage`.

Messaggio chiave:
- non mischiare entity schema e page schema;
- una pagina profilo e' `ProfilePage` + entity `Person`;
- una pagina dettaglio evento e' `ItemPage` + entity `Event`.

Superfici aggiornate:
- `AGENTS.md`
- `bashscripts/ai/.cursor/rules/meetup-schema-org-rich-snippets.md`
- `bashscripts/ai/.cursor/memories/meetup-schema-org-rich-snippets.md`
- `bashscripts/ai/.codex/skills/schema-markup/SKILL.md`
- `laravel/Modules/Cms/docs/webpage-schema-governance.md`
- `laravel/Themes/Meetup/docs/webpage-profilepage-governance.md`
