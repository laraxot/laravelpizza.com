<?php

declare(strict_types=1);

namespace Modules\Cms\Actions\Module;

use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\File\FixPathAction;
use Nwidart\Modules\Laravel\Module;

use function Safe\realpath;

use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\Finder\SplFileInfo;

final class FixJigSawByModuleAction
{
    use QueueableAction;

    /**
     * @return list<string>
     */
    public function execute(Module $module): array
    {
        $res = [];
        $stubs_dir = realpath(__DIR__.'/../../Console/Commands/stubs/docs');
        // if ($stubs_dir === false) {
        //    throw new Exception('['.__LINE__.']['.__FILE__.']');
        // }

        $stubs = File::allFiles($stubs_dir);
        foreach ($stubs as $stub) {
            if (! $stub->isFile()) {
                continue;
            }

            if ('stub' !== $stub->getExtension()) {
                continue;
            }

            $res[] = $this->publish($stub, $module);
        }

        return $res;
    }

    public function publish(SplFileInfo $stub, Module $module): string
    {
        $filename = str_replace('.stub', '', $stub->getRelativePathname());
        $file_path = $module->getPath().'/docs/'.$filename;
        $file_path = app(FixPathAction::class)->execute($file_path);
        /*
         * //mkdir(): Permission denied
         * if (! is_dir(dirname($file_path))) {
         * (new Filesystem())->makeDirectory(dirname($file_path));
         * }
         */

        $replace = [
            'ModuleName' => $module->getName(),
        ];

        $file_content = str_replace(array_keys($replace), array_values($replace), $stub->getContents());
        File::put($file_path, $file_content);

        return $file_path;
    }
}
