<?php

declare(strict_types=1);

namespace Modules\User\Datas;

use Spatie\LaravelData\Data;

final class SocialiteEmailDomainAnalysisData extends Data
{
    public function __construct(
        public bool $hasFirstPartyDomain,
        public bool $hasClientDomain,
    ) {}

    public function hasUnrecognizedDomain(): bool
    {
        return ! $this->hasFirstPartyDomain && ! $this->hasClientDomain;
    }
}
