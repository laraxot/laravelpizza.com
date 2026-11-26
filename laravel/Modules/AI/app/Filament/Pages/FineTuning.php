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

/**
 * Pagina di pannello per avviare il fine-tuning del modello (inoltra la richiesta al backend configurato).
 *
 * @see Modules/AI/docs/manuals/manuale-utente.md
 */
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
     *
     * @see Modules/AI/docs/manuals/manuale-utente.md
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
                ->title(__('ai::fine_tuning.error_title'))
                ->body(__('ai::fine_tuning.error_body'))
                ->danger()
                ->send();

            return;
        }

        Notification::make()
            ->title(__('ai::fine_tuning.success_title'))
            ->body(__('ai::fine_tuning.success_body'))
            ->success()
            ->send();
    }

    // Metodo rimosso: safeTranslate() non utilizzato

    /**
     * Schema del form: etichette e aiuti dalle chiavi `ai::fine_tuning.*`.
     *
     * @see Modules/AI/docs/manuals/manuale-utente.md
     */
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('learningRate')
                ->label(__('ai::fine_tuning.learning_rate'))
                ->required()
                ->numeric()
                ->minValue(0)
                ->helperText(__('ai::fine_tuning.learning_rate_hint')),

            TextInput::make('batchSize')
                ->label(__('ai::fine_tuning.batch_size'))
                ->required()
                ->numeric()
                ->minValue(1)
                ->helperText(__('ai::fine_tuning.batch_size_hint')),

            TextInput::make('epochs')
                ->label(__('ai::fine_tuning.epochs'))
                ->required()
                ->numeric()
                ->minValue(1)
                ->helperText(__('ai::fine_tuning.epochs_hint')),

            Select::make('dataset')
                ->label(__('ai::fine_tuning.dataset'))
                ->options([
                    'dataset1' => __('ai::fine_tuning.dataset1'),
                    'dataset2' => __('ai::fine_tuning.dataset2'),
                ])
                ->required(),
            FileUpload::make('datasetFile')
                ->label(__('ai::fine_tuning.dataset_file'))
                ->required()
                ->helperText(__('ai::fine_tuning.dataset_file_hint')),
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
