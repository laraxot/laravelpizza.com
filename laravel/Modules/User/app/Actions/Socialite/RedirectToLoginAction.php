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

    /**
     * Execute the action.
     */
    public function execute(string $message): RedirectResponse
    {
        // Assert::string($route_name = config('filament-socialite.login_page_route', 'filament.admin.auth.login'));
        // Route [filament.auth.login] not defined.
        $route_name = 'login';
        Assert::string($message = __('user::'.$message));
        Notification::make()
            ->title($message)
            ->danger()
            ->persistent()
            ->send();

        // Redirect back to the login route with an error message attached
        return redirect()
            ->route($route_name)
            ->withErrors([
                'email' => [
                    __($message),
                ],
            ]);
    }
}
