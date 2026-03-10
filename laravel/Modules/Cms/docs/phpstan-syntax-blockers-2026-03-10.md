# PHPStan Syntax Blockers - 2026-03-10

## Contesto

Eseguendo `./vendor/bin/phpstan analyse Modules` dal root `laravel/` il risultato non si ferma a type errors: il primo blocco reale e' sintattico.

## Stato Cms osservato

- `database/Migrations/2024_01_01_000000_create_page_contents_table.php`
- `database/seeders/CmsMassSeeder.php`

Entrambi mostravano corruzione sintattica evidente:

- callback chiuse male;
- array `create([)` spezzati;
- uso di variabile `command` non definita al posto di `$this->command`.

## Ripristino applicato

- migration `create_page_contents_table` riportata a callback valide `tableCreate()` / `tableUpdate()`;
- `CmsMassSeeder` ripristinato con `create([...])` validi e output su `$this->command?->...`.

## Nota importante

La documentazione storica che dichiarava Cms completamente compliant non e' piu' affidabile da sola: c'e' stata una regressione successiva.

## Stato dopo il ripristino

- il cluster sintattico `Cms` corretto in questo passaggio ora passa PHPStan su file mirati;
- il run globale `./vendor/bin/phpstan analyse Modules` non si ferma piu' su questi due file;
- i blocchi `Cms` rimasti sono ora di tipo semantico/documentale, non piu' parse errors.

## Backlog Cms emerso dal run globale

- `app/Http/Livewire/Page/Show.php`: cast e proprieta' mancanti su `Page`;
- `app/View/Components/GuestLayout.php`: tipo `view-string` da rendere esplicito;
- `database/factories/PostFactory.php`: factory riferita a modello `Post` non risolto;
- `resources/views/Composers/ThemeComposer.php`: firma `Blocks` non piu' allineata.
