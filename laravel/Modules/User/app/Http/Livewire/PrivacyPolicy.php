<?php

declare(strict_types=1);

namespace Modules\User\Http\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;
use Modules\Tenant\Actions\Markdown\GetLocalizedMarkdownPathAction;
use Webmozart\Assert\Assert;

use function Safe\file_get_contents;

class PrivacyPolicy extends Component
{
    /**
     * Show the terms of service for the application.
     */
    public function render(): View
    {
        $policyFile = app(GetLocalizedMarkdownPathAction::class)->execute('policy.md');
        Assert::string($policyFile, 'Policy file path must be a string');
        if ($policyFile === '' || $policyFile === '#') {
            throw new \RuntimeException('Policy file path is empty or invalid');
        }
        /**
         * @phpstan-var view-string
         */
        $view_name = 'filament-jet::livewire.privacy-policy';
        $view_params = [
            'terms' => Str::markdown(file_get_contents($policyFile)),
        ];
        $view = view($view_name, $view_params);

        $view->layout('filament::components.layouts.base', [
            'title' => __('filament-jet::registration.privacy_policy'),
        ]);

        return $view;
    }
}
