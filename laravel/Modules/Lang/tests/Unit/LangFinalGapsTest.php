<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\HtmlString;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator as LaravelTranslator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mockery;
use Mockery\MockInterface;
use Modules\Lang\Actions\SaveTransAction;
use Modules\Lang\Actions\SyncTranslationsAction;
use Modules\Lang\Actions\Translation\RecordMissingTranslationAction;
use Modules\Lang\Actions\WriteTranslationFileAction;
use Modules\Lang\Adapters\TranslatorAdapter;
use Modules\Lang\Filament\Actions\LocaleSwitcherRefresh;
use Modules\Lang\Filament\Forms\Components\NationalFlagSelect;
use Modules\Lang\Filament\Forms\Components\TranslationEditor;
use Modules\Lang\Filament\Resources\TranslationFileResource\Pages\EditTranslationFile;
use Modules\Lang\Filament\Widgets\LanguageSwitcherWidget;
use Modules\Lang\Models\Post;
use Modules\Lang\Models\TranslationFile;
use Modules\Lang\Providers\RouteServiceProvider;
use Modules\Lang\Tests\Fixtures\AutoLabelExecuteNestedCaller;
use Modules\Lang\Tests\Fixtures\AutoLabelForcedKeyStub;
use Modules\Lang\Tests\Fixtures\AutoLabelNullCallerStub;
use Modules\Lang\Tests\Fixtures\AutoLabelStaticCaller;
use Modules\Lang\Tests\Fixtures\NationalFlagSelectFinalStub;
use Modules\Lang\Tests\Fixtures\PostNullTitleForGuidStub;
use Modules\Lang\Tests\Fixtures\ThemeComposerNonStringFieldStub;
use Modules\Lang\Tests\Fixtures\WriteTranslationFileActionFailStub;
use Modules\Lang\Tests\Fixtures\WriteTranslationFileActionWriteFailStub;
use Modules\Lang\Tests\TestCase;
use Modules\Lang\View\Composers\ThemeComposer;
use Modules\Xot\Actions\File\AssetAction;
use Modules\Xot\Actions\File\SvgExistsAction;
use Modules\Xot\Actions\GetTransKeyAction;
use PHPUnit\Framework\Assert;
use ReflectionMethod;
use ReflectionProperty;

use function Safe\file_put_contents;
use function Safe\mkdir;
use function Safe\rename;
use function Safe\rmdir;
use function Safe\unlink;

uses(TestCase::class);

/**
 * Locale dell'app dopo normalizeLocale()+applyLocale(), partendo ogni volta da 'it':
 * un 'en' letto dopo la chiamata prova il fallback, non un locale rimasto da prima.
 *
 * @param  array<string, mixed>  $data
 */
function langLocaleAfterApplying(LocaleSwitcherRefresh $action, array $data): string
{
    app()->setLocale('it');
    $action->applyLocale(LocaleSwitcherRefresh::normalizeLocale($data['locale'] ?? null));

    return app()->getLocale();
}

afterEach(function (): void {
    Mockery::close();
});

test('EditTranslationFile schemaFromRecord covers both branches', function (): void {
    $edit = new EditTranslationFile;
    Assert::assertNotEmpty($edit->schemaFromRecord((object) ['content' => ['hello' => 'world']]));
    Assert::assertSame([], $edit->schemaFromRecord(null));
    Assert::assertSame([], $edit->schemaFromRecord((object) ['content' => 'scalar']));
    Assert::assertSame([], $edit->schemaFromRecord((object) []));
});

test('LocaleSwitcherRefresh applyLocale covers string and non-string locale', function (): void {
    app()->instance('request', Request::create('http://localhost/it', 'GET', [], [], [], [
        'HTTP_REFERER' => 'http://localhost/it',
    ]));
    $action = LocaleSwitcherRefresh::make('x');

    Assert::assertSame('de', langLocaleAfterApplying($action, ['locale' => 'de']));
    Assert::assertSame('en', langLocaleAfterApplying($action, ['locale' => 123]));
    Assert::assertSame('en', langLocaleAfterApplying($action, []));
});

test('TranslatorAdapter coerces non-string loaded values', function (): void {
    // Qui c'era `TestCase::forceSqliteTranslations()`, un helper invocato e mai
    // scritto. Non e' stato scritto ma rimosso: il test non tocca il database.
    // Carica le traduzioni da un `ArrayLoader`, scrive la property `loaded` per
    // reflection e mocka `RecordMissingTranslationAction`, che e' l'unico punto
    // che avrebbe interrogato una connessione. Un helper che forzasse la
    // connessione a SQLite avrebbe dato l'impressione di proteggere qualcosa
    // che non e' in pericolo, e avrebbe contraddetto la regola per cui i test
    // girano sulle repliche MySQL. Story LANG-17.4.
    $loader = new ArrayLoader;
    $adapter = new TranslatorAdapter($loader, 'it');
    $loaded = new ReflectionProperty(LaravelTranslator::class, 'loaded');
    $loaded->setAccessible(true);
    // JSON translation path returns non-string/non-array values without notifyMissingKey/DB
    $loaded->setValue($adapter, ['*' => ['*' => ['it' => ['json.int.key' => 99]]]]);
    $this->mockService(RecordMissingTranslationAction::class, static function (MockInterface $mock): void {
        $mock->allows('execute');
    });
    Assert::assertSame('99', $adapter->get('json.int.key', [], 'it', false));
});

test('ThemeComposer fallback locales and buildAdminLanguageUrl', function (): void {
    Config::set('laravellocalization', []);
    $composer = new ThemeComposer;
    Assert::assertGreaterThan(0, $composer->languages()->count());

    Assert::assertSame('#', $composer->buildAdminLanguageUrl('it'));

    config([
        'laravellocalization.supportedLocales' => [
            'it' => ['name' => 'Italiano', 'regional' => 'it_IT'],
            'en' => ['name' => 'English', 'regional' => 'en_US'],
        ],
    ]);
    Route::shouldReceive('currentRouteName')->andReturn('home');
    Route::shouldReceive('current')->andReturn(null);
    Route::shouldReceive('has')->andReturn(true);
    $url = $composer->buildAdminLanguageUrl('en');
    Assert::assertNotSame('', $url);
});

test('RouteServiceProvider covers fallback locales and admin segment index', function (): void {
    config(['laravellocalization.supportedLocales' => null]);
    app()->instance('request', Request::create('http://localhost/it/admin/dashboard', 'GET'));
    session(['in_admin' => true]);
    $provider = new RouteServiceProvider(app());
    $provider->registerLang();
    Assert::assertContains(app()->getLocale(), ['it', 'en']);
});

test('TranslationFile respects configured PHPStan runtime boundary', function (): void {
    config(['app.phpstan_running' => true]);
    Assert::assertSame([], (new TranslationFile)->getRows());
    config(['app.phpstan_running' => false]);
});

test('SyncTranslationsAction skips empty casted glob entries', function (): void {
    $action = app(SyncTranslationsAction::class);
    $tmpModule = 'LangFinal'.uniqid();
    $base = base_path('Modules/'.$tmpModule);
    mkdir($base.'/lang/it', 0o755, true);
    file_put_contents($base.'/lang/it/ok.php', "<?php\nreturn ['a' => 'b'];\n");

    File::partialMock()
        ->shouldReceive('glob')
        ->andReturn([null, '', $base.'/lang/it/ok.php']);
    File::shouldReceive('exists')->andReturnUsing(static fn (string $p): bool => file_exists($p) || is_dir($p));
    File::shouldReceive('makeDirectory')->andReturn(true);
    File::shouldReceive('put')->andReturn(10);

    try {
        $result = $action->execute('it', ['en'], $tmpModule);
        Assert::assertIsArray($result);
        Assert::assertIsArray($result['modules']);
        Assert::assertIsArray($result['modules'][$tmpModule]);
        Assert::assertSame('completed', $result['modules'][$tmpModule]['status']);
    } finally {
        Mockery::close();
        if (is_dir($base)) {
            File::deleteDirectory($base);
        }
    }
});

test('WriteTranslationFileAction createBackup makes directory', function (): void {
    $backupDir = storage_path('app/backups/translations');
    if (is_dir($backupDir)) {
        // rename temporarily
        $moved = $backupDir.'_bak_'.uniqid();
        rename($backupDir, $moved);
    } else {
        $moved = null;
    }

    $path = sys_get_temp_dir().'/wfa_'.uniqid().'.php';
    TestCase::createTranslationFile($path, ['x' => '1']);
    app()->instance('cache', new class
    {
        public function flush(): void {}
    });

    try {
        Assert::assertTrue(app(WriteTranslationFileAction::class)->execute($path, ['x' => '2']));
        Assert::assertDirectoryExists(storage_path('app/backups/translations'));
    } finally {
        if (file_exists($path)) {
            unlink($path);
        }
        if (isset($moved) && is_dir($moved)) {
            if (is_dir($backupDir)) {
                File::deleteDirectory($backupDir);
            }
            rename($moved, $backupDir);
        }
    }
});

test('LanguageSwitcherWidget falls back when getLocalizedURL returns non-string true', function (): void {
    LaravelLocalization::shouldReceive('getLocalizedURL')
        ->andReturn(true);

    $widget = new LanguageSwitcherWidget;
    Assert::assertSame('/en', $widget->getLanguageUrl('en'));
});

test('Post linkable and accessor edge branches', function (): void {
    $post = new Post;

    $post->setRawAttributes(['post_type' => 123, 'post_id' => ['x']], true);
    Assert::assertIsString($post->getTitleAttribute(null));

    $post2 = new Post;
    $post2->setRawAttributes(['title' => null], true);
    // guid with null title falls through
    Assert::assertIsString($post2->getGuidAttribute(' '));
});

test('NationalFlagSelect array localized name and bad code in filter', function (): void {
    $this->mockService(AssetAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => '/f.svg']);
    });
    app('translator')->addLines(['countries.it' => ['label' => 'Italia']], 'it');
    app()->setLocale('it');

    $select = NationalFlagSelectFinalStub::make('c');
    $select->forcedCountries = [
        ['iso_3166_1_alpha2' => 'IT', 'name' => 'Italy'],
        ['iso_3166_1_alpha2' => 9, 'name' => 'Bad'],
        'nope',
    ];
    $f = new ReflectionMethod(NationalFlagSelect::class, 'getFilteredCountryOptions');
    $f->setAccessible(true);
    Assert::assertIsArray($f->invoke($select, 'ital'));
    Assert::assertIsArray($f->invoke($select, 'IT'));
});

test('TranslationEditor make preserves the field name', function (): void {
    $editor = TranslationEditor::make('c');
    Assert::assertSame('c', $editor->getName());
});

test('WriteTranslationFileAction throws when put fails', function (): void {
    $path = sys_get_temp_dir().'/wfail_'.uniqid().'.php';
    TestCase::createTranslationFile($path, ['a' => '1']);
    app()->instance('cache', new class
    {
        public function flush(): void {}
    });
    $action = new WriteTranslationFileActionFailStub;
    expect(fn () => $action->execute($path, ['a' => '2']))->toThrow(\Exception::class);
    unlink($path);
});

test('Post guid null title uses random fallback', function (): void {
    $post = new Post;
    $post->setRawAttributes([], true);
    // force title accessor path to null then guid
    $guid = $post->getGuidAttribute(null);
    Assert::assertIsString($guid);
});

test('RouteServiceProvider non-array locales and admin n=3', function (): void {
    config(['laravellocalization.supportedLocales' => new \stdClass]);
    $request = Request::create('http://localhost/it/admin/pages', 'GET');
    app()->instance('request', $request);
    \Illuminate\Support\Facades\Request::swap($request);
    session(['in_admin' => true]);
    (new RouteServiceProvider(app()))->registerLang();
    Assert::assertContains(app()->getLocale(), ['it', 'en']);
});

test('ThemeComposer inAdmin language urls and non-string currentLang field', function (): void {
    config([
        'laravellocalization.supportedLocales' => [
            'it' => ['name' => 'Italiano', 'regional' => 'it_IT'],
            'en' => ['name' => 'English', 'regional' => 'en_US'],
        ],
    ]);
    $request = Request::create('http://localhost/it/admin/dashboard', 'GET');
    app()->instance('request', $request);
    \Illuminate\Support\Facades\Request::swap($request);
    app()->setLocale('it');
    $composer = new ThemeComposer;
    Assert::assertGreaterThan(0, $composer->languages()->count());
    // flag field is HTML string; asking a missing dynamic property via currentLang on 'flag' works as string
    Assert::assertStringContainsString('<', $composer->currentLang('flag'));
});

test('NationalFlagSelect hits array localized translation branch', function (): void {
    $this->mockService(AssetAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => '/f.svg']);
    });
    app('translator')->addLines(['countries.it' => ['x' => 'y']], 'it', 'lang');
    app()->setLocale('it');
    $select = NationalFlagSelectFinalStub::make('c');
    $select->forcedCountries = [
        ['iso_3166_1_alpha2' => 'IT', 'name' => 'Italy'],
    ];
    $f = new ReflectionMethod(NationalFlagSelect::class, 'getFilteredCountryOptions');
    $f->setAccessible(true);
    $options = $f->invoke($select, 'ital');
    Assert::assertIsArray($options);
    Assert::assertArrayHasKey('IT', $options);
});

test('AutoLabelAction covers FIX label for array translation', function (): void {
    $this->mockService(GetTransKeyAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => 'lang::form']);
    });
    $this->mockService(SaveTransAction::class, static function (MockInterface $mock): void {
        $mock->allows('execute');
    });
    $this->mockService(SvgExistsAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => true]);
    });
    app('translator')->addLines([
        'form.sections.empty.heading' => ['a' => 'b'],
        'form.fields.help.helper_text' => '<b>h</b>',
        'form.actions.z.icon' => 'heroicon-o-check',
        'form.fields.title.label' => 'Titolo',
        'form.sections.htmlcast.heading' => 'Casted',
    ], 'it', 'lang');
    app()->setLocale('it');

    $action = new AutoLabelForcedKeyStub;
    $section = Section::make()->heading(null);
    Assert::assertSame($section, $action->execute($section, 'heading'));

    $help = TextInput::make('help');
    Assert::assertSame($help, $action->execute($help, 'helperText'));

    $act = Action::make('z');
    Assert::assertSame($act, $action->execute($act, 'icon'));

    $field = TextInput::make('title');
    Assert::assertSame($field, $action->execute($field, 'label'));

    $htmlHeading = Section::make()->heading(new HtmlString('<i>htmlcast</i>'));
    Assert::assertSame($htmlHeading, $action->execute($htmlHeading, 'heading'));
});

test('AutoLabelAction null caller frame returns component early', function (): void {
    $field = TextInput::make('x');
    Assert::assertSame($field, (new AutoLabelNullCallerStub)->execute($field, 'label'));
});

test('AutoLabelAction nested execute caller covers execute skip frame', function (): void {
    $this->mockService(GetTransKeyAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => 'lang::form']);
    });
    $this->mockService(SaveTransAction::class, static function (MockInterface $mock): void {
        $mock->allows('execute');
    });
    app('translator')->addLines(['form.fields.nested.label' => 'N'], 'it', 'lang');
    app()->setLocale('it');
    $field = TextInput::make('nested');
    Assert::assertSame($field, (new AutoLabelExecuteNestedCaller)->execute($field, 'label'));
});

test('Post guid null titleForGuid uses random fallback', function (): void {
    $post = new PostNullTitleForGuidStub;
    $guid = $post->getGuidAttribute(null);
    Assert::assertIsString($guid);
    Assert::assertNotSame('', $guid);
});

test('RouteServiceProvider covers missing supportedLocales key', function (): void {
    Config::set('laravellocalization', []);
    Assert::assertFalse(config()->has('laravellocalization.supportedLocales'));
    app()->instance('request', Request::create('http://localhost/it/page', 'GET'));
    (new RouteServiceProvider(app()))->registerLang();
    Assert::assertContains(app()->getLocale(), ['it', 'en']);
});

test('ThemeComposer non-string lang field returns empty string', function (): void {
    config([
        'laravellocalization.supportedLocales' => [
            'it' => ['name' => 'Italiano', 'regional' => 'it_IT'],
        ],
    ]);
    app()->setLocale('it');
    $composer = new ThemeComposerNonStringFieldStub;
    Assert::assertSame('', $composer->currentLang('name'));
    Assert::assertSame('it', $composer->currentLang('id'));
});

test('NationalFlagSelect casts non-array non-string localized label', function (): void {
    $this->mockService(AssetAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => '/f.svg']);
    });
    $translator = app('translator');
    $mock = Mockery::mock($translator)->makePartial();
    $mock->shouldReceive('get')
        ->andReturnUsing(static function (string $key, array $replace = [], ?string $locale = null) use ($translator): string|int|array {
            if (str_contains($key, 'countries.it')) {
                return 99;
            }

            return $translator->get($key, $replace, $locale);
        });
    app()->instance('translator', $mock);
    app()->setLocale('it');

    $select = NationalFlagSelectFinalStub::make('c');
    $select->forcedCountries = [
        ['iso_3166_1_alpha2' => 'IT', 'name' => 'Italy'],
    ];
    $m = new ReflectionMethod(NationalFlagSelect::class, 'getCountryOptions');
    $m->setAccessible(true);
    $options = $m->invoke($select);
    Assert::assertIsArray($options);
    Assert::assertArrayHasKey('IT', $options);
});

test('NationalFlagSelect finalizeFilteredCountries defensive continue', function (): void {
    $this->mockService(AssetAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => '/f.svg']);
    });
    $select = NationalFlagSelectFinalStub::make('c');
    $select->forcedCountries = [
        ['iso_3166_1_alpha2' => 'IT', 'name' => 'Italy'],
    ];
    $select->extraFilteredRows = [
        'not-an-array',
        ['iso_3166_1_alpha2' => null],
        ['name' => 'NoCode'],
    ];
    $f = new ReflectionMethod(NationalFlagSelect::class, 'getFilteredCountryOptions');
    $f->setAccessible(true);
    $options = $f->invoke($select, 'ital');
    Assert::assertIsArray($options);
    Assert::assertArrayHasKey('IT', $options);
});

test('SaveTransAction early return when persist disabled in unit tests', function (): void {
    config(['lang.persist_trans_in_tests' => false]);
    app()->instance(SaveTransAction::class, new SaveTransAction);
    app(SaveTransAction::class)->execute('lang::should_not_write.nested', 'x');
    Assert::assertFileDoesNotExist(base_path('Modules/Lang/lang/'.app()->getLocale().'/should_not_write.php'));
    TestCase::forgetSaveTransActionOverride();
});

test('AutoLabelAction static caller covers class-only frame', function (): void {
    $this->mockService(GetTransKeyAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => 'lang::form']);
    });
    app('translator')->addLines(['form.fields.staticf.label' => 'S'], 'it', 'lang');
    app()->setLocale('it');
    $field = TextInput::make('staticf');
    Assert::assertSame($field, AutoLabelStaticCaller::run($field, 'label'));
});

test('NationalFlagSelect getCountryOptions casts int localized label', function (): void {
    $this->mockService(AssetAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => '/f.svg']);
    });
    app()->setLocale('it');
    $real = app('translator');
    Assert::assertInstanceOf(LaravelTranslator::class, $real);
    app()->instance('translator', new class($real)
    {
        public function __construct(private readonly LaravelTranslator $inner) {}

        /**
         * @param  array<string, mixed>  $replace
         * @return string|int|array<array-key, mixed>
         */
        public function get(string $key, array $replace = [], ?string $locale = null, bool $fallback = true): string|int|array
        {
            if (str_contains($key, 'countries.it')) {
                return 77;
            }

            return $this->inner->get($key, $replace, $locale, $fallback);
        }

        /** @param list<mixed> $arguments */
        public function __call(string $name, array $arguments): mixed
        {
            return $this->inner->{$name}(...$arguments);
        }
    });

    $select = NationalFlagSelectFinalStub::make('c');
    $select->forcedCountries = [
        ['iso_3166_1_alpha2' => 'IT', 'name' => 'Italy'],
    ];
    $m = new ReflectionMethod(NationalFlagSelect::class, 'getCountryOptions');
    $m->setAccessible(true);
    $options = $m->invoke($select);
    Assert::assertIsArray($options);
    Assert::assertArrayHasKey('IT', $options);
});

test('NationalFlagSelect getCountryOptions array localized label branch', function (): void {
    $this->mockService(AssetAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => '/f.svg']);
    });
    app()->setLocale('it');
    $real = app('translator');
    Assert::assertInstanceOf(LaravelTranslator::class, $real);
    app()->instance('translator', new class($real)
    {
        public function __construct(private readonly LaravelTranslator $inner) {}

        /**
         * @param  array<string, mixed>  $replace
         * @return string|array<array-key, mixed>
         */
        public function get(string $key, array $replace = [], ?string $locale = null, bool $fallback = true): string|array
        {
            if (str_contains($key, 'countries.it')) {
                return ['n' => 'Italia'];
            }

            return $this->inner->get($key, $replace, $locale, $fallback);
        }

        /** @param list<mixed> $arguments */
        public function __call(string $name, array $arguments): mixed
        {
            return $this->inner->{$name}(...$arguments);
        }
    });

    $select = NationalFlagSelectFinalStub::make('c');
    $select->forcedCountries = [
        ['iso_3166_1_alpha2' => 'IT', 'name' => 'Italy'],
    ];
    $m = new ReflectionMethod(NationalFlagSelect::class, 'getCountryOptions');
    $m->setAccessible(true);
    $options = $m->invoke($select);
    Assert::assertIsArray($options);
    Assert::assertArrayHasKey('IT', $options);
});

test('WriteTranslationFileAction putTranslationFile returns false when write fails', function (): void {
    $action = new WriteTranslationFileActionWriteFailStub;
    $m = new ReflectionMethod(WriteTranslationFileAction::class, 'putTranslationFile');
    $m->setAccessible(true);
    $dir = sys_get_temp_dir().'/lang_put_false_'.uniqid();
    $path = $dir.'/x.php';
    Assert::assertFalse($m->invoke($action, $path, '<?php return [];'));
});

test('WriteTranslationFileAction putTranslationFile edge paths', function (): void {
    app()->instance('cache', new class
    {
        public function flush(): void {}
    });

    $missingDir = sys_get_temp_dir().'/lang_wfa_dir_'.uniqid();
    $path = $missingDir.'/out.php';
    Assert::assertTrue((new WriteTranslationFileAction)->execute($path, ['a' => '1']));
    Assert::assertFileExists($path);

    $path3 = sys_get_temp_dir().'/lang_wfa_wf_'.uniqid().'.php';
    TestCase::createTranslationFile($path3, ['c' => '1']);
    expect(fn () => (new WriteTranslationFileActionWriteFailStub)->execute($path3, ['c' => '2']))
        ->toThrow(\Exception::class);

    foreach ([$path, $path3] as $f) {
        if (is_file($f)) {
            unlink($f);
        }
    }
    if (is_dir($missingDir)) {
        rmdir($missingDir);
    }
});
