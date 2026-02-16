# Sistema Backup Email 

## Panoramica

Sistema di backup per preservare e ripristinare i template email.

## Backup Template

### 1. Template Backup

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Notify\Models\MailTemplate;

class MailTemplateBackup
{
    protected const BACKUP_PATH = 'backups/templates';
    protected const BACKUP_EXTENSION = 'json';

    public function createBackup(MailTemplate $template): string
    {
        $data = [
            'id' => $template->id,
            'name' => $template->name,
            'version' => $template->version,
            'content' => $template->content,
            'created_at' => $template->created_at,
            'updated_at' => $template->updated_at,
        ];

        $filename = $this->generateBackupFilename($template);
        $path = self::BACKUP_PATH . '/' . $filename;

        Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

        return $path;
    }

    public function restoreBackup(string $path): ?MailTemplate
    {
        if (!Storage::exists($path)) {
            return null;
        }

        $data = json_decode(Storage::get($path), true);
        
        return MailTemplate::updateOrCreate(
            ['id' => $data['id']],
            [
                'name' => $data['name'],
                'version' => $data['version'],
                'content' => $data['content'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]
        );
    }

    public function listBackups(): array
    {
        $files = Storage::files(self::BACKUP_PATH);
        $backups = [];

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === self::BACKUP_EXTENSION) {
                $backups[] = [
                    'path' => $file,
                    'size' => Storage::size($file),
                    'last_modified' => Storage::lastModified($file),
                ];
            }
        }

        return $backups;
    }

    protected function generateBackupFilename(MailTemplate $template): string
    {
        return sprintf(
            '%s_%s_%s.%s',
            $template->id,
            $template->name,
            now()->format('Y_m_d_His'),
            self::BACKUP_EXTENSION
        );
    }
}
```

### 2. Template Scheduler

```php
namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Services\MailTemplateBackup;

class MailTemplateBackupCommand extends Command
{
    protected $signature = 'mail:backup-templates';
    protected $description = 'Backup di tutti i template email';

    protected $backup;

    public function __construct(MailTemplateBackup $backup)
    {
        parent::__construct();
        $this->backup = $backup;
    }

    public function handle(): void
    {
        $templates = MailTemplate::all();
        $bar = $this->output->createProgressBar(count($templates));

        $this->info('Inizio backup template...');
        $bar->start();

        foreach ($templates as $template) {
            $this->backup->createBackup($template);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Backup template completato!');
    }
}
```

## Backup Notifiche

### 1. Notifiche Backup

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Notify\Models\MailNotification;

class MailNotificationBackup
{
    protected const BACKUP_PATH = 'backups/notifications';
    protected const BACKUP_EXTENSION = 'json';

    public function createBackup(MailNotification $notification): string
    {
        $data = [
            'id' => $notification->id,
            'template_id' => $notification->template_id,
            'status' => $notification->status,
            'sent_at' => $notification->sent_at,
            'opened_at' => $notification->opened_at,
            'clicked_at' => $notification->clicked_at,
            'created_at' => $notification->created_at,
            'updated_at' => $notification->updated_at,
        ];

        $filename = $this->generateBackupFilename($notification);
        $path = self::BACKUP_PATH . '/' . $filename;

        Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

        return $path;
    }

    public function restoreBackup(string $path): ?MailNotification
    {
        if (!Storage::exists($path)) {
            return null;
        }

        $data = json_decode(Storage::get($path), true);
        
        return MailNotification::updateOrCreate(
            ['id' => $data['id']],
            [
                'template_id' => $data['template_id'],
                'status' => $data['status'],
                'sent_at' => $data['sent_at'],
                'opened_at' => $data['opened_at'],
                'clicked_at' => $data['clicked_at'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]
        );
    }

    public function listBackups(): array
    {
        $files = Storage::files(self::BACKUP_PATH);
        $backups = [];

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === self::BACKUP_EXTENSION) {
                $backups[] = [
                    'path' => $file,
                    'size' => Storage::size($file),
                    'last_modified' => Storage::lastModified($file),
                ];
            }
        }

        return $backups;
    }

    protected function generateBackupFilename(MailNotification $notification): string
    {
        return sprintf(
            '%s_%s_%s.%s',
            $notification->id,
            $notification->template_id,
            now()->format('Y_m_d_His'),
            self::BACKUP_EXTENSION
        );
    }
}
```

### 2. Notifiche Scheduler

```php
namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Models\MailNotification;
use Modules\Notify\Services\MailNotificationBackup;

class MailNotificationBackupCommand extends Command
{
    protected $signature = 'mail:backup-notifications';
    protected $description = 'Backup di tutte le notifiche email';

    protected $backup;

    public function __construct(MailNotificationBackup $backup)
    {
        parent::__construct();
        $this->backup = $backup;
    }

    public function handle(): void
    {
        $notifications = MailNotification::all();
        $bar = $this->output->createProgressBar(count($notifications));

        $this->info('Inizio backup notifiche...');
        $bar->start();

        foreach ($notifications as $notification) {
            $this->backup->createBackup($notification);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Backup notifiche completato!');
    }
}
```

## Backup Queue

### 1. Queue Backup

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Notify\Models\MailQueue;

class MailQueueBackup
{
    protected const BACKUP_PATH = 'backups/queue';
    protected const BACKUP_EXTENSION = 'json';

    public function createBackup(MailQueue $job): string
    {
        $data = [
            'id' => $job->id,
            'template_id' => $job->template_id,
            'status' => $job->status,
            'attempts' => $job->attempts,
            'error' => $job->error,
            'created_at' => $job->created_at,
            'updated_at' => $job->updated_at,
        ];

        $filename = $this->generateBackupFilename($job);
        $path = self::BACKUP_PATH . '/' . $filename;

        Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

        return $path;
    }

    public function restoreBackup(string $path): ?MailQueue
    {
        if (!Storage::exists($path)) {
            return null;
        }

        $data = json_decode(Storage::get($path), true);
        
        return MailQueue::updateOrCreate(
            ['id' => $data['id']],
            [
                'template_id' => $data['template_id'],
                'status' => $data['status'],
                'attempts' => $data['attempts'],
                'error' => $data['error'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]
        );
    }

    public function listBackups(): array
    {
        $files = Storage::files(self::BACKUP_PATH);
        $backups = [];

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === self::BACKUP_EXTENSION) {
                $backups[] = [
                    'path' => $file,
                    'size' => Storage::size($file),
                    'last_modified' => Storage::lastModified($file),
                ];
            }
        }

        return $backups;
    }

    protected function generateBackupFilename(MailQueue $job): string
    {
        return sprintf(
            '%s_%s_%s.%s',
            $job->id,
            $job->template_id,
            now()->format('Y_m_d_His'),
            self::BACKUP_EXTENSION
        );
    }
}
```

### 2. Queue Scheduler

```php
namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Models\MailQueue;
use Modules\Notify\Services\MailQueueBackup;

class MailQueueBackupCommand extends Command
{
    protected $signature = 'mail:backup-queue';
    protected $description = 'Backup della coda email';

    protected $backup;

    public function __construct(MailQueueBackup $backup)
    {
        parent::__construct();
        $this->backup = $backup;
    }

    public function handle(): void
    {
        $jobs = MailQueue::all();
        $bar = $this->output->createProgressBar(count($jobs));

        $this->info('Inizio backup coda...');
        $bar->start();

        foreach ($jobs as $job) {
            $this->backup->createBackup($job);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Backup coda completato!');
    }
}
```

## Best Practices

### 1. Backup Retention

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class MailBackupRetention
{
    protected const RETENTION_DAYS = 30;

    public function cleanup(): void
    {
        $this->cleanupTemplates();
        $this->cleanupNotifications();
        $this->cleanupQueue();
    }

    protected function cleanupTemplates(): void
    {
        $files = Storage::files('backups/templates');
        $this->deleteExpiredFiles($files);
    }

    protected function cleanupNotifications(): void
    {
        $files = Storage::files('backups/notifications');
        $this->deleteExpiredFiles($files);
    }

    protected function cleanupQueue(): void
    {
        $files = Storage::files('backups/queue');
        $this->deleteExpiredFiles($files);
    }

    protected function deleteExpiredFiles(array $files): void
    {
        $expiryDate = Carbon::now()->subDays(self::RETENTION_DAYS);

        foreach ($files as $file) {
            if (Storage::lastModified($file) < $expiryDate->timestamp) {
                Storage::delete($file);
            }
        }
    }
}
```

### 2. Backup Encryption

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

class MailBackupEncryption
{
    public function encrypt(string $path): void
    {
        if (!Storage::exists($path)) {
            return;
        }

        $content = Storage::get($path);
        $encrypted = Crypt::encryptString($content);

        Storage::put($path, $encrypted);
    }

    public function decrypt(string $path): ?string
    {
        if (!Storage::exists($path)) {
            return null;
        }

        $encrypted = Storage::get($path);

        try {
            return Crypt::decryptString($encrypted);
        } catch (\Exception $e) {
            return null;
        }
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Backup Falliti**
   - Verifica spazio
   - Controlla permessi
   - Debug errori

2. **Ripristino Fallito**
   - Verifica integrità
   - Controlla versioni
   - Debug errori

3. **Performance**
   - Ottimizza spazio
   - Gestisci retention
   - Monitora backup

### 2. Debug

```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Models\MailNotification;
use Modules\Notify\Models\MailQueue;

class MailBackupDebugger
{
    protected $templateBackup;
    protected $notificationBackup;
    protected $queueBackup;
    protected $retention;
    protected $encryption;

    public function __construct(
        MailTemplateBackup $templateBackup,
        MailNotificationBackup $notificationBackup,
        MailQueueBackup $queueBackup,
        MailBackupRetention $retention,
        MailBackupEncryption $encryption
    ) {
        $this->templateBackup = $templateBackup;
        $this->notificationBackup = $notificationBackup;
        $this->queueBackup = $queueBackup;
        $this->retention = $retention;
        $this->encryption = $encryption;
    }

    public function debug(): array
    {
        return [
            'templates' => $this->debugTemplates(),
            'notifications' => $this->debugNotifications(),
            'queue' => $this->debugQueue(),
            'storage' => $this->debugStorage(),
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
                'backups' => $this->templateBackup->listBackups(),
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
                'status' => $notification->status,
                'backups' => $this->notificationBackup->listBackups(),
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
                'backups' => $this->queueBackup->listBackups(),
            ];
        }

        return $debug;
    }

    protected function debugStorage(): array
    {
        return [
            'templates' => [
                'path' => 'backups/templates',
                'size' => $this->getDirectorySize('backups/templates'),
                'count' => count(Storage::files('backups/templates')),
            ],
            'notifications' => [
                'path' => 'backups/notifications',
                'size' => $this->getDirectorySize('backups/notifications'),
                'count' => count(Storage::files('backups/notifications')),
            ],
            'queue' => [
                'path' => 'backups/queue',
                'size' => $this->getDirectorySize('backups/queue'),
                'count' => count(Storage::files('backups/queue')),
            ],
        ];
    }

    protected function getDirectorySize(string $path): int
    {
        $size = 0;
        $files = Storage::files($path);

        foreach ($files as $file) {
            $size += Storage::size($file);
        }

        return $size;
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)

## Vedi Anche
- [Laravel Storage](https://laravel.com/docs/storage)
- [Laravel Encryption](https://laravel.com/docs/encryption)
- [Laravel Commands](https://laravel.com/docs/artisan) 