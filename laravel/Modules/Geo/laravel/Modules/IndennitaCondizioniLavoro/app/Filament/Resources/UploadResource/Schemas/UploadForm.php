<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources\UploadResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class UploadForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        $dir = 'indennitaCondizioniLavoro/'.auth()->id();

        // $dir='indennitaCondizioniLavoro';
        return [
            'path' => FileUpload::make('path')
                ->preserveFilenames()
                ->acceptedFileTypes(['application/pdf'])
            // ->disk('cache')
                ->directory($dir)
                ->openable()
            // ->downloadable()
                ->moveFiles(),
            'quadrimestre' => Select::make('quadrimestre')->options(['1' => '1', '2' => '2', '3' => '3', '4' => '4'])->required(),
            'anno' => Select::make('anno')->options(['2023' => '2023'])->required(),
            'note' => TextInput::make('note'),
        ];
    }
}
