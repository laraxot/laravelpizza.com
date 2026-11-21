<?php

declare(strict_types=1);

namespace Modules\Meetup\Mcp\Tools;

use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsOpenWorld;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;
use Modules\Meetup\Actions\Event\BuildEventSummaryAction;
use Modules\Meetup\Actions\Event\GetUserRegisteredEventsAction;
use Modules\Meetup\Mcp\Concerns\ResolvesMcpUser;
use Modules\Meetup\Models\Event;

#[Name('my_events')]
#[Description('The events the authenticated user is registered to, the next one first.')]
#[IsReadOnly]
#[IsOpenWorld(false)]
class MyEventsTool extends Tool
{
    use ResolvesMcpUser;

    public function handle(Request $request, GetUserRegisteredEventsAction $registered, BuildEventSummaryAction $summary): Response|ResponseFactory
    {
        $user = $this->mcpUser($request);
        if ($user === null) {
            return Response::error($this->mcpText('errors.unauthenticated', null));
        }
        $locale = $this->mcpLocale($user);

        return Response::structured([
            'events' => $registered->execute((string) $user->id)
                ->map(fn (Event $event): array => $summary->execute($event, null, false, $locale))
                ->values()->all(),
        ]);
    }
}
