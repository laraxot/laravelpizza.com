<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Modules\Seo\Actions\Robots\BuildRobotsTxtAction;
use Modules\Seo\Tests\TestCase;

uses(TestCase::class);

/*
 * robots.txt va servito come file statico: con la configurazione nginx di serie la rotta risponde 404 e Google
 * ignora il file. Il comando scrive lo stesso contenuto della rotta.
 */
it('writes the same robots.txt the route serves', function (): void {
    $path = sys_get_temp_dir().'/robots-'.uniqid().'.txt';

    expect(Artisan::call('seo:robots', ['--path' => $path]))->toBe(0);

    expect(File::get($path))
        ->toBe(app(BuildRobotsTxtAction::class)->execute())
        ->toContain('Sitemap: ')
        ->toContain('Disallow: /*/admin');

    File::delete($path);
});

it('only prints the content with --dry-run', function (): void {
    $path = sys_get_temp_dir().'/robots-'.uniqid().'.txt';

    expect(Artisan::call('seo:robots', ['--path' => $path, '--dry-run' => true]))->toBe(0);

    expect(File::exists($path))->toBeFalse();
});
