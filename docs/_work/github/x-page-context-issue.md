[Context]

`Modules\Cms\View\Components\Page` aveva props dedicate `container0` e `slug0`, oltre allo stesso contesto gia' trasportato in `$data`.

Questo accoppiava `x-page` al pattern route corrente e rendeva scomodo supportare livelli futuri come:

- `container1` / `slug1`
- `container2` / `slug2`

[Decision]

Ho confermato il principio proposto, con una precisazione:

- il contesto route deve vivere solo in `$data`;
- il `render()` puo' fare `...$this->data` nei `view_params`;
- le chiavi interne del componente (`blocks`, `side`, `slug`, `data`) devono restare autorevoli e quindi sovrascrivere eventuali collisioni provenienti da `$data`.

[Changes]

- rimosse da `Page.php` le props dedicate `container0` e `slug0`;
- rimosso `resolveContext()`;
- il costruttore ora accetta solo `data` come contesto estendibile;
- `render()` passa `...$this->data` alla view;
- aggiornato `cms::components.page`;
- aggiornato `pub_theme::components.blocks.content-resolver` per passare il contesto via `:data`;
- aggiunte docs:
  - `laravel/Modules/Cms/docs/x-page-context-data-rule.md`
  - update `laravel/Modules/Cms/docs/blade-logic-separation.md`
  - update `laravel/Themes/Meetup/docs/events-detail-slug0-loading.md`
- aggiornati test Pest su `PageComponentDataMergeTest`

[Verification]

- Pest:
  - `Modules/Cms/tests/Unit/Views/PageComponentDataMergeTest.php`
  - `Modules/Meetup/tests/Feature/EventDetailPageTest.php`
  - result: `3 passed (24 assertions)`
- `php -l` OK su `Page.php` e `PageComponentDataMergeTest.php`
- `phpinsights` OK su complexity/architecture; restano warning stile e rumore storico del modulo
- `phpmd` non disponibile nel repo (`./vendor/bin/phpmd` mancante)
- `phpstan Modules/Cms` bloccato da errori sintattici preesistenti in factories/migrations/seeders del modulo, non causati da questa modifica
