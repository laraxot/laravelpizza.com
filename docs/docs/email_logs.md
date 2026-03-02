# Sistema Log Email 

## Panoramica

Sistema di log per tracciare e monitorare le attività del sistema email.

## Log Template

### 1. Template Log

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;
use Modules\Notify\Models\MailTemplate;

class MailTemplateLog
{
    protected const LOG_CHANNEL = 'mail-templates';

    public function logCreate(MailTemplate $template): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Template creato', [
            'template_id' => $template->id,
            'name' => $template->name,
            'version' => $template->version,
            'created_at' => now(),
        ]);
    }

    public function logUpdate(MailTemplate $template): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Template aggiornato', [
            'template_id' => $template->id,
            'name' => $template->name,
            'version' => $template->version,
            'updated_at' => now(),
        ]);
    }

    public function logDelete(MailTemplate $template): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Template eliminato', [
            'template_id' => $template->id,
            'name' => $template->name,
            'version' => $template->version,
            'deleted_at' => now(),
        ]);
    }

    public function logError(MailTemplate $template, \Throwable $e): void
    {
        Log::channel(self::LOG_CHANNEL)->error('Errore template', [
            'template_id' => $template->id,
            'name' => $template->name,
            'version' => $template->version,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'occurred_at' => now(),
        ]);
    }
}
```

### 2. Template Observer

```php
namespace Modules\Notify\Observers;

use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Services\MailTemplateLog;

class MailTemplateObserver
{
    protected $log;

    public function __construct(MailTemplateLog $log)
    {
        $this->log = $log;
    }

    public function created(MailTemplate $template): void
    {
        $this->log->logCreate($template);
    }

    public function updated(MailTemplate $template): void
    {
        $this->log->logUpdate($template);
    }

    public function deleted(MailTemplate $template): void
    {
        $this->log->logDelete($template);
    }
}
```

## Log Notifiche

### 1. Notifiche Log

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;
use Modules\Notify\Models\MailNotification;

class MailNotificationLog
{
    protected const LOG_CHANNEL = 'mail-notifications';

    public function logSend(MailNotification $notification): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Notifica inviata', [
            'notification_id' => $notification->id,
            'template_id' => $notification->template_id,
            'recipients' => $notification->recipients,
            'sent_at' => now(),
        ]);
    }

    public function logOpen(MailNotification $notification): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Notifica aperta', [
            'notification_id' => $notification->id,
            'template_id' => $notification->template_id,
            'opened_at' => now(),
        ]);
    }

    public function logClick(MailNotification $notification): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Notifica cliccata', [
            'notification_id' => $notification->id,
            'template_id' => $notification->template_id,
            'clicked_at' => now(),
        ]);
    }

    public function logError(MailNotification $notification, \Throwable $e): void
    {
        Log::channel(self::LOG_CHANNEL)->error('Errore notifica', [
            'notification_id' => $notification->id,
            'template_id' => $notification->template_id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'occurred_at' => now(),
        ]);
    }
}
```

### 2. Notifiche Observer

```php
namespace Modules\Notify\Observers;

use Modules\Notify\Models\MailNotification;
use Modules\Notify\Services\MailNotificationLog;

class MailNotificationObserver
{
    protected $log;

    public function __construct(MailNotificationLog $log)
    {
        $this->log = $log;
    }

    public function saved(MailNotification $notification): void
    {
        if ($notification->wasRecentlyCreated) {
            $this->log->logSend($notification);
        }
    }

    public function updated(MailNotification $notification): void
    {
        if ($notification->isDirty('opened_at')) {
            $this->log->logOpen($notification);
        }

        if ($notification->isDirty('clicked_at')) {
            $this->log->logClick($notification);
        }
    }
}
```

## Log Queue

### 1. Queue Log

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;
use Modules\Notify\Models\MailQueue;

class MailQueueLog
{
    protected const LOG_CHANNEL = 'mail-queue';

    public function logAdd(MailQueue $job): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Job aggiunto', [
            'job_id' => $job->id,
            'template_id' => $job->template_id,
            'status' => $job->status,
            'added_at' => now(),
        ]);
    }

    public function logProcess(MailQueue $job): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Job processato', [
            'job_id' => $job->id,
            'template_id' => $job->template_id,
            'status' => $job->status,
            'processed_at' => now(),
        ]);
    }

    public function logFail(MailQueue $job): void
    {
        Log::channel(self::LOG_CHANNEL)->error('Job fallito', [
            'job_id' => $job->id,
            'template_id' => $job->template_id,
            'status' => $job->status,
            'error' => $job->error,
            'failed_at' => now(),
        ]);
    }

    public function logRetry(MailQueue $job): void
    {
        Log::channel(self::LOG_CHANNEL)->info('Job riprovato', [
            'job_id' => $job->id,
            'template_id' => $job->template_id,
            'status' => $job->status,
            'attempts' => $job->attempts,
            'retried_at' => now(),
        ]);
    }
}
```

### 2. Queue Observer

```php
namespace Modules\Notify\Observers;

use Modules\Notify\Models\MailQueue;
use Modules\Notify\Services\MailQueueLog;

class MailQueueObserver
{
    protected $log;

    public function __construct(MailQueueLog $log)
    {
        $this->log = $log;
    }

    public function created(MailQueue $job): void
    {
        $this->log->logAdd($job);
    }

    public function updated(MailQueue $job): void
    {
        if ($job->isDirty('status')) {
            switch ($job->status) {
                case 'processing':
                    $this->log->logProcess($job);
                    break;
                case 'failed':
                    $this->log->logFail($job);
                    break;
                case 'retrying':
                    $this->log->logRetry($job);
                    break;
            }
        }
    }
}
```

## Best Practices

### 1. Log Channels

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;

class MailLogChannels
{
    public const TEMPLATES = 'mail-templates';
    public const NOTIFICATIONS = 'mail-notifications';
    public const QUEUE = 'mail-queue';

    public static function all(): array
    {
        return [
            self::TEMPLATES,
            self::NOTIFICATIONS,
            self::QUEUE,
        ];
    }

    public static function clear(): void
    {
        foreach (self::all() as $channel) {
            Log::channel($channel)->info('Log cleared', [
                'cleared_at' => now(),
            ]);
        }
    }
}
```

### 2. Log Events

```php
namespace Modules\Notify\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\MailNotification;
use Modules\Notify\Models\MailQueue;

class MailTemplateLogged
{
    use SerializesModels;

    public $template;
    public $action;

    public function __construct(MailTemplate $template, string $action)
    {
        $this->template = $template;
        $this->action = $action;
    }
}

class MailNotificationLogged
{
    use SerializesModels;

    public $notification;
    public $action;

    public function __construct(MailNotification $notification, string $action)
    {
        $this->notification = $notification;
        $this->action = $action;
    }
}

class MailQueueLogged
{
    use SerializesModels;

    public $job;
    public $action;

    public function __construct(MailQueue $job, string $action)
    {
        $this->job = $job;
        $this->action = $action;
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Log non scritti**
   - Verifica permessi
   - Controlla canali
   - Debug log

2. **Performance**
   - Monitora spazio
   - Ottimizza rotazione
   - Usa canali

3. **Debug**
   - Verifica livelli
   - Controlla formati
   - Monitora errori

### 2. Debug

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;

class MailLogDebugger
{
    protected $templateLog;
    protected $notificationLog;
    protected $queueLog;

    public function __construct(
        MailTemplateLog $templateLog,
        MailNotificationLog $notificationLog,
        MailQueueLog $queueLog
    ) {
        $this->templateLog = $templateLog;
        $this->notificationLog = $notificationLog;
        $this->queueLog = $queueLog;
    }

    public function debug(): array
    {
        return [
            'templates' => $this->debugTemplates(),
            'notifications' => $this->debugNotifications(),
            'queue' => $this->debugQueue(),
            'channels' => $this->debugChannels(),
        ];
    }

    protected function debugTemplates(): array
    {
        $debug = [];
        $templates = MailTemplate::all();

        foreach ($templates as $template) {
            $debug[$template->id] = [
                'name' => $template->name,
                'version' => $template->version,
                'created_at' => $template->created_at,
                'updated_at' => $template->updated_at,
                'deleted_at' => $template->deleted_at,
            ];
        }

        return $debug;
    }

    protected function debugNotifications(): array
    {
        $debug = [];
        $notifications = MailNotification::all();

        foreach ($notifications as $notification) {
            $debug[$notification->id] = [
                'template_id' => $notification->template_id,
                'recipients' => $notification->recipients,
                'sent_at' => $notification->sent_at,
                'opened_at' => $notification->opened_at,
                'clicked_at' => $notification->clicked_at,
            ];
        }

        return $debug;
    }

    protected function debugQueue(): array
    {
        $debug = [];
        $jobs = MailQueue::all();

        foreach ($jobs as $job) {
            $debug[$job->id] = [
                'template_id' => $job->template_id,
                'status' => $job->status,
                'attempts' => $job->attempts,
                'error' => $job->error,
                'created_at' => $job->created_at,
                'updated_at' => $job->updated_at,
            ];
        }

        return $debug;
    }

    protected function debugChannels(): array
    {
        return [
            'templates' => [
                'enabled' => Log::channel(MailLogChannels::TEMPLATES)->isEnabled(),
                'level' => Log::channel(MailLogChannels::TEMPLATES)->getLevel(),
            ],
            'notifications' => [
                'enabled' => Log::channel(MailLogChannels::NOTIFICATIONS)->isEnabled(),
                'level' => Log::channel(MailLogChannels::NOTIFICATIONS)->getLevel(),
            ],
            'queue' => [
                'enabled' => Log::channel(MailLogChannels::QUEUE)->isEnabled(),
                'level' => Log::channel(MailLogChannels::QUEUE)->getLevel(),
            ],
        ];
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)

## Vedi Anche
- [Laravel Logging](https://laravel.com/project_docs/logging)
- [Laravel Events](https://laravel.com/project_docs/events)
- [Laravel Observers](https://laravel.com/project_docs/eloquent#observers) 