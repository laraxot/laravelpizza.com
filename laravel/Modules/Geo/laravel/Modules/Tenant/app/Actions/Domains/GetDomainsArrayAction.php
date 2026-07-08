<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Domains;

// use Illuminate\Support\Facades\File;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

class GetDomainsArrayAction
{
    use QueueableAction;

    /**
     * @return array<int, array{id: string, name: string}>
     */
    public function execute(): array
    {
        $res = $this->recurse(config_path());
        /** @var array<string, mixed> $res */
        $res1 = $this->collapse($res);

        $mapped = [];
        foreach ($res1 as $value) {
            $mapped[] = [
                'id' => $value,
                'name' => $value,
            ];
        }

        return $mapped;
    }

    /**
     * @return array<string, mixed>
     */
    public function recurse(string $path): array
    {
        $filesystem = new Filesystem();
        $directories = $filesystem->directories($path);
        $res = [];
        foreach ($directories as $dir) {
            // Type narrowing: directories() returns array but items are mixed
            if (! is_string($dir)) {
                continue;
            }
            $name = Str::after($dir, $path.'/');
            if (\in_array($name, ['lang'], true)) {
                continue;
            }
            $res[$name] = $this->recurse($dir);
        }

        return $res;
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return array<int, string>
     */
    public function collapse(array $data, string $keyPrefix = ''): array
    {
        $res = [];
        foreach ($data as $k0 => $v0) {
            $newkey = $keyPrefix === '' ? $k0 : ($k0.'.'.$keyPrefix);
            if ($v0 === []) {
                $res[] = $newkey;
            }

            // Type narrowing: $v0 is mixed from array
            if (is_array($v0)) {
                /** @var array<string, mixed> $nested */
                $nested = $v0;
                $res = array_merge($res, $this->collapse($nested, $newkey));
            }
        }

        return $res;
    }
}
