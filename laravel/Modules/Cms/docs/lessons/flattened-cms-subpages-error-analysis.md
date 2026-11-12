# Analisi di un errore: sotto-pagine CMS "appiattite" (events-my.json)

Data: 12/11/2026. Autore dell'errore e dell'analisi: Claude. Commit dell'errore: `2edc5fe60` (9/11/2026).
Correzione: commit che introduce `pages/profile/edit.json` e sposta le sotto-pagine in `pages/events/`.

## Cosa è successo

Nel repository c'era `pages/events/my.json` ("I miei eventi"), ma con `"slug": "events-my"` dentro la cartella.
`SushiToJsons` prefissa lo slug con la cartella, quindi la pagina valeva `events.events-my` e `/it/events/my` dava 404.

Invece di correggere lo slug nel file (`"slug": "my"`), ho:

1. spostato il file in `pages/events-my.json` (pagina piatta, URL `/events-my`);
2. aggiunto varianti "con il trattino" in due punti: `PageSlugMiddleware` (`implode('-', $segments)`) e la pagina
   Folio `[container0]/[slug0]` (`events-my` come ripiego di `events.my`);
3. creato con lo stesso schema `events-past.json`, e lasciato `events_view.json` / `profile_view.json` piatti.

Il sito funzionava, i test passavano, ma la struttura dei contenuti non seguiva più la convenzione del CMS e il
codice aveva due regole per la stessa cosa. Marco ha dovuto ricordarmi la convenzione quando è servita
`pages/profile/edit.json`.

## Perché l'ho fatto (cause vere, non scuse)

- **Ho corretto il sintomo, non la causa.** Il sintomo era "404 su /events/my"; la causa era un valore sbagliato in un
  JSON. Ho cercato il modo più breve per far rispondere la pagina, non il perché non rispondesse.
- **Non ho letto il meccanismo prima di cambiarlo.** `SushiToJsons::prefixRowKeys()` documenta in una riga che
  `a/b/1.json` diventa `a.b.<valore>`. Leggerla avrebbe mostrato subito che la cartella era giusta e lo slug no.
- **Ho preso un file sbagliato come esempio da imitare.** I file piatti `events_view.json` e `profile_view.json`
  (con lo slug completo `events.view` dentro) mi hanno fatto credere che "piatto" fosse lo standard.
- **Ho aggiunto tolleranza invece di una regola.** Accettare sia `.` sia `-` sembra robusto, ma rende ambiguo quale
  file serve un URL e invita chi viene dopo a scegliere a caso.
- **Non ho guardato la storia del file.** `git log` su `pages/events/` avrebbe mostrato che la cartella esisteva per
  scelta, non per errore.

## Come evitarlo

- Prima di "aggiustare" un 404 del CMS: trovare quale slug produce il file (`Page::query()->pluck('slug')`) e quale
  slug cerca la rotta; correggere il dato, non il resolver.
- Leggere il codice che carica i contenuti (`SushiToJsons`, `ResolvePageAction`, `PageSlugMiddleware`) prima di
  aggiungere eccezioni.
- Una convenzione, una sola strada: niente varianti alternative "per sicurezza" nei resolver.
- Se un esempio nel repository contraddice la convenzione, l'esempio va corretto, non copiato.
- La convenzione ora è scritta in [../cms-subpages-folders.md](../cms-subpages-folders.md) ed è coperta da test
  (`Modules/Meetup/tests/Feature/ProfileEditPageTest.php`).

## Un secondo errore trovato lavorando su questo

`Modules/Meetup/tests/TestCase.php` impostava `xra.main_module = User`, mentre la produzione usa `Meetup`. Nei test il
profilo era `Modules\User\Models\Profile` (database utenti, con `bio`), in produzione `Modules\Meetup\Models\Profile`
(database dati, **senza** `bio`, `locale`, `address`): la biografia del profilo pubblico non poteva mai comparire e i
test non se ne accorgevano. Corretto il TestCase (stessa configurazione della produzione) e aggiunta la migrazione
`2026_11_12_000001_add_bio_locale_address_to_profiles_table`. Lezione: i test devono girare con la configurazione del
tenant reale, non con una comoda.
