<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Widgets\Auth;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Modules\Gdpr\Actions\Registration\HandleSuccessfulRegistrationAction;
use Modules\Gdpr\Actions\SaveGdprConsentsAction;
use Modules\Gdpr\Actions\Validation\ValidateUserDataAction;
use Modules\Gdpr\Models\Treatment;
use Modules\User\Actions\Activity\LogRegistrationAction;
use Modules\User\Actions\User\CreateUserAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * GDPR-Compliant Registration Widget.
 */
class RegisterWidget extends XotBaseWidget
{
    /** @var array<string, bool> */
    public array $consents = [];

    #[Validate('required|string|min:2|max:255')]
    public string $first_name = '';

    #[Validate('required|string|min:2|max:255')]
    public string $last_name = '';

    #[Validate('required|email|max:255|unique:user.users,email')]
    public string $email = '';

    #[Validate('required|string|min:8')]
    public string $password = '';

    #[Validate('required|string|same:password')]
    public string $password_confirmation = '';

    public bool $show_password = false;

    public static function canView(): bool
    {
        return ! Auth::check();
    }

    public function mount(): void
    {
        $treatments = $this->getTreatments();
        foreach ($treatments as $treatment) {
            $this->consents[$treatment->id] = false;
        }
    }

    protected function getView(): string
    {
        return 'filament.widgets.auth.register';
    }

    /**
     * @return Collection<string, Treatment>
     */
    public function getTreatments(): Collection
    {
        return Treatment::where('active', 1)
            ->orderBy('weight')
            ->get();
    }

    public function submit(): void
    {
        $this->validate();

        // Manual validation for required treatments
        $treatments = $this->getTreatments();
        foreach ($treatments as $treatment) {
            if ($treatment->required && ! ($this->consents[$treatment->id] ?? false)) {
                $this->addError("consents.{$treatment->id}", "You must accept: {$treatment->name}");

                return;
            }
        }

        $formData = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ];

        $validatedData = app(ValidateUserDataAction::class)->execute($formData);

        $user = DB::connection('user')->transaction(function () use ($validatedData) {
            $user = app(CreateUserAction::class)->execute($validatedData);

            // Re-map consents for SaveGdprConsentsAction
            // Since SaveGdprConsentsAction uses treatment names (legacy or specific logic), 
            // we'll pass the raw array and let the action handle it.
            // Actually, let's pass an array of [treatment_name => bool]
            $mappedConsents = [];
            $activeTreatments = $this->getTreatments();
            foreach ($activeTreatments as $t) {
                $mappedConsents[$t->name] = $this->consents[$t->id] ?? false;
            }

            app(SaveGdprConsentsAction::class)->execute($user, $mappedConsents);

            app(LogRegistrationAction::class)->execute($user, [
                'gdpr_consents' => $mappedConsents,
            ]);

            return $user;
        });

        app(HandleSuccessfulRegistrationAction::class)->execute($user, $this);
    }
}
