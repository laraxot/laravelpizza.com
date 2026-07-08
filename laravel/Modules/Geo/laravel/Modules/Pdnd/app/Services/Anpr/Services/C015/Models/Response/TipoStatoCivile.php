<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C015\Models\Response;

class TipoStatoCivile
{
    public function __construct(
        public readonly ?string $statoCivile = null,
        public readonly ?string $noteStatoCivile = null,
        public readonly ?string $statoCivileND = null
    ) {}

    public function toArray(): array
    {
        $data = [];
        if ($this->statoCivile !== null) $data['statoCivile'] = $this->statoCivile;
        if ($this->noteStatoCivile !== null) $data['noteStatoCivile'] = $this->noteStatoCivile;
        if ($this->statoCivileND !== null) $data['statoCivileND'] = $this->statoCivileND;
        return $data;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            statoCivile: isset($data['statoCivile']) && is_string($data['statoCivile']) ? $data['statoCivile'] : null,
            noteStatoCivile: isset($data['noteStatoCivile']) && is_string($data['noteStatoCivile']) ? $data['noteStatoCivile'] : null,
            statoCivileND: isset($data['statoCivileND']) && is_string($data['statoCivileND']) ? $data['statoCivileND'] : null,
        );
    }
}