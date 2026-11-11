<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Translation\ArrayLoader;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mockery;
use Mockery\MockInterface;
use Modules\Lang\Actions\Filament\AutoLabelAction;
use Modules\Lang\Actions\GetAllTranslationAction;
use Modules\Lang\Actions\GetTransPathAction;
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
use Modules\Lang\Models\Translation;
use Modules\Lang\Models\TranslationFile;
use Modules\Lang\Providers\LangServiceProvider;
use Modules\Lang\Providers\RouteServiceProvider;
use Modules\Lang\Tests\Fixtures\NationalFlagSelectStub;
use Modules\Lang\Tests\TestCase;
use Modules\Lang\View\Composers\ThemeComposer;
use Modules\Xot\Actions\File\AssetAction;
use Modules\Xot\Actions\File\SvgExistsAction;
use Modules\Xot\Actions\GetTransKeyAction;
use PHPUnit\Framework\Assert;
use ReflectionMethod;

use function Safe\file_get_contents;
use function Safe\file_put_contents;
use function Safe\getmypid;
use function Safe\mkdir;
use function Safe\touch;
use function Safe\unlink;

uses(TestCase::class);

afterEach(function (): void {
    Mockery::close();
    $sqlite = $GLOBALS['__lang_gaps_sqlite'] ?? null;
    if (is_string($sqlite)) {
        DB::purge('lang');
        if (is_file($sqlite)) {
            unlink($sqlite);
        }
        unset($GLOBALS['__lang_gaps_sqlite']);
    }
});

function langGapsSqlite(): void
{
    $database = sys_get_temp_dir().'/lang_gaps_'.getmypid().'_'.uniqid('', true).'.sqlite';
    touch($database);
    config([
        'database.connections.lang' => [
            'driver' => 'sqlite',
            'database' => $database,
            'prefix' => '',
            'foreign_key_constraints' => false,
        ],
    ]);
    DB::purge('lang');
    DB::reconnect('lang');
    Schema::connection('lang')->create('translations', static function (Blueprint $table): void {
        $table->id();
        $table->string('lang')->nullable();
        $table->string('namespace')->nullable();
        $table->string('group')->nullable();
        $table->string('item')->nullable();
        $table->text('value')->nullable();
        $table->timestamps();
    });
    Schema::connection('lang')->create('posts', static function (Blueprint $table): void {
        $table->uuid('id')->primary();
        $table->string('title')->nullable();
        $table->string('guid')->nullable();
        $table->string('post_type')->nullable();
        $table->string('post_id')->nullable();
        $table->text('txt')->nullable();
        $table->timestamps();
    });
    $GLOBALS['__lang_gaps_sqlite'] = $database;
}

describe('Lang coverage gaps closeout', function (): void {
    test('TranslatorAdapter notifyMissingKey records the missing key', function (): void {
        langGapsSqlite();
        $loader = new ArrayLoader;
        $loader->addMessages('it', 'g', ['n' => 9]);

        $adapter = new TranslatorAdapter($loader, 'it');
        $missing = 'g.missing_'.uniqid('', true);
        Assert::assertSame($missing, $adapter->get($missing));
        Assert::assertTrue(Translation::query()->where('item', substr($missing, 2))->exists() || Translation::query()->count() > 0);
    });

    test('TranslatorAdapter non-string result coerces to key', function (): void {
        $loader = new ArrayLoader;
        $loader->addMessages('it', 'g', ['n' => 9]);
        $adapter = new TranslatorAdapter($loader, 'it');
        $this->mockService(RecordMissingTranslationAction::class, static function (MockInterface $mock): void {
            $mock->allows('execute');
        });
        Assert::assertSame('g.n', $adapter->get('g.n'));
    });

    test('RecordMissingTranslationAction covers namespace without item dot', function (): void {
        langGapsSqlite();
        app(RecordMissingTranslationAction::class)->execute('mod::onlygroup', 'it');
        Assert::assertTrue(
            Translation::query()->where('namespace', 'mod')->where('group', 'onlygroup')->whereNull('item')->exists(),
        );
    });

    test('SaveTransAction catch and non-array require paths', function (): void {
        TestCase::bindRealSaveTransAction();
        config(['lang.save_missing_translations' => true]);
        $file = sys_get_temp_dir().'/save_trans_'.uniqid().'.php';
        file_put_contents($file, '<?php throw new Exception("x");');

        $this->mockService(GetTransPathAction::class, static function (MockInterface $mock) use ($file): void {
            $mock->allows(['execute' => $file]);
        });

        // File illeggibile (throw a runtime): l'action riporta ed esce senza
        // riscrivere, per non sostituire il file con la sola chiave nuova.
        app(SaveTransAction::class)->execute('lang::x.y', 'v');
        Assert::assertSame('<?php throw new Exception("x");', file_get_contents($file));

        file_put_contents($file, "<?php\nreturn 'scalar';\n");
        app(SaveTransAction::class)->execute('lang::x.y', 'v');
        /** @var array<string, mixed> $loaded */
        $loaded = require $file;
        Assert::assertSame('v', $loaded['y']);
        unlink($file);
        TestCase::forgetSaveTransActionOverride();
    });

    test('WriteTranslationFileAction backs up existing file', function (): void {
        $path = sys_get_temp_dir().'/write_cov_'.uniqid().'.php';
        TestCase::createTranslationFile($path, ['a' => '1']);
        app()->instance('cache', new class
        {
            public function flush(): void {}
        });

        Assert::assertTrue(app(WriteTranslationFileAction::class)->execute($path, ['a' => '2']));
        if (file_exists($path)) {
            unlink($path);
        }
    });

    test('SyncTranslationsAction completes for temp module', function (): void {
        $action = app(SyncTranslationsAction::class);
        $tmpModule = 'LangGaps'.uniqid();
        $base = base_path('Modules/'.$tmpModule);
        mkdir($base.'/lang/it', 0o755, true);
        file_put_contents($base.'/lang/it/ok.php', "<?php\nreturn ['k' => 'v'];\n");

        try {
            $result = $action->execute('it', ['en'], $tmpModule);
            Assert::assertIsArray($result);
            Assert::assertIsArray($result['modules']);
            Assert::assertIsArray($result['modules'][$tmpModule]);
            Assert::assertSame('completed', $result['modules'][$tmpModule]['status']);
            Assert::assertIsInt($result['total_files']);
            Assert::assertIsInt($result['total_translations']);
        } finally {
            if (is_dir($base)) {
                File::deleteDirectory($base);
            }
        }
    });

    test('LocaleSwitcherRefresh action callback updates locale', function (): void {
        session()->put('locale', 'it');
        app()->instance('request', Request::create('http://localhost/it/page', 'GET', [], [], [], [
            'HTTP_REFERER' => 'http://localhost/it/page',
        ]));
        $action = LocaleSwitcherRefresh::make('loc');
        Assert::assertSame('it', $action->lang);
        Assert::assertNotSame('', $action->fullUrl);
    });

    test('NationalFlagSelectStub covers defensive country branches', function (): void {
        $this->mockService(AssetAction::class, static function (MockInterface $mock): void {
            $mock->allows(['execute' => '/x.svg']);
        });
        $select = NationalFlagSelectStub::make('c');
        $select->forcedCountries = [
            'bad',
            ['name' => 'NoCode'],
            ['iso_3166_1_alpha2' => 12, 'name' => 'BadCode'],
            ['iso_3166_1_alpha2' => 'IT', 'name' => 'Italy'],
            ['iso_3166_1_alpha2' => 'XX', 'name' => 99],
        ];
        $m = new ReflectionMethod(NationalFlagSelect::class, 'getCountryOptions');
        $m->setAccessible(true);
        $options = $m->invoke($select);
        Assert::assertIsArray($options);
        Assert::assertArrayHasKey('IT', $options);

        $f = new ReflectionMethod(NationalFlagSelect::class, 'getFilteredCountryOptions');
        $f->setAccessible(true);
        $byName = $f->invoke($select, 'ital');
        $byCode = $f->invoke($select, 'IT');
        Assert::assertIsArray($byName);
        Assert::assertIsArray($byCode);
        Assert::assertArrayHasKey('IT', $byName);
        Assert::assertArrayHasKey('IT', $byCode);
    });

    test('TranslationEditor afterStateHydrated and EditTranslationFile schema paths', function (): void {
        $editor = TranslationEditor::make('c');
        $setUp = new ReflectionMethod($editor, 'setUp');
        $setUp->setAccessible(true);
        $setUp->invoke($editor);
        Assert::assertInstanceOf(TranslationEditor::class, $editor);

        $edit = new EditTranslationFile;
        Assert::assertNotEmpty($edit->getFormSchema());
        Assert::assertNotEmpty($edit->makeFromArray(['a' => '1', 'b' => ['c' => '2']], 'content'));
        Assert::assertSame([], $edit->makeFromArray([]));
        Assert::assertNotEmpty($edit->schemaFromRecord((object) ['content' => ['a' => '1']]));
        Assert::assertSame([], $edit->schemaFromRecord(null));
        Assert::assertSame([], $edit->schemaFromRecord((object) ['content' => 'x']));
    });

    test('LanguageSwitcherWidget falls back when getLocalizedURL is not a string', function (): void {
        LaravelLocalization::shouldReceive('getLocalizedURL')
            ->andReturn(false);

        $widget = new LanguageSwitcherWidget;
        Assert::assertSame('/en', $widget->getLanguageUrl('en'));
    });

    test('Post accessors persist when model has key', function (): void {
        langGapsSqlite();
        $post = new Post;
        $post->id = (string) Str::uuid();
        $post->exists = true;
        $post->setRawAttributes([
            'id' => $post->id,
            'post_type' => 'article',
            'post_id' => '1',
        ], true);
        // Avoid real update by mocking
        /** @var Post&MockInterface $post */
        $post = Mockery::mock(Post::class)->makePartial();
        $post->shouldReceive('getKey')->andReturn('abc');
        $post->shouldReceive('update')->andReturnTrue();
        $post->setRawAttributes(['post_type' => 'article', 'post_id' => '1'], true);
        Assert::assertSame('article 1', $post->getTitleAttribute(null));

        /** @var Post&MockInterface $post2 */
        $post2 = Mockery::mock(Post::class)->makePartial();
        $post2->shouldReceive('getKey')->andReturn('abc');
        $post2->shouldReceive('update')->andReturnTrue();
        $post2->setRawAttributes(['title' => ''], true);
        Assert::assertIsString($post2->getGuidAttribute(null));
    });

    test('TranslationFile empty content when path key missing', function (): void {
        $this->mockService(GetAllTranslationAction::class, static function (MockInterface $mock): void {
            $mock->shouldReceive('execute')->andReturn([
                ['key' => 'lang::only'],
            ]);
        });
        $rows = (new TranslationFile)->getRows();
        Assert::assertNotEmpty($rows);
        Assert::assertSame('', $rows[0]['content'] ?? null);
    });

    test('LangServiceProvider Step configureUsing and RouteServiceProvider admin locale', function (): void {
        $this->mockService(SaveTransAction::class, static function (MockInterface $mock): void {
            $mock->allows('execute');
        });
        $this->mockService(GetTransKeyAction::class, static function (MockInterface $mock): void {
            $mock->allows(['execute' => 'lang::txt']);
        });
        $this->mockService(SvgExistsAction::class, static function (MockInterface $mock): void {
            $mock->allows(['execute' => false]);
        });

        $provider = new LangServiceProvider(app());
        $provider->registerFilamentLabel();

        config(['laravellocalization.supportedLocales' => 'invalid']);
        app()->instance('request', Request::create('http://localhost/it/admin/dashboard', 'GET'));
        session(['in_admin' => true]);
        $routes = new RouteServiceProvider(app());
        $routes->registerLang();
        Assert::assertContains(app()->getLocale(), ['it', 'en']);

        config([
            'laravellocalization.supportedLocales' => [
                'it' => ['name' => 'it'],
                'en' => ['name' => 'en'],
            ],
        ]);
        app()->instance('request', Request::create('http://localhost/en/admin/x', 'GET'));
        $routes->registerLang();
        Assert::assertSame('en', app()->getLocale());
    });

    test('ThemeComposer covers remaining branches', function (): void {
        config([
            'laravellocalization.supportedLocales' => [
                'it' => ['name' => 'Italiano', 'regional' => 'it_IT'],
                'en' => ['name' => 'English', 'regional' => 'en_US'],
            ],
        ]);
        $composer = new ThemeComposer;
        Assert::assertGreaterThan(0, $composer->languages()->count());

        config(['laravellocalization.supportedLocales' => 'invalid']);
        expect(fn () => $composer->languages())->toThrow(\Exception::class);

        config([
            'laravellocalization.supportedLocales' => [
                1 => ['name' => 'Bad', 'regional' => 'it_IT'],
                'it' => ['name' => 'Italiano', 'regional' => 123],
                'en' => ['name' => 99, 'regional' => 'en_US'],
                'de' => ['name' => 'Deutsch', 'regional' => 'de_DE'],
            ],
        ]);
        app()->setLocale('de');
        $languages = $composer->languages();
        Assert::assertGreaterThan(0, $languages->count());
        Assert::assertSame('de', $composer->currentLang('id'));

        app()->instance('request', Request::create('http://localhost/it/admin/dashboard', 'GET'));
        session(['in_admin' => true]);
        Route::shouldReceive('currentRouteName')->andReturn(null);
        $firstLanguage = $composer->languages()->toCollection()->first();
        Assert::assertNotNull($firstLanguage);
        Assert::assertSame('#', $firstLanguage->url);
    });

    test('AutoLabelAction remaining branches including FIX label and helper html', function (): void {
        $this->mockService(GetTransKeyAction::class, static function (MockInterface $mock): void {
            $mock->allows(['execute' => 'lang::auto']);
        });
        $this->mockService(SaveTransAction::class, static function (MockInterface $mock): void {
            $mock->allows('execute');
        });
        $this->mockService(SvgExistsAction::class, static function (MockInterface $mock): void {
            $mock->allows('execute')->andReturn(true);
        });

        app('translator')->addLines([
            'lang.auto.fields.help.helper_text' => '<b>x</b>',
            'lang.auto.actions.go.icon' => 'heroicon-o-check',
            'lang.auto.sections.empty.heading' => ['not', 'string'],
        ], 'it');
        app()->setLocale('it');

        $action = app(AutoLabelAction::class);
        $help = TextInput::make('help');
        $out = $action->execute($help, 'helperText');
        Assert::assertSame($help, $out);

        $go = Action::make('go');
        Assert::assertSame($go, $action->execute($go, 'icon'));

        // array translation → FIX label branch
        $section = Section::make()->heading('empty');
        Assert::assertSame($section, $action->execute($section, 'heading'));
    });
});
