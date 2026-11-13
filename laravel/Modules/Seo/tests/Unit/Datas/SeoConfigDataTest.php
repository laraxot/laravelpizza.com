<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Modules\Seo\Datas\SeoConfigData;
use Modules\Seo\Filament\Pages\SettingPage;
use Modules\Seo\Http\Middleware\RedirectToCanonicalPath;
use Modules\Seo\Tests\Support\FakeTenantSeoConfig;
use Symfony\Component\HttpFoundation\Response;
use Modules\Seo\Tests\TestCase;
use Webmozart\Assert\Assert;

uses(TestCase::class);

/**
 * @param  array<mixed>  $rows
 */
function seoAliasesOf(array $rows): SeoConfigData
{
    return SeoConfigData::from(['path_aliases' => $rows]);
}

test('the seo settings live in the seo tenant file', function (): void {
    expect(SeoConfigData::tenantConfigName())->toBe('seo')
        ->and(SettingPage::getConfigName())->toBe('seo');
});

test('without a saved value the page aliases are the ones the module declared before', function (): void {
    $data = SeoConfigData::from([]);

    expect($data->pathAliases())->toBe([
        'about' => 'chi-siamo',
        'contatti' => 'contacts',
        'cookie' => 'cookies',
        'faqs' => 'faq',
        'home' => '',
    ])->and($data->hasRejectedAliases())->toBeFalse();
});

test('values from the tenant file override the defaults', function (): void {
    FakeTenantSeoConfig::bind([
        'path_aliases' => [
            [
                'alias' => 'old',
                'target' => 'new',
            ],
        ],
    ]);

    expect(SeoConfigData::make()->pathAliases())->toBe(['old' => 'new']);
});

test('the canonical redirect reads the aliases saved in the tenant file', function (): void {
    FakeTenantSeoConfig::bind([
        'path_aliases' => [
            [
                'alias' => 'old',
                'target' => 'new',
            ],
        ],
    ]);
    $pass = static fn (): Response => response('pagina');

    $saved = (new RedirectToCanonicalPath)->handle(Request::create('/it/old?a=1', 'GET'), $pass);
    $default = (new RedirectToCanonicalPath)->handle(Request::create('/it/faqs', 'GET'), $pass);

    expect($saved->getStatusCode())->toBe(301)
        ->and((string) $saved->headers->get('Location'))->toEndWith('/it/new?a=1')
        ->and($default->getContent())->toBe('pagina');
});

test('an empty list switches every alias off', function (): void {
    FakeTenantSeoConfig::bind(['path_aliases' => []]);

    $response = (new RedirectToCanonicalPath)->handle(Request::create('/it/faqs', 'GET'), static fn (): Response => response('pagina'));

    expect($response->getContent())->toBe('pagina');
});

test('an alias that could make a redirect loop is ignored and flagged', function (array $rows, array $kept): void {
    $data = seoAliasesOf($rows);

    expect($data->pathAliases())->toBe($kept)
        ->and($data->hasRejectedAliases())->toBeTrue();
})->with([
    'alias of itself' => [
        [
            [
                'alias' => 'a',
                'target' => 'a',
            ],
        ],
        [],
    ],
    'two aliases pointing at each other' => [
        [
            [
                'alias' => 'a',
                'target' => 'b',
            ],
            [
                'alias' => 'b',
                'target' => 'a',
            ],
        ],
        [],
    ],
    'a chain keeps only the last hop' => [
        [
            [
                'alias' => 'a',
                'target' => 'b',
            ],
            [
                'alias' => 'b',
                'target' => 'c',
            ],
        ],
        ['b' => 'c'],
    ],
    'the same alias twice' => [
        [
            [
                'alias' => 'a',
                'target' => 'b',
            ],
            [
                'alias' => 'a',
                'target' => 'c',
            ],
        ],
        ['a' => 'c'],
    ],
    'an alias with no path' => [
        [
            [
                'alias' => '/',
                'target' => 'b',
            ],
        ],
        [],
    ],
]);

test('slashes around a path are not part of the alias', function (): void {
    $data = seoAliasesOf([
        [
            'alias' => '/chi/',
            'target' => '/about/',
        ],
    ]);

    expect($data->pathAliases())->toBe(['chi' => 'about'])
        ->and($data->hasRejectedAliases())->toBeFalse();
});

test('a malformed file never breaks the request: it falls back to the declared aliases', function (mixed $value): void {
    $data = SeoConfigData::from(['path_aliases' => $value]);

    expect($data->pathAliases())->toHaveKey('faqs');
})->with([
    'a string' => ['faqs=faq'],
    'null' => [null],
]);

test('rows without text are dropped and the form row keys are not kept', function (): void {
    $data = SeoConfigData::from([
        'path_aliases' => [
            'f3a1' => [
                'alias' => 'a',
                'target' => 'b',
            ],
            'f3a2' => [
                'alias' => 7,
                'target' => 'b',
            ],
            'f3a3' => 'oops',
        ],
    ]);

    expect(array_keys($data->path_aliases))->toBe([0])
        ->and($data->pathAliases())->toBe(['a' => 'b']);
});

test('an empty target saved by the form means the home page', function (): void {
    $data = SeoConfigData::from([
        'path_aliases' => [
            'f3a1' => [
                'alias' => 'home',
                'target' => null,
            ],
        ],
    ]);

    expect($data->pathAliases())->toBe(['home' => '']);
});

test('the setting page exposes exactly the properties of the config data', function (): void {
    $properties = array_map(
        static fn (ReflectionProperty $property): string => $property->getName(),
        (new ReflectionClass(SeoConfigData::class))->getProperties(ReflectionProperty::IS_PUBLIC),
    );

    $schema = (new ReflectionMethod(SettingPage::class, 'getFormSchema'))
        ->invoke(app(SettingPage::class));
    Assert::isArray($schema);

    expect(array_keys($schema))->toEqualCanonicalizing($properties);
});

test('the form refuses rows the site would ignore and accepts the others', function (): void {
    $rule = new ReflectionMethod(SettingPage::class, 'pathAliasesRule');
    $page = app(SettingPage::class);
    $failures = [];
    $fail = static function (string $message) use (&$failures): void {
        $failures[] = $message;
    };

    $rule->invoke($page, 'path_aliases', [
        'f3a1' => [
            'alias' => 'a',
            'target' => 'b',
        ],
        'f3a2' => [
            'alias' => 'b',
            'target' => 'a',
        ],
    ], $fail);
    expect($failures)->toHaveCount(1);

    $failures = [];
    $rule->invoke($page, 'path_aliases', [
        'f3a1' => [
            'alias' => 'a',
            'target' => 'b',
        ],
    ], $fail);
    expect($failures)->toBe([]);
});

test('every field of the page has a label in italian and english', function (string $locale): void {
    $lang = require dirname(__DIR__, 3).'/lang/'.$locale.'/setting.php';
    Assert::isArray($lang);
    $fields = $lang['fields'];
    Assert::isArray($fields);

    foreach (['path_aliases', 'alias', 'target'] as $field) {
        expect($fields)->toHaveKey($field);
        $entry = $fields[$field];
        Assert::isArray($entry);
        expect($entry['label'])->toBeString()->not->toBeEmpty();
    }
    expect($lang)->toHaveKey('errors');
})->with(['it', 'en']);

test('the aliases are no longer declared in the module config', function (): void {
    $config = require dirname(__DIR__, 3).'/config/config.php';
    Assert::isArray($config);

    expect($config)->not->toHaveKey('path_aliases');
});
