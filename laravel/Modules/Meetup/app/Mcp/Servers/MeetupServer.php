<?php

declare(strict_types=1);

namespace Modules\Meetup\Mcp\Servers;

use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Version;
use Modules\Meetup\Mcp\Prompts\FindMeetupPrompt;
use Modules\Meetup\Mcp\Resources\UpcomingEventsResource;
use Modules\Meetup\Mcp\Tools\JoinEventTool;
use Modules\Meetup\Mcp\Tools\LeaveEventTool;
use Modules\Meetup\Mcp\Tools\MyEventsTool;
use Modules\Meetup\Mcp\Tools\SearchEventsTool;
use Modules\Meetup\Mcp\Tools\ShowEventTool;

/**
 * Server MCP di Laravel Pizza Meetups: Claude, Cursor e gli altri client MCP cercano gli eventi e gestiscono le
 * iscrizioni dell'utente del token. Ogni tool chiama le stesse Action del sito: nessuna logica duplicata.
 * Rotta: Modules/Meetup/routes/api.php. Docs: Modules/Meetup/docs/mcp-server.md.
 */
#[Name('Laravel Pizza Meetups')]
#[Version('1.0.0')]
#[Instructions('Laravel Pizza Meetups: in-person Laravel meetups in Italy. Search upcoming or past events, read an event, list the events of the authenticated user, register to an event or cancel a registration. Use the event slug returned by search_events. Ask the user before registering or cancelling: seats are limited. Dates are ISO 8601 in Europe/Rome.')]
class MeetupServer extends Server
{
    protected array $tools = [
        SearchEventsTool::class,
        ShowEventTool::class,
        MyEventsTool::class,
        JoinEventTool::class,
        LeaveEventTool::class,
    ];

    protected array $resources = [
        UpcomingEventsResource::class,
    ];

    protected array $prompts = [
        FindMeetupPrompt::class,
    ];
}
