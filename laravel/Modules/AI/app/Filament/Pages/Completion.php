<?php

declare(strict_types=1);

namespace Modules\AI\Filament\Pages;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Filament\Support\Exceptions\Halt;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Modules\AI\Actions\CompletionAction;
use Modules\AI\Actions\SentimentAction;
use Modules\Xot\Filament\Pages\XotBasePage;
use RuntimeException;
use Webmozart\Assert\Assert;

/**
 * @property Schema $form
 * @property Schema $completionForm
 */
class Completion extends XotBasePage implements HasForms
{
    // protected string $view = 'ai::filament.pages.completion';

    /**
     * @var array<string, mixed>|null
     */
    public ?array $completionData = [];

    public function mount(): void
    {
        // $this->view = 'ai::filament.pages.completion';
        $this->completionForm->fill();
    }

    public function completionForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('prompt')
                    ->required(),
            ])
            ->model($this->getUser())
            ->statePath('completionData');
    }

    public function completion(): void
    {
        try {
            $data = $this->completionForm->getState();
            Assert::string($prompt = $data['prompt']);

            $action = new CompletionAction;
            $result = $action->execute($prompt);

            $this->dispatch('completion-completed', result: $result);
        } catch (Halt $exception) {
            // Form validation failed
        }
    }

    public function sentiment(): void
    {
        try {
            $data = $this->completionForm->getState();
            Assert::string($prompt = $data['prompt']);

            $action = new SentimentAction;
            $result = $action->execute($prompt);

            $this->dispatch('sentiment-completed', result: $result);
        } catch (Halt $exception) {
            // Form validation failed
        }
    }

    protected function getUser(): Authenticatable&Model
    {
        $user = Filament::auth()->user();

        if ($user === null) {
            throw new RuntimeException('Nessun utente autenticato trovato.');
        }

        return $user;
    }

    /**
     * @return array<int, Action>
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('completion')
                ->label('Generate Completion')
                ->action('completion')
                ->color('primary'),

            Action::make('sentiment')
                ->label('Analyze Sentiment')
                ->action('sentiment')
                ->color('secondary'),
        ];
    }
}
