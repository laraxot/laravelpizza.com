<?php

declare(strict_types=1);
use Modules\Xot\Actions\String\GetPronounceablePasswordAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('rispetta la lunghezza richiesta e le categorie di caratteri', function (int $length): void {
    $password = (new GetPronounceablePasswordAction)->execute($length);

    Assert::assertSame(max(5, $length), strlen($password));
    Assert::assertMatchesRegularExpression('/[a-z]/', $password);
    Assert::assertMatchesRegularExpression('/[A-Z]/', $password);
    Assert::assertMatchesRegularExpression('/[0-9]/', $password);
    Assert::assertMatchesRegularExpression('/[!#*_=+:?\-]/', $password);
    Assert::assertMatchesRegularExpression('/\A[a-zA-Z0-9!#*_=+:?\-]+\z/', $password);
})->with([-1, 0, 2, 4, 5, 6, 8, 12, 16, 64]);

it('genera dodici caratteri per impostazione predefinita', function (): void {
    Assert::assertSame(12, strlen((new GetPronounceablePasswordAction)->execute()));
});
