<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit;

use Illuminate\Translation\ArrayLoader;
use Illuminate\View\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mockery;
use Mockery\MockInterface;
use Modules\Lang\Actions\MergeTranslationsAction;
use Modules\Lang\Actions\SyncTranslationsAction;
use Modules\Lang\Actions\Translation\RecordMissingTranslationAction;
use Modules\Lang\Actions\WriteTranslationFileAction;
use Modules\Lang\Adapters\TranslatorAdapter;
use Modules\Lang\Datas\LangData;
use Modules\Lang\Datas\TranslationData;
use Modules\Lang\Filament\Resources\TranslationFileResource;
use Modules\Lang\Filament\Resources\TranslationFileResource\Pages\EditTranslationFile;
use Modules\Lang\Filament\Resources\TranslationFileResource\Pages\ListTranslationFiles;
use Modules\Lang\Filament\Resources\TranslationFileResource\Schemas\TranslationFileForm;
use Modules\Lang\Filament\Resources\TranslationFileResource\Schemas\TranslationFileInfolist;
use Modules\Lang\Filament\Resources\TranslationFileResource\Tables\TranslationFilesTable;
use Modules\Lang\Filament\Widgets\LanguageSwitcherWidget;
use Modules\Lang\Models\Policies\PostPolicy;
use Modules\Lang\Models\Policies\TranslationFilePolicy;
use Modules\Lang\Models\Policies\TranslationPolicy;
use Modules\Lang\Models\Post;
use Modules\Lang\Models\Translation;
use Modules\Lang\Models\TranslationFile;
use Modules\Lang\Providers\RouteServiceProvider;
use Modules\Lang\Tests\TestCase;
use Modules\Lang\View\Components\Flag;
use Modules\Lang\View\Components\LanguageSwitcher;
use Modules\Lang\View\Composers\ThemeComposer;
use Modules\Xot\Actions\GetViewAction;
use Modules\Xot\Contracts\UserContract;
use PHPUnit\Framework\Assert;

use function Safe\mkdir;
use function Safe\rmdir;
use function Safe\unlink;

uses(TestCase::class);

/**
 * @param  list<string>  $permissions
 * @return MockInterface&UserContract
 */
function langFakeUser(array $permissions = [], bool $superAdmin = false): UserContract
{
    /** @var MockInterface&UserContract $user */
    $user = Mockery::mock(UserContract::class);
    $user->shouldReceive('hasRole')
        ->with('super-admin')
        ->andReturn($superAdmin);
    $user->shouldReceive('hasPermissionTo')
        ->andReturnUsing(static function (string $permission) use ($permissions): bool {
            return in_array($permission, $permissions, true);
        });

    return $user;
}

afterEach(function (): void {
    Mockery::close();
});

describe('Lang coverage boost — Actions', function (): void {
    test('MergeTranslationsAction merges later files over earlier keys', function (): void {
        $merged = app(MergeTranslationsAction::class)->execute([
            ['welcome' => 'Hello', 'bye' => 'Goodbye'],
            ['welcome' => 'Ciao'],
        ]);

        Assert::assertSame('Ciao', $merged['welcome']);
        Assert::assertSame('Goodbye', $merged['bye']);
    });

    test('WriteTranslationFileAction writes valid php translation file', function (): void {
        $path = sys_get_temp_dir().'/lang_write_test_'.uniqid().'.php';

        try {
            app()->instance('cache', new class
            {
                public function flush(): void {}
            });

            $result = app(WriteTranslationFileAction::class)->execute($path, [
                'greeting' => 'Hello',
                'nested' => ['key' => 'value'],
            ]);

            Assert::assertTrue($result);
            Assert::assertFileExists($path);
            /** @var array<string, mixed> $loaded */
            $loaded = require $path;
            Assert::assertSame('Hello', $loaded['greeting']);
        } finally {
            if (file_exists($path)) {
                unlink($path);
            }
        }
    });
});

describe('Lang coverage boost — Policies', function (): void {
    test('TranslationPolicy delegates to permissions', function (): void {
        $policy = new TranslationPolicy;
        $allowed = langFakeUser(['translation.viewAny', 'translation.view', 'translation.create']);
        $denied = langFakeUser([]);

        Assert::assertTrue($policy->viewAny($allowed));
        Assert::assertTrue($policy->view($allowed, new Translation));
        Assert::assertTrue($policy->create($allowed));
        Assert::assertFalse($policy->viewAny($denied));
    });

    test('super-admin bypasses TranslationPolicy checks', function (): void {
        $policy = new TranslationPolicy;
        $superAdmin = langFakeUser(superAdmin: true);

        Assert::assertTrue($policy->before($superAdmin, 'viewAny'));
    });

    test('PostPolicy and TranslationFilePolicy enforce permissions', function (): void {
        $postPolicy = new PostPolicy;
        $filePolicy = new TranslationFilePolicy;
        $user = langFakeUser(['post.update', 'translation_file.delete']);

        Assert::assertTrue($postPolicy->update($user, new Post));
        Assert::assertTrue($filePolicy->delete($user, new TranslationFile));
        Assert::assertFalse($postPolicy->delete(langFakeUser([]), new Post));
    });
});

describe('Lang coverage boost — Filament static', function (): void {
    test('TranslationFileResource exposes translatable helpers and pages', function (): void {
        config(['app.locale' => 'it']);

        Assert::assertSame('it', TranslationFileResource::getDefaultTranslatableLocale());
        Assert::assertSame(['it', 'en'], TranslationFileResource::getTranslatableLocales());

        $pages = TranslationFileResource::getPages();
        Assert::assertArrayHasKey('index', $pages);
        Assert::assertArrayHasKey('create', $pages);
        Assert::assertArrayHasKey('edit', $pages);
    });
});

describe('Lang coverage boost — UI and data', function (): void {
    test('translation file schemas and pages build executable structures', function (): void {
        $formSchema = (new TranslationFileForm)->getFormSchema();
        $infolistSchema = (new TranslationFileInfolist)->getInfolistSchema();
        $tableColumns = (new TranslationFilesTable)->getTableColumns();

        Assert::assertArrayHasKey('name', $formSchema);
        Assert::assertArrayHasKey('id', $infolistSchema);
        Assert::assertArrayHasKey('path', $tableColumns);

        $listPage = new ListTranslationFiles;
        $editPage = new EditTranslationFile;

        $builtFields = $editPage->makeFromArray([
            'title' => 'Hello',
            'meta' => ['description' => 'World'],
        ]);

        $listHeader = new \ReflectionMethod($listPage, 'getHeaderActions');
        $listHeader->setAccessible(true);
        $listHeaderActions = $listHeader->invoke($listPage);
        Assert::assertIsArray($listHeaderActions);
        Assert::assertArrayHasKey('locale_switcher', $listHeaderActions);
        Assert::assertCount(2, $builtFields);
        Assert::assertSame(['it', 'en'], $editPage->getTranslatableLocales());
    });

    test('language widget and blade components expose runtime data', function (): void {
        $widget = new LanguageSwitcherWidget;

        Assert::assertTrue(LanguageSwitcherWidget::canView());
        $supportedCodes = array_keys(LaravelLocalization::getSupportedLocales());
        Assert::assertSame($supportedCodes, $widget->getAvailableLocales()->pluck('code')->all());
        $firstLocale = $widget->getAvailableLocales()->first();
        Assert::assertNotNull($firstLocale);
        Assert::assertContains($firstLocale['code'], $supportedCodes);

        app('request')->server->set('REQUEST_URI', '/it/example');
        app('request')->server->set('PATH_INFO', '/it/example');
        app()->setLocale('it');

        Assert::assertStringContainsString('en', $widget->getLanguageUrl('en'));

        $component = new LanguageSwitcher;
        $rendered = $component->render();

        Assert::assertInstanceOf(View::class, $rendered);
        Assert::assertSame('lang::components.language-switcher', $rendered->name());
    });

    test('flag component, theme composer and data objects resolve language metadata', function (): void {
        $this->mockService(GetViewAction::class, static function (MockInterface $mock): void {
            $mock->allows(['execute' => 'lang::components.empty']);
        });

        $flag = new Flag('it');
        $flagView = $flag->render();

        Assert::assertInstanceOf(View::class, $flagView);
        Assert::assertSame('lang::components.empty', $flagView->name());

        config([
            'laravellocalization.supportedLocales' => [
                'it' => ['name' => 'Italiano', 'regional' => 'it_IT'],
                'en' => ['name' => 'English', 'regional' => 'en_US'],
            ],
        ]);
        app()->setLocale('it');

        $composer = new ThemeComposer;
        $languages = $composer->languages();
        $others = $composer->otherLanguages();

        Assert::assertCount(2, $languages);
        Assert::assertCount(1, $others);
        Assert::assertSame('Italiano', $composer->currentLang('name'));
        Assert::assertSame('it', $composer->currentLang('id'));

        $collection = LangData::collection([
            ['id' => 'it', 'name' => 'Italiano', 'flag' => '<i></i>', 'url' => '/it'],
        ]);

        Assert::assertCount(1, $collection);
    });

    test('translation data resolves filenames and translator adapter records misses', function (): void {
        $langDir = sys_get_temp_dir().'/lang_data_'.uniqid();
        mkdir($langDir, 0o755, true);
        $filePath = $langDir.'/it/messages.php';
        mkdir(dirname($filePath), 0o755, true);
        TestCase::createTranslationFile($filePath, ['welcome' => 'Ciao']);

        app()->instance('translator', new class($langDir)
        {
            public function __construct(private readonly string $path) {}

            public function getLoader(): object
            {
                return new class($this->path)
                {
                    public function __construct(private readonly string $path) {}

                    /** @return array<string, string> */
                    public function namespaces(): array
                    {
                        return ['tenant' => $this->path];
                    }
                };
            }
        });

        $translationData = TranslationData::from([
            'lang' => 'it',
            'namespace' => 'tenant',
            'group' => 'messages',
            'item' => 'welcome',
        ]);

        Assert::assertSame($filePath, $translationData->getFilename());
        Assert::assertSame(['welcome' => 'Ciao'], $translationData->getData());

        $loader = new ArrayLoader;
        $loader->addMessages('it', 'messages', ['known' => 'Valore']);
        $adapter = new TranslatorAdapter($loader, 'it');

        $this->mockService(RecordMissingTranslationAction::class, static function (MockInterface $mock): void {
            $mock->expects('execute')->once()->with('messages.missing', 'it');
        });

        Assert::assertSame('messages.missing', $adapter->get('messages.missing'));
        Assert::assertSame('Valore', $adapter->get('messages.known'));

        unlink($filePath);
        rmdir(dirname($filePath));
        rmdir($langDir);
    });
});

describe('Lang coverage boost — Post accessors', function (): void {
    test('Post mutators and accessors work without persisting', function (): void {
        $post = new Post;
        $post->setTitleAttribute('My Title');

        Assert::assertSame('My Title', $post->getAttributes()['title']);
        Assert::assertSame('my-title', $post->getAttributes()['guid']);
        Assert::assertSame('', $post->getTxtAttribute(null));

        $post->title = 'Search me';
        $post->guid = 'search-me';
        $post->txt = 'body';

        Assert::assertSame(
            ['title' => 'Search me', 'guid' => 'search-me', 'txt' => 'body'],
            $post->toSearchableArray(),
        );
    });

    test('Post guid accessor slugifies fallback title', function (): void {
        $post = new Post;
        $post->setRawAttributes(['title' => 'Hello World']);

        Assert::assertSame('hello-world', $post->getGuidAttribute(null));
    });
});

describe('Lang coverage boost — Sync and routes', function (): void {
    test('SyncTranslationsAction processes Lang module lang files', function (): void {
        $result = app(SyncTranslationsAction::class)->execute('it', ['en'], 'Lang');

        Assert::assertIsArray($result);
        Assert::assertSame(1, $result['total_modules']);
        Assert::assertIsArray($result['modules']);
        Assert::assertArrayHasKey('Lang', $result['modules']);
        $langResult = $result['modules']['Lang'];
        Assert::assertIsArray($langResult);
        Assert::assertArrayHasKey('status', $langResult);
    });

    test('RouteServiceProvider registerLang runs with fallback locales', function (): void {
        config(['laravellocalization.supportedLocales' => null]);

        $provider = new RouteServiceProvider(app());
        Assert::assertSame('Lang', $provider->name);
        $provider->registerLang();

        Assert::assertContains(app()->getLocale(), ['it', 'en']);
    });
});
