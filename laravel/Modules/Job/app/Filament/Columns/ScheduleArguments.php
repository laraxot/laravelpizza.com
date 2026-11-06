<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Columns;

use Illuminate\Support\Collection;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Filament\Tables\Columns\XotBaseTextColumn;
use Webmozart\Assert\Assert;

class ScheduleArguments extends XotBaseTextColumn
{
    protected string $view = 'job::filament.columns.schedule-arguments';

    protected bool $withValue = true;

    /**
     * Set whether to include values in the output.
     */
    public function withValue(bool $withValue = true): static
    {
        $this->withValue = $withValue;

        return $this;
    }

    /**
     * Get the tags as an array.
     *
     * @return array<int, string>
     */
    public function getTags(): array
    {
        $tags = $this->getState();

        if (is_array($tags)) {
            return $this->formatArrayTags($tags);
        }

        $separator = $this->getSeparator();

        if (empty($separator)) {
            return [];
        }

        Assert::string($tags, 'Expected tags to be a string.');

        $tagsArray = explode($separator, $tags);

        return $this->filterEmptyTags($tagsArray);
    }

    /**
     * Format tags when they are in array format.
     *
     * @param  array<int|string, mixed>  $tags
     * @return array<int, string>
     */
    protected function formatArrayTags(array $tags): array
    {
        /** @var Collection<int|string, array<array-key, mixed>|bool|float|int|string|null> $collection */
        $collection = collect($tags);

        if ($this->withValue) {
            $collection = $collection->filter(
                static function (array|bool|float|int|string|null $value): bool {
                    if (! is_array($value)) {
                        return false;
                    }

                    return array_key_exists('value', $value) && $value['value'] !== null && $value['value'] !== '';
                },
            );
        }

        return $collection
            ->map(
                function (array|bool|float|int|string|null $value, int|string $key): string {
                    if ($this->withValue && is_array($value)) {
                        $name = isset($value['name']) && is_string($value['name'])
                            ? $value['name']
                            : (string) $key;
                        $val = isset($value['value']) ? SafeStringCastAction::cast($value['value']) : '';

                        return $name.'='.$val;
                    }

                    return (string) $key.'='.SafeStringCastAction::cast($value);
                },
            )
            ->values()
            ->all();
    }

    /**
     * Filter out empty tags from the array.
     *
     * @param  array<int, string>  $tags
     * @return array<int, string>
     */
    protected function filterEmptyTags(array $tags): array
    {
        if (count($tags) === 1 && blank($tags[0])) {
            return [];
        }

        return $tags;
    }
}
