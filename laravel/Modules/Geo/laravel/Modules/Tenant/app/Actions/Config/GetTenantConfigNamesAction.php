<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Config;

use Illuminate\Support\Facades\File;
use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Xot\Actions\File\FixPathAction;
use Spatie\QueueableAction\QueueableAction;

class GetTenantConfigNamesAction
{
    use QueueableAction;

    /**
     * @return array<int, array{id:int,name:string}>
     */
    public function execute(): array
    {
        $name = app(GetTenantNameAction::class)->execute();

        $dir = config_path($name);
        $dir = app(FixPathAction::class)->execute($dir);

        $files = File::files($dir);

        return collect($files)
            ->filter(static fn ($item): bool => $item->getExtension() === 'php')
            ->map(static fn ($item, $k): array => [
                'id' => $k + 1,
                'name' => $item->getFilenameWithoutExtension(),
            ])
            ->values()
            ->all();
    }
}
