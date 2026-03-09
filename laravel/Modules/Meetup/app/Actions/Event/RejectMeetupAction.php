<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use DomainException;
use Modules\Meetup\Models\Event;
use Spatie\QueueableAction\QueueableAction;

class RejectMeetupAction
{
    use QueueableAction;

    /**
     * Reject a pending event proposal: status → rejected.
     * Rejected event remains visible to the proposer only.
     */
    public function execute(Event $event, string $rejectedBy, string $reason = ''): Event
    {
        if (! $event->isPending()) {
            throw new DomainException('Only pending events can be rejected.');
        }

        return app('db')->transaction(function () use ($event, $rejectedBy, $reason): Event {
            $event->status = 'rejected';
            $event->updated_by = $rejectedBy;

            if ($reason !== '') {
                $metaData = (array) ($event->meta_data ?? []);
                $metaData['rejection_reason'] = $reason;
                $event->meta_data = $metaData;
            }

            $event->save();

            $fresh = $event->fresh();
            \Webmozart\Assert\Assert::isInstanceOf($fresh, Event::class);

            return $fresh;
        });
    }
}
