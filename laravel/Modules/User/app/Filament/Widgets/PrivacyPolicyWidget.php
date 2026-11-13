<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

use function Safe\file_get_contents;

/**
 * PrivacyPolicyWidget: widget per visualizzare la privacy policy nel panel.
 *
 * Sostituisce il vecchio Livewire `Modules\User\Http\Livewire\PrivacyPolicy`.
 */
final class PrivacyPolicyWidget extends XotBaseWidget
{
    public function render(): View
    {
        /** @var view-string $viewName */
        $viewName = 'user::filament.widgets.privacy-policy';
        $policyFile = resource_path('markdown/privacy-policy.md');
        $policyContent = file_get_contents($policyFile);

        return view($viewName, [
            'terms' => Str::markdown($policyContent),
        ])->layout('filament::components.layouts.base', [
            'title' => __('user::profile.privacy_policy.title'),
        ]);
    }
}
