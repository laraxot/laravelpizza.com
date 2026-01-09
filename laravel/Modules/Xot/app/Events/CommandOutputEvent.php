<?php

declare(strict_types=1);

namespace Modules\Xot\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommandOutputEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public string $processId,
        public string $output,
        public string $type = 'output',
    ) {
    }

    public function broadcastOn(): array
    {
        return [
            new Channel("command.{$this->processId}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'CommandOutput';
    }

    public function broadcastWith(): array
    {
        return [
            'processId' => $this->processId,
            'output' => $this->output,
            'type' => $this->type,
            'timestamp' => now()->toIso8601String(),
        ];
    }
}
