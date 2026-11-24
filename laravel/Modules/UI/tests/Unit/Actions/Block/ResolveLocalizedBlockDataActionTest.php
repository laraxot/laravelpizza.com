<?php

declare(strict_types=1);

use Modules\UI\Actions\Block\ResolveLocalizedBlockDataAction;
use Modules\UI\Tests\TestCase;

use function Safe\file_get_contents;
use function Safe\preg_match;

uses(TestCase::class);

/*
 * Contratto: docs/contracts/resolve-localized-block-data-action.md
 * ADR: docs/adr/optional-cms-delegation-for-block-data.md
 * Il resolver di Cms viene sostituito nel container: il test prova la delega, non la localizzazione di Cms.
 */

const UI_CMS_BLOCK_RESOLVER = 'Modules\Cms\Actions\ResolveLocalizedBlockDataAction';

afterEach(function (): void {
    app()->forgetInstance(UI_CMS_BLOCK_RESOLVER);
});

it('hands the block data to the Cms resolver and returns what it resolves', function (): void {
    app()->instance(UI_CMS_BLOCK_RESOLVER, new class()
    {
        /**
         * @param  array<string, mixed>  $data
         * @return array<string, mixed>
         */
        public function execute(array $data): array
        {
            return [...$data, 'url' => '/it/resolved'];
        }
    });

    $resolved = app(ResolveLocalizedBlockDataAction::class)->execute(['title' => 'Ciao', 'url' => '/raw']);

    expect($resolved)->toBe(['title' => 'Ciao', 'url' => '/it/resolved']);
})->group('UI-BLOCKDATA-INV-1');

it('returns the input untouched when the resolver has no execute or returns a non array', function (object $resolver): void {
    app()->instance(UI_CMS_BLOCK_RESOLVER, $resolver);

    expect(app(ResolveLocalizedBlockDataAction::class)->execute(['title' => 'Ciao']))->toBe(['title' => 'Ciao']);
})->with([
    'no execute' => fn (): object => new class() {},
    'non array result' => fn (): object => new class()
    {
        /** @param  array<string, mixed>  $data */
        public function execute(array $data): string
        {
            return 'not an array';
        }
    },
])->group('UI-BLOCKDATA-INV-2');

it('refuses resolved data with non string keys', function (): void {
    app()->instance(UI_CMS_BLOCK_RESOLVER, new class()
    {
        /**
         * @param  array<string, mixed>  $data
         * @return array<int, string>
         */
        public function execute(array $data): array
        {
            return ['first'];
        }
    });

    expect(fn (): array => app(ResolveLocalizedBlockDataAction::class)->execute(['title' => 'Ciao']))
        ->toThrow(UnexpectedValueException::class);
})->group('UI-BLOCKDATA-INV-3');

it('never imports a Cms class in UI code: Cms is reached only by class name string', function (): void {
    $offenders = [];
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(dirname(__DIR__, 4).'/app', FilesystemIterator::SKIP_DOTS));
    foreach ($files as $file) {
        if ($file instanceof SplFileInfo && $file->getExtension() === 'php'
            && preg_match('/^use\s+Modules\\\\Cms\\\\/m', file_get_contents($file->getPathname())) === 1) {
            $offenders[] = $file->getPathname();
        }
    }

    expect($offenders)->toBe([]);
})->group('UI-BLOCKDATA-INV-4');
