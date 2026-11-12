<?php

declare(strict_types=1);

namespace Modules\Meetup\Http\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Meetup\Actions\Profile\ChangeOwnPasswordAction;
use Modules\Meetup\Actions\Profile\ResolveOwnProfileAction;
use Modules\Meetup\Actions\Profile\UpdateOwnAvatarAction;
use Modules\Meetup\Actions\Profile\UpdateOwnProfileAction;
use Modules\Meetup\Datas\OwnProfileData;
use Modules\User\Models\User;

/**
 * Pagina "Modifica il profilo" (/{lingua}/profile/edit, CMS pages/profile/edit.json, blocco profile.edit).
 * Tre parti indipendenti, ognuna con il suo pulsante: dati del profilo, foto, password.
 * La logica sta nelle Actions di Modules\Meetup\Actions\Profile; qui solo validazione e stato del form.
 */
class ProfileEditForm extends Component
{
    use WithFileUploads;

    public string $first_name = '';

    public string $last_name = '';

    public string $bio = '';

    public string $locale = '';

    public string $email = '';

    public string $avatarUrl = '';

    /** @var TemporaryUploadedFile|null */
    public $photo = null;

    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    /** Sezione appena salvata (profile, photo, password): mostra la conferma accanto al pulsante giusto. */
    public string $saved = '';

    public function mount(ResolveOwnProfileAction $resolveProfile): void
    {
        $user = $this->user();
        $profile = $resolveProfile->execute($user);

        $this->first_name = (string) ($user->first_name ?? $profile->first_name ?? '');
        $this->last_name = (string) ($user->last_name ?? $profile->last_name ?? '');
        $bio = $profile->getAttribute('bio');
        $this->bio = \is_string($bio) ? $bio : '';
        $locale = $profile->getAttribute('locale') ?? $user->lang ?? LaravelLocalization::getCurrentLocale();
        $this->locale = \is_string($locale) ? $locale : '';
        $this->email = (string) $user->email;
        $this->avatarUrl = $profile->getAvatarUrl();
    }

    public function saveProfile(UpdateOwnProfileAction $update): void
    {
        $this->saved = '';
        $this->validate([
            'first_name' => 'required|string|min:1|max:80',
            'last_name' => 'required|string|min:1|max:80',
            'bio' => 'nullable|string|max:500',
            'locale' => 'nullable|in:'.implode(',', $this->supportedLocales()),
        ]);

        $update->execute($this->user(), new OwnProfileData(
            first_name: $this->first_name,
            last_name: $this->last_name,
            bio: $this->bio,
            locale: $this->locale === '' ? null : $this->locale,
        ));

        $this->saved = 'profile';
        // Il nome compare nel menu in alto, reso fuori da questo componente.
        $this->dispatch('profile-updated');
    }

    public function savePhoto(UpdateOwnAvatarAction $updateAvatar): void
    {
        $this->saved = '';
        $this->validate(['photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048']);

        $photo = $this->photo;
        if (! $photo instanceof UploadedFile) {
            return;
        }

        $this->avatarUrl = $updateAvatar->execute($this->user(), $photo);
        $this->photo = null;
        $this->saved = 'photo';
    }

    public function removePhoto(UpdateOwnAvatarAction $updateAvatar): void
    {
        $this->saved = '';
        $this->avatarUrl = $updateAvatar->execute($this->user(), null);
        $this->photo = null;
        $this->saved = 'photo';
    }

    public function changePassword(ChangeOwnPasswordAction $changePassword): void
    {
        $this->saved = '';
        $this->validate([
            'current_password' => 'required|current_password:web',
            'password' => ['required', 'confirmed', 'different:current_password', Password::min(8)],
        ]);

        $changePassword->execute($this->user(), $this->password);

        $this->reset(['current_password', 'password', 'password_confirmation']);
        $this->saved = 'password';
    }

    /**
     * @return array<string, string>
     */
    protected function validationAttributes(): array
    {
        return [
            'first_name' => (string) __('meetup::profile_edit.fields.first_name'),
            'last_name' => (string) __('meetup::profile_edit.fields.last_name'),
            'bio' => (string) __('meetup::profile_edit.fields.bio'),
            'locale' => (string) __('meetup::profile_edit.fields.locale'),
            'photo' => (string) __('meetup::profile_edit.fields.photo'),
            'current_password' => (string) __('meetup::profile_edit.fields.current_password'),
            'password' => (string) __('meetup::profile_edit.fields.password'),
        ];
    }

    public function render(): View
    {
        $locales = [];
        foreach ((array) config('laravellocalization.supportedLocales', []) as $code => $properties) {
            $native = \is_array($properties) ? ($properties['native'] ?? $code) : $code;
            $locales[(string) $code] = \is_string($native) ? $native : (string) $code;
        }

        return view('meetup::livewire.profile-edit-form', [
            'locales' => $locales,
            'publicProfileUrl' => LaravelLocalization::localizeUrl('/profile/'.(string) $this->user()->id),
            'initials' => mb_strtoupper(mb_substr(trim($this->first_name), 0, 1).mb_substr(trim($this->last_name), 0, 1)),
        ]);
    }

    /**
     * @return list<string>
     */
    private function supportedLocales(): array
    {
        return array_map(strval(...), array_keys((array) config('laravellocalization.supportedLocales', [])));
    }

    private function user(): User
    {
        $user = Auth::user();
        abort_unless($user instanceof User, 403);

        return $user;
    }
}
