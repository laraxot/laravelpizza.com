<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Tables\Columns;

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
    /**
     * @param  array<int|string, mixed>  $tags
     * @return array<int, string>
     */
    protected function formatArrayTags(array $tags): array
    {
        $result = [];

        foreach ($tags as $key => $value) {
            $keyStr = (string) $key;

            if (! $this->withValue) {
                $valStr = is_scalar($value) ? (string) $value : '';
                $result[] = $keyStr.'='.$valStr;

                continue;
            }

            if (is_array($value)) {
                $name = isset($value['name']) && is_scalar($value['name']) ? (string) $value['name'] : $keyStr;
                $val = isset($value['value']) && is_scalar($value['value']) ? (string) $value['value'] : '';
                $result[] = $name.'='.$val;

                continue;
            }

            $valStr = is_scalar($value) ? (string) $value : '';
            $result[] = $keyStr.'='.$valStr;
        }

        return $result;
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
