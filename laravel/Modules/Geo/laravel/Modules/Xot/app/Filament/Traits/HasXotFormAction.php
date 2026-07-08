<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Traits;

use Filament\Actions\Action;
use Filament\Support\Facades\FilamentView;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Js;

/**
 * Trait HasXotFormAction.
 */
trait HasXotFormAction
{
    protected static string $resource = '';

    public static function getResource(): string
    {
        return static::$resource;
    }

    protected function getCancelFormAction(): Action
    {
        $url = $this->previousUrl ?? $this->getResourceUrl();
        $spaUrl = is_string($url) ? $url : null;

        return Action::make('cancel')
            ->label(__('filament-panels::resources/pages/edit-record.form.actions.cancel.label'))
            ->alpineClickHandler(
                FilamentView::hasSpaMode($spaUrl)
                    ? 'document.referrer ? window.history.back() : Livewire.navigate('.Js::from($url).')'
                    : 'document.referrer ? window.history.back() : (window.location.href = '.Js::from($url).')',
            )
            ->color('gray');
    }

    /**
     * @param array<string, mixed> $parameters
     */
    public function getResourceUrl(?string $name = null, array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?Model $tenant = null, bool $shouldGuessMissingParameters = true): string
    {
        if (filled($name) && ('index' !== $name) && method_exists($this, 'getRecord')) {
            $parameters['record'] ??= $this->getRecord();
        }

        $url = static::getResource()::getUrl($name, $parameters, $isAbsolute, $panel, $tenant, $shouldGuessMissingParameters);

        return is_string($url) ? $url : '';
    }

    protected function getSaveFormAction(): Action
    {
        $hasFormWrapper = $this->hasFormWrapper();

        return Action::make('save')
            ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
            ->submit($hasFormWrapper ? $this->getSubmitFormLivewireMethodName() : null)
            ->action($hasFormWrapper ? null : $this->getSubmitFormLivewireMethodName())
            ->keyBindings(['mod+s']);
    }

    protected function getSubmitFormAction(): Action
    {
        return $this->getSaveFormAction();
    }

    protected function getSubmitFormLivewireMethodName(): string
    {
        return 'save';
    }
}
