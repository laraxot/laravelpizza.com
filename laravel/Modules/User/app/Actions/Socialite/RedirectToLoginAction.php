<?php

declare(strict_types=1);
/**
 * @see https://github.com/DutchCodingCompany/filament-socialite
 */

namespace Modules\User\Actions\Socialite;

// use DutchCodingCompany\FilamentSocialite\FilamentSocialite;
use Filament\Notifications\Notification;
use Illuminate\Http\RedirectResponse;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class RedirectToLoginAction
{
    use QueueableAction;

    /**
     * @param  array<string, string>  $replace  segnaposto `:chiave` del testo tradotto
     */
    public function execute(string $message, array $replace = []): RedirectResponse
    {
        // Il login FO e' la pagina Folio `/{lang}/auth/login`. Il nome Folio `login` risolve sempre la lingua di
        // default: chi annulla Google da /en/ tornerebbe su /it/. Si localizza quindi l'URL con la lingua corrente.
        $loginUrl = LaravelLocalization::localizeURL('/auth/login', app()->getLocale());
        Assert::string($loginUrl);
        $translated = __('user::'.$message);
        if (is_array($translated)) {
            $translated = $translated['text'] ?? $message;
        }
        Assert::string($translated);
        $pairs = [];
        foreach ($replace as $key => $value) {
            $pairs[':'.$key] = $value;
        }
        $translated = trim(strtr($translated, $pairs));
        Notification::make()
            ->title($translated)
            ->danger()
            ->persistent()
            ->send();

        // Redirect back to the login page with an error message attached
        return redirect()
            ->to($loginUrl)
            ->withErrors([
                'email' => [$translated],
            ]);
    }
}
