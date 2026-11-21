<?php

declare(strict_types=1);

use Laravel\Mcp\Facades\Mcp;
use Modules\Meetup\Mcp\Servers\MeetupServer;

/*
 * Server MCP (Model Context Protocol): POST /api/mcp con "Authorization: Bearer <token Passport>".
 * Un agente non si stanca mai: le chiamate sono limitate come quelle di ogni altra API.
 * Docs: Modules/Meetup/docs/mcp-server.md
 */
Mcp::web('/mcp', MeetupServer::class)->middleware(['auth:api', 'throttle:60,1']);
