<?php

declare(strict_types=1);

namespace Modules\User\Http\Livewire\Auth;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Xot\Contracts\UserContract;
use Spatie\Permission\Models\Role;
use Webmozart\Assert\Assert;

/**
 * Componente Livewire per la gestione del login.
 *
 * @property Schema $form
 */
class Login extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    /**
     * Data array for form state.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    /**
     * Inizializza il componente.
     */
    public function mount(): void
    {
        $this->form->fill();
    }

    /**
     * Crea il form schema.
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components($this->getFormSchema())
            ->statePath('data');
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
            $data = $this->form->getState();

            // Estrai remember dal data array e assicurati che sia un booleano
            $remember = $data['remember'] ?? false;
            // Converto esplicitamente a bool per PHPStan livello 10
            $remember = (bool) $remember;
            unset($data['remember']);

            if (Auth::attempt($data, $remember)) {
                session()->regenerate();

                // Redirect intelligente basato sui ruoli dell'utente
                return $this->getRedirectUrl();
            }

            $this->addError('data.email', __('Le credenziali fornite non sono corrette..'));
        } catch (\Exception $e) {
            $this->addError('data.email', __('Si è verificato un errore durante il login. Riprova più tardi.'));
            report($e);
        }
    }

    /**
     * Renderizza il componente.
     */
    public function render(): View|Factory
    {
        /** @var view-string $viewName */
        $viewName = 'user::livewire.auth.login';

        // app(ViewCopyAction::class)->execute('user::livewire.auth.login', 'pub_theme::livewire.auth.login');
        return view($viewName);
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
                ->suffixIcon('heroicon-m-envelope')
                ->autofocus()
                ->live()
                ->afterStateUpdated(fn ($_state) => $this->validateOnly('email'))
                ->dehydrated(),

            TextInput::make('password')
                ->password()
                ->required()
                ->suffixIcon('heroicon-m-key')
                ->revealable()
                ->minLength(8)
                ->maxLength(255)
                ->dehydrated(),
            Checkbox::make('remember')
                ->default(false)
                ->dehydrated(),
        ];
    }

    /**
     * Determina l'URL di redirect appropriato per l'utente autenticato.
     */
    protected function getRedirectUrl(): RedirectResponse
    {
        /** @var UserContract|null $user */
        $user = Auth::user();
        if (! $user instanceof UserContract) {
            return redirect()->to('/');
        }

        /** @var Collection<int, Role> $roles */
        $roles = $user->roles()->get();
        $adminRoles = $roles->filter(
            static fn (Role $role): bool => str_ends_with($role->name, '::admin')
        );

        $adminCount = $adminRoles->count();
        if (1 === $adminCount) {
            $role = $adminRoles->first();
            Assert::isInstanceOf($role, Role::class);
            $moduleName = str_replace('::admin', '', $role->name);

            return redirect()->to("/{$moduleName}/admin");
        }

        if ($adminCount > 1) {
            return redirect()->to('/admin');
        }

        // Utente senza ruoli admin - redirect alla homepage
        return redirect()->to('/'.app()->getLocale());
    }
}
