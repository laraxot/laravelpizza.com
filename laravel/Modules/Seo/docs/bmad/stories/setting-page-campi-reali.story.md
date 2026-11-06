---
title: "SettingPage di Seo: gli alias delle pagine doppie"
status: done
module: Seo
type: story
qmd: "Seo SettingPage path_aliases SeoConfigData alias pagine doppie redirect 301 sitemap"
related:
  - ../../../../Xot/docs/bmad/stories/setting-page-campi-reali.story.md
---

# SettingPage di Seo: gli alias delle pagine doppie

## Fase BMAD

Build, dentro la story madre di Xot [setting-page-campi-reali](../../../../Xot/docs/bmad/stories/setting-page-campi-reali.story.md).
Richiesta dell'utente (testuale): "nei SettingPage il metodo getFormSchema non puo restituire [] in ogni modulo c'e'
qualcosa da settare".

## Cosa si configura davvero

| Campo | Default | Chi lo legge | Decisione |
|-------|---------|--------------|-----------|
| `path_aliases` | le 5 righe che stavano in `config/config.php` (`about`, `contatti`, `cookie`, `faqs`, `home`) | `RedirectToCanonicalPath::aliases()` (middleware globale, 301) e `BuildSitemapAction::indexableEntries()` (l'alias non entra in sitemap), tramite `SeoConfigData::make()->pathAliases()` | Repeater di righe `alias` / `target` |

I lettori leggevano `config('seo.config.path_aliases')`: il config del modulo viene registrato con `Config::set` e sostituisce il
ramo, quindi un valore del tenant non sarebbe mai arrivato. Ora leggono la Data, che legge `config/{tenant}/seo.php` con
`GetTenantConfigArrayAction` (niente `config:cache`). Il default vive solo nella Data; `config/config.php` ha un commento che la indica.

## Scelte

- **Lista di righe, non mappa.** `SaveTenantConfigAction` fonde le mappe per chiave: un alias tolto dal form tornerebbe nel file al
  salvataggio dopo. Una lista (come dice il commento di quella Action) sostituisce lo stato intero. La Data converte in mappa con
  `pathAliases()`.
- **Un giro di redirect e' un blocco del sito, quindi la Data lo impedisce due volte.** `pathAliases()` scarta alias vuoti, alias di se
  stessi, canonici che sono a loro volta alias e alias ripetuti; il form rifiuta il salvataggio se almeno una riga verrebbe scartata
  (`hasRejectedAliases()`, messaggio `errors.path_aliases`). L'alias riguarda solo percorsi con prefisso di lingua, quindi i pannelli
  `/{modulo}/admin` non sono raggiungibili da questa impostazione.
- **Un file sbagliato non rompe le richieste.** Il redirect e' un middleware globale: `prepareForPipeline()` riporta al default un valore che
  non e' una lista, scarta le righe che non sono testo/testo, toglie le chiavi uuid delle righe del form e legge `target` null (campo
  vuoto del form) come home.

## Lasciato fuori

- `site_title`, `site_description` (bozza di Codex): nessun lettore in `Seo`. Titolo e descrizione del sito sono nel file `metatag`
  (`MetatagData` di Xot, impostazione del modulo Tenant); `Seo\Datas\MetatagData` e' uno stato in memoria riempito dalla facade
  `Metatag`, non legge la configurazione.
- `indexable` (bozza di Codex): nessun lettore. Un interruttore "non indicizzare il sito" richiede di toccare Cms, che decide il
  `<meta name="robots">` (`ResolveRobotsPolicyAction`) e non dipende da Seo; `robots.txt` con `Disallow: /` da solo non toglie le
  pagine dall'indice (lo dice il commento di `BuildRobotsTxtAction`) e contraddice il `noindex`. Non aggiunto: servirebbe un punto di
  estensione in Cms. Mostrarlo ora sarebbe una bugia nel menu.
- `BuildRobotsTxtAction::PRIVATE_SEGMENTS`: costante legata da un test a `ResolveRobotsPolicyAction::HIDDEN_SEGMENTS`, non una
  preferenza.

## Verifica

- Pest `Modules/Seo/tests/Unit/Datas/SeoConfigDataTest.php`: 20 test (default uguali a oggi, valore del file del tenant, il middleware lo usa,
  elenco vuoto = nessun alias, giri/catene/ripetuti scartati e segnalati, file malformato, righe del form, campi = proprieta', etichette
  it/en, alias tolti dal config). Test del middleware e di `ResolvePathAliasAction` aggiornati per leggere la Data.
- Falliscono gia' prima di questa modifica, per motivi che non c'entrano: `ResolvePathAliasActionTest > keeps the JSON of every alias`
  (cerca i contenuti del modulo `TechPlanner`, assente in questo repo), i dataset `german` (`/de/`) di `RedirectToPageAliasTest` e
  `RedirectToCanonicalPathTest` (la lingua `de` non e' attiva nel tenant locale) e due test di `CanonicalPathRedirectTest` (404 su
  `/it/tickets`, pagine che il tenant locale non ha).
- PHPStan livello max sui file toccati: 0 errori. Pint: passed.
- Non verificato: il rendering reale del Repeater nel pannello (nessun browser); il test controlla lo schema, le chiavi e le etichette.
