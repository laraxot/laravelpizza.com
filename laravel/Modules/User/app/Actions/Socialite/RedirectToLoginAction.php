<?php

/**
 * @see https://github.com/DutchCodingCompany/filament-socialite
 */

declare(strict_types=1);

namespace Modules\User\Actions\Socialite;

// use DutchCodingCompany\FilamentSocialite\FilamentSocialite;
use Filament\Notifications\Notification;
use Illuminate\Http\RedirectResponse;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class RedirectToLoginAction
{
    use QueueableAction;

    public function execute(string $message): RedirectResponse
    {
        // Assert::string($route_name = config('filament-socialite.login_page_route', 'filament.admin.auth.login'));
        // Route [filament.auth.login] not defined.
        $routeName = 'login';
        Assert::string($message = __('user::'.$message));
        Notification::make()
            ->title($message)
            ->danger()
            ->persistent()
            ->send();

        // Redirect back to the login route with an error message attached
        return redirect()
            ->route($routeName)
            ->withErrors([
                'email' => [
                    __($message),
                ],
            ]);
    }
}
