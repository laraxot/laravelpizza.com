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
use Modules\Meetup\Actions\Event\SearchPublicEventsAction;
use Modules\Meetup\Mcp\Concerns\ResolvesMcpUser;
use Modules\Meetup\Models\Event;

#[Name('search_events')]
#[Description('Search the published meetups: upcoming (default) or past, optionally by city and date range. Returns slug, title, dates, city, venue, free seats and the public URL of each event.')]
#[IsReadOnly]
#[IsOpenWorld(false)]
class SearchEventsTool extends Tool
{
    use ResolvesMcpUser;

    public function handle(Request $request, SearchPublicEventsAction $search, BuildEventSummaryAction $summary): ResponseFactory
    {
        $validated = $request->validate([
            'timing' => ['nullable', 'in:upcoming,past'],
            'city' => ['nullable', 'string', 'max:100'],
            'from' => ['nullable', 'date_format:Y-m-d'],
            'until' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:from'],
            'limit' => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);
        $user = $this->mcpUser($request);
        $locale = $this->mcpLocale($user);

        $events = $search->execute(
            is_string($validated['timing'] ?? null) ? $validated['timing'] : SearchPublicEventsAction::UPCOMING,
            ['city' => $validated['city'] ?? null, 'from' => $validated['from'] ?? null, 'until' => $validated['until'] ?? null],
            is_numeric($validated['limit'] ?? null) ? (int) $validated['limit'] : 20,
        );

        return Response::structured([
            'events' => $events->map(fn (Event $event): array => $summary->execute($event, $user?->id, false, $locale))->values()->all(),
            'cities' => $search->cities(is_string($validated['timing'] ?? null) ? $validated['timing'] : SearchPublicEventsAction::UPCOMING),
        ]);
    }

    /**
     * @return array<string, Type>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'timing' => $schema->string()->enum(['upcoming', 'past'])->description('Upcoming events (default) or past events.'),
            'city' => $schema->string()->description('City name exactly as returned in "cities", e.g. "Milano".'),
            'from' => $schema->string()->description('First day, YYYY-MM-DD.'),
            'until' => $schema->string()->description('Last day, YYYY-MM-DD.'),
            'limit' => $schema->integer()->min(1)->max(50)->description('Maximum number of events (default 20).'),
        ];
    }
}
