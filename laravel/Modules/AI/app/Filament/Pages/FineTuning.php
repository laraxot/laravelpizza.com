<?php

declare(strict_types=1);

namespace Modules\AI\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Modules\Xot\Filament\Pages\XotBasePage;
use Webmozart\Assert\Assert;

use function Safe\file_get_contents;

class FineTuning extends XotBasePage
{
    public string $learningRate = '0.001';

    public int $batchSize = 32;

    public int $epochs = 10;

    public string $dataset = 'dataset1';

    public ?TemporaryUploadedFile $datasetFile = null;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog';

    protected string $view = 'ai::filament.pages.fine-tuning';

    /**
     * Avvia il processo di fine-tuning.
     */
    public function startFineTuning(): void
    {
        $data = [
            'learning_rate' => (float) $this->learningRate,
            'batch_size' => (int) $this->batchSize,
            'epochs' => (int) $this->epochs,
            'dataset' => $this->dataset,
        ];

        if ($this->datasetFile) {
            $data['dataset_file'] = $this->datasetFile->getRealPath();
        }

        Assert::string($apiEndpoint = Config::get('ai.backend_api.fine_tuning_url'));

        $response = $this->sendFineTuningRequest($data, $apiEndpoint);

        if (! $response->successful()) {
            Notification::make()
                ->title('Error')
                ->body('Fine-tuning failed to start')
                ->danger()
                ->send();

            return;
        }

        Notification::make()
            ->title('Success')
            ->body('Fine-tuning started successfully')
            ->success()
            ->send();
    }

    // Metodo rimosso: safeTranslate() non utilizzato

    /**
     * Schema del form.
     */
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('learningRate')
                ->label('Learning Rate')
                ->required()
                ->numeric()
                ->minValue(0)
                ->helperText('Set the learning rate for fine-tuning'),

            TextInput::make('batchSize')
                ->label('Batch Size')
                ->required()
                ->numeric()
                ->minValue(1)
                ->helperText('Number of samples per batch'),

            TextInput::make('epochs')
                ->label('Epochs')
                ->required()
                ->numeric()
                ->minValue(1)
                ->helperText('Number of training epochs'),

            Select::make('dataset')
                ->label('Dataset')
                ->options([
                    'dataset1' => 'Dataset 1',
                    'dataset2' => 'Dataset 2',
                ])
                ->required(),
            FileUpload::make('datasetFile')
                ->label('Dataset File')
                ->required()
                ->helperText('Upload the dataset file for training'),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function sendFineTuningRequest(array $data, string $endpoint): Response
    {
        Assert::string($datasetFile = $data['dataset_file']);
        Assert::string($content = file_get_contents($datasetFile));

        return Http::attach('dataset_file', $content, basename($datasetFile))
            ->post($endpoint, $data);
    }

    /**
     * Restituisce le azioni del form, come il pulsante per avviare il fine-tuning.
     *
     * @return array<int, Action>
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('submit')
                ->label('Start Fine-tuning')
                ->action('startFineTuning')
                ->color('primary'),
        ];
    }
}
