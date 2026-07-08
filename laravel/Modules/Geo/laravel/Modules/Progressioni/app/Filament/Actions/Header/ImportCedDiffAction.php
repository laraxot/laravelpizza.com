<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Actions\Header;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Progressioni\Imports\CedDiffImport;
use Modules\Progressioni\Models\CedDiff;

class ImportCedDiffAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('progressioni::messages.import_ced_diff'))

            ->schema([
                FileUpload::make('file')
                    // ->disk('cache')
                    ->label(__('progressioni::messages.choose_xls_file'))
                    ->required()
                    ->afterStateUpdated(function (Set $set, TemporaryUploadedFile $state) {
                        $set('fileRealPath', $state->getRealPath());
                    }),
                Hidden::make('fileRealPath'),
                Toggle::make('create_table'),
            ])
            ->action(function (array $data): void {
                // $filePath = storage_path('app/' . $data['file']);
                // $filePath = $data['fileRealPath'];
                /** @var string $filePath */
                $filePath = storage_path('app/public/'.(string) ($data['file'] ?? ''));
                // $filePath = Storage::disk('cache')->path($data['file']);

                // Verifica se il file esiste
                if (! file_exists($filePath)) {
                    Notification::make()
                        ->title(__('progressioni::messages.file_not_found'))
                        ->body($filePath)
                        ->danger()
                        // ->persiste
                        ->send();

                    return;
                }
                $import = new CedDiffImport;
                Excel::import($import, $filePath); // , null, \Maatwebsite\Excel\Excel::XLSX);

                $columns = $import->getColumns();

                if ($data['create_table']) {
                    $this->createTableFromXLS($columns);
                }

                Notification::make()
                    ->title(__('progressioni::messages.import_completed'))
                    ->success()
                    ->send();
            });
    }

    public static function getDefaultName(): ?string
    {
        return 'import_ced_diff';
    }

    // private function confirmCreateTable(array $columns): bool
    // {
    //    return $this->ask(__('progressioni::messages.confirm_create_table'), 'yes');
    // }

    /** @param array<mixed> $columns */
        private function createTableFromXLS(array $columns): void
    {
        $ced_diff = app(CedDiff::class);
        $tbl = $ced_diff->getTable();
        $conn_name = $ced_diff->getConnectionName();
        // if (Schema::connection($conn_name)->hasTable($tbl)) {
        //    Schema::connection($conn_name)->dropIfExists($tbl);
        // }

        Schema::connection($conn_name)
            ->create($tbl, function (Blueprint $table) use ($columns) {
                $table->id();
                foreach ($columns as $i => $column) {
                    /** @var array<string, mixed> $column */
                    $nameRaw = $column['name'] ?? '';
                    /** @var string $name */
                    $name = is_string($nameRaw) ? $nameRaw : Str::of((string) $nameRaw)->slug('_')->toString();
                    /*
                $name=Str::of($name)->slug('_')->toString();
                dddx([
                    'i'=>$i,
                    'column'=>$column,
                    'name'=>$name,
                    'columns'=>$columns,
                ]);
                    */
                    $table->string($name)->nullable();
                }
                $table->timestamps();
            });

        Notification::make()
            ->title('!')
            ->success()
            ->body('table '.$conn_name.'.'.$tbl.' created')
            ->send();
    }
}
