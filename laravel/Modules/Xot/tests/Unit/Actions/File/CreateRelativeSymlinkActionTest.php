<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\File\CreateRelativeSymlinkAction;
use Modules\Xot\Tests\TestCase;

use function Safe\readlink;
use function Safe\symlink;

uses(TestCase::class);

beforeEach(function (): void {
    $this->root = sys_get_temp_dir().'/xot-relative-link-'.bin2hex(random_bytes(4));
    File::ensureDirectoryExists($this->root.'/laravel/Themes/TwentyOne/public');
    File::put($this->root.'/laravel/Themes/TwentyOne/public/manifest.json', '{}');
    File::ensureDirectoryExists($this->root.'/public_html/themes');
});

afterEach(function (): void {
    File::deleteDirectory($this->root);
});

it('crea public_html/themes/<tema> come ../../laravel/Themes/<tema>/public', function (): void {
    $link = $this->root.'/public_html/themes/TwentyOne';
    $source = $this->root.'/laravel/Themes/TwentyOne/public';

    $target = app(CreateRelativeSymlinkAction::class)->execute($source, $link);

    expect($target)->toBe('../../laravel/Themes/TwentyOne/public')
        ->and(readlink($link))->toBe('../../laravel/Themes/TwentyOne/public')
        ->and(is_file($link.'/manifest.json'))->toBeTrue()
        ->and(app(CreateRelativeSymlinkAction::class)->isRelativeLinkTo($link, $source))->toBeTrue();
});

it('il link relativo funziona anche dopo aver spostato il progetto', function (): void {
    app(CreateRelativeSymlinkAction::class)->execute(
        $this->root.'/laravel/Themes/TwentyOne/public',
        $this->root.'/public_html/themes/TwentyOne',
    );
    $moved = $this->root.'-spostato';
    File::moveDirectory($this->root, $moved);
    $this->root = $moved;

    expect(is_file($moved.'/public_html/themes/TwentyOne/manifest.json'))->toBeTrue();
});

it('un link assoluto alla stessa cartella non conta come relativo', function (): void {
    $link = $this->root.'/public_html/themes/TwentyOne';
    $source = $this->root.'/laravel/Themes/TwentyOne/public';
    symlink($source, $link);

    expect(app(CreateRelativeSymlinkAction::class)->isRelativeLinkTo($link, $source))->toBeFalse();
});
