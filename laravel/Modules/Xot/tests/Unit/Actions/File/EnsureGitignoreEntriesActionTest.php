<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\File\EnsureGitignoreEntriesAction;
use Modules\Xot\Tests\TestCase;

use function Safe\exec;
use function Safe\symlink;

uses(TestCase::class);

beforeEach(function (): void {
    $this->dir = sys_get_temp_dir().'/xot-gitignore-'.bin2hex(random_bytes(4));
    File::ensureDirectoryExists($this->dir);
});

afterEach(function (): void {
    File::deleteDirectory($this->dir);
});

it('aggiunge le due righe del link (cartella reale e symlink) una sola volta', function (): void {
    $path = $this->dir.'/.gitignore';
    $action = app(EnsureGitignoreEntriesAction::class);

    expect($action->execute($path, 'geo', '# intestazione'))->toBe(['geo/', 'geo'])
        ->and($action->execute($path, 'geo', '# intestazione'))->toBe([])
        ->and($action->execute($path, 'roosko'))->toBe(['roosko/', 'roosko'])
        ->and(File::get($path))->toBe("# intestazione\ngeo/\ngeo\nroosko/\nroosko\n");
});

it('il pattern senza barra fa ignorare a git anche il symlink', function (): void {
    exec('git --version', $out, $code);
    if ($code !== 0) {
        $this->markTestSkipped('git non disponibile');
    }
    $repo = $this->dir;
    File::ensureDirectoryExists($repo.'/laravel/Modules/Geo/public');
    File::ensureDirectoryExists($repo.'/public_html/assets');
    exec('git -C '.escapeshellarg($repo).' init -q');
    symlink('../../laravel/Modules/Geo/public', $repo.'/public_html/assets/geo');
    app(EnsureGitignoreEntriesAction::class)->execute($repo.'/public_html/assets/.gitignore', 'geo');

    exec('git -C '.escapeshellarg($repo).' check-ignore -q public_html/assets/geo', $ignored, $ignoredCode);

    expect($ignoredCode)->toBe(0);
});
