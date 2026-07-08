<?php

declare(strict_types=1);

namespace Modules\User\Http\Livewire\Auth;

use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Xot\Actions\File\ViewCopyAction;

/**
 * Componente Livewire per la gestione del login.
 *
 * @property ComponentContainer $form
 */
class Login extends Component implements HasForms
{
    use InteractsWithForms;

    /**
     * Regole di validazione.
     *
     * @var array<string, array<string|object>>
     */
    protected array $rules = [
        'email' => ['required', 'email'],
        'password' => ['required'],
        'remember' => ['boolean'],
    ];

    /**
     * Email dell'utente.
     */
    public string $email = '';

    /**
     * Password dell'utente.
     */
    public string $password = '';

    /**
     * Flag per ricordare l'utente.
     */
    public bool $remember = false;

    /**
     * Inizializza il componente.
     */
    public function mount(): void
    {
        $this->form = $this->form();
    }

    /**
     * Definisce lo schema del form.
     *
     * @return array<TextInput|Checkbox>
     */
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('email')
                ->email()
                ->required()
                ->label(__('Email'))
                ->placeholder(__('Inserisci la tua email'))
                ->suffixIcon('heroicon-m-envelope')
                ->autofocus()
                ->live()
                ->afterStateUpdated(fn ($state) => $this->validateEmail($state))
                ->dehydrated(),

            TextInput::make('password')
                ->password()
                ->required()
                ->label(__('Password'))
                ->placeholder(__('Inserisci la tua password'))
                ->suffixIcon('heroicon-m-key')
                ->revealable()
                ->minLength(8)
                ->maxLength(255)
                ->dehydrated(),

            Checkbox::make('remember')
                ->label(__('Ricordami'))
                ->default(false)
                ->dehydrated(),
        ];
    }

    /**
     * Crea il form.
     */
    public function form(): Form
    {
        return $this->makeForm()
            ->schema($this->getFormSchema());
    }

    /**
     * Esegue l'autenticazione dell'utente.
     *
     * @return RedirectResponse|void
     */
    public function authenticate()
    {
        try {
            /** @var array{email: string, password: string, remember?: bool} $data */
            $data = $this->validate();

            // Estrai remember dal data array e assicurati che sia un booleano
            $remember = $data['remember'] ?? false;
            // Converto esplicitamente a bool per PHPStan livello 10
            $remember = (bool) $remember;
            unset($data['remember']);

            if (Auth::attempt($data, $remember)) {
                session()->regenerate();

                return redirect()->intended();
            }

            $this->addError('email', __('Le credenziali fornite non sono corrette.'));
        } catch (\Exception $e) {
            $this->addError('email', __('Si è verificato un errore durante il login. Riprova più tardi.'));
            report($e);
        }
    }

    /**
     * Renderizza il componente.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        //app(ViewCopyAction::class)->execute('user::livewire.auth.login', 'pub_theme::livewire.auth.login');
        return view('user::livewire.auth.login');
    }
}
