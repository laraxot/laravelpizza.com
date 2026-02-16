<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\View;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * Provides a widget for user logout functionality within Filament admin panels.
 *
 * This widget handles the user logout process including session invalidation,
 * event dispatching, and proper redirection with localization support.
 *
 * @method void mount() Initialize the widget and form state.
 * @method array<string, Component> getFormSchema() Define the form schema for the logout confirmation.
 * @method void logout() Handle the user logout process.
 * @method array<string, Action> getFormActions() Define the form actions (logout and cancel buttons).
 * @method array<string, string> getViewData() Get additional data to pass to the view.
 *
 * @property array<string, mixed>|null $data Widget data array managed by XotBaseWidget.
 * @property bool $isLoggingOut Flag indicating if logout is in progress.
 */
class LogoutWidget extends XotBaseWidget
{
    /**
     * Widget data array.
     *
     * CRITICAL: This property is managed by XotBaseWidget.
     * Do not remove or redeclare it.
     *
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    /**
     * Indicates if the logout process is in progress.
     */
    public bool $isLoggingOut = false;

    /**
     * The view to render the widget.
     *
     * IMPORTANT: When using @livewire() directly in Blade templates,
     * the path should be without the module namespace.
     */
    /** @phpstan-ignore-next-line property.defaultValue */
    protected string $view = 'user::widgets.logout';

    /**
     * Mount the widget and initialize the form.
     */
    public function mount(): void
    {
        $this->form->fill();
    }

    /**
     * Get the form schema for the logout confirmation.
     *
     * This method implements the abstract method from XotBaseWidget.
     * Do not override the form() method as it's declared as final.
     *
     * @return array<string, Component>
     */
    #[\Override]
    public function getFormSchema(): array
    {
        $view = 'filament.widgets.auth.logout-message';
        // @phpstan-ignore-next-line
        if (! view()->exists($view)) {
            throw new \Exception('View '.$view.' not found');
        }

        return [
            'message' => View::make($view)->columnSpanFull(),
        ];
    }

    /**
     * Handle the user logout process.
     *
     * This method performs the following actions:
     * 1. Validates the current user session
     * 2. Dispatches pre-logout events
     * 3. Performs the actual logout
     * 4. Invalidates the session
     * 5. Dispatches post-logout events
     * 6. Logs the operation
     * 7. Handles redirection with proper localization
     *
     * @throws \RuntimeException If the logout process fails
     */
    public function logout(): void
    {
        try {
            $this->isLoggingOut = true;

            // Get the authenticated user before logging out
            $user = $this->getAuthenticatedUser();
            if ($user === null) {
                $this->handleNoUserScenario();

                return;
            }

            $this->dispatchPreLogoutEvent($user);
            $this->performLogout();
            $this->dispatchPostLogoutEvent();
            $this->logLogoutSuccess($user);
            $this->redirectAfterLogout();
        } catch (\Throwable $e) {
            $this->handleLogoutError($e);
        }
    }

    /**
     * Get the form actions for the widget.
     *
     * @return array<string, Action>
     */
    #[\Override]
    public function getFormActions(): array
    {
        return [
            'logout' => $this->getLogoutAction(),
            'cancel' => $this->getCancelAction(),
        ];
    }

    /**
     * Get the logout action configuration.
     */
    protected function getLogoutAction(): Action
    {
        return Action::make('logout')
            ->translateLabel()
            ->color('danger')
            ->size('lg')
            ->extraAttributes(['class' => 'w-full justify-center'])
            ->action($this->logout(...));
    }

    /**
     * Get the cancel action configuration.
     */
    protected function getCancelAction(): Action
    {
        return Action::make('cancel')
            ->translateLabel()
            ->color('gray')
            ->size('lg')
            ->extraAttributes(['class' => 'w-full justify-center mt-2'])
            ->url($this->getLocalizedHomeUrl());
    }

    /**
     * Get localized home URL based on current locale.
     */
    protected function getLocalizedHomeUrl(): string
    {
        $locale = App::getLocale();

        return '/'.ltrim($locale, '/');
    }

    /**
     * Get the authenticated user instance.
     */
    protected function getAuthenticatedUser(): ?Authenticatable
    {
        return Auth::user();
    }

    /**
     * Handle scenario when no user is authenticated.
     */
    protected function handleNoUserScenario(): void
    {
        $this->isLoggingOut = false;
        Log::warning('Logout attempted with no authenticated user');
    }

    /**
     * Dispatch pre-logout events.
     */
    protected function dispatchPreLogoutEvent(Authenticatable $user): void
    {
        Event::dispatch('auth.logout.attempting', [$user]);
    }

    /**
     * Perform the actual logout operations.
     */
    protected function performLogout(): void
    {
        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();
    }

    /**
     * Dispatch post-logout events.
     */
    protected function dispatchPostLogoutEvent(): void
    {
        Event::dispatch('auth.logout.successful');
    }

    /**
     * Log successful logout operation.
     */
    protected function logLogoutSuccess(Authenticatable $user): void
    {
        Log::info('User logged out', [
            'user_id' => $user->getAuthIdentifier(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }

    /**
     * Handle redirect after successful logout.
     */
    protected function redirectAfterLogout(): void
    {
        $redirect = redirect($this->getLocalizedHomeUrl())->with('success', __('user::auth.logout_success'));

        $redirect->send();
        exit;
    }

    /**
     * Handle any errors that occur during logout.
     *
     * @throws \RuntimeException
     */
    protected function handleLogoutError(\Throwable $e): void
    {
        Log::error('Logout error: '.$e->getMessage(), [
            'exception' => $e::class,
            'trace' => $e->getTraceAsString(),
        ]);

        $this->isLoggingOut = false;
        Session::flash('error', __('user::auth.logout_error'));
    }

    /**
     * Get view data for the widget.
     *
     * @return array{
     *     title: string,
     *     description: string
     * }
     */
    protected function getViewData(): array
    {
        return [
            'title' => __('user::auth.logout_title'),
            'description' => __('user::auth.logout_confirmation'),
        ];
    }
}
