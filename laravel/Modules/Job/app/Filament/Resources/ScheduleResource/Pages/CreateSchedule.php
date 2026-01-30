<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\ScheduleResource\Pages;

use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Modules\Job\Filament\Resources\ScheduleResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
use Modules\Xot\Filament\Traits\NavigationPageLabelTrait;
use Webmozart\Assert\Assert;

class CreateSchedule extends XotBaseCreateRecord
{
    use NavigationPageLabelTrait;

    public Collection $commands;

    protected static string $resource = ScheduleResource::class;

    /**
     * @return array<Htmlable|string>
     */
    public function getformSchema(): array
    {
        $res = $this->getResource()::getFormSchema();
        Assert::isArray($res);
        $formSchema = $res;

        /** @var array<Htmlable|string> $formSchema */
        return $formSchema;
    }

    public function schema(Schema $schema): Schema
    {
        /** @var array<Htmlable|string> $formSchema */
        $formSchema = $this->getFormSchema();
        Assert::isArray($formSchema);

        return $schema->components($formSchema);
    }

    protected function onValidationError(ValidationException $exception): void
    {
        Notification::make()
            ->title($exception->getMessage())
            ->danger()
            ->send();
    }
}
