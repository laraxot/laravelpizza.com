<?php

declare(strict_types=1);

namespace Modules\Meetup\Mcp\Prompts;

use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Title;
use Laravel\Mcp\Server\Prompt;
use Laravel\Mcp\Server\Prompts\Argument;

#[Name('find_meetup')]
#[Title('Find my next meetup')]
#[Description('Suggests the upcoming meetups that fit the city and interests of the user and, after confirmation, registers to the chosen one.')]
class FindMeetupPrompt extends Prompt
{
    public function handle(Request $request): Response
    {
        $validated = $request->validate([
            'city' => ['nullable', 'string', 'max:100'],
            'interests' => ['nullable', 'string', 'max:200'],
        ]);
        $city = is_string($validated['city'] ?? null) && $validated['city'] !== '' ? $validated['city'] : 'any city';
        $interests = is_string($validated['interests'] ?? null) && $validated['interests'] !== '' ? $validated['interests'] : 'Laravel in general';

        return Response::text(<<<PROMPT
            I am looking for my next Laravel Pizza meetup. City: {$city}. Interests: {$interests}.

            1. Check my registrations with my_events, then the upcoming events with search_events (use the city filter only if it appears in "cities").
            2. Read the most relevant ones with show_event.
            3. Show me at most three events in a table: date, city, title, free seats, and one line on why each fits my interests.
            4. Register me with join_event only after I confirm which one.
            PROMPT);
    }

    /**
     * @return array<int, Argument>
     */
    public function arguments(): array
    {
        return [
            new Argument(name: 'city', description: 'Preferred city, e.g. "Milano".', required: false),
            new Argument(name: 'interests', description: 'Topics of interest, e.g. "testing and Filament".', required: false),
        ];
    }
}
