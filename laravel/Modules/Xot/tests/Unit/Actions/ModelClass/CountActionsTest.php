<?php

declare(strict_types=1);
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Mockery\MockInterface;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Xot\Actions\ModelClass\CountAction;
use Modules\Xot\Actions\ModelClass\UpdateCountAction;
use Modules\Xot\Tests\Fixtures\Models\TestConcreteXotBaseModel;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('count actions work', function (): void {
    $modelClass = TestConcreteXotBaseModel::class;
    $tenantDir = sys_get_temp_dir().'/xot-count-actions-'.uniqid('', true);
    File::makeDirectory($tenantDir.'/database/content', 0755, true);

    /** @var GetTenantFilePathAction&MockInterface $tenantPath */
    $tenantPath = Mockery::mock(GetTenantFilePathAction::class);
    $tenantPath->shouldReceive('execute')
        ->andReturnUsing(fn (string $relative): string => $tenantDir.'/'.$relative);
    app()->instance(GetTenantFilePathAction::class, $tenantPath);

    Schema::dropIfExists('test_xot_table');
    Schema::create('test_xot_table', function (Blueprint $table): void {
        $table->id();
    });

    try {
        Assert::assertSame(0, app(CountAction::class)->execute($modelClass));

        app(UpdateCountAction::class)->execute($modelClass, 10);
        Assert::assertSame(10, app(CountAction::class)->execute($modelClass));
    } finally {
        Schema::dropIfExists('test_xot_table');
        File::deleteDirectory($tenantDir);
    }
});
