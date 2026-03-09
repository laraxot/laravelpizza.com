[Progress]

Ho riesaminato il refactor prima di considerarlo valido.

Conclusione:

- spostare `container0` / `slug0` dentro `data` e' corretto;
- eliminare props dedicate e' piu' dry e scala a `container1` / `slug1` senza cambiare la signature;
- `...$this->data` nei view params e' accettabile solo se le chiavi interne del componente restano autorevoli.

Rifiniture completate:

- aggiunto test Pest che verifica il passaggio del contesto annidato (`container0`, `slug0`, `container1`, `slug1`);
- aggiunto test Pest che verifica la precedence delle chiavi interne (`side`, `slug`) rispetto a collisioni provenienti da `data`;
- aggiornata la regola `laravel/Modules/Cms/docs/x-page-context-data-rule.md`;
- allineati i docs CMS/Theme sul fatto che `x-page` deve restare route-agnostic.

Verifiche eseguite:

- `./vendor/bin/pest Modules/Cms/tests/Unit/Views/PageComponentDataMergeTest.php Modules/Meetup/tests/Feature/EventDetailPageTest.php`
  - result: `4 passed (46 assertions)`
- `./vendor/bin/phpstan analyse Modules/Cms/app/View/Components/Page.php Modules/Cms/tests/Unit/Views/PageComponentDataMergeTest.php --no-progress --debug`
  - result: `No errors`
- `php -l` OK su `Page.php` e `PageComponentDataMergeTest.php`
- `./vendor/bin/phpmd` non disponibile nel repo
- `./vendor/bin/phpinsights analyse ...`
  - il refactor non introduce errori architetturali;
  - restano warning storici/non bloccanti:
    - public properties del componente Blade;
    - rule `static closure` incompatibile con la sintassi usata da Pest in questo progetto;
    - syntax check rumoroso su file legacy del modulo Cms non collegati a questo refactor.
