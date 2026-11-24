<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit;

use Illuminate\Support\Facades\File;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\preg_match;

uses(TestCase::class);

/*
 * Laraxot mounts every module config file as <module>.<file>: config/notify.php becomes `notify.notify`.
 * A read of `notify.inbound_token` returns null in the real app, so a test that sets that same wrong key
 * with config([...]) passes while the feature is dead (the inbound webhook answered 401 to everyone).
 */
it('mounts config/notify.php under notify.notify and not under notify', function (): void {
    $mounted = config('notify.notify');

    Assert::assertIsArray($mounted);
    Assert::assertArrayHasKey('inbound_token', $mounted);
    Assert::assertArrayHasKey('mail_dns', $mounted);
    Assert::assertNull(config('notify.inbound_token'));
    Assert::assertNull(config('notify.mail_dns'));
});

it('reads no key of config/notify.php at the wrong depth', function (): void {
    $offenders = [];
    foreach (File::allFiles(dirname(__DIR__, 2).'/app') as $file) {
        if ($file->getExtension() !== 'php') {
            continue;
        }
        if (preg_match("/config\\(\\s*'notify\\.(inbound_token|mail_dns)/", $file->getContents()) === 1) {
            $offenders[] = $file->getRelativePathname();
        }
    }

    Assert::assertSame([], $offenders, 'Use notify.notify.<key>: these files read the wrong depth.');
});
