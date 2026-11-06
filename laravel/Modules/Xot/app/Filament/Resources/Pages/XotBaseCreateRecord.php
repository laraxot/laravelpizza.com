<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Pages;

use Filament\Resources\Pages\CreateRecord as FilamentCreateRecord;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Filament\Links\RecordAnchor;

abstract class XotBaseCreateRecord extends FilamentCreateRecord
{
    protected function getRecordReturnUrl(string $fallback): string
    {
        $record = $this->getRecord();
        $returnTo = request()->query(RecordAnchor::RETURN_TO_PARAMETER);
        $returnTo = is_string($returnTo) ? $returnTo : (is_string($this->previousUrl) ? $this->previousUrl : null);

        if (! $record instanceof Model || (! is_int($record->getKey()) && ! is_string($record->getKey()))) {
            return $fallback;
        }

        $returnTo = RecordAnchor::resolveReturnTo($returnTo, $record->getKey());

        return $returnTo ?? $fallback;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getRecordReturnUrl(parent::getRedirectUrl());
    }

    /**
     * Get default form data.
     *
     * @return array<string, mixed>
     */
    protected function getDefaultFormData(): array
    {
        return [];
    }
}
