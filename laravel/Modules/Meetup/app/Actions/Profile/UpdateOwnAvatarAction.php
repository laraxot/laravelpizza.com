<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Profile;

use Illuminate\Http\UploadedFile;
use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

/**
 * Foto del profilo (collezione media "avatar", disco pubblico). Una sola foto per volta: quella vecchia viene cancellata.
 * Senza file la foto viene tolta e il sito torna a mostrare le iniziali.
 */
final class UpdateOwnAvatarAction
{
    use QueueableAction;

    public const string COLLECTION = 'avatar';

    public function __construct(private readonly ResolveOwnProfileAction $resolveProfile) {}

    public function execute(User $user, ?UploadedFile $photo): string
    {
        $profile = $this->resolveProfile->execute($user);
        $profile->clearMediaCollection(self::COLLECTION);

        if ($photo !== null) {
            $profile->addMedia($photo->getRealPath())
                ->usingFileName('avatar.'.($photo->guessExtension() ?? 'jpg'))
                ->toMediaCollection(self::COLLECTION);
        }

        return $profile->refresh()->getAvatarUrl();
    }
}
