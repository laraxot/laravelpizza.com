<?php

declare(strict_types=1);

namespace Modules\Lang\Actions;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\Arr\SaveArrayAction;
use Spatie\QueueableAction\QueueableAction;

class SaveTransAction
{
    use QueueableAction;

    /**
     * Undocumented function.
     */
    public function execute(string $key, int|string|array|Htmlable|null $data): void
    {
        if (str_contains($key, "\0")) {
            return;
        }
        $cont = [];

        $filename = app(GetTransPathAction::class)->execute($key);

        if (! File::exists($filename)) {
            app(SaveArrayAction::class)->execute(
                data: $cont,
                filename: $filename,
            );
        }

        try {
            $cont = File::getRequire($filename);
        } catch (\Exception $e) {
            dddx([
                'key' => $key,
                'data' => $data,
                'filename' => $filename,
                'message' => $e->getMessage(),
            ]);
        }

        if (! is_array($cont)) {
            $cont = [];
        }

        $piece = implode('.', array_slice(explode('.', $key), 1));
        if ($piece !== '') {
            Arr::set($cont, $piece, $data);
        } else {
            $cont = $data;
        }

        if (! is_array($cont)) {
            throw new \Exception('Error in SaveTransAction');
        }

        app(SaveArrayAction::class)->execute(
            data: $cont,
            filename: $filename,
        );
    }
}
