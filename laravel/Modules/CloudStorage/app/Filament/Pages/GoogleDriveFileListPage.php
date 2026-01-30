<?php

declare(strict_types=1);

namespace Modules\CloudStorage\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\CloudStorage\Services\GoogleDriveService;

// implements HasTable

class GoogleDriveFileListPage extends Page
{
    // use InteractsWithTable;
    protected string $view = 'cloudstorage::filament.pages.google-drive-file-list';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cloud';

    protected GoogleDriveService $driveService;

    /*
    public function __construct()
    {
        dddx('b');
    }
        */

    public function setUp(): void
    {
        dddx('c');
    }

    public function mount(GoogleDriveService $driveService): void
    {
        $this->driveService = $driveService;

        dddx([
            'listFiles' => $this->driveService->getFiles(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')

                    ->searchable(),

                TextColumn::make('mimeType'),

                TextColumn::make('modifiedTime')

                    ->dateTime('Y-m-d H:i:s'),

                TextColumn::make('size')

                    ->formatStateUsing(fn ($state): string => is_numeric($state) ? $this->formatFileSize((int) $state) : '0 bytes'),
            ])
            ->recordActions([
                Action::make('view')
                    ->icon('heroicon-o-eye')
                    ->tooltip(__('View File'))
                    ->url(fn ($record) => is_array($record) && isset($record['webViewLink']) ? $record['webViewLink'] : '#', true),
                /*
                Action::make('share')
                    ->icon('heroicon-o-share')
                    ->tooltip(__('Share to Corporate Folder'))
                    ->action(fn ($record) => $this->shareFileToCorporate($record['id'])),
                */
            ]);
    }

    protected function getFilesQuery(): array
    {
        return $this->driveService->getFiles();
    }

    /*
    protected function shareFileToCorporate(string $fileId): void
    {
        $corporateFolderId = config('cloudstorage.corporate_folder_id'); // Set in config
        $this->driveService->shareFile($fileId, $corporateFolderId);

        // You can log or notify the user about the sharing status.
    }
    */
    protected function formatFileSize(int $size): string
    {
        if ($size >= 1073741824) {
            return number_format($size / 1073741824, 2).' GB';
        }
        if ($size >= 1048576) {
            return number_format($size / 1048576, 2).' MB';
        }
        if ($size >= 1024) {
            return number_format($size / 1024, 2).' KB';
        }

        return $size.' bytes';
    }
}
