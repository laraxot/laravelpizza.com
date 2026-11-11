<?php

declare(strict_types=1);

namespace Modules\Meetup\Http\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Meetup\Actions\Contact\SendContactMessageAction;

/**
 * Modulo "Contatti" (prima era un form HTML con action="#": i messaggi non arrivavano a nessuno).
 * Antispam: campo esca nascosto e limite di invii per indirizzo IP.
 */
class ContactForm extends Component
{
    private const int MAX_ATTEMPTS = 3;

    private const int DECAY_SECONDS = 600;

    public string $name = '';

    public string $email = '';

    public string $message = '';

    /** Campo esca: invisibile alle persone, i bot lo compilano. */
    public string $website = '';

    public bool $privacy_accepted = false;

    public bool $sent = false;

    /**
     * @return array<string, string>
     */
    protected function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:120',
            'email' => 'required|email|max:191',
            'message' => 'required|string|min:10|max:5000',
            'privacy_accepted' => 'accepted',
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function validationAttributes(): array
    {
        return [
            'name' => (string) __('meetup::contact_form.fields.name'),
            'email' => (string) __('meetup::contact_form.fields.email'),
            'message' => (string) __('meetup::contact_form.fields.message'),
            'privacy_accepted' => (string) __('meetup::contact_form.fields.privacy'),
        ];
    }

    public function submit(SendContactMessageAction $send): void
    {
        $key = 'contact-form|'.request()->ip();
        if (RateLimiter::tooManyAttempts($key, self::MAX_ATTEMPTS)) {
            $this->addError('email', (string) __('meetup::contact_form.throttle', ['minutes' => (int) ceil(RateLimiter::availableIn($key) / 60)]));

            return;
        }

        $this->validate();
        RateLimiter::hit($key, self::DECAY_SECONDS);

        // Un bot ha compilato il campo esca: risposta identica, nessun invio.
        if ($this->website === '') {
            $send->execute(trim($this->name), trim($this->email), trim($this->message), LaravelLocalization::getCurrentLocale());
        }

        $this->reset(['name', 'email', 'message', 'privacy_accepted']);
        $this->sent = true;
    }

    public function render(): View
    {
        return view('meetup::livewire.contact-form', [
            'privacyUrl' => LaravelLocalization::localizeUrl('/privacy'),
        ]);
    }
}
