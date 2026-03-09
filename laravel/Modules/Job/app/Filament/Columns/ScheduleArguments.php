<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Columns;

use Filament\Tables\Columns\TextColumn;
use Webmozart\Assert\Assert;

class ScheduleArguments extends TextColumn
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
     */
    protected function formatArrayTags(array $tags): array
    {
        $collection = collect($tags);

        if ($this->withValue) {
            $collection = $collection->filter(
                static function (mixed $value): bool {
                    if (! is_array($value)) {
                        return false;
                    }

                    return array_key_exists('value', $value) && $value['value'] !== null && $value['value'] !== '';
                },
            );
        }

        return $collection
            ->map(
                function (mixed $value, int|string $key): string {
                    if ($this->withValue && is_array($value)) {
                        $name = isset($value['name']) && is_string($value['name'])
                            ? $value['name']
                            : (string) $key;
                        $val = isset($value['value']) ? (string) $value['value'] : '';

                        return $name.'='.$val;
                    }

                    return (string) $key.'='.(string) $value;
                },
            )
            ->values()
            ->all();
    }

    /**
     * Filter out empty tags from the array.
     */
    protected function filterEmptyTags(array $tags): array
    {
        if (count($tags) === 1 && blank($tags[0])) {
            return [];
        }

        return $tags;
    }
}
