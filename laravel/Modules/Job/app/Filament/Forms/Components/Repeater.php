<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Forms\Components;

use Modules\Xot\Filament\Forms\Components\XotBaseRepeater;
use Webmozart\Assert\Assert;

class Repeater extends XotBaseRepeater
{
    public function getItemLabel(string $uuid, ?int $index = null): ?string
    {
        $container = $this->getChildSchema($uuid);
        if ($container === null) {
            return null;
        }

        $res = $this->evaluate($this->itemLabel, [
            'state' => $container->getRawState(),
            'uuid' => $uuid,
        ]);
        Assert::nullOrString($res);

        return $res;
    }
}
