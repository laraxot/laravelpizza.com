<?php

declare(strict_types=1);

namespace Modules\Notify\Models\Traits;

trait NotifyThemeMutators
{
    /**
     * @param  array<string, int>  $value
     * @return array<string, int|string>
     */
    public function getLogoAttribute(?array $value): array
    {
        return $this->getLogo();
    }

    /**
     * @return array<string, int|string>
     */
    public function getLogo(): array
    {
        return [
            // 'path' => asset(strval($this->logo_src)),
            'path' => url($this->getFirstMediaUrl()),
            'width' => (int) ($this->logo_width ?? 50),
            'height' => (int) ($this->logo_height ?? 50)];
    }
}
