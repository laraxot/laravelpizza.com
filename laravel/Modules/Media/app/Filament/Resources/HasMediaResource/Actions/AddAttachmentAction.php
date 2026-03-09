<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\HasMediaResource\Actions;

use Exception;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Support\Str;
use Modules\Xot\Filament\Actions\XotBaseAction;
use Webmozart\Assert\Assert;

class AddAttachmentAction extends XotBaseAction
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->icon('heroicon-o-plus')
            ->color('success')
            ->button()
            ->schema(fn (): array => static::getFormSchema(false))
            ->action(static::formHandlerCallback(...));
    }

    public static function trans(string $key): string
    {
        Assert::string(
            $ris = trans('media::add_attachment_action.'.$key),
            '['.$key.']['.__LINE__.']['.class_basename(self::class).']',
        );

        return $ris;
    }

    public static function getDefaultName(): ?string
    {
        return 'add_attachment';
    }

    /**
     * @return array<int, TextInput|FileUpload>
     */
    public static function getFormSchema(bool $asset = true): array
    {
        Assert::integer($max_size = config('media-library.max_file_size'));

        return [
            FileUpload::make('file')
                ->hint(static::trans('fields.file_hint'))
                ->storeFileNamesIn('original_file_name')
                ->visibility('private')
                ->maxSize($max_size)
                ->required()
                ->columnSpanFull(),
            TextInput::make('name')
                ->hint(static::trans('fields.name_hint'))
                ->autocomplete(false)
                ->maxLength(255)
                ->columnSpanFull(),
        ];
    }

    public static function formHandlerCallback(RelationManager $livewire, array $data): void
    {
        $ownerRecord = $livewire->getOwnerRecord();
        $mediaCollection = $data['attachment_type'] ?? 'default';

        if (! method_exists($ownerRecord, 'addMediaFromDisk')) {
            throw new Exception('wip');
        }

        $fileAdder = $ownerRecord->addMediaFromDisk($data['file'], config('attachment.upload.disk.driver'));

        if (! is_object($fileAdder) || ! method_exists($fileAdder, 'setName') || ! method_exists($fileAdder, 'preservingOriginal') || ! method_exists($fileAdder, 'toMediaCollection')) {
            throw new Exception('FileAdder error');
        }

        $attachment = $fileAdder->setName($data['name'] ?? Str::beforeLast((string) ($data['original_file_name'] ?? ''), '.'))
            ->preservingOriginal()
            ->toMediaCollection($mediaCollection);

        if (is_object($attachment) && method_exists($attachment, 'update')) {
            $user_id = authId();
            $attachment->update([
                'created_by' => $user_id,
                'updated_by' => $user_id,
            ]);
        }
    }
}
