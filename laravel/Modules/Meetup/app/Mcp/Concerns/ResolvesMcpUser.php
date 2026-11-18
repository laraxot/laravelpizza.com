<?php

declare(strict_types=1);

namespace Modules\Meetup\Mcp\Concerns;

use Laravel\Mcp\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\User\Models\User;

/**
 * Chi sta chiamando il tool: l'utente del token (Passport, guard `api`). Ogni client MCP agisce per una persona precisa.
 */
trait ResolvesMcpUser
{
    protected function mcpUser(Request $request): ?User
    {
        $user = $request->user();

        return $user instanceof User ? $user : null;
    }

    /** Lingua dei messaggi e dei link: quella del profilo dell'utente, se il sito la supporta. */
    protected function mcpLocale(?User $user): string
    {
        $supported = array_keys(LaravelLocalization::getSupportedLocales());
        $lang = $user?->lang;

        return is_string($lang) && in_array($lang, $supported, true) ? $lang : (string) LaravelLocalization::getDefaultLocale();
    }

    /** @param  array<string, string|int>  $replace */
    protected function mcpText(string $key, ?User $user, array $replace = []): string
    {
        return (string) __('meetup::mcp.'.$key, $replace, $this->mcpLocale($user));
    }
}
