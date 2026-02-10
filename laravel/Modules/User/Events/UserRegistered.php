<?php

declare(strict_types=1);

namespace Modules\User\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Models\User;

/**
 * Event UserRegistered.
 *
 * Dispatched when a new user registers successfully.
 * Contains all registration data including GDPR consent information.
 */
class UserRegistered implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * The user that registered.
     */
    public User $user;

    /**
     * Form data submitted during registration.
     *
     * @var array<string, mixed>
     */
    public array $formData;

    /**
     * IP address of the registration request.
     */
    public string $ipAddress;

    /**
     * User agent of the registration request.
     */
    public string $userAgent;

    /**
     * Create a new event instance.
     *
     * @param array<string, mixed> $formData
     */
    public function __construct(
        User $user,
        array $formData,
        string $ipAddress,
        string $userAgent,
    ) {
        $this->user = $user;
        $this->formData = $formData;
        $this->ipAddress = $ipAddress;
        $this->userAgent = $userAgent;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.'.$this->user->id),
        ];
    }

    /**
     * Get GDPR consent data from form data.
     *
     * @return array<string, bool>
     */
    public function getGdprConsents(): array
    {
        return [
            'privacy_policy_accepted' => (bool) ($this->formData['privacy_policy_accepted'] ?? false),
            'terms_accepted' => (bool) ($this->formData['terms_accepted'] ?? false),
            'data_processing_accepted' => (bool) ($this->formData['data_processing_accepted'] ?? false),
            'marketing_consent' => (bool) ($this->formData['marketing_consent'] ?? false),
            'profiling_consent' => (bool) ($this->formData['profiling_consent'] ?? false),
            'analytics_consent' => (bool) ($this->formData['analytics_consent'] ?? false),
            'third_party_consent' => (bool) ($this->formData['third_party_consent'] ?? false),
        ];
    }
}
