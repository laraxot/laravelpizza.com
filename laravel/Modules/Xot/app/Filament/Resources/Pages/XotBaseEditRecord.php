<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as FilamentEditRecord;
use Filament\Support\Components\Component;
use Filament\Support\Facades\FilamentView;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Js;
use Modules\Xot\Filament\Links\RecordAnchor;
use Modules\Xot\Filament\Traits\TransTrait;

abstract class XotBaseEditRecord extends FilamentEditRecord
{
    use TransTrait;

    protected function getRecordReturnUrl(string $fallback): string
    {
        $returnTo = request()->query(RecordAnchor::RETURN_TO_PARAMETER);
        $returnTo = is_string($returnTo) ? $returnTo : (is_string($this->previousUrl) ? $this->previousUrl : null);
        $record = $this->getRecord();
        $key = $record->getKey();

        if (! is_int($key) && ! is_string($key)) {
            return $fallback;
        }

        $returnTo = RecordAnchor::resolveReturnTo($returnTo, $key);

        return $returnTo ?? $fallback;
    }

    protected function getRedirectUrl(): ?string
    {
        $fallback = parent::getRedirectUrl();

        return $fallback === null ? null : $this->getRecordReturnUrl($fallback);
    }

    /**
     * Annulla riporta alla riga di partenza dell'elenco (`#record-N`), come il salvataggio.
     *
     * Filament usa `history.back()`, che riapre la lista senza ancora: senza un ritorno valido
     * (accesso diretto) il comportamento resta quello di Filament.
     */
    protected function getCancelFormAction(): Action
    {
        $action = parent::getCancelFormAction();
        $fallback = $this->previousUrl ?? $this->getResourceUrl();
        $url = $this->getRecordReturnUrl($fallback);

        if ($url === $fallback) {
            return $action;
        }

        return $action->alpineClickHandler(
            FilamentView::hasSpaMode($url)
                ? 'Livewire.navigate('.Js::from($url).')'
                : 'window.location.href = '.Js::from($url),
        );
    }

    public static function getNavigationLabel(): string
    {
        return static::transFunc(__FUNCTION__);
    }

    public static function getNavigationIcon(): string
    {
        return static::transFunc(__FUNCTION__);
    }

    public static function canDelete(Model $record): bool
    {
        $resource = static::getResource();

        $result = $resource::canDelete($record);

        return is_bool($result) ? $result : false;
    }

    public static function canForceDelete(Model $record): bool
    {
        $resource = static::getResource();

        $result = $resource::canForceDelete($record);

        return is_bool($result) ? $result : false;
    }

    public static function canRestore(Model $record): bool
    {
        $resource = static::getResource();

        $result = $resource::canRestore($record);

        return is_bool($result) ? $result : false;
    }

    /**
     * Get the form schema.
     *
     * @return array<int, Component>
     */
    protected function getFormSchema(): array
    {
        return [];
    }

    /**
     * Get the header actions.
     *
     * @return array<string, Action|ActionGroup>
     */
    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make()
                ->icon('heroicon-o-trash')
                ->visible(fn (Model $record) => static::canDelete($record)),
            /*
            'forceDelete' => Actions\ForceDeleteAction::make()
                ->icon('heroicon-o-trash')
                ->visible(fn(Model $record) => static::canForceDelete($record)),
            'restore' => Actions\RestoreAction::make()
                ->icon('heroicon-o-trash')
                ->visible(fn(Model $record) => static::canRestore($record)),
            // ...
            */
        ];
    }
}
