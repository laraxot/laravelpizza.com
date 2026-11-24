<?php

declare(strict_types=1);

namespace Modules\Notify\Enums;

enum NotificationStatusEnum: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case SENT = 'sent';
    case DELIVERED = 'delivered';
    case FAILED = 'failed';
    case OPENED = 'opened';
    case CLICKED = 'clicked';
}
