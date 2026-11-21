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
use Laravel\Mcp\Server\Tools\Annotations\IsDestructive;
use Laravel\Mcp\Server\Tools\Annotations\IsOpenWorld;
use Modules\Meetup\Actions\Event\UnregisterAttendeeFromEventAction;
use Modules\Meetup\Mcp\Concerns\ResolvesMcpUser;
use Modules\Meetup\Models\Event;

#[Name('leave_event')]
#[Description('Cancel the registration of the authenticated user to an event (slug). The seat goes back to other people. Ask the user to confirm first.')]
#[IsDestructive]
#[IsOpenWorld(false)]
class LeaveEventTool extends Tool
{
    use ResolvesMcpUser;

    public function handle(Request $request, UnregisterAttendeeFromEventAction $unregister): Response
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

        try {
            $unregister->execute($event, (string) $user->id);
        } catch (\DomainException $exception) {
            return Response::error($this->mcpText('errors.'.JoinEventTool::reason($exception), $user, ['title' => (string) $event->title]));
        }

        return Response::text($this->mcpText('messages.unregistered', $user, ['title' => (string) $event->title]));
    }

    /**
     * @return array<string, Type>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'slug' => $schema->string()->description('Event slug.')->required(),
        ];
    }
}
