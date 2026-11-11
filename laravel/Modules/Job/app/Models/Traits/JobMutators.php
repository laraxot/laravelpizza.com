<?php

declare(strict_types=1);

namespace Modules\Job\Models\Traits;

use Webmozart\Assert\Assert;

use function Safe\json_decode;

trait JobMutators
{
    public function getDisplayNameAttribute(): ?string
    {
        return $this->getDisplayName();
    }

    public function getDisplayName(): ?string
    {
        Assert::string($json = $this->attributes['payload'], __FILE__.':'.__LINE__.' - '.class_basename(self::class));
        $payload = json_decode($json, true);
        if (! is_array($payload)) {
            return null;
        }

        Assert::nullOrString($res = $payload['displayName'] ?? null);

        return $res;
    }
}
