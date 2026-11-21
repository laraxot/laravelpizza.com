<?php

declare(strict_types=1);

use App\Support\FeatureFlags;
use Modules\Xot\Tests\XotBaseTestCase;
use PHPUnit\Framework\Assert;

/*
 * The feature registry lives in config/features.php with FLAT dot-notation keys
 * ('notifications.email.enabled' => true), not nested arrays. Every assertion here
 * pins that contract: reading a flag must go through the whole registry, because
 * config('features.notifications.email.enabled') walks the key segment by segment
 * and returns null.
 *
 * XotBaseTestCase boots the application without DatabaseTransactions: these tests
 * only need the config repository, never the database.
 *
 * App\Support\FeatureFlags exists only in host apps that ship the full skeleton
 * (ptvx, predict, ...). Slim hosts (restaurant, techplanner, ...) do not provide
 * it, so every test skips itself when the class is absent instead of failing.
 * Assert::assertIs* narrows FeatureFlags::get() (mixed) and pins return contracts;
 * prefer Assert over Pest expect() to avoid argument.templateType su PHPStan max.
 */

uses(XotBaseTestCase::class);

beforeEach(function (): void {
    config()->set('features', [
        'notifications.email.enabled' => true,
        'notifications.sms.enabled' => false,
        'notifications.slack.enabled' => true,
        'cache.store' => 'redis',
        'cache.ttl' => 3600,
        'pdnd.client_id' => null,
    ]);
});

describe('FeatureFlags::get', function (): void {
    it('reads a flat dot-notation key from the registry', function (): void {
        if (! class_exists(FeatureFlags::class)) {
            $this->markTestSkipped('Host app senza App\Support\FeatureFlags.');
        }

        $store = FeatureFlags::get('cache.store');
        $ttl = FeatureFlags::get('cache.ttl');
        Assert::assertIsString($store);
        Assert::assertIsInt($ttl);

        Assert::assertSame('redis', $store);
        Assert::assertSame(3600, $ttl);
    });

    it('returns the registered value even when it is null', function (): void {
        if (! class_exists(FeatureFlags::class)) {
            $this->markTestSkipped('Host app senza App\Support\FeatureFlags.');
        }

        $value = FeatureFlags::get('pdnd.client_id', 'fallback');

        Assert::assertNull($value);
    });

    it('falls back to the default for an unknown key', function (): void {
        if (! class_exists(FeatureFlags::class)) {
            $this->markTestSkipped('Host app senza App\Support\FeatureFlags.');
        }

        $withDefault = FeatureFlags::get('does.not.exist', 'fallback');
        $withoutDefault = FeatureFlags::get('does.not.exist');
        Assert::assertIsString($withDefault);
        Assert::assertNull($withoutDefault);

        Assert::assertSame('fallback', $withDefault);
    });

    it('does not resolve a key as a nested config path', function (): void {
        if (! class_exists(FeatureFlags::class)) {
            $this->markTestSkipped('Host app senza App\Support\FeatureFlags.');
        }

        $nested = config('features.cache.store');
        $store = FeatureFlags::get('cache.store');
        Assert::assertNull($nested);
        Assert::assertIsString($store);

        Assert::assertSame('redis', $store);
    });
});

describe('FeatureFlags::isEnabled', function (): void {
    it('coerces the registered value to bool', function (): void {
        if (! class_exists(FeatureFlags::class)) {
            $this->markTestSkipped('Host app senza App\Support\FeatureFlags.');
        }

        $email = FeatureFlags::isEnabled('notifications.email.enabled');
        $sms = FeatureFlags::isEnabled('notifications.sms.enabled');
        Assert::assertIsBool($email);
        Assert::assertIsBool($sms);

        Assert::assertTrue($email);
        Assert::assertFalse($sms);
    });

    it('uses the default when the key is absent', function (): void {
        if (! class_exists(FeatureFlags::class)) {
            $this->markTestSkipped('Host app senza App\Support\FeatureFlags.');
        }

        $missing = FeatureFlags::isEnabled('missing.flag');
        $missingWithDefault = FeatureFlags::isEnabled('missing.flag', true);
        Assert::assertIsBool($missing);
        Assert::assertIsBool($missingWithDefault);

        Assert::assertFalse($missing);
        Assert::assertTrue($missingWithDefault);
    });
});

describe('FeatureFlags::isAnyEnabled', function (): void {
    it('is true when at least one flag of the group is on', function (): void {
        if (! class_exists(FeatureFlags::class)) {
            $this->markTestSkipped('Host app senza App\Support\FeatureFlags.');
        }

        $any = FeatureFlags::isAnyEnabled('notifications');
        Assert::assertIsBool($any);

        Assert::assertTrue($any);
    });

    it('is false when the group has no enabled flag', function (): void {
        if (! class_exists(FeatureFlags::class)) {
            $this->markTestSkipped('Host app senza App\Support\FeatureFlags.');
        }

        config()->set('features', [
            'notifications.email.enabled' => false,
            'notifications.sms.enabled' => false,
        ]);

        $any = FeatureFlags::isAnyEnabled('notifications');
        Assert::assertIsBool($any);

        Assert::assertFalse($any);
    });

    it('is false for an unknown group', function (): void {
        if (! class_exists(FeatureFlags::class)) {
            $this->markTestSkipped('Host app senza App\Support\FeatureFlags.');
        }

        $any = FeatureFlags::isAnyEnabled('telepathy');
        Assert::assertIsBool($any);

        Assert::assertFalse($any);
    });
});

describe('FeatureFlags::listEnabled', function (): void {
    it('lists only the enabled features of the group, without prefix or suffix', function (): void {
        if (! class_exists(FeatureFlags::class)) {
            $this->markTestSkipped('Host app senza App\Support\FeatureFlags.');
        }

        $enabled = FeatureFlags::listEnabled('notifications');
        Assert::assertIsArray($enabled);

        Assert::assertSame(['email', 'slack'], $enabled);
    });

    it('returns an empty list for an unknown group', function (): void {
        if (! class_exists(FeatureFlags::class)) {
            $this->markTestSkipped('Host app senza App\Support\FeatureFlags.');
        }

        $enabled = FeatureFlags::listEnabled('telepathy');
        Assert::assertIsArray($enabled);

        Assert::assertSame([], $enabled);
    });

    it('ignores keys of the group that are not .enabled flags', function (): void {
        if (! class_exists(FeatureFlags::class)) {
            $this->markTestSkipped('Host app senza App\Support\FeatureFlags.');
        }

        $enabled = FeatureFlags::listEnabled('cache');
        Assert::assertIsArray($enabled);

        Assert::assertSame([], $enabled);
    });
});

describe('FeatureFlags::all', function (): void {
    it('returns the whole registry', function (): void {
        if (! class_exists(FeatureFlags::class)) {
            $this->markTestSkipped('Host app senza App\Support\FeatureFlags.');
        }

        $all = FeatureFlags::all();
        Assert::assertIsArray($all);

        Assert::assertArrayHasKey('cache.store', $all);
        Assert::assertSame('redis', $all['cache.store']);
        Assert::assertCount(6, $all);
    });

    it('returns an empty registry when the config is not an array', function (): void {
        if (! class_exists(FeatureFlags::class)) {
            $this->markTestSkipped('Host app senza App\Support\FeatureFlags.');
        }

        config()->set('features', 'not-an-array');

        $all = FeatureFlags::all();
        Assert::assertIsArray($all);

        Assert::assertSame([], $all);
    });

    it('drops non-string keys', function (): void {
        if (! class_exists(FeatureFlags::class)) {
            $this->markTestSkipped('Host app senza App\Support\FeatureFlags.');
        }

        config()->set('features', [
            0 => 'positional',
            'cache.store' => 'file',
        ]);

        $all = FeatureFlags::all();
        Assert::assertIsArray($all);

        Assert::assertSame(['cache.store' => 'file'], $all);
    });
});

/*
 * app/Helpers/features.php declares feature(), feature_enabled() and
 * features_enabled(), but the file is not in composer.json `autoload.files`
 * (autoload is psr-4 only) and no call site exists in app/ or Modules/: those
 * three functions are undefined at runtime. Not tested here on purpose — the
 * rule is to fix the test when it looks for an API that does not exist, not to
 * invent the wiring that would make it exist.
 */
