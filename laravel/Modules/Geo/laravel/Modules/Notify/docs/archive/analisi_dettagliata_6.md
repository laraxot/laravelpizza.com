# Analisi Dettagliata del Modulo Notify - Parte 6: Monitoraggio e Analytics

## 6. Monitoraggio e Analytics

### 6.1 Logging

#### 6.1.1 TemplateLogger
```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;
use Modules\Notify\Models\Template;

class TemplateLogger
{
    protected $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function created(): void
    {
        Log::info('Template created', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'version' => $this->template->version,
            'user_id' => auth()->id()
        ]);
    }

    public function updated(): void
    {
        Log::info('Template updated', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'version' => $this->template->version,
            'user_id' => auth()->id()
        ]);
    }

    public function deleted(): void
    {
        Log::info('Template deleted', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'user_id' => auth()->id()
        ]);
    }

    public function versionCreated(int $version): void
    {
        Log::info('Template version created', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'version' => $version,
            'user_id' => auth()->id()
        ]);
    }

    public function versionRolledBack(int $version): void
    {
        Log::info('Template version rolled back', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'version' => $version,
            'user_id' => auth()->id()
        ]);
    }

    public function translationCreated(string $locale): void
    {
        Log::info('Template translation created', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'locale' => $locale,
            'user_id' => auth()->id()
        ]);
    }

    public function translationUpdated(string $locale): void
    {
        Log::info('Template translation updated', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'locale' => $locale,
            'user_id' => auth()->id()
        ]);
    }

    public function translationDeleted(string $locale): void
    {
        Log::info('Template translation deleted', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'locale' => $locale,
            'user_id' => auth()->id()
        ]);
    }

    public function previewed(): void
    {
        Log::info('Template previewed', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'user_id' => auth()->id()
        ]);
    }

    public function tested(string $email): void
    {
        Log::info('Template tested', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'email' => $email,
            'user_id' => auth()->id()
        ]);
    }

    public function error(string $message, array $context = []): void
    {
        Log::error('Template error', array_merge([
            'id' => $this->template->id,
            'name' => $this->template->name,
            'message' => $message,
            'user_id' => auth()->id()
        ], $context));
    }
}
```

#### 6.1.2 MailgunLogger
```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;

class MailgunLogger
{
    public function webhookReceived(array $data): void
    {
        Log::info('Mailgun webhook received', [
            'event' => $data['event'],
            'message_id' => $data['message-id'],
            'recipient' => $data['recipient'],
            'domain' => $data['domain'],
            'timestamp' => $data['timestamp']
        ]);
    }

    public function emailSent(array $data): void
    {
        Log::info('Email sent', [
            'to' => $data['to'],
            'subject' => $data['subject'],
            'message_id' => $data['message-id'],
            'template_id' => $data['template_id']
        ]);
    }

    public function emailDelivered(array $data): void
    {
        Log::info('Email delivered', [
            'message_id' => $data['message-id'],
            'recipient' => $data['recipient'],
            'timestamp' => $data['timestamp']
        ]);
    }

    public function emailOpened(array $data): void
    {
        Log::info('Email opened', [
            'message_id' => $data['message-id'],
            'recipient' => $data['recipient'],
            'timestamp' => $data['timestamp'],
            'user_agent' => $data['user-agent']
        ]);
    }

    public function emailClicked(array $data): void
    {
        Log::info('Email clicked', [
            'message_id' => $data['message-id'],
            'recipient' => $data['recipient'],
            'timestamp' => $data['timestamp'],
            'url' => $data['url']
        ]);
    }

    public function emailBounced(array $data): void
    {
        Log::error('Email bounced', [
            'message_id' => $data['message-id'],
            'recipient' => $data['recipient'],
            'timestamp' => $data['timestamp'],
            'code' => $data['code'],
            'error' => $data['error']
        ]);
    }

    public function emailComplained(array $data): void
    {
        Log::warning('Email complained', [
            'message_id' => $data['message-id'],
            'recipient' => $data['recipient'],
            'timestamp' => $data['timestamp']
        ]);
    }

    public function emailUnsubscribed(array $data): void
    {
        Log::info('Email unsubscribed', [
            'message_id' => $data['message-id'],
            'recipient' => $data['recipient'],
            'timestamp' => $data['timestamp']
        ]);
    }

    public function webhookError(string $message, array $data): void
    {
        Log::error('Mailgun webhook error', [
            'message' => $message,
            'data' => $data
        ]);
    }
}
```

### 6.2 Analytics

#### 6.2.1 TemplateAnalytics
```php
namespace Modules\Notify\Services;

use Modules\Notify\Models\Template;
use Modules\Notify\Models\TemplateAnalytics;

class TemplateAnalytics
{
    protected $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function trackEvent(string $event, array $metadata = []): void
    {
        $this->template->analytics()->create([
            'event' => $event,
            'metadata' => $metadata,
            'user_agent' => request()->userAgent(),
            'ip_address' => request()->ip(),
            'session_id' => session()->getId()
        ]);
    }

    public function getStats(): array
    {
        return [
            'total_sent' => $this->getTotalSent(),
            'delivered' => $this->getDeliveredCount(),
            'opened' => $this->getOpenedCount(),
            'clicked' => $this->getClickedCount(),
            'bounced' => $this->getBouncedCount(),
            'complained' => $this->getComplainedCount(),
            'unsubscribed' => $this->getUnsubscribedCount(),
            'delivery_rate' => $this->getDeliveryRate(),
            'open_rate' => $this->getOpenRate(),
            'click_rate' => $this->getClickRate(),
            'bounce_rate' => $this->getBounceRate(),
            'complaint_rate' => $this->getComplaintRate(),
            'unsubscribe_rate' => $this->getUnsubscribeRate()
        ];
    }

    public function getTotalSent(): int
    {
        return $this->template->analytics()
            ->where('event', 'sent')
            ->count();
    }

    public function getDeliveredCount(): int
    {
        return $this->template->analytics()
            ->where('event', 'delivered')
            ->count();
    }

    public function getOpenedCount(): int
    {
        return $this->template->analytics()
            ->where('event', 'opened')
            ->count();
    }

    public function getClickedCount(): int
    {
        return $this->template->analytics()
            ->where('event', 'clicked')
            ->count();
    }

    public function getBouncedCount(): int
    {
        return $this->template->analytics()
            ->where('event', 'bounced')
            ->count();
    }

    public function getComplainedCount(): int
    {
        return $this->template->analytics()
            ->where('event', 'complained')
            ->count();
    }

    public function getUnsubscribedCount(): int
    {
        return $this->template->analytics()
            ->where('event', 'unsubscribed')
            ->count();
    }

    public function getDeliveryRate(): float
    {
        $sent = $this->getTotalSent();
        if ($sent === 0) {
            return 0;
        }

        return ($this->getDeliveredCount() / $sent) * 100;
    }

    public function getOpenRate(): float
    {
        $delivered = $this->getDeliveredCount();
        if ($delivered === 0) {
            return 0;
        }

        return ($this->getOpenedCount() / $delivered) * 100;
    }

    public function getClickRate(): float
    {
        $opened = $this->getOpenedCount();
        if ($opened === 0) {
            return 0;
        }

        return ($this->getClickedCount() / $opened) * 100;
    }

    public function getBounceRate(): float
    {
        $sent = $this->getTotalSent();
        if ($sent === 0) {
            return 0;
        }

        return ($this->getBouncedCount() / $sent) * 100;
    }

    public function getComplaintRate(): float
    {
        $delivered = $this->getDeliveredCount();
        if ($delivered === 0) {
            return 0;
        }

        return ($this->getComplainedCount() / $delivered) * 100;
    }

    public function getUnsubscribeRate(): float
    {
        $delivered = $this->getDeliveredCount();
        if ($delivered === 0) {
            return 0;
        }

        return ($this->getUnsubscribedCount() / $delivered) * 100;
    }

    public function getEventsByDate(string $event, string $startDate, string $endDate): array
    {
        return $this->template->analytics()
            ->where('event', $event)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();
    }

    public function getEventsByHour(string $event, string $date): array
    {
        return $this->template->analytics()
            ->where('event', $event)
            ->whereDate('created_at', $date)
            ->selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->pluck('count', 'hour')
            ->toArray();
    }

    public function getTopRecipients(string $event, int $limit = 10): array
    {
        return $this->template->analytics()
            ->where('event', $event)
            ->selectRaw('metadata->>"$.recipient" as recipient, COUNT(*) as count')
            ->groupBy('recipient')
            ->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->pluck('count', 'recipient')
            ->toArray();
    }

    public function getTopUserAgents(string $event, int $limit = 10): array
    {
        return $this->template->analytics()
            ->where('event', $event)
            ->whereNotNull('user_agent')
            ->selectRaw('user_agent, COUNT(*) as count')
            ->groupBy('user_agent')
            ->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->pluck('count', 'user_agent')
            ->toArray();
    }

    public function getTopIPs(string $event, int $limit = 10): array
    {
        return $this->template->analytics()
            ->where('event', $event)
            ->whereNotNull('ip_address')
            ->selectRaw('ip_address, COUNT(*) as count')
            ->groupBy('ip_address')
            ->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->pluck('count', 'ip_address')
            ->toArray();
    }

    public function getTopClickedUrls(int $limit = 10): array
    {
        return $this->template->analytics()
            ->where('event', 'clicked')
            ->selectRaw('metadata->>"$.url" as url, COUNT(*) as count')
            ->groupBy('url')
            ->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->pluck('count', 'url')
            ->toArray();
    }

    public function getBounceReasons(): array
    {
        return $this->template->analytics()
            ->where('event', 'bounced')
            ->selectRaw('metadata->>"$.error" as reason, COUNT(*) as count')
            ->groupBy('reason')
            ->orderByDesc('count')
            ->get()
            ->pluck('count', 'reason')
            ->toArray();
    }

    public function getBounceCodes(): array
    {
        return $this->template->analytics()
            ->where('event', 'bounced')
            ->selectRaw('metadata->>"$.code" as code, COUNT(*) as count')
            ->groupBy('code')
            ->orderByDesc('count')
            ->get()
            ->pluck('count', 'code')
            ->toArray();
    }
}
```

#### 6.2.2 AnalyticsExporter
```php
namespace Modules\Notify\Services;

use Modules\Notify\Models\Template;
use Illuminate\Support\Facades\Storage;

class AnalyticsExporter
{
    protected $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function exportToCsv(string $startDate, string $endDate): string
    {
        $filename = "analytics_{$this->template->id}_{$startDate}_{$endDate}.csv";
        $path = "analytics/{$filename}";

        $handle = fopen(Storage::path($path), 'w');

        // Intestazioni
        fputcsv($handle, [
            'Event',
            'Date',
            'Time',
            'Recipient',
            'User Agent',
            'IP Address',
            'Session ID',
            'Metadata'
        ]);

        // Dati
        $this->template->analytics()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at')
            ->each(function ($analytics) use ($handle) {
                fputcsv($handle, [
                    $analytics->event,
                    $analytics->created_at->format('Y-m-d'),
                    $analytics->created_at->format('H:i:s'),
                    $analytics->metadata['recipient'] ?? '',
                    $analytics->user_agent,
                    $analytics->ip_address,
                    $analytics->session_id,
                    json_encode($analytics->metadata)
                ]);
            });

        fclose($handle);

        return $path;
    }

    public function exportToJson(string $startDate, string $endDate): string
    {
        $filename = "analytics_{$this->template->id}_{$startDate}_{$endDate}.json";
        $path = "analytics/{$filename}";

        $data = $this->template->analytics()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at')
            ->get()
            ->map(function ($analytics) {
                return [
                    'event' => $analytics->event,
                    'date' => $analytics->created_at->format('Y-m-d'),
                    'time' => $analytics->created_at->format('H:i:s'),
                    'recipient' => $analytics->metadata['recipient'] ?? null,
                    'user_agent' => $analytics->user_agent,
                    'ip_address' => $analytics->ip_address,
                    'session_id' => $analytics->session_id,
                    'metadata' => $analytics->metadata
                ];
            });

        Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

        return $path;
    }

    public function exportToExcel(string $startDate, string $endDate): string
    {
        $filename = "analytics_{$this->template->id}_{$startDate}_{$endDate}.xlsx";
        $path = "analytics/{$filename}";

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Intestazioni
        $sheet->setCellValue('A1', 'Event');
        $sheet->setCellValue('B1', 'Date');
        $sheet->setCellValue('C1', 'Time');
        $sheet->setCellValue('D1', 'Recipient');
        $sheet->setCellValue('E1', 'User Agent');
        $sheet->setCellValue('F1', 'IP Address');
        $sheet->setCellValue('G1', 'Session ID');
        $sheet->setCellValue('H1', 'Metadata');

        // Dati
        $row = 2;
        $this->template->analytics()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at')
            ->each(function ($analytics) use ($sheet, &$row) {
                $sheet->setCellValue('A' . $row, $analytics->event);
                $sheet->setCellValue('B' . $row, $analytics->created_at->format('Y-m-d'));
                $sheet->setCellValue('C' . $row, $analytics->created_at->format('H:i:s'));
                $sheet->setCellValue('D' . $row, $analytics->metadata['recipient'] ?? '');
                $sheet->setCellValue('E' . $row, $analytics->user_agent);
                $sheet->setCellValue('F' . $row, $analytics->ip_address);
                $sheet->setCellValue('G' . $row, $analytics->session_id);
                $sheet->setCellValue('H' . $row, json_encode($analytics->metadata));
                $row++;
            });

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save(Storage::path($path));

        return $path;
    }
}
``` 
