<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Fields;

use Filament\Forms\Components\Repeater as ComponentsRepeater;
use Webmozart\Assert\Assert;

class Repeater extends ComponentsRepeater
{
    public function getItemLabel(string $uuid): ?string
    {
        $container = // @var mixed getChildSchema($uuid;
        if ($container === null) {
            return null;
        }

        $res = // @var mixed evaluate($this->itemLabel, [
            'state' => $container->getRawState(),
            'uuid' => $uuid,
        ]);
        Assert::nullOrString($res);

        return $res;
    }
}
