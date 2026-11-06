<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Translation\ArrayLoader;
use Illuminate\View\View;
use Livewire\Livewire;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mockery;
use Mockery\MockInterface;
use Modules\Lang\Actions\Filament\AutoLabelAction;
use Modules\Lang\Actions\GetAllModuleTranslationAction;
use Modules\Lang\Actions\GetAllTranslationAction;
use Modules\Lang\Actions\GetTransPathAction;
use Modules\Lang\Actions\PublishTranslationAction;
use Modules\Lang\Actions\ReadTranslationFileAction;
use Modules\Lang\Actions\SaveTransAction;
use Modules\Lang\Actions\SyncTranslationsAction;
use Modules\Lang\Actions\TransArrayAction;
use Modules\Lang\Actions\TransCollectionAction;
use Modules\Lang\Actions\Translation\RecordMissingTranslationAction;
use Modules\Lang\Actions\WriteTranslationFileAction;
use Modules\Lang\Adapters\TranslatorAdapter;
use Modules\Lang\Casts\LangField;
use Modules\Lang\Datas\TranslationData;
use Modules\Lang\Filament\Actions\LocaleSwitcherRefresh;
use Modules\Lang\Filament\Forms\Components\NationalFlagSelect;
use Modules\Lang\Filament\Resources\TranslationFileResource\Pages\EditTranslationFile;
use Modules\Lang\Filament\Resources\TranslationFileResource\Pages\ListTranslationFiles;
use Modules\Lang\Filament\Resources\TranslationFileResource\Tables\TranslationFilesTable;
use Modules\Lang\Filament\Widgets\LanguageSwitcherWidget;
use Modules\Lang\Models\LanguageLine;
use Modules\Lang\Models\Policies\PostPolicy;
use Modules\Lang\Models\Policies\TranslationFilePolicy;
use Modules\Lang\Models\Policies\TranslationPolicy;
use Modules\Lang\Models\Post;
use Modules\Lang\Models\Translation;
use Modules\Lang\Models\TranslationFile;
use Modules\Lang\Providers\LangServiceProvider;
use Modules\Lang\Providers\RouteServiceProvider;
use Modules\Lang\Providers\TranslatorTraitPhpstanProbe;
use Modules\Lang\Tests\Fixtures\LangBaseCreateRecordStub;
use Modules\Lang\Tests\Fixtures\LangBaseEditRecordStub;
use Modules\Lang\Tests\Fixtures\LangBaseListRecordsStub;
use Modules\Lang\Tests\Fixtures\LangBasePolicyStub;
use Modules\Lang\Tests\Fixtures\LangBaseResourceStub;
use Modules\Lang\Tests\Fixtures\LangBaseViewRecordStub;
use Modules\Lang\Tests\Fixtures\LangFieldHostModel;
use Modules\Lang\Tests\Fixtures\StrictTranslationsHost;
use Modules\Lang\Tests\Fixtures\TranslationEditorStub;
use Modules\Lang\Tests\TestCase;
use Modules\Lang\View\Components\LanguageSwitcher;
use Modules\Lang\View\Composers\ThemeComposer;
use Modules\Xot\Actions\Arr\SaveArrayAction;
use Modules\Xot\Actions\File\AssetAction;
use Modules\Xot\Actions\File\SvgExistsAction;
use Modules\Xot\Actions\GetTransKeyAction;
use Modules\Xot\Contracts\UserContract;
use PHPUnit\Framework\Assert;
use ReflectionMethod;

use function Safe\fclose;
use function Safe\file_put_contents;
use function Safe\fopen;
use function Safe\getmypid;
use function Safe\mkdir;
use function Safe\rmdir;
use function Safe\touch;
use function Safe\unlink;

uses(TestCase::class);

/**
 * @param  list<string>  $permissions
 * @return MockInterface&UserContract
 */
function langHundredFakeUser(array $permissions = [], bool $superAdmin = false): UserContract
{
    /** @var MockInterface&UserContract $user */
    $user = Mockery::mock(UserContract::class);
    $user->shouldReceive('hasRole')->with('super-admin')->andReturn($superAdmin);
    $user->shouldReceive('hasPermissionTo')
        ->andReturnUsing(static fn (string $permission): bool => in_array($permission, $permissions, true));

    return $user;
}

/**
 * `mixed ...$values` voluto: helper per costruire collezioni di valori eterogenei.
 *
 * @return Collection<int|string, mixed>
 */
function langMixedCollection(mixed ...$values): Collection
{
    return new Collection($values);
}

function langForceSqliteTranslations(): void
{
    $database = sys_get_temp_dir().'/lang_cov_'.getmypid().'_'.uniqid('', true).'.sqlite';
    if (file_exists($database)) {
        unlink($database);
    }
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

    Schema::connection('lang')->dropIfExists('translations');
    Schema::connection('lang')->create('translations', static function (Blueprint $table): void {
        $table->id();
        $table->string('lang')->nullable();
        $table->string('namespace')->nullable();
        $table->string('group')->nullable();
        $table->string('item')->nullable();
        $table->text('value')->nullable();
        $table->timestamps();
    });

    // Stash path for cleanup after the test.
    $GLOBALS['__lang_cov_sqlite'] = $database;
}

afterEach(function (): void {
    Mockery::close();
    config(['lang.language_switcher.enabled' => true]);

    $sqlite = $GLOBALS['__lang_cov_sqlite'] ?? null;
    if (is_string($sqlite)) {
        DB::purge('lang');
        if (file_exists($sqlite)) {
            unlink($sqlite);
        }
        unset($GLOBALS['__lang_cov_sqlite']);
    }
});

describe('Lang 100% — Actions zero-coverage', function (): void {
    test('GetAllModuleTranslationAction and GetAllTranslationAction honor session locale and skip non-strings', function (): void {
        session()->put('locale', 'en');
        app()->setLocale('it');

        $sample = base_path('Modules/Lang/lang/en/auth.php');
        File::shouldReceive('glob')->andReturn([42, $sample])->byDefault();

        $moduleRows = app(GetAllModuleTranslationAction::class)->execute();
        $allRows = app(GetAllTranslationAction::class)->execute();

        Assert::assertSame('en', app()->getLocale());
        Assert::assertNotEmpty($moduleRows);
        Assert::assertSame($moduleRows[0]['path'], $sample);
        Assert::assertNotEmpty($allRows);
        Assert::assertStringContainsString('lang::', $allRows[0]['key']);
    });

    test('PublishTranslationAction writes when item value changes', function (): void {
        $dir = sys_get_temp_dir().'/lang_pub_'.uniqid();
        mkdir($dir.'/it', 0o755, true);
        $file = $dir.'/it/messages.php';
        TestCase::createTranslationFile($file, ['welcome' => 'old']);

        $data = TranslationData::from([
            'lang' => 'it',
            'namespace' => 'tenant',
            'group' => 'messages',
            'item' => 'welcome',
            'value' => 'new',
            'filename' => $file,
        ]);

        app(PublishTranslationAction::class)->execute($data);

        /** @var array<string, mixed> $loaded */
        $loaded = require $file;
        Assert::assertSame('new', $loaded['welcome']);

        unlink($file);
        rmdir($dir.'/it');
        rmdir($dir);
    });

    test('PublishTranslationAction skips write when data unchanged', function (): void {
        $dir = sys_get_temp_dir().'/lang_pub2_'.uniqid();
        mkdir($dir.'/it', 0o755, true);
        $file = $dir.'/it/messages.php';
        TestCase::createTranslationFile($file, ['welcome' => 'same']);

        $data = TranslationData::from([
            'lang' => 'it',
            'namespace' => 'tenant',
            'group' => 'messages',
            'item' => 'welcome',
            'value' => 'same',
            'filename' => $file,
        ]);

        $this->mockService(SaveArrayAction::class, static function (MockInterface $mock): void {
            $mock->shouldReceive('execute')->never();
        });

        app(PublishTranslationAction::class)->execute($data);

        unlink($file);
        rmdir($dir.'/it');
        rmdir($dir);
    });

    test('SaveTransAction creates missing file and sets nested key', function (): void {
        TestCase::bindRealSaveTransAction();
        $file = sys_get_temp_dir().'/lang_save_cov_'.uniqid().'.php';
        $this->mockService(GetTransPathAction::class, static function (MockInterface $mock) use ($file): void {
            $mock->allows(['execute' => $file]);
        });

        try {
            app(SaveTransAction::class)->execute('lang::tmpcov.nested.key', 'val');

            Assert::assertFileExists($file);
            /** @var array<string, mixed> $loaded */
            $loaded = require $file;
            Assert::assertIsArray($loaded['nested']);
            Assert::assertSame('val', $loaded['nested']['key']);
        } finally {
            if (file_exists($file)) {
                unlink($file);
            }
            TestCase::forgetSaveTransActionOverride();
        }
    });

    test('SaveTransAction replaces whole content when piece empty', function (): void {
        TestCase::bindRealSaveTransAction();
        $file = sys_get_temp_dir().'/lang_save_root_'.uniqid().'.php';
        TestCase::createTranslationFile($file, ['a' => '1']);
        $this->mockService(GetTransPathAction::class, static function (MockInterface $mock) use ($file): void {
            $mock->allows(['execute' => $file]);
        });

        try {
            expect(fn () => app(SaveTransAction::class)->execute('lang::tmproot', 'not-array'))
                ->toThrow(\Exception::class);
        } finally {
            if (file_exists($file)) {
                unlink($file);
            }
            TestCase::forgetSaveTransActionOverride();
        }
    });

    test('RecordMissingTranslationAction parses namespace and plain keys', function (): void {
        langForceSqliteTranslations();

        app(RecordMissingTranslationAction::class)->execute('lang::group.item', 'it');
        app(RecordMissingTranslationAction::class)->execute('plain.key', 'en');
        app(RecordMissingTranslationAction::class)->execute('lonely', 'de');

        Assert::assertSame(3, Translation::query()->count());
        Assert::assertTrue(Translation::query()->where('namespace', 'lang')->where('group', 'group')->where('item', 'item')->exists());
        Assert::assertTrue(Translation::query()->where('namespace', '*')->where('group', 'plain')->where('item', 'key')->exists());
        Assert::assertTrue(Translation::query()->where('namespace', '*')->where('group', 'lonely')->whereNull('item')->exists());
    });

    test('TranslatorAdapter covers missing keys and array results', function (): void {
        langForceSqliteTranslations();

        $loader = new ArrayLoader;
        $loader->addMessages('it', 'messages', [
            'known' => 'Ciao',
            'tree' => ['a' => 'b'],
            'num' => 7,
        ]);

        $adapter = new TranslatorAdapter($loader, 'it');
        Assert::assertSame('Ciao', $adapter->get('messages.known'));
        Assert::assertSame(['a' => 'b'], $adapter->get('messages.tree'));
        Assert::assertSame('messages.num', $adapter->get('messages.num'));
        $adapterMissingKey = 'messages.missing_'.uniqid('', true);
        Assert::assertSame($adapterMissingKey, $adapter->get($adapterMissingKey));
        Assert::assertGreaterThan(0, Translation::query()->count());
    });

    test('WriteTranslationFileAction backs up existing files and flushes translation loader', function (): void {
        $path = sys_get_temp_dir().'/lang_write_cov_'.uniqid().'.php';
        TestCase::createTranslationFile($path, ['old' => '1']);

        app()->instance('cache', new class
        {
            public function flush(): void {}
        });
        $translationLoader = new class
        {
            public bool $flushed = false;

            public function flush(): void
            {
                $this->flushed = true;
            }
        };
        app()->instance('translation.loader', $translationLoader);

        try {
            Assert::assertTrue(app(WriteTranslationFileAction::class)->execute($path, ['new' => '2']));
            Assert::assertFileExists($path);
            /** @var array<string, mixed> $loaded */
            $loaded = require $path;
            Assert::assertSame('2', $loaded['new']);
            Assert::assertTrue($translationLoader->flushed);
        } finally {
            if (file_exists($path)) {
                unlink($path);
            }
        }
    });

    test('WriteTranslationFileAction rejects invalid php syntax', function (): void {
        $path = sys_get_temp_dir().'/lang_bad_'.uniqid().'.php';
        $action = app(WriteTranslationFileAction::class);

        $read = Mockery::mock(ReadTranslationFileAction::class);
        $read->shouldReceive('toPhp')->andReturn('<?php return [;');
        app()->instance(ReadTranslationFileAction::class, $read);

        expect(fn () => $action->execute($path, ['x' => 'y']))->toThrow(\Exception::class);
    });

    test('SyncTranslationsAction covers skip paths nested merge and getModules', function (): void {
        $action = app(SyncTranslationsAction::class);

        $missing = $action->execute('it', ['en'], 'DefinitelyMissingModuleXyz');
        Assert::assertIsArray($missing);
        Assert::assertIsArray($missing['modules']);
        Assert::assertIsArray($missing['modules']['DefinitelyMissingModuleXyz']);
        Assert::assertSame('skipped', $missing['modules']['DefinitelyMissingModuleXyz']['status']);

        $tmpModule = 'LangCovTmp'.uniqid();
        $base = base_path('Modules/'.$tmpModule);
        mkdir($base.'/lang/it', 0o755, true);
        file_put_contents($base.'/lang/it/empty.php', "<?php\n\nreturn [];\n");
        file_put_contents($base.'/lang/it/nested.php', "<?php\n\nreturn ['a' => ['b' => '1'], 'c' => '2'];\n");

        try {
            $done = $action->execute('xx', ['en'], $tmpModule);
            Assert::assertIsArray($done);
            Assert::assertIsArray($done['modules']);
            Assert::assertIsArray($done['modules'][$tmpModule]);
            Assert::assertSame('skipped', $done['modules'][$tmpModule]['status']);

            $synced = $action->execute('it', ['en'], $tmpModule);
            Assert::assertIsArray($synced);
            Assert::assertIsArray($synced['modules']);
            Assert::assertIsArray($synced['modules'][$tmpModule]);
            Assert::assertSame('completed', $synced['modules'][$tmpModule]['status']);
            Assert::assertFileExists($base.'/lang/en/nested.php');

            $getModules = new ReflectionMethod($action, 'getModules');
            $getModules->setAccessible(true);
            /** @var list<string> $modules */
            $modules = $getModules->invoke($action, base_path('Modules'));
            Assert::assertContains('Lang', $modules);
        } finally {
            File::deleteDirectory($base);
        }

        $load = new ReflectionMethod($action, 'loadTranslations');
        $load->setAccessible(true);
        Assert::assertSame([], $load->invoke($action, '/no/such/file.php'));

        $broken = sys_get_temp_dir().'/lang_broken_'.uniqid().'.php';
        file_put_contents($broken, '<?php throw new Exception("boom");');
        Assert::assertSame([], $load->invoke($action, $broken));
        unlink($broken);

        $nonArray = sys_get_temp_dir().'/lang_nonarray_'.uniqid().'.php';
        file_put_contents($nonArray, "<?php\nreturn 'x';\n");
        Assert::assertSame([], $load->invoke($action, $nonArray));
        unlink($nonArray);
    });

    test('TransArrayAction and TransCollectionAction hit label and underscore branches', function (): void {
        app('translator')->addLines([
            'cov.foo.label' => 'Etichetta',
            'cov.bar_baz' => 'Underscore',
            'col.hello' => 'Ciao',
            'col.x_y' => 'XY',
        ], 'it');
        app()->setLocale('it');

        $arrayAction = app(TransArrayAction::class);
        Assert::assertSame([''], $arrayAction->execute([''], 'cov'));
        Assert::assertSame(['0'], $arrayAction->execute(['0'], 'cov'));
        Assert::assertSame(['Etichetta'], $arrayAction->execute(['foo'], 'cov'));
        Assert::assertSame(['Underscore'], $arrayAction->execute(['bar.baz'], 'cov'));
        Assert::assertSame(['missing'], $arrayAction->execute(['missing'], 'cov'));

        $colAction = app(TransCollectionAction::class);
        $empty = $colAction->execute(langMixedCollection(''), 'col');
        Assert::assertSame([''], $empty->all());
        Assert::assertSame(['Ciao'], $colAction->execute(langMixedCollection('hello'), 'col')->all());
        Assert::assertSame(['XY'], $colAction->execute(langMixedCollection('x.y'), 'col')->all());
        Assert::assertSame(['z'], $colAction->execute(langMixedCollection('z'), 'col')->all());
    });

    test('AutoLabelAction covers section step action icon and helperText branches', function (): void {
        $this->mockService(GetTransKeyAction::class, static function (MockInterface $mock): void {
            $mock->allows(['execute' => 'lang::autolabel']);
        });
        $this->mockService(SaveTransAction::class, static function (MockInterface $mock): void {
            $mock->allows('execute');
        });
        $this->mockService(SvgExistsAction::class, static function (MockInterface $mock): void {
            $mock->allows('execute')->andReturnUsing(static fn (string $label): bool => $label === 'heroicon-o-check');
        });

        app('translator')->addLines([
            'lang.autolabel.fields.title.label' => 'Titolo',
            'lang.autolabel.sections.empty.heading' => 'Sezione',
            'lang.autolabel.steps.one.label' => 'Passo',
            'lang.autolabel.actions.save.label' => 'Salva',
            'lang.autolabel.actions.save.icon' => 'heroicon-o-check',
            'lang.autolabel.actions.broken.icon' => 'missing-icon',
            'lang.autolabel.fields.help.helper_text' => '<b>aiuto</b>',
        ], 'it');
        app()->setLocale('it');

        $action = app(AutoLabelAction::class);

        $field = TextInput::make('title');
        Assert::assertSame($field, $action->execute($field, 'label'));

        $section = Section::make()->heading(null);
        Assert::assertSame($section, $action->execute($section, 'heading'));

        $save = Action::make('save');
        Assert::assertSame($save, $action->execute($save, 'label'));
        Assert::assertSame($save, $action->execute($save, 'icon'));

        $broken = Action::make('broken');
        Assert::assertSame($broken, $action->execute($broken, 'icon'));

        $help = TextInput::make('help');
        Assert::assertSame($help, $action->execute($help, 'helperText'));
    });
});

describe('Lang 100% — Filament / Livewire / Casts', function (): void {
    test('LangBaseResource stub exposes locales', function (): void {
        config(['app.locale' => 'it']);
        Assert::assertSame('it', LangBaseResourceStub::getDefaultTranslatableLocale());
        Assert::assertSame(['it', 'en'], LangBaseResourceStub::getTranslatableLocales());
    });

    test('LangBase page stubs expose header actions with locale switcher', function (): void {
        $create = new ReflectionMethod(LangBaseCreateRecordStub::class, 'getHeaderActions');
        $create->setAccessible(true);
        Assert::assertNotEmpty($create->invoke(new LangBaseCreateRecordStub));

        $edit = new ReflectionMethod(LangBaseEditRecordStub::class, 'getHeaderActions');
        $edit->setAccessible(true);
        $editActions = $edit->invoke(new LangBaseEditRecordStub);
        Assert::assertIsArray($editActions);
        Assert::assertArrayHasKey('locale-switcher', $editActions);

        $list = new ReflectionMethod(LangBaseListRecordsStub::class, 'getHeaderActions');
        $list->setAccessible(true);
        $listActions = $list->invoke(new LangBaseListRecordsStub);
        Assert::assertIsArray($listActions);
        Assert::assertArrayHasKey('locale_switcher', $listActions);

        $view = new ReflectionMethod(LangBaseViewRecordStub::class, 'getHeaderActions');
        $view->setAccessible(true);
        $viewActions = $view->invoke(new LangBaseViewRecordStub);
        Assert::assertIsArray($viewActions);
        Assert::assertArrayHasKey('locale-switcher', $viewActions);
    });

    test('LocaleSwitcherRefresh setUp runs with session locale', function (): void {
        session()->put('locale', 'en');
        $action = LocaleSwitcherRefresh::make('locale');
        Assert::assertSame('en', $action->lang);
        Assert::assertNotSame('', $action->fullUrl);
    });

    test('LocaleSwitcherRefresh falls back when session locale invalid', function (): void {
        session()->forget('locale');
        $action = LocaleSwitcherRefresh::make('locale2');
        Assert::assertSame('it', $action->lang);
    });

    test('NationalFlagSelect builds options and filters search', function (): void {
        $this->mockService(AssetAction::class, static function (MockInterface $mock): void {
            $mock->allows(['execute' => '/flag.svg']);
        });

        $select = NationalFlagSelect::make('country');
        $optionsMethod = new ReflectionMethod($select, 'getCountryOptions');
        $optionsMethod->setAccessible(true);
        /** @var array<string, string> $options */
        $options = $optionsMethod->invoke($select);
        Assert::assertNotEmpty($options);

        $filterMethod = new ReflectionMethod($select, 'getFilteredCountryOptions');
        $filterMethod->setAccessible(true);
        Assert::assertNotEmpty($filterMethod->invoke($select, ''));
        Assert::assertIsArray($filterMethod->invoke($select, 'ital'));
        Assert::assertIsArray($filterMethod->invoke($select, 'IT'));
    });

    test('TranslationEditor builds nested child components', function (): void {
        $editor = TranslationEditorStub::make('content');
        $editor->forcedState = [
            'title' => 'Hello',
            'meta' => ['description' => 'World'],
        ];
        Assert::assertCount(2, $editor->getDefaultChildComponents());

        $empty = TranslationEditorStub::make('empty');
        $empty->forcedState = 'nope';
        Assert::assertSame([], $empty->getDefaultChildComponents());
    });

    test('EditTranslationFile and ListTranslationFiles cover remaining methods', function (): void {
        $this->mockService(SaveTransAction::class, static function (MockInterface $mock): void {
            $mock->allows('execute');
        });

        $edit = new EditTranslationFile;
        $schema = $edit->getFormSchema();
        Assert::assertNotEmpty($schema);

        $header = new ReflectionMethod($edit, 'getHeaderActions');
        $header->setAccessible(true);
        $headerActions = $header->invoke($edit);
        Assert::assertIsArray($headerActions);
        Assert::assertArrayHasKey('locale-switcher', $headerActions);

        $mutate = new ReflectionMethod($edit, 'mutateFormDataBeforeSave');
        $mutate->setAccessible(true);
        $record = new class extends Model
        {
            protected $guarded = [];
        };
        $record->forceFill(['key' => 'lang::messages']);
        $edit->record = $record;
        Assert::assertSame(['content' => ['a' => 'b']], $mutate->invoke($edit, ['content' => ['a' => 'b']]));
        Assert::assertSame(['content' => null], $mutate->invoke($edit, ['content' => null]));

        $editNoKey = new EditTranslationFile;
        $editNoKey->record = new class extends Model
        {
            protected $guarded = [];
        };
        Assert::assertSame(['x' => 1], $mutate->invoke($editNoKey, ['x' => 1]));

        $after = new ReflectionMethod($edit, 'afterSave');
        $after->setAccessible(true);
        $refreshable = new class extends Model
        {
            public bool $refreshed = false;

            public function refresh(): static
            {
                $this->refreshed = true;

                return $this;
            }
        };
        $edit->record = $refreshable;
        $after->invoke($edit);
        Assert::assertTrue($refreshable->refreshed);

        $edit->record = null;
        $after->invoke($edit);

        $list = new ListTranslationFiles;
        $listHeader = new ReflectionMethod($list, 'getHeaderActions');
        $listHeader->setAccessible(true);
        $listHeaderActions = $listHeader->invoke($list);
        Assert::assertIsArray($listHeaderActions);
        Assert::assertArrayHasKey('locale_switcher', $listHeaderActions);

        $table = new TranslationFilesTable;
        Assert::assertArrayHasKey('locale_switcher', $table->getTableHeaderActions());
    });

    test('LanguageSwitcherWidget covers changeLanguage urls and view data', function (): void {
        $widget = new LanguageSwitcherWidget;
        $viewData = $widget->exposeViewData();
        Assert::assertArrayHasKey('available_locales', $viewData);
        Assert::assertArrayHasKey('lang', $viewData);
        Assert::assertArrayHasKey('langs', $viewData);
        $availableLocales = $viewData['available_locales'];
        Assert::assertInstanceOf(Collection::class, $availableLocales);
        $supportedCodes = array_keys(LaravelLocalization::getSupportedLocales());
        Assert::assertSame($supportedCodes, $availableLocales->pluck('code')->all());

        app()->instance('request', Request::create('http://localhost/it/demo', 'GET'));
        app()->setLocale('it');
        Assert::assertStringContainsString('en', $widget->getLanguageUrl('en'));

        app()->instance('request', Request::create('http://localhost/it', 'GET'));
        Assert::assertStringContainsString('en', $widget->getLanguageUrl('en'));

        app()->instance('request', Request::create('http://localhost/', 'GET'));
        Assert::assertSame('/de', $widget->getLanguageUrl('de'));

        Livewire::test(LanguageSwitcherWidget::class)
            ->call('changeLanguage', 'en')
            ->assertRedirect();

        Livewire::test(LanguageSwitcherWidget::class)
            ->call('changeLanguage', 'xx');
    });

    test('LanguageSwitcher blade component empty branch when disabled', function (): void {
        config(['lang.language_switcher.enabled' => false]);
        $component = new LanguageSwitcher;
        $view = $component->render();
        Assert::assertInstanceOf(View::class, $view);
        Assert::assertSame('lang::components.empty', $view->name());
    });

    test('retired HTTP Switcher and Change files no longer exist', function (): void {
        $httpLangDir = dirname(__DIR__, 2).'/app/Http/Livewire/Lang';
        Assert::assertFileDoesNotExist($httpLangDir.'/Change.php');
        Assert::assertFileDoesNotExist($httpLangDir.'/Switcher.php');
    });

    test('LangField cast get and set via host model', function (): void {
        $cast = new LangField;
        $host = new LangFieldHostModel;
        /** @var Post&MockInterface $post */
        $post = Mockery::mock(Post::class)->makePartial();
        $initialTitle = ['it' => 'Hello'];
        $post->setAttribute('custom_field', $initialTitle);
        $post->shouldReceive('save')->once()->andReturnTrue();
        $host->setRelation('post', $post);

        Assert::assertSame($initialTitle, $cast->get($host, 'custom_field', null, []));
        $translatedTitle = ['it' => 'World'];
        Assert::assertSame([], $cast->set($host, 'custom_field', $translatedTitle, []));
        Assert::assertSame($translatedTitle, $post->getAttribute('custom_field'));
    });
});

describe('Lang 100% — Models policies providers views', function (): void {
    test('LanguageLine fillable and casts', function (): void {
        $line = new LanguageLine;
        Assert::assertSame(['group', 'key', 'text', 'locale'], $line->getFillable());
        $casts = new ReflectionMethod($line, 'casts');
        $casts->setAccessible(true);
        Assert::assertSame(['text' => 'json'], $casts->invoke($line));
    });

    test('HasStrictTranslations normalizes scalar array bool float and object', function (): void {
        $model = new StrictTranslationsHost;

        $model->forcedTranslation = 'Ciao';
        Assert::assertSame('Ciao', $model->getTranslation('title', 'it'));

        $model->forcedTranslation = 3;
        Assert::assertSame(3, $model->getTranslation('title', 'it'));

        $model->forcedTranslation = null;
        Assert::assertNull($model->getTranslation('title', 'it'));

        $model->forcedTranslation = ['nested' => 'x', 0 => 'skip'];
        Assert::assertSame(['nested' => 'x'], $model->getTranslation('title', 'en'));

        $model->forcedTranslation = true;
        Assert::assertSame(1, $model->getTranslation('title', 'de'));

        $model->forcedTranslation = 1.5;
        Assert::assertSame(1, $model->getTranslation('title', 'fr'));

        $model->forcedTranslation = new class
        {
            public function __toString(): string
            {
                return 'obj';
            }
        };
        Assert::assertSame('obj', $model->getTranslation('title', 'es'));

        $model->forcedTranslation = fopen('php://memory', 'r');
        Assert::assertNull($model->getTranslation('title', 'pt'));
        if (is_resource($model->forcedTranslation)) {
            fclose($model->forcedTranslation);
        }
    });

    test('policies cover all abilities and before null path', function (): void {
        $user = langHundredFakeUser([
            'translation.viewAny', 'translation.view', 'translation.create', 'translation.update',
            'translation.delete', 'translation.restore', 'translation.forceDelete',
            'post.viewAny', 'post.view', 'post.create', 'post.update', 'post.delete', 'post.restore', 'post.forceDelete',
            'translation_file.viewAny', 'translation_file.view', 'translation_file.create', 'translation_file.update',
            'translation_file.delete', 'translation_file.restore', 'translation_file.forceDelete',
        ]);
        $denied = langHundredFakeUser([]);

        $translationPolicy = new TranslationPolicy;
        $postPolicy = new PostPolicy;
        $filePolicy = new TranslationFilePolicy;
        $base = new LangBasePolicyStub;

        Assert::assertNull($base->before($denied, 'viewAny'));
        Assert::assertTrue($translationPolicy->viewAny($user));
        Assert::assertTrue($translationPolicy->view($user, new Translation));
        Assert::assertTrue($translationPolicy->create($user));
        Assert::assertTrue($translationPolicy->update($user, new Translation));
        Assert::assertTrue($translationPolicy->delete($user, new Translation));
        Assert::assertTrue($translationPolicy->restore($user, new Translation));
        Assert::assertTrue($translationPolicy->forceDelete($user, new Translation));
        Assert::assertFalse($translationPolicy->viewAny($denied));

        Assert::assertTrue($postPolicy->viewAny($user));
        Assert::assertTrue($postPolicy->view($user, new Post));
        Assert::assertTrue($postPolicy->create($user));
        Assert::assertTrue($postPolicy->restore($user, new Post));
        Assert::assertTrue($postPolicy->forceDelete($user, new Post));

        Assert::assertTrue($filePolicy->viewAny($user));
        Assert::assertTrue($filePolicy->view($user, new TranslationFile));
        Assert::assertTrue($filePolicy->create($user));
        Assert::assertTrue($filePolicy->update($user, new TranslationFile));
        Assert::assertTrue($filePolicy->restore($user, new TranslationFile));
        Assert::assertTrue($filePolicy->forceDelete($user, new TranslationFile));
        Assert::assertFalse($filePolicy->viewAny($denied));
    });

    test('Post linkable slug options and accessors without persistence', function (): void {
        $post = new Post;
        Assert::assertSame('guid', $post->getSlugOptions()->slugField);

        $post->setRawAttributes(['post_type' => 'article', 'post_id' => '9']);
        Assert::assertSame('article 9', $post->getTitleAttribute(null));

        $post2 = new Post;
        $post2->setRawAttributes([]);
        $post2->post_type = 'page';
        $post2->post_id = 3;
        Assert::assertSame('page 3', $post2->getTitleAttribute(null));

        $post3 = new Post;
        $post3->setRawAttributes(['title' => '']);
        Assert::assertIsString($post3->getGuidAttribute('bad value with spaces'));

        $post4 = new Post;
        $post4->setRawAttributes(['title' => '', 'post_type' => 'x', 'post_id' => 1]);
        Assert::assertSame('x-1', $post4->getGuidAttribute(null));
    });

    test('TranslationFile getRows ide-helper path and load failures', function (): void {
        $previousArgv = $_SERVER['argv'] ?? null;
        $_SERVER['argv'] = ['artisan', 'ide-helper:models'];
        $ideHelperRows = (new TranslationFile)->getRows();
        $_SERVER['argv'] = $previousArgv;
        Assert::assertSame([], $ideHelperRows);

        $this->mockService(GetAllTranslationAction::class, static function (MockInterface $mock): void {
            $mock->shouldReceive('execute')->andThrow(new \RuntimeException('boom'));
        });
        $failedLoadRows = (new TranslationFile)->getRows();
        Assert::assertSame([], $failedLoadRows);

        $bad = sys_get_temp_dir().'/tf_bad_'.uniqid().'.php';
        file_put_contents($bad, '<?php throw new Exception("x");');
        $this->mockService(GetAllTranslationAction::class, static function (MockInterface $mock) use ($bad): void {
            $mock->shouldReceive('execute')->andReturn([
                ['key' => 'lang::bad', 'path' => $bad],
                ['key' => 'lang::missing', 'path' => '/no/file.php'],
                123,
            ]);
        });
        $rows = (new TranslationFile)->getRows();
        Assert::assertNotEmpty($rows);
        unlink($bad);
    });

    test('TranslationData throws when namespace missing or file not array', function (): void {
        app()->instance('translator', new class
        {
            public function getLoader(): object
            {
                return new class
                {
                    /** @return array<string, string> */
                    public function namespaces(): array
                    {
                        // Nessun namespace registrato: TranslationData deve lanciare.
                        return [];
                    }
                };
            }
        });

        $data = TranslationData::from([
            'lang' => 'it',
            'namespace' => 'missing',
            'group' => 'g',
            'item' => 'i',
        ]);
        expect(fn () => $data->getFilename())->toThrow(\Exception::class);

        $file = sys_get_temp_dir().'/td_'.uniqid().'.php';
        file_put_contents($file, "<?php\nreturn 'nope';\n");
        $data2 = TranslationData::from([
            'lang' => 'it',
            'namespace' => 'x',
            'group' => 'g',
            'item' => 'i',
            'filename' => $file,
        ]);
        expect(fn () => $data2->getData())->toThrow(\Exception::class);
        unlink($file);
    });

    test('TranslatorAdapter covers array and non-string translation results', function (): void {
        $loader = new ArrayLoader;
        $loader->addMessages('it', 'm', [
            'tree' => ['k' => 'v'],
            'num' => 5,
            'ok' => 'yes',
        ]);
        $adapter = new TranslatorAdapter($loader, 'it');

        $this->mockService(RecordMissingTranslationAction::class, static function (MockInterface $mock): void {
            $mock->allows('execute');
        });

        Assert::assertSame(['k' => 'v'], $adapter->get('m.tree'));
        Assert::assertSame('m.num', $adapter->get('m.num'));
        Assert::assertSame('yes', $adapter->get('m.ok'));
    });

    test('LangServiceProvider registerTranslator and filament configure callbacks', function (): void {
        $this->mockService(SaveTransAction::class, static function (MockInterface $mock): void {
            $mock->allows('execute');
        });
        $this->mockService(RecordMissingTranslationAction::class, static function (MockInterface $mock): void {
            $mock->allows('execute');
        });
        $this->mockService(GetTransKeyAction::class, static function (MockInterface $mock): void {
            $mock->allows(['execute' => 'lang::txt']);
        });

        $provider = new LangServiceProvider(app());
        $provider->registerTranslator();
        Assert::assertInstanceOf(TranslatorAdapter::class, app('translator'));

        $provider->registerFilamentLabel();
    });

    test('TranslatorTrait registerTranslator via probe', function (): void {
        $probe = new TranslatorTraitPhpstanProbe(app());
        $probe->registerTranslator();
        Assert::assertInstanceOf(TranslatorAdapter::class, app('translator'));
    });

    test('RouteServiceProvider registerLang with admin segment and locales', function (): void {
        config([
            'laravellocalization.supportedLocales' => [
                'it' => ['name' => 'it'],
                'en' => ['name' => 'en'],
            ],
        ]);
        $request = request();
        $request->server->set('REQUEST_URI', '/it/admin/dashboard');
        $request->server->set('PATH_INFO', '/it/admin/dashboard');

        $provider = new RouteServiceProvider(app());
        $provider->registerLang();
        Assert::assertContains(app()->getLocale(), ['it', 'en']);
    });

    test('ThemeComposer covers invalid config admin url and missing current lang', function (): void {
        config(['laravellocalization.supportedLocales' => 'bad']);
        expect(fn () => (new ThemeComposer)->languages())->toThrow(\Exception::class);

        config([
            'laravellocalization.supportedLocales' => [
                'it' => 'nope',
            ],
        ]);
        expect(fn () => (new ThemeComposer)->languages())->toThrow(\InvalidArgumentException::class);

        config([
            'laravellocalization.supportedLocales' => [
                'it' => ['name' => 'Italiano'],
            ],
        ]);
        expect(fn () => (new ThemeComposer)->languages())->toThrow(\InvalidArgumentException::class);

        config([
            'laravellocalization.supportedLocales' => [
                'it' => ['name' => 'Italiano', 'regional' => 'it_IT'],
                'en' => ['name' => 'English', 'regional' => 'en_US'],
            ],
        ]);
        app()->setLocale('it');
        $composer = new ThemeComposer;
        Assert::assertCount(2, $composer->languages());

        $request = request();
        $request->server->set('REQUEST_URI', '/it/admin/x');
        $request->server->set('PATH_INFO', '/it/admin/x');
        session(['in_admin' => true]);
        $firstLanguage = $composer->languages()->toCollection()->first();
        Assert::assertNotNull($firstLanguage);
        Assert::assertIsString($firstLanguage->url);

        app()->setLocale('zz');
        expect(fn () => $composer->currentLang('name'))->toThrow(\Exception::class);
    });
});
