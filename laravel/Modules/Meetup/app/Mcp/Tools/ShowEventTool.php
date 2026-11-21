<?php

declare(strict_types=1);

namespace Modules\Meetup\Mcp\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsOpenWorld;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;
use Modules\Meetup\Actions\Event\BuildEventSummaryAction;
use Modules\Meetup\Mcp\Concerns\ResolvesMcpUser;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\Performer;
use Modules\Meetup\Models\Sponsor;

#[Name('show_event')]
#[Description('Details of one published event by slug: description, dates, venue and address, speakers, sponsors, free seats and whether the authenticated user is already registered.')]
#[IsReadOnly]
#[IsOpenWorld(false)]
class ShowEventTool extends Tool
{
    use ResolvesMcpUser;

    public function handle(Request $request, BuildEventSummaryAction $summary): Response|ResponseFactory
    {
        $validated = $request->validate(['slug' => ['required', 'string', 'max:255']]);
        $slug = is_string($validated['slug'] ?? null) ? $validated['slug'] : '';
        $user = $this->mcpUser($request);

        $event = Event::query()->published()->where('slug', $slug)->with(['venue', 'performers', 'sponsors'])->first();
        if (! $event instanceof Event) {
            return Response::error($this->mcpText('errors.not_found', $user, ['slug' => $slug]));
        }

        return Response::structured([
            ...$summary->execute($event, $user?->id, true, $this->mcpLocale($user)),
            'speakers' => $event->performers->map(fn (Performer $performer): array => [
                'name' => (string) $performer->name,
                'company' => is_string($performer->company) ? $performer->company : null,
            ])->values()->all(),
            'sponsors' => $event->sponsors->map(fn (Sponsor $sponsor): string => (string) $sponsor->name)->values()->all(),
        ]);
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
}
