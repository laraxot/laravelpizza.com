<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Socialite;

use Illuminate\Support\ViewErrorBag;
use PHPUnit\Framework\Assert;

final class NotConfiguredErrorProbe
{
    public static function message(): string
    {
        $bag = session('errors');
        Assert::assertInstanceOf(ViewErrorBag::class, $bag);
        $message = $bag->getBag('default')->first('email');
        Assert::assertIsString($message);

        return $message;
    }
}
