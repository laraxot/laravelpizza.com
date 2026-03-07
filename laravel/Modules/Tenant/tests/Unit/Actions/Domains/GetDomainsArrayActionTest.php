<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Domains;

use Illuminate\Filesystem\Filesystem;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Tests\TestCase;

uses(TestCase::class);

it('gets domains array by scanning config directory', function (): void {
    // This test is a bit tricky because recurse() instantiates Filesystem internally
    // and uses config_path().

    $action = new class extends GetDomainsArrayAction
    {
        public function recurse(string $path): array
        {
            return [
                'tenant1' => [],
                'group1' => [
                    'tenant2' => [],
                ],
            ];
        }
    };

    $result = $action->execute();

    expect($result)->toBeArray()
        ->toHaveCount(2)
        ->and($result)->toContain(['id' => 'tenant1', 'name' => 'tenant1'])
        ->and($result)->toContain(['id' => 'tenant2.group1', 'name' => 'tenant2.group1']);
});

it('collapses nested directory structure into dot notation', function (): void {
    $action = app(GetDomainsArrayAction::class);
    $data = [
        'a' => [
            'b' => [
                'c' => [],
            ],
            'd' => [],
        ],
        'e' => [],
    ];

    $result = $action->collapse($data);

    expect($result)->toBeArray()
        ->toHaveCount(3)
        ->and($result)->toContain('c.b.a')
        ->and($result)->toContain('d.a')
        ->and($result)->toContain('e');
});
