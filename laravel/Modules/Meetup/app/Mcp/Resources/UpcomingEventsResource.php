<?php

declare(strict_types=1);

namespace Modules\Meetup\Mcp\Resources;

use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\MimeType;
use Laravel\Mcp\Server\Attributes\Uri;
use Laravel\Mcp\Server\Resource;
use Modules\Meetup\Actions\Event\BuildEventSummaryAction;
use Modules\Meetup\Actions\Event\SearchPublicEventsAction;
use Modules\Meetup\Models\Event;

#[Uri('laravelpizza://events/upcoming')]
#[MimeType('application/json')]
#[Description('All the upcoming published meetups, the nearest first.')]
class UpcomingEventsResource extends Resource
{
    public function handle(SearchPublicEventsAction $search, BuildEventSummaryAction $summary): Response
    {
        $events = $search->execute(SearchPublicEventsAction::UPCOMING, [], 200)
            ->map(fn (Event $event): array => $summary->execute($event))
            ->values()->all();

        return Response::text(json_encode($events, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}
