# Analisi Dettagliata del Modulo Notify - Parte 3: Servizi Core

## 3. Servizi Core

### 3.1 TemplateService

#### 3.1.1 Struttura Base
```php
namespace Modules\Notify\Services;

use Modules\Notify\Models\Template;
use Modules\Notify\Events\TemplateCreated;
use Modules\Notify\Events\TemplateUpdated;
use Modules\Notify\Events\TemplateDeleted;
use Modules\Notify\Exceptions\TemplateException;

class TemplateService
{
    protected $cache;
    protected $mjml;
    protected $mailgun;

    public function __construct(
        CacheService $cache,
        MjmlService $mjml,
        MailgunService $mailgun
    ) {
        $this->cache = $cache;
        $this->mjml = $mjml;
        $this->mailgun = $mailgun;
    }
}
```

#### 3.1.2 Gestione Template
```php
public function create(array $data): Template
{
    try {
        DB::beginTransaction();

        $template = Template::create([
            'name' => $data['name'],
            'subject' => $data['subject'],
            'content' => $data['content'],
            'layout' => $data['layout'] ?? 'default',
            'from_name' => $data['from_name'] ?? null,
            'from_email' => $data['from_email'] ?? null,
            'reply_to' => $data['reply_to'] ?? null,
            'cc' => $data['cc'] ?? null,
            'bcc' => $data['bcc'] ?? null,
            'attachments' => $data['attachments'] ?? null,
            'variables' => $data['variables'] ?? [],
            'settings' => $data['settings'] ?? []
        ]);

        // Crea versione iniziale
        $template->versions()->create([
            'version' => 1,
            'content' => $data['content'],
            'created_by' => auth()->id(),
            'status' => 'published'
        ]);

        // Crea traduzione default
        $template->translations()->create([
            'locale' => config('app.locale'),
            'content' => $data['content'],
            'subject' => $data['subject'],
            'from_name' => $data['from_name'] ?? null,
            'variables' => $data['variables'] ?? [],
            'translated_by' => auth()->id()
        ]);

        DB::commit();

        event(new TemplateCreated($template));

        return $template;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new TemplateException(
            "Failed to create template: {$e->getMessage()}"
        );
    }
}

public function update(Template $template, array $data): Template
{
    try {
        DB::beginTransaction();

        $oldVersion = $template->version;
        $newVersion = $oldVersion + 1;

        // Aggiorna template
        $template->update([
            'name' => $data['name'] ?? $template->name,
            'subject' => $data['subject'] ?? $template->subject,
            'content' => $data['content'] ?? $template->content,
            'layout' => $data['layout'] ?? $template->layout,
            'from_name' => $data['from_name'] ?? $template->from_name,
            'from_email' => $data['from_email'] ?? $template->from_email,
            'reply_to' => $data['reply_to'] ?? $template->reply_to,
            'cc' => $data['cc'] ?? $template->cc,
            'bcc' => $data['bcc'] ?? $template->bcc,
            'attachments' => $data['attachments'] ?? $template->attachments,
            'variables' => $data['variables'] ?? $template->variables,
            'settings' => $data['settings'] ?? $template->settings,
            'version' => $newVersion
        ]);

        // Crea nuova versione
        $template->versions()->create([
            'version' => $newVersion,
            'content' => $data['content'] ?? $template->content,
            'created_by' => auth()->id(),
            'changes' => $this->getChanges($template, $data),
            'status' => 'published',
            'notes' => $data['notes'] ?? null
        ]);

        // Aggiorna traduzione default
        $template->translations()
            ->where('locale', config('app.locale'))
            ->update([
                'content' => $data['content'] ?? $template->content,
                'subject' => $data['subject'] ?? $template->subject,
                'from_name' => $data['from_name'] ?? $template->from_name,
                'variables' => $data['variables'] ?? $template->variables
            ]);

        DB::commit();

        event(new TemplateUpdated($template));

        return $template;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new TemplateException(
            "Failed to update template: {$e->getMessage()}"
        );
    }
}

public function delete(Template $template): bool
{
    try {
        DB::beginTransaction();

        $template->delete();

        DB::commit();

        event(new TemplateDeleted($template));

        return true;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new TemplateException(
            "Failed to delete template: {$e->getMessage()}"
        );
    }
}
```

#### 3.1.3 Gestione Versioni
```php
public function createVersion(Template $template, array $data): TemplateVersion
{
    try {
        DB::beginTransaction();

        $newVersion = $template->version + 1;

        $version = $template->versions()->create([
            'version' => $newVersion,
            'content' => $data['content'],
            'created_by' => auth()->id(),
            'changes' => $this->getChanges($template, $data),
            'status' => $data['status'] ?? 'draft',
            'notes' => $data['notes'] ?? null
        ]);

        $template->update(['version' => $newVersion]);

        DB::commit();

        return $version;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new TemplateException(
            "Failed to create version: {$e->getMessage()}"
        );
    }
}

public function rollbackVersion(Template $template, int $version): Template
{
    try {
        DB::beginTransaction();

        $targetVersion = $template->versions()
            ->where('version', $version)
            ->firstOrFail();

        $template->update([
            'content' => $targetVersion->content,
            'version' => $version
        ]);

        DB::commit();

        return $template;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new TemplateException(
            "Failed to rollback version: {$e->getMessage()}"
        );
    }
}

protected function getChanges(Template $template, array $data): array
{
    $changes = [];

    foreach ($data as $key => $value) {
        if (isset($template->$key) && $template->$key !== $value) {
            $changes[$key] = [
                'old' => $template->$key,
                'new' => $value
            ];
        }
    }

    return $changes;
}
```

#### 3.1.4 Gestione Traduzioni
```php
public function createTranslation(Template $template, array $data): TemplateTranslation
{
    try {
        DB::beginTransaction();

        $translation = $template->translations()->create([
            'locale' => $data['locale'],
            'content' => $data['content'],
            'subject' => $data['subject'],
            'from_name' => $data['from_name'] ?? null,
            'variables' => $data['variables'] ?? [],
            'translated_by' => auth()->id()
        ]);

        DB::commit();

        return $translation;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new TemplateException(
            "Failed to create translation: {$e->getMessage()}"
        );
    }
}

public function updateTranslation(TemplateTranslation $translation, array $data): TemplateTranslation
{
    try {
        DB::beginTransaction();

        $translation->update([
            'content' => $data['content'] ?? $translation->content,
            'subject' => $data['subject'] ?? $translation->subject,
            'from_name' => $data['from_name'] ?? $translation->from_name,
            'variables' => $data['variables'] ?? $translation->variables
        ]);

        DB::commit();

        return $translation;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new TemplateException(
            "Failed to update translation: {$e->getMessage()}"
        );
    }
}

public function deleteTranslation(TemplateTranslation $translation): bool
{
    try {
        DB::beginTransaction();

        $translation->delete();

        DB::commit();

        return true;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new TemplateException(
            "Failed to delete translation: {$e->getMessage()}"
        );
    }
}
```

#### 3.1.5 Preview e Test
```php
public function preview(Template $template, array $variables = []): string
{
    try {
        $content = $this->replaceVariables(
            $template->content,
            $variables
        );

        return $this->mjml->compile($content);

    } catch (\Exception $e) {
        throw new TemplateException(
            "Failed to preview template: {$e->getMessage()}"
        );
    }
}

public function test(Template $template, string $email, array $variables = []): bool
{
    try {
        $content = $this->preview($template, $variables);

        return $this->mailgun->send([
            'to' => $email,
            'subject' => $template->subject,
            'html' => $content,
            'from_name' => $template->from_name,
            'from_email' => $template->from_email,
            'reply_to' => $template->reply_to,
            'cc' => $template->cc,
            'bcc' => $template->bcc,
            'attachments' => $template->attachments
        ]);

    } catch (\Exception $e) {
        throw new TemplateException(
            "Failed to test template: {$e->getMessage()}"
        );
    }
}

protected function replaceVariables(string $content, array $variables): string
{
    foreach ($variables as $key => $value) {
        $content = str_replace(
            "{{$key}}",
            $value,
            $content
        );
    }

    return $content;
}
```

### 3.2 MjmlService

#### 3.2.1 Struttura Base
```php
namespace Modules\Notify\Services;

use MJML\Mjml;
use MJML\MjmlException;

class MjmlService
{
    protected $mjml;
    protected $cache;

    public function __construct(CacheService $cache)
    {
        $this->mjml = new Mjml();
        $this->cache = $cache;
    }
}
```

#### 3.2.2 Compilazione MJML
```php
public function compile(string $content): string
{
    try {
        $cacheKey = $this->getCacheKey($content);

        return $this->cache->remember($cacheKey, function () use ($content) {
            return $this->mjml->render($content);
        });

    } catch (MjmlException $e) {
        throw new TemplateException(
            "Failed to compile MJML: {$e->getMessage()}"
        );
    }
}

public function validate(string $content): bool
{
    try {
        return $this->mjml->validate($content);
    } catch (MjmlException $e) {
        return false;
    }
}

protected function getCacheKey(string $content): string
{
    return 'mjml:' . md5($content);
}
```

#### 3.2.3 Estrazione Stili
```php
public function extractStyles(string $content): array
{
    $styles = [];

    // Estrai stili inline
    preg_match_all('/style="([^"]+)"/', $content, $matches);
    foreach ($matches[1] as $style) {
        $styles[] = $style;
    }

    // Estrai stili MJML
    preg_match_all('/mj-style>([^<]+)<\/mj-style>/', $content, $matches);
    foreach ($matches[1] as $style) {
        $styles[] = $style;
    }

    return array_unique($styles);
}

public function extractComponents(string $content): array
{
    $components = [];

    // Estrai componenti MJML
    preg_match_all('/<mj-([^>]+)>/', $content, $matches);
    foreach ($matches[1] as $component) {
        $components[] = $component;
    }

    return array_unique($components);
}
```

### 3.3 MailgunService

#### 3.3.1 Struttura Base
```php
namespace Modules\Notify\Services;

use Mailgun\Mailgun;
use Mailgun\Exception\MailgunException;

class MailgunService
{
    protected $mailgun;
    protected $domain;
    protected $cache;

    public function __construct(CacheService $cache)
    {
        $this->mailgun = Mailgun::create(
            config('services.mailgun.secret')
        );
        $this->domain = config('services.mailgun.domain');
        $this->cache = $cache;
    }
}
```

#### 3.3.2 Invio Email
```php
public function send(array $data): bool
{
    try {
        $message = [
            'from' => $this->formatFrom($data),
            'to' => $data['to'],
            'subject' => $data['subject'],
            'html' => $data['html'],
            'reply-to' => $data['reply_to'] ?? null,
            'cc' => $data['cc'] ?? null,
            'bcc' => $data['bcc'] ?? null,
            'attachment' => $this->formatAttachments($data['attachments'] ?? [])
        ];

        $response = $this->mailgun->messages()->send(
            $this->domain,
            $message
        );

        $this->logMessage($response);

        return true;

    } catch (MailgunException $e) {
        throw new TemplateException(
            "Failed to send email: {$e->getMessage()}"
        );
    }
}

protected function formatFrom(array $data): string
{
    if (isset($data['from_name'])) {
        return "{$data['from_name']} <{$data['from_email']}>";
    }

    return $data['from_email'];
}

protected function formatAttachments(array $attachments): array
{
    $formatted = [];

    foreach ($attachments as $attachment) {
        $formatted[] = [
            'filePath' => $attachment['path'],
            'filename' => $attachment['name']
        ];
    }

    return $formatted;
}

protected function logMessage($response): void
{
    // Log messaggio inviato
    Log::info('Email sent', [
        'id' => $response->getId(),
        'message' => $response->getMessage()
    ]);
}
```

#### 3.3.3 Gestione Eventi
```php
public function handleWebhook(array $data): void
{
    try {
        $event = $data['event'];
        $messageId = $data['message-id'];

        switch ($event) {
            case 'delivered':
                $this->handleDelivered($messageId);
                break;
            case 'opened':
                $this->handleOpened($messageId);
                break;
            case 'clicked':
                $this->handleClicked($messageId);
                break;
            case 'bounced':
                $this->handleBounced($messageId);
                break;
            case 'complained':
                $this->handleComplained($messageId);
                break;
            case 'unsubscribed':
                $this->handleUnsubscribed($messageId);
                break;
        }

    } catch (\Exception $e) {
        Log::error('Webhook error', [
            'error' => $e->getMessage(),
            'data' => $data
        ]);
    }
}

protected function handleDelivered(string $messageId): void
{
    // Aggiorna analytics
    $this->updateAnalytics($messageId, 'delivered');
}

protected function handleOpened(string $messageId): void
{
    // Aggiorna analytics
    $this->updateAnalytics($messageId, 'opened');
}

protected function handleClicked(string $messageId): void
{
    // Aggiorna analytics
    $this->updateAnalytics($messageId, 'clicked');
}

protected function handleBounced(string $messageId): void
{
    // Aggiorna analytics
    $this->updateAnalytics($messageId, 'bounced');
}

protected function handleComplained(string $messageId): void
{
    // Aggiorna analytics
    $this->updateAnalytics($messageId, 'complained');
}

protected function handleUnsubscribed(string $messageId): void
{
    // Aggiorna analytics
    $this->updateAnalytics($messageId, 'unsubscribed');
}

protected function updateAnalytics(string $messageId, string $event): void
{
    // Trova template
    $template = Template::where('message_id', $messageId)->first();
    if (!$template) {
        return;
    }

    // Crea analytics
    $template->analytics()->create([
        'event' => $event,
        'metadata' => [
            'message_id' => $messageId,
            'timestamp' => now()
        ]
    ]);
}
``` 
