<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Config;

use Illuminate\Support\Facades\File;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/get-tenant-config-array-action.md
<<<<<<< .merge_file_UNZoNk
 *
=======
>>>>>>> .merge_file_f9S4ri
 * @contract docs/contracts/get-tenant-config-array-action.md
 */
class GetTenantConfigArrayAction
{
    use QueueableAction;

    /**
     * @return array<string, mixed>
     */
    public function execute(string $name): array
    {
        $path = app(GetTenantConfigPathAction::class)->execute($name);

        if (! File::exists($path)) {
            return [];
        }

        $content = File::getRequire($path);

        if (! is_array($content)) {
            return [];
        }

        $result = [];
        foreach ($content as $key => $value) {
            if (is_string($key)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
