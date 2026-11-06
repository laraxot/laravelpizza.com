<?php

declare(strict_types=1);

use Modules\User\Http\Controllers\Socialite\RedirectToProviderController;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;
use ReflectionMethod;

uses(TestCase::class);

/**
 * Contratto: con URI {lang}/auth/login/{provider} i controller devono dichiarare
 * $lang e $provider, altrimenti Laravel lega "it" a $provider.
 */
test('RedirectToProviderController declares lang before provider', function (): void {
    $method = new ReflectionMethod(RedirectToProviderController::class, '__invoke');
    $names = array_map(static fn (\ReflectionParameter $p) => $p->getName(), $method->getParameters());

    Assert::assertContains('lang', $names);
    Assert::assertContains('provider', $names);

    $langPos = array_search('lang', $names, true);
    $providerPos = array_search('provider', $names, true);
    Assert::assertIsInt($langPos);
    Assert::assertIsInt($providerPos);
    Assert::assertLessThan($providerPos, $langPos);
});

// Il ritorno da OAuth non e' piu' un controller: contratto in tests/Feature/Socialite/OauthCallbackFolioPageTest.php (DCP-360).
