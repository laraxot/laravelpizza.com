Update sul fix header auth CTA/localization.

Implementazione completata:

- la `headernav` CMS non duplica piu' i bottoni guest auth;
- i file
  - `Modules/Cms/resources/views/components/headernav/simple.blade.php`
  - `Modules/Cms/resources/views/components/blocks/headernav/simple.blade.php`
  delegano ora al partial condiviso `pub_theme::components.ui.auth-buttons`;
- questo rende DRY copy, stile e route localizzate (`/auth/login`, `/auth/register`) tra tema Meetup e headernav CMS;
- copy tedesca riallineata a `Anmelden` / `Registrieren`;
- aggiornata la documentazione locale del tema per fissare la regola di delega al partial condiviso.

Verifica eseguita:

- `php -l`
- `./vendor/bin/pest Modules/Meetup/tests/Feature/HeaderLocalizationTest.php Modules/Cms/tests/Unit/Views/HeadernavAuthCtaLocalizationTest.php Modules/Cms/tests/Feature/Frontoffice/FolioRoutes/HeaderAuthLocalizationTest.php`
  - risultato: `10 passed (54 assertions)`
- `./vendor/bin/phpinsights analyse ...`
  - score perimetro toccato: `Code 99 / Complexity 100 / Architecture 100 / Style 97.6`
- `./vendor/bin/phpstan analyse ...`
  - ancora bloccato da errore infrastrutturale locale: `Failed to listen on tcp://127.0.0.1:0`
- `phpmd`
  - non disponibile nel repository (`./vendor/bin/phpmd` mancante)

Nota UX:

- ho mantenuto una gerarchia forte tra CTA secondaria login e primaria register, coerente con best practice UX su primary vs secondary actions e prominence del bottone principale (Baymard).
