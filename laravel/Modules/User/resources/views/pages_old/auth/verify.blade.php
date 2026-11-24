<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Livewire\Volt\Component;
use Modules\User\Actions\Auth\ResendEmailVerificationAction;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

middleware(['auth', 'throttle:6,1']);
name('verification.notice');

new class extends Component {
    public function resend(): ?RedirectResponse
    {
        $user = auth()->user();
        abort_unless($user instanceof MustVerifyEmail, 403);

        if (! app(ResendEmailVerificationAction::class)->execute($user)) {
            return redirect('/');
        }

        $this->dispatch('resent');
        session()->flash('resent');

        return null;
    }
};
?>

{{--
  Verifica email: stesso guscio delle altre pagine di accesso (x-auth.shell via partial, DCP-290).
  Prima era <x-layouts.main> legacy — niente header/footer CMS, card grigia.
  Logica invariata: ResendEmailVerificationAction + throttle:6,1.
  @volt deve stare direttamente in x-layouts.app: il markup va nel partial del tema attivo.
--}}
<x-layouts.app
    :title="__('user::auth_pages.sections.verify.title')"
    :meta-description="__('user::auth_pages.verify.check_email.description')"
>
    @volt('auth.verify')
        <div class="page-content content" data-dc data-slug="auth.verify" data-side="content">
            @include('pub_theme::components.pages.auth.verify')
        </div>
    @endvolt
</x-layouts.app>
