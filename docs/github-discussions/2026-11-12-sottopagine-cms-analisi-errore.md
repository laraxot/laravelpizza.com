Categoria: Ideas (o General) · Titolo: **Sotto-pagine CMS: una cartella per contenitore (e l'errore che ce l'ha insegnato)**

Regola: una pagina che sta sotto un contenitore è un JSON nella sua cartella, con slug corto.
`pages/profile/edit.json` con `"slug": "edit"` → pagina `profile.edit` → `/it/profile/edit`.
`pages/events/my.json` → `/it/events/my`.

Il 9/11 avevamo appiattito `pages/events/my.json` in `events-my.json` (con varianti "col trattino" nei resolver) invece di correggere lo slug sbagliato dentro il file. Il sito funzionava, ma con due convenzioni per la stessa cosa. Ora c'è una sola convenzione, i vecchi URL reindirizzano (301) e un evento non può più prendere lo slug di una sotto-pagina.

- Regola: `laravel/Modules/Cms/docs/cms-subpages-folders.md`
- Analisi dell'errore (cause e come evitarlo): `laravel/Modules/Cms/docs/lessons/flattened-cms-subpages-error-analysis.md`

**Domanda**: gli altri progetti Laraxot che usano il modulo Cms hanno pagine piatte del tipo `{contenitore}_view.json` o `{contenitore}-x.json`? Conviene migrarle alla stessa regola.
