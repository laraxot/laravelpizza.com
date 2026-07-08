<?php

/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

declare(strict_types=1);

namespace Modules\Ptv\Filament\Actions\Header;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Component;
use Illuminate\Database\Eloquent\Model;
// Header actions must be an instance of Filament\Actions\Action, or Filament\Actions\ActionGroup.
// use Filament\Tables\Actions\Action;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Sigma\Models\Ana02f;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportValutatoriAction extends Action
{
    /** @var array<string, Component> */
    public array $fields = [];

    public string $stabiDirigenteModel;

    public string $schedaModel;

    public static function getDefaultName(): ?string
    {
        return 'import_valutatori_';
    }

    /**
     * @param  array<string, Component>  $fields
     */
    public function addFields(array $fields): self
    {
        $this->fields = array_merge($this->fields, $fields);
        /** @var array<int, Component> $formFields */
        $formFields = $this->getFormFields();
        $this->schema($formFields);

        return $this;
    }

    public function setStabiDirigenteModel(string $model): self
    {
        $this->stabiDirigenteModel = $model;

        return $this;
    }

    public function setSchedaModel(string $model): self
    {
        $this->schedaModel = $model;

        return $this;
    }

    /**
     * @return array<int|string, Component>
     */
    protected function getFormFields(): array
    {
        return [
            FileUpload::make('file')
                ->label('File XLS')
                ->acceptedFileTypes([
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                ])
                ->required(),
            TextInput::make('header_row')
                ->label('Riga intestazione')
                ->helperText('Inserisci il numero della riga che contiene le intestazioni delle colonne')
                ->numeric()
                ->default(1)
                ->required()
                ->minValue(1),
            ...$this->fields, // I campi aggiuntivi vengono aggiunti qui
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();
        /** @var array<int, Component> $formFields */
        $formFields = $this->getFormFields();
        $this->label('Importa XLS')
            ->icon('heroicon-o-arrow-up-tray')
            ->schema($formFields)
            ->action(function (array $data): void {
                /** @var array<string, mixed> $data */
                $file = isset($data['file']) && is_string($data['file']) ? $data['file'] : '';
                if ($file === '') {
                    return;
                }
                $path = storage_path('app/public/'.$file);
                $headerRowIndex = isset($data['header_row']) ? (int) $data['header_row'] : 1;

                $spreadsheet = IOFactory::load($path);
                $worksheet = $spreadsheet->getActiveSheet();

                // Ottieni le intestazioni dalla riga specificata
                $headers = [];
                $headerRow = $worksheet->getRowIterator($headerRowIndex)->current();
                foreach ($headerRow->getCellIterator() as $cell) {
                    $headers[] = Str::slug(trim((string) $cell->getValue()));
                }

                // Raccogli i dati dalle righe successive
                $rows = [];
                foreach ($worksheet->getRowIterator($headerRowIndex + 1) as $row) {
                    $rowData = [];
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);

                    foreach ($cellIterator as $index => $cell) {
                        $columnIndex = $cell->getColumn();
                        $headerIndex = Coordinate::columnIndexFromString($columnIndex) - 1;

                        if (isset($headers[$headerIndex])) {
                            $key = $headers[$headerIndex];
                            $rowData[$key] = $cell->getValue();
                        }
                    }

                    if (! empty(array_filter($rowData))) {
                        $rows[] = $rowData;
                    }
                }

                /**  array<string, mixed> $validatedData */
                $validatedData = [];
                foreach ($data as $key => $value) {
                    if (is_string($key)) {
                        $validatedData[$key] = $value;
                    }
                }

                $this->syncValutatore($validatedData, $rows);
            })
            ->after(function () {
                // Force garbage collection to prevent memory leaks
                gc_collect_cycles();
            });
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<int, array<string, mixed>>  $rows
     */
    public function syncValutatore(array $data, array $rows): void
    {
        $where = Arr::except($data, ['file', 'header_row']);

        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            // $email = trim((string) ($row['testo'] ?? ''));
            // $email = trim((string) ($row['dirigente'] ?? ''));
            // $dirigente = (string) ($row['dirigente'] ?? '');
            // $email = trim($dirigente);
            $email = trim((string) ($row['email'] ?? ''));

            $ana02f = Ana02f::where('emaind', $email)->first();
            if ($ana02f == null) {
                Notification::make()
                    ->title('ERROR')
                    ->body('nessun utente in ana02f con mail ['.$email.']')
                    ->danger()
                    ->persistent()
                    ->send();

                continue;
            }
            $matr = $ana02f->getAttribute('matr');
            $ente = $ana02f->getAttribute('ente') ?? '90';
            $conome = $ana02f->getAttribute('conome');
            $nomeAttr = $ana02f->getAttribute('nome');
            $conomeStr = is_string($conome) ? $conome : '';
            $nomeStr = is_string($nomeAttr) ? $nomeAttr : '';
            $nome = $conomeStr.' '.$nomeStr;

            // Type narrowing: $this->stabiDirigenteModel is already string from property type
            if (! class_exists($this->stabiDirigenteModel)) {
                continue;
            }
            /** @var class-string<Model> $stabiDirigenteModelClass */
            $stabiDirigenteModelClass = $this->stabiDirigenteModel;
            $valutatore = $stabiDirigenteModelClass::where($where)
                ->whereRaw('valutatore_id = id')
                ->where('email', $email)
                ->first();
            if ($valutatore === null || ! ($valutatore instanceof Model)) {
                /** @var array<string, mixed> $whereAttributes */
                $whereAttributes = array_merge(['email' => $email], $where);
                /** @var array<string, mixed> $createAttributes */
                $createAttributes = [
                    'nome_diri' => $nome,
                    'ente' => $ente,
                    'matr' => $matr,
                ];
                // Type narrowing: ensure attributes are array<string, mixed>
                /** @var array<string, mixed> $validatedWhereAttributes */
                $validatedWhereAttributes = $whereAttributes;
                /** @var array<string, mixed> $validatedCreateAttributes */
                $validatedCreateAttributes = $createAttributes;
                $valutatore = $stabiDirigenteModelClass::updateOrCreate($validatedWhereAttributes, $validatedCreateAttributes);
                // dddx($valutatore);
                if (! ($valutatore instanceof Model)) {
                    continue;
                }
                $valutatoreId = $valutatore->getAttribute('id');
                $up = [
                    // 'nome_diri'=>$nome,

                    'email' => $email,

                    'valutatore_id' => $valutatoreId,
                ];
                $valutatore->update($up);
            }

            $valutatore_id = $valutatore->getAttribute('id');
            if (! is_numeric($valutatore_id)) {
                continue;
            }

            $matricola = (string) ($row['matricola'] ?? '');
            if ($matricola === '') {
                continue;
            }

            // Type narrowing: $this->schedaModel is already string from property type
            if (! class_exists($this->schedaModel)) {
                continue;
            }
            /** @var class-string<Model> $schedaModelClass */
            $schedaModelClass = $this->schedaModel;
            /** @var array<string, mixed> $schedaWhereAttributes */
            $schedaWhereAttributes = array_merge($where, ['matr' => $matricola]);
            /** @var array<string, mixed> $schedaCreateAttributes */
            $schedaCreateAttributes = ['valutatore_id' => $valutatore_id];
            $schedaModelClass::withoutEvents(function () use ($schedaModelClass, $schedaWhereAttributes, $schedaCreateAttributes): void {
                $schedaModelClass::query()->updateOrCreate($schedaWhereAttributes, $schedaCreateAttributes);
            });
            // $cond =

            // dddx($cond);
        }
    }
}
