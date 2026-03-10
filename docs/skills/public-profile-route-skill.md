# Public Profile Route Skill

Quando si tocca `/profile/{id}`:

1. verificare quale file Folio vince davvero in runtime;
2. eliminare route duplicate o renderle coerenti sullo stesso blocco;
3. controllare che il body contenga stringhe tradotte visibili, non solo dati presenti nello schema JSON-LD;
4. controllare `ProfilePage` / `Person` in `PageSchemaBuilder`;
5. eseguire almeno:
   - `./vendor/bin/phpstan analyse Modules/Cms/app/Support/PageSchemaBuilder.php --no-progress --debug`
   - `./vendor/bin/pest Modules/Cms/tests/Feature/Frontoffice/FolioRoutes/PublicProfileRouteTest.php Modules/Cms/tests/Unit/Support/PageSchemaBuilderTest.php`
