# Analisi Dettagliata del Modulo Notify - Parte 7: Manutenzione e Backup

## 7. Manutenzione e Backup

### 7.1 Versioning

#### 7.1.1 VersionManager
```php
namespace Modules\Notify\Services;

use Modules\Notify\Models\Template;
use Modules\Notify\Models\TemplateVersion;
use Modules\Notify\Exceptions\TemplateException;

class VersionManager
{
    protected $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function createVersion(array $data): TemplateVersion
    {
        try {
            $newVersion = $this->template->version + 1;

            $version = $this->template->versions()->create([
                'version' => $newVersion,
                'content' => $data['content'],
                'created_by' => auth()->id(),
                'changes' => $this->getChanges($data),
                'status' => $data['status'] ?? 'draft',
                'notes' => $data['notes'] ?? null
            ]);

            $this->template->update(['version' => $newVersion]);

            return $version;

        } catch (\Exception $e) {
            throw new TemplateException(
                "Failed to create version: {$e->getMessage()}"
            );
        }
    }

    public function rollbackVersion(int $version): Template
    {
        try {
            $targetVersion = $this->template->versions()
                ->where('version', $version)
                ->firstOrFail();

            $this->template->update([
                'content' => $targetVersion->content,
                'version' => $version
            ]);

            return $this->template;

        } catch (\Exception $e) {
            throw new TemplateException(
                "Failed to rollback version: {$e->getMessage()}"
            );
        }
    }

    public function compareVersions(int $version1, int $version2): array
    {
        try {
            $v1 = $this->template->versions()
                ->where('version', $version1)
                ->firstOrFail();

            $v2 = $this->template->versions()
                ->where('version', $version2)
                ->firstOrFail();

            return [
                'added' => $this->getAddedLines($v1->content, $v2->content),
                'removed' => $this->getRemovedLines($v1->content, $v2->content),
                'modified' => $this->getModifiedLines($v1->content, $v2->content)
            ];

        } catch (\Exception $e) {
            throw new TemplateException(
                "Failed to compare versions: {$e->getMessage()}"
            );
        }
    }

    public function getVersionHistory(): array
    {
        return $this->template->versions()
            ->orderBy('version', 'desc')
            ->get()
            ->map(function ($version) {
                return [
                    'version' => $version->version,
                    'content' => $version->content,
                    'status' => $version->status,
                    'notes' => $version->notes,
                    'created_at' => $version->created_at,
                    'created_by' => $version->creator->name
                ];
            })
            ->toArray();
    }

    protected function getChanges(array $data): array
    {
        $changes = [];

        foreach ($data as $key => $value) {
            if (isset($this->template->$key) && $this->template->$key !== $value) {
                $changes[$key] = [
                    'old' => $this->template->$key,
                    'new' => $value
                ];
            }
        }

        return $changes;
    }

    protected function getAddedLines(string $old, string $new): array
    {
        $oldLines = explode("\n", $old);
        $newLines = explode("\n", $new);
        return array_diff($newLines, $oldLines);
    }

    protected function getRemovedLines(string $old, string $new): array
    {
        $oldLines = explode("\n", $old);
        $newLines = explode("\n", $new);
        return array_diff($oldLines, $newLines);
    }

    protected function getModifiedLines(string $old, string $new): array
    {
        $oldLines = explode("\n", $old);
        $newLines = explode("\n", $new);
        $modified = [];

        foreach ($oldLines as $index => $line) {
            if (isset($newLines[$index]) && $line !== $newLines[$index]) {
                $modified[] = [
                    'old' => $line,
                    'new' => $newLines[$index]
                ];
            }
        }

        return $modified;
    }
}
```

### 7.2 Backup

#### 7.2.1 BackupManager
```php
namespace Modules\Notify\Services;

use Modules\Notify\Models\Template;
use Illuminate\Support\Facades\Storage;
use Modules\Notify\Exceptions\TemplateException;

class BackupManager
{
    protected $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function createBackup(): string
    {
        try {
            $filename = "backup_{$this->template->id}_" . date('Y-m-d_His') . ".json";
            $path = "backups/{$filename}";

            $data = [
                'template' => [
                    'id' => $this->template->id,
                    'name' => $this->template->name,
                    'subject' => $this->template->subject,
                    'content' => $this->template->content,
                    'layout' => $this->template->layout,
                    'is_active' => $this->template->is_active,
                    'version' => $this->template->version,
                    'from_name' => $this->template->from_name,
                    'from_email' => $this->template->from_email,
                    'reply_to' => $this->template->reply_to,
                    'cc' => $this->template->cc,
                    'bcc' => $this->template->bcc,
                    'attachments' => $this->template->attachments,
                    'variables' => $this->template->variables,
                    'settings' => $this->template->settings,
                    'created_at' => $this->template->created_at,
                    'updated_at' => $this->template->updated_at
                ],
                'versions' => $this->template->versions()
                    ->orderBy('version')
                    ->get()
                    ->map(function ($version) {
                        return [
                            'version' => $version->version,
                            'content' => $version->content,
                            'status' => $version->status,
                            'notes' => $version->notes,
                            'created_at' => $version->created_at,
                            'created_by' => $version->creator->name
                        ];
                    })
                    ->toArray(),
                'translations' => $this->template->translations()
                    ->get()
                    ->map(function ($translation) {
                        return [
                            'locale' => $translation->locale,
                            'content' => $translation->content,
                            'subject' => $translation->subject,
                            'from_name' => $translation->from_name,
                            'variables' => $translation->variables,
                            'created_at' => $translation->created_at,
                            'translated_by' => $translation->translator->name
                        ];
                    })
                    ->toArray()
            ];

            Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

            return $path;

        } catch (\Exception $e) {
            throw new TemplateException(
                "Failed to create backup: {$e->getMessage()}"
            );
        }
    }

    public function restoreFromBackup(string $path): Template
    {
        try {
            $data = json_decode(Storage::get($path), true);

            DB::beginTransaction();

            // Ripristina template
            $this->template->update([
                'name' => $data['template']['name'],
                'subject' => $data['template']['subject'],
                'content' => $data['template']['content'],
                'layout' => $data['template']['layout'],
                'is_active' => $data['template']['is_active'],
                'version' => $data['template']['version'],
                'from_name' => $data['template']['from_name'],
                'from_email' => $data['template']['from_email'],
                'reply_to' => $data['template']['reply_to'],
                'cc' => $data['template']['cc'],
                'bcc' => $data['template']['bcc'],
                'attachments' => $data['template']['attachments'],
                'variables' => $data['template']['variables'],
                'settings' => $data['template']['settings']
            ]);

            // Ripristina versioni
            $this->template->versions()->delete();
            foreach ($data['versions'] as $version) {
                $this->template->versions()->create([
                    'version' => $version['version'],
                    'content' => $version['content'],
                    'status' => $version['status'],
                    'notes' => $version['notes'],
                    'created_by' => auth()->id()
                ]);
            }

            // Ripristina traduzioni
            $this->template->translations()->delete();
            foreach ($data['translations'] as $translation) {
                $this->template->translations()->create([
                    'locale' => $translation['locale'],
                    'content' => $translation['content'],
                    'subject' => $translation['subject'],
                    'from_name' => $translation['from_name'],
                    'variables' => $translation['variables'],
                    'translated_by' => auth()->id()
                ]);
            }

            DB::commit();

            return $this->template;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new TemplateException(
                "Failed to restore from backup: {$e->getMessage()}"
            );
        }
    }

    public function getBackups(): array
    {
        return collect(Storage::files('backups'))
            ->filter(function ($path) {
                return str_starts_with(basename($path), "backup_{$this->template->id}_");
            })
            ->map(function ($path) {
                return [
                    'path' => $path,
                    'filename' => basename($path),
                    'created_at' => Storage::lastModified($path),
                    'size' => Storage::size($path)
                ];
            })
            ->sortByDesc('created_at')
            ->values()
            ->toArray();
    }

    public function deleteBackup(string $path): bool
    {
        try {
            return Storage::delete($path);
        } catch (\Exception $e) {
            throw new TemplateException(
                "Failed to delete backup: {$e->getMessage()}"
            );
        }
    }
}
```

#### 7.2.2 BackupCommand
```php
namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Models\Template;
use Modules\Notify\Services\BackupManager;

class BackupTemplatesCommand extends Command
{
    protected $signature = 'notify:backup-templates {--template= : ID del template da backuppare} {--all : Backup di tutti i template}';

    protected $description = 'Crea backup dei template';

    public function handle()
    {
        if ($this->option('all')) {
            $templates = Template::all();
        } elseif ($templateId = $this->option('template')) {
            $templates = Template::where('id', $templateId)->get();
        } else {
            $this->error('Specificare --template o --all');
            return 1;
        }

        $bar = $this->output->createProgressBar(count($templates));
        $bar->start();

        foreach ($templates as $template) {
            try {
                $backupManager = new BackupManager($template);
                $path = $backupManager->createBackup();
                $this->info("\nBackup creato: {$path}");
            } catch (\Exception $e) {
                $this->error("\nErrore nel backup del template {$template->id}: {$e->getMessage()}");
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Backup completato');

        return 0;
    }
}
```

### 7.3 Manutenzione

#### 7.3.1 MaintenanceManager
```php
namespace Modules\Notify\Services;

use Modules\Notify\Models\Template;
use Illuminate\Support\Facades\Cache;
use Modules\Notify\Exceptions\TemplateException;

class MaintenanceManager
{
    protected $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function cleanup(): void
    {
        try {
            // Pulisci cache
            $this->clearCache();

            // Pulisci analytics vecchi
            $this->cleanupAnalytics();

            // Pulisci backup vecchi
            $this->cleanupBackups();

            // Pulisci allegati non utilizzati
            $this->cleanupAttachments();

        } catch (\Exception $e) {
            throw new TemplateException(
                "Failed to cleanup: {$e->getMessage()}"
            );
        }
    }

    public function optimize(): void
    {
        try {
            // Ottimizza database
            $this->optimizeDatabase();

            // Ottimizza cache
            $this->optimizeCache();

            // Ottimizza storage
            $this->optimizeStorage();

        } catch (\Exception $e) {
            throw new TemplateException(
                "Failed to optimize: {$e->getMessage()}"
            );
        }
    }

    public function validate(): array
    {
        try {
            $issues = [];

            // Valida template
            if (!$this->validateTemplate()) {
                $issues[] = 'Template non valido';
            }

            // Valida versioni
            if (!$this->validateVersions()) {
                $issues[] = 'Versioni non valide';
            }

            // Valida traduzioni
            if (!$this->validateTranslations()) {
                $issues[] = 'Traduzioni non valide';
            }

            // Valida analytics
            if (!$this->validateAnalytics()) {
                $issues[] = 'Analytics non validi';
            }

            return $issues;

        } catch (\Exception $e) {
            throw new TemplateException(
                "Failed to validate: {$e->getMessage()}"
            );
        }
    }

    protected function clearCache(): void
    {
        Cache::tags(['template_' . $this->template->id])->flush();
    }

    protected function cleanupAnalytics(): void
    {
        $this->template->analytics()
            ->where('created_at', '<', now()->subMonths(3))
            ->delete();
    }

    protected function cleanupBackups(): void
    {
        $backups = collect(Storage::files('backups'))
            ->filter(function ($path) {
                return str_starts_with(basename($path), "backup_{$this->template->id}_");
            })
            ->sortByDesc(function ($path) {
                return Storage::lastModified($path);
            })
            ->skip(10);

        foreach ($backups as $backup) {
            Storage::delete($backup);
        }
    }

    protected function cleanupAttachments(): void
    {
        $usedAttachments = $this->template->attachments ?? [];
        $allAttachments = Storage::files('attachments');

        foreach ($allAttachments as $attachment) {
            if (!in_array($attachment, $usedAttachments)) {
                Storage::delete($attachment);
            }
        }
    }

    protected function optimizeDatabase(): void
    {
        DB::statement('OPTIMIZE TABLE templates');
        DB::statement('OPTIMIZE TABLE template_versions');
        DB::statement('OPTIMIZE TABLE template_translations');
        DB::statement('OPTIMIZE TABLE template_analytics');
    }

    protected function optimizeCache(): void
    {
        Cache::tags(['template_' . $this->template->id])->flush();
    }

    protected function optimizeStorage(): void
    {
        // Comprimi allegati
        foreach ($this->template->attachments ?? [] as $attachment) {
            if (Storage::exists($attachment)) {
                $content = Storage::get($attachment);
                $compressed = gzcompress($content);
                Storage::put($attachment . '.gz', $compressed);
            }
        }
    }

    protected function validateTemplate(): bool
    {
        return $this->template->is_valid;
    }

    protected function validateVersions(): bool
    {
        return $this->template->versions()
            ->where('is_valid', false)
            ->count() === 0;
    }

    protected function validateTranslations(): bool
    {
        return $this->template->translations()
            ->where('is_valid', false)
            ->count() === 0;
    }

    protected function validateAnalytics(): bool
    {
        return $this->template->analytics()
            ->where('is_valid', false)
            ->count() === 0;
    }
}
```

#### 7.3.2 MaintenanceCommand
```php
namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Models\Template;
use Modules\Notify\Services\MaintenanceManager;

class MaintainTemplatesCommand extends Command
{
    protected $signature = 'notify:maintain-templates {--template= : ID del template da mantenere} {--all : Manutenzione di tutti i template} {--cleanup : Pulisci risorse} {--optimize : Ottimizza risorse} {--validate : Valida risorse}';

    protected $description = 'Esegue manutenzione sui template';

    public function handle()
    {
        if ($this->option('all')) {
            $templates = Template::all();
        } elseif ($templateId = $this->option('template')) {
            $templates = Template::where('id', $templateId)->get();
        } else {
            $this->error('Specificare --template o --all');
            return 1;
        }

        $bar = $this->output->createProgressBar(count($templates));
        $bar->start();

        foreach ($templates as $template) {
            try {
                $maintenanceManager = new MaintenanceManager($template);

                if ($this->option('cleanup')) {
                    $maintenanceManager->cleanup();
                    $this->info("\nPulizia completata per il template {$template->id}");
                }

                if ($this->option('optimize')) {
                    $maintenanceManager->optimize();
                    $this->info("\nOttimizzazione completata per il template {$template->id}");
                }

                if ($this->option('validate')) {
                    $issues = $maintenanceManager->validate();
                    if (empty($issues)) {
                        $this->info("\nValidazione completata per il template {$template->id}");
                    } else {
                        $this->warn("\nProblemi trovati nel template {$template->id}:");
                        foreach ($issues as $issue) {
                            $this->warn("- {$issue}");
                        }
                    }
                }

            } catch (\Exception $e) {
                $this->error("\nErrore nella manutenzione del template {$template->id}: {$e->getMessage()}");
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Manutenzione completata');

        return 0;
    }
} 
