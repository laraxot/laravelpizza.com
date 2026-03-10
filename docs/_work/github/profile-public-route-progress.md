Aggiornamento sul profilo pubblico `/it/profile/{id}`.

Root cause reale:

- la URL pubblica usa l'`id` dell'utente (`Modules\User\Models\User`), non uno slug profilo;
- il rendering passava dal catch-all Folio `container0.view`;
- mancava il template CMS `profile.view`, quindi la route non aveva un contratto di rendering dedicato;
- `PageSchemaBuilder` riconosceva `ProfilePage` per `profile.*`, ma non per `container0.view` con `container0=profile`.

Intervento fatto:

- aggiunte docs locali:
  - `Modules/Cms/docs/profile-public-route-resolution.md`
  - `Themes/Meetup/docs/profile-view-page-contract.md`
- aggiunto JSON CMS `config/local/laravelpizza/database/content/pages/profile_view.json`
- aggiunto block tema `pub_theme::components.blocks.profile.detail`
- mantenuto il pattern unico `container0.view` senza introdurre route/controller paralleli
- esteso `PageSchemaBuilder` per trattare `/profile/{id}` come `ProfilePage` anche nel route name generico e per emettere `mainEntity: Person` con `identifier`
- aggiunti test:
  - `Modules/Meetup/tests/Feature/ProfileDetailPageTest.php`
  - `Modules/Cms/tests/Unit/Support/PageSchemaBuilderTest.php`

Verifica:

- request Laravel interna su `/it/profile/019cca1b-1f72-700a-ba0b-0bb414ca0c88`: `STATUS=200`
- il contenuto contiene `Eufemia Martinelli`
- il contenuto contiene `helga.ferrara@example.org`
- Pest:
  - `./vendor/bin/pest Modules/Meetup/tests/Feature/ProfileDetailPageTest.php Modules/Cms/tests/Unit/Support/PageSchemaBuilderTest.php Modules/Cms/tests/Unit/Actions/ResolvePageActionTest.php`
  - risultato: `12 passed (44 assertions)`
- `php -l` verde sui file PHP toccati
- `phpstan` ancora bloccato dall'errore infrastrutturale locale `Failed to listen on tcp://127.0.0.1:0`
- `phpmd` non disponibile nel repository (`./vendor/bin/phpmd` mancante)
- `phpinsights` sul perimetro:
  - `Code 96 / Complexity 40 / Architecture 94.1 / Style 97.6`
  - il rumore residuo e' in gran parte storico del repository; resta debito di complessita' su `PageSchemaBuilder`
