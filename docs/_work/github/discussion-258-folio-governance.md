Aggiornamento da studio sorgente `laravel/folio`:

- nel repository il frontoffice Folio e' montato da `App\\Providers\\FolioServiceProvider` con `Folio::path($pagesPath)->middleware(['*' => [SetFolioLocale::class]])`, non da un route group classico in `routes/web.php`;
- Folio dispatcha tramite fallback route e compone i middleware come: `web` + mount-level + inline `middleware(...)`;
- `name()` nel page file diventa il route name effettivo della richiesta matchata;
- i wildcard segment della struttura file (`[slug]`, `[container0]`, `[slug0]`) vengono passati come data della pagina, quindi `request()->route()` va evitato quando Folio/Volt ha gia' fatto il binding.

Ho allineato la governance locale con nuovi documenti:

- `docs/rules/laravel-folio-governance-rule.md`
- `docs/memory/laravel-folio-runtime-memory.md`
- `docs/skills/laravel-folio-debug-skill.md`
- `laravel/Modules/Cms/docs/folio-runtime-governance.md`
- `laravel/Themes/Meetup/docs/laravel-folio-governance.md`

Effetto pratico: i prossimi fix su pagine pubbliche, CMS blocks e route dinamiche devono partire dal runtime Folio reale prima di ipotizzare problemi di Blade, CMS o middleware “esterni”.
