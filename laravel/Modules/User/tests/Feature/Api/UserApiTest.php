<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Api;

use Modules\User\Tests\TestCase;

uses(TestCase::class);

/**
 * User API CRUD: specifica non implementata.
 *
 * Il corpo originale (37 test) esercita endpoint REST su `api/users` (index con filtri e
 * paginazione, show, store, update, destroy, bulk-update, bulk-delete, statistics, export).
 * `routes/api.php` espone solo `POST api/user/login`, `GET api/v2/user` e `GET api/v2/logout`:
 * nessuna route `api/users*`, nessun controller CRUD (DCP-252). Il vecchio `setUp` saltava gia'
 * l'intera classe in assenza della route, ma usava anche `Tests\Support\Traits\ModuleTestTrait`
 * (`setUpModuleTest`, `createAuthenticatedUser`, `createUserWithRole`), che non esiste in nessun
 * modulo, e `RefreshDatabase`, vietato.
 *
 * Quando l'API sara' implementata, ripristinare il corpo da git e riscriverlo in Pest su
 * `Modules\User\Tests\TestCase`: `git -C Modules/User show 0e2e66d86:tests/Feature/Api/UserApiTest.php`.
 *
 * @see Modules/User/docs/stories/phpstan-test-wave-user-b.story.md
 */
it('user api crud')->skip('api/users CRUD routes and controller not implemented (DCP-252)');
