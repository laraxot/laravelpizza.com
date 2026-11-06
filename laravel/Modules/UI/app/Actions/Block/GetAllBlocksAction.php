<?php

declare(strict_types=1);

namespace Modules\UI\Actions\Block;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Xot\Actions\File\GetClassNameByPathAction;
use Modules\Xot\Datas\ComponentFileData;
use Spatie\LaravelData\DataCollection;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

use function Safe\realpath;

final class GetAllBlocksAction
{
    use QueueableAction;

    /**
     * @return DataCollection<int, ComponentFileData>
     */
    public function execute(): DataCollection
    {
        Assert::string($relativePath = config('modules.paths.generator.model.path'));

        $files = File::glob(base_path('Modules').'/*/'.$relativePath.'/../Filament/Blocks/*.php');

        /** @var list<string> $files */
        $files = is_array($files) ? array_values($files) : [];

        /** @var array<int, array{name: string, class: class-string, module: string, path: string|false}> $blocks */
        $blocks = Arr::map($files, function (string $path): array {
            $path = realpath($path);
            $class = app(GetClassNameByPathAction::class)->execute($path);

            $name = Str::of(class_basename($class))->snake()->toString();
            if (Str::endsWith($name, '_block')) {
                $name = Str::before($name, '_block');
            }

            $module = Str::of($class)->between('Modules\\', '\Filament\\')->toString();

            return [
                'name' => $name,
                'class' => $class,
                'module' => $module,
                'path' => $path,
            ];
        });

        return ComponentFileData::collection(array_values($blocks));
    }
}
