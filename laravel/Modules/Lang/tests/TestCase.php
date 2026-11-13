<?php

declare(strict_types=1);

namespace Modules\Lang\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Modules\Lang\Actions\ReadTranslationFileAction;
use Modules\Lang\Actions\SaveTransAction;
use Modules\Lang\Database\Factories\TranslationFactory;
use Modules\Lang\Models\BaseModel;
use Modules\Lang\Models\Translation;
use Modules\Lang\Providers\LangServiceProvider;
use Modules\User\Models\User;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Tests\XotBaseTestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_put_contents;
use function Safe\mkdir;
use function Safe\unlink;

/**
 * Base test case for Lang module.
 *
 * Uses MySQL from .env.testing.
 * All module connections are mapped by TenantServiceProvider.
 * Migrations must be run ONCE externally: php artisan migrate --env=testing
 * DatabaseTransactions handles rollback between tests.
 */
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

    /** @var list<string> */
    protected $connectionsToTransact = ['sqlite', 'lang', 'user'];

    protected function setUp(): void
    {
        // Prima di parent::setUp(): DatabaseTransactions apre le transazioni subito; senza questo la
        // connessione `user` (mysql) va in "Connection refused" dove non c'e' MariaDB (vedi XotBaseTestCase).
        $this->prepareSharedSqliteForTesting();

        parent::setUp();

        $database = database_path('database.sqlite');

        /** @var array<string, array<string, mixed>> $connections */
        $connections = config('database.connections', []);
        foreach (array_keys($connections) as $connection) {
            if (config("database.connections.{$connection}.driver") !== 'sqlite') {
                continue;
            }

            $this->app['config']->set("database.connections.{$connection}.database", $database);
            DB::purge($connection);
        }

        config(['auth.providers.users.model' => User::class]);
    }

    /**
     * @return array<int, class-string>
     */
    protected function getPackageProviders(Application $app): array
    {
        return [
            ...parent::getPackageProviders($app),
            UserServiceProvider::class,
            LangServiceProvider::class,
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function assertDatabaseHasRow(string $table, array $data, ?string $connection = null): void
    {
        $this->assertDatabaseHas($table, $data, $connection ?? 'lang');
    }

    /**
     * @param  class-string<\Throwable>  $exceptionClass
     */
    public function expectApplicationException(string $exceptionClass, ?string $message = null): void
    {
        $this->expectException($exceptionClass);
        if ($message !== null) {
            $this->expectThrowableMessage($message);
        }
    }

    /**
     * Istanza tipizzata del provider Lang per i test unitari.
     *
     * SSoT del gate PHPStan: i test chiamano questo metodo (FQCN) o il wrapper
     * globale in `tests/Pest.php`. Non ridefinire `makeLangServiceProvider()`
     * dentro un file test — pest-plugin non la risolve (`function.notFound`).
     */
    public static function makeLangServiceProvider(): LangServiceProvider
    {
        return new LangServiceProvider(app());
    }

    /**
     * Scrive un file di traduzione PHP, creando la directory se manca.
     *
     * I test la usano per preparare un file esistente prima di verificare come
     * lo trattano le action di scrittura. Il tipo e' `array<string, mixed>`
     * perche' i file di traduzione reali sono annidati (auth.failed, ...).
     *
     * @param  array<string, mixed>  $data
     */
    public static function createTranslationFile(string $path, array $data): void
    {
        $directory = \dirname($path);

        if (! is_dir($directory)) {
            mkdir($directory, 0o755, true);
        }

        file_put_contents($path, '<?php'.PHP_EOL.PHP_EOL.'return '.var_export($data, true).';'.PHP_EOL);
    }

    /**
     * Registra nel container l'implementazione reale di SaveTransAction.
     *
     * Serve ai test che vogliono verificare la scrittura vera su file: senza
     * questa riga il container puo' ancora avere il mock lasciato da un test
     * precedente dello stesso processo, e l'asserzione verificherebbe il mock.
     */
    public static function bindRealSaveTransAction(): void
    {
        app()->instance(SaveTransAction::class, new SaveTransAction);
    }

    /**
     * Rimuove l'override di SaveTransAction dal container.
     *
     * Si chiamava `restoreSaveTransActionNoOp()`, ma il nome descriveva un
     * meccanismo che non e' mai esistito: nessun bootstrap registra una versione
     * no-op da ripristinare. Quello che i test fanno davvero, nel `finally`, e'
     * togliere l'istanza forzata da {@see bindRealSaveTransAction()} perche' il
     * test successivo riparta dalla risoluzione normale.
     */
    public static function forgetSaveTransActionOverride(): void
    {
        app()->forgetInstance(SaveTransAction::class);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public static function createTranslation(array $attributes = []): Translation
    {
        return TranslationFactory::new()->createOne($attributes);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public static function makeTranslation(array $attributes = []): Translation
    {
        $translation = TranslationFactory::new()->make($attributes);
        if (! $translation instanceof Translation) {
            throw new \InvalidArgumentException('Expected Translation model from factory make().');
        }

        return $translation;
    }

    public static function cleanupTranslationFile(string $filePath): void
    {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function langAssertDatabaseHasRow(string $table, array $data, ?string $connection = 'lang'): void
    {
        $query = DB::connection($connection)->table($table);

        foreach ($data as $column => $value) {
            $query->where((string) $column, $value);
        }

        Assert::assertTrue($query->exists());
    }

    public static function makeLangBaseModel(): BaseModel
    {
        return new class extends BaseModel
        {
            protected $table = 'test_lang_table';
        };
    }

    /** @return array<string, mixed> */
    public static function defaultReadTranslationTestData(): array
    {
        return [
            'auth' => [
                'failed' => 'These credentials do not match our records.',
                'password' => 'The provided password is incorrect.',
            ],
            'pagination' => [
                'previous' => '&laquo; Previous',
                'next' => 'Next &raquo;',
            ],
        ];
    }

    public static function readTranslationTestFilePath(): string
    {
        return sys_get_temp_dir().'/test_translations.php';
    }

    public static function makeReadTranslationFileAction(): ReadTranslationFileAction
    {
        return new ReadTranslationFileAction;
    }
}
