<?php

declare(strict_types=1);

namespace Modules\Lang\Models\Traits\Mutators;

use Illuminate\Support\Str;

/**
 * Attribute mutators and accessors for the Post model.
 */
trait PostMutators
{
    public function setTitleAttribute(string $value): void
    {
        $this->attributes['title'] = $value;
        $this->attributes['guid'] = Str::slug($value);
    }

    public function getTitleAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }

        $postType = is_string($this->attributes['post_type'] ?? null) ? $this->attributes['post_type'] : '';
        $postId = is_scalar($this->attributes['post_id'] ?? null) ? $this->attributes['post_id'] : '';
        $value = $postType.' '.$postId;
        $this->title = $value;

        if ($this->getKey() !== null) {
            $this->update(['title' => $value]);
        }

        return $value;
    }

    public function getGuidAttribute(?string $value): ?string
    {
        if (is_string($value) && $value !== '' && ! str_contains($value, ' ')) {
            return $value;
        }

        $value = Str::slug($this->title ?? '');
        $this->guid = $value;

        if ($this->getKey() !== null) {
            $this->update(['guid' => $value]);
        }

        return $value;
    }

    public function getTxtAttribute(?string $value): ?string
    {
        return $value ?? '';
    }
}
