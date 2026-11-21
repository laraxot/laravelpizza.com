<?php

declare(strict_types=1);

namespace Modules\Meetup\Mcp\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsIdempotent;
use Laravel\Mcp\Server\Tools\Annotations\IsOpenWorld;
use Modules\Meetup\Actions\Event\JoinEventAction;
use Modules\Meetup\Mcp\Concerns\ResolvesMcpUser;
use Modules\Meetup\Models\Event;

#[Name('join_event')]
#[Description('Register the authenticated user to an event (slug from search_events). Takes one of the limited seats and sends the confirmation email with the calendar file. Ask the user to confirm first.')]
#[IsIdempotent]
#[IsOpenWorld(false)]
class JoinEventTool extends Tool
{
    use ResolvesMcpUser;

    public function handle(Request $request, JoinEventAction $join): Response
    {
        $validated = $request->validate(['slug' => ['required', 'string', 'max:255']]);
        $slug = is_string($validated['slug'] ?? null) ? $validated['slug'] : '';
        $user = $this->mcpUser($request);
        if ($user === null) {
            return Response::error($this->mcpText('errors.unauthenticated', null));
        }

        $event = Event::query()->published()->where('slug', $slug)->first();
        if (! $event instanceof Event) {
            return Response::error($this->mcpText('errors.not_found', $user, ['slug' => $slug]));
        }
        // Idempotente: una seconda chiamata non è un errore per chi la fa (l'agente può ripetere un tool).
        if ($event->isUserRegistered($user->id)) {
            return Response::text($this->mcpText('messages.already_registered', $user, ['title' => (string) $event->title]));
        }

        try {
            $join->execute($event, $user, $this->mcpLocale($user));
        } catch (\DomainException $exception) {
            return Response::error($this->mcpText('errors.'.self::reason($exception), $user, ['title' => (string) $event->title]));
        }

        return Response::text($this->mcpText('messages.registered', $user, ['title' => (string) $event->title]));
    }

    /**
     * @return array<string, Type>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'slug' => $schema->string()->description('Event slug, from search_events.')->required(),
        ];
    }

    public static function reason(\DomainException $exception): string
    {
        return match ($exception->getMessage()) {
            'Event is full' => 'full',
            'Event has already started' => 'started',
            'User is not registered for this event' => 'not_registered',
            default => 'closed',
        };
    }
}
