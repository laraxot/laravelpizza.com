<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Cast;

use Spatie\QueueableAction\QueueableAction;

/**
 * Converte valori primitivi in stringhe scalari (risposte API / prediction draft).
 */
final class ScalarCasterAction
{
    use QueueableAction;

    public function execute(mixed $value, string $default = ''): string
    {
        return $this->handle($value, $default);
    }

    public function handle(mixed $value, string $default = ''): string
    {
        if ($value === null) {
            return $default;
        }

        return is_scalar($value) ? (string) $value : $default;
    }

    public static function string(mixed $value, string $default = ''): string
    {
        return app(self::class)->execute($value, $default);
    }

    public function nullableString(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $scalar = $this->scalarCheck($value);

        return $scalar === '' ? null : $scalar;
    }

    /**
     * @return list<string>
     */
    public function stringList(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        $out = [];
        foreach ($value as $tag) {
            $scalar = $this->scalarCheck($tag);
            if ($scalar !== '') {
                $out[] = $scalar;
            }
        }

        return $out;
    }

    private function scalarCheck(mixed $value): string
    {
        return is_scalar($value) ? (string) $value : '';
    }
}
