<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Profile;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Modules\User\Models\User;

/**
 * Token personali attivi dell'utente (non revocati e non scaduti), dal più recente.
 */
final class ListOwnAssistantTokensAction
{
    /** @return list<array{id: string, name: string, created_at: ?Carbon, expires_at: ?Carbon}> */
    public function execute(User $user): array
    {
        return array_values($user->tokens()
            ->where('revoked', false)
            ->where(static fn ($query) => $query->whereNull('expires_at')->orWhere('expires_at', '>', now()))
            ->latest()
            ->get()
            ->map(static fn (Model $token): array => [
                'id' => is_scalar($token->getKey()) ? (string) $token->getKey() : '',
                'name' => is_string($token->getAttribute('name')) ? $token->getAttribute('name') : '',
                'created_at' => self::date($token->getAttribute('created_at')),
                'expires_at' => self::date($token->getAttribute('expires_at')),
            ])
            ->all());
    }

    private static function date(mixed $value): ?Carbon
    {
        return $value instanceof \DateTimeInterface ? Carbon::instance($value) : null;
    }
}
