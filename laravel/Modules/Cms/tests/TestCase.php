<?php

declare(strict_types=1);

namespace Modules\Cms\Tests;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\User\Models\User;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase as RootTestCase;

use function Safe\file_get_contents;
use function Safe\json_decode;

/**
 * TestCase base per il modulo Cms.
 */
abstract class TestCase extends RootTestCase
{
    public static ?self $currentTest = null;

    protected function setUp(): void
    {
        parent::setUp();
        self::$currentTest = $this;
    }

    protected function tearDown(): void
    {
        self::$currentTest = null;
        parent::tearDown();
    }

    /**
     * @template T of object
     *
     * @param  class-string<T>  $class
     * @return T&MockObject
     */
    public function createPHPUnitMock(string $class): MockObject
    {
        return $this->createMock($class);
    }

    /**
     * Generate a unique email address for testing.
     */
    public static function pestGenerateUniqueEmail(): string
    {
        return 'test-'.Str::uuid().'@example.com';
    }

    /**
     * Create a test user with the given attributes.
     *
     * @param  array<string, mixed>  $attributes
     */
    public static function pestCreateTestUser(array $attributes = []): Authenticatable
    {
        return User::factory()->createOne($attributes);
    }

    /**
     * Email univoca: stessa firma di `XotBaseTestCase::generateUniqueEmail()`, usata dai test Auth.
     */
    protected static function generateUniqueEmail(): string
    {
        return self::pestGenerateUniqueEmail();
    }

    /**
     * @return class-string<Model&UserContract>
     */
    protected static function getUserClass(): string
    {
        return XotData::make()->getUserClass();
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    protected static function createTestUser(array $attributes = []): UserContract
    {
        return User::factory()->createOne($attributes);
    }

    /**
     * Salta il test corrente (stessa firma di `XotBaseTestCase::skipTest()`).
     */
    public function skipTest(string $message = ''): never
    {
        $this->markTestSkipped($message);
    }

    /**
     * Homepage del tenant corrente: il JSON in `database/content/pages` con slug `home`.
     *
     * Il file non ha un nome fisso (`home.json` nei test, `1.json` nelle docs) e il path non
     * dipende dal progetto: lo risolve `GetTenantFilePathAction`. Se il tenant non ha la
     * homepage i test di architettura dei blocchi non hanno oggetto e vengono saltati; un JSON
     * che non rispetta la forma dichiarata qui sotto fa fallire il test.
     *
     * Sta su `TestCase` e non in `tests/PestHelpers.php`: una funzione in un file incluso con
     * `require_once` si perde in un merge, un metodo risolto dal PSR-4 no. Story ROOT-17.10.
     *
     * @return array{id: int|string, slug: string, title: array<string, string>, content_blocks: array<string, list<array{type: string, data: array<string, mixed>}>>}
     */
    public static function homepageJsonForBlocksArchitecture(): array
    {
        $dir = dirname(app(GetTenantFilePathAction::class)->execute('database/content/pages/home.json'));
        $homepage = null;

        if (is_dir($dir)) {
            foreach (File::files($dir) as $file) {
                $decoded = $file->getExtension() === 'json' ? json_decode(file_get_contents($file->getPathname()), true) : null;
                if (is_array($decoded) && 'home' === ($decoded['slug'] ?? null)) {
                    $homepage = $decoded;
                    break;
                }
            }
        }

        if ($homepage === null) {
            Assert::markTestSkipped('No homepage JSON (slug "home") in '.$dir.' for the current tenant.');
        }

        $id = $homepage['id'] ?? null;
        $contentBlocks = $homepage['content_blocks'] ?? null;
        if ((! is_int($id) && ! is_string($id)) || ! is_array($contentBlocks)) {
            Assert::fail('Homepage JSON must have "id" (int|string) and "content_blocks" (object keyed by locale).');
        }

        return [
            'id' => $id,
            'slug' => 'home',
            'title' => self::stringMap($homepage['title'] ?? []),
            'content_blocks' => self::blocksByLocale($contentBlocks),
        ];
    }

    /**
     * Blocchi della homepage per una lingua.
     *
     * @return list<array{type: string, data: array<string, mixed>}>
     */
    public static function homepageBlocksForLocale(string $locale): array
    {
        $blocks = self::homepageJsonForBlocksArchitecture()['content_blocks'][$locale] ?? null;
        if ($blocks === null) {
            Assert::fail('Homepage JSON has no content_blocks for locale "'.$locale.'".');
        }

        return $blocks;
    }

    /**
     * @param  array<mixed>  $contentBlocks
     * @return array<string, list<array{type: string, data: array<string, mixed>}>>
     */
    private static function blocksByLocale(array $contentBlocks): array
    {
        $byLocale = [];
        foreach ($contentBlocks as $locale => $blocks) {
            if (! is_array($blocks)) {
                Assert::fail('Homepage JSON: content_blocks["'.$locale.'"] must be a list of blocks.');
            }

            $parsed = [];
            foreach ($blocks as $block) {
                $type = is_array($block) ? ($block['type'] ?? null) : null;
                $data = is_array($block) ? ($block['data'] ?? null) : null;
                if (! is_string($type) || ! is_array($data)) {
                    Assert::fail('Homepage JSON: every block in "'.$locale.'" must have "type" (string) and "data" (object).');
                }
                $parsed[] = ['type' => $type, 'data' => self::stringKeys($data)];
            }

            $byLocale[(string) $locale] = $parsed;
        }

        return $byLocale;
    }

    /**
     * @return array<string, string>
     */
    private static function stringMap(mixed $value): array
    {
        $items = is_array($value) ? $value : [];
        $map = [];
        foreach ($items as $key => $item) {
            if (! is_string($item)) {
                Assert::fail('Homepage JSON: "title" must map locale to string.');
            }
            $map[(string) $key] = $item;
        }

        return $map;
    }

    /**
     * @param  array<mixed>  $data
     * @return array<string, mixed>
     */
    private static function stringKeys(array $data): array
    {
        $map = [];
        foreach ($data as $key => $item) {
            $map[(string) $key] = $item;
        }

        return $map;
    }
}
