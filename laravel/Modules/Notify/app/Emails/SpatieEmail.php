<?php

declare(strict_types=1);

namespace Modules\Notify\Emails;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Notify\Models\MailTemplate;
use Modules\Xot\Actions\Cast\SafeArrayByModelCastAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Datas\MetatagData;
use Modules\Xot\Datas\XotData;
use Mustache_Engine;
use Spatie\MailTemplates\Interfaces\MailTemplateInterface;
use Spatie\MailTemplates\TemplateMailable;
use Symfony\Component\Mime\MimeTypes;
use Webmozart\Assert\Assert;

use function Safe\file_get_contents;

/**
 * @see https://github.com/spatie/laravel-database-mail-templates
 */
class SpatieEmail extends TemplateMailable
{
    public string $slug;

    public array $data = [];

    // use our custom mail template model
    /** @var class-string<MailTemplateInterface> */
    protected static $templateModelClass = MailTemplate::class;

    /** @var array<int, Attachment> */
    protected array $customAttachments = [];

    /**
     * The email recipient.
     */
    protected ?string $recipient = null;

    public function __construct(Model $record, string $slug)
    {
        $this->slug = Str::slug($slug);

        $tpl = MailTemplate::firstOrCreate(
            [
                'mailable' => self::class,
                'slug' => $this->slug,
            ],
            [
                'subject' => 'Benvenuto, {{ first_name }}',
                'html_template' => '<p>Gentile {{ first_name }} {{ last_name }},</p><p>La tua registrazione  è in attesa di approvazione. Ti contatteremo presto.</p>['.
                        $this->slug.
                        ']',
                'text_template' => 'Gentile {{ first_name }} {{ last_name }}, la tua registrazione  è in attesa di approvazione. Ti contatteremo presto.['.
                        $this->slug.
                        ']',
                'sms_template' => 'Gentile {{ first_name }} {{ last_name }}, la tua registrazione  è in attesa di approvazione. Ti contatteremo presto.['.
                        $this->slug.
                        ']',
            ],
        );

        if ($tpl !== null) {
            $tpl->update(['counter' => $tpl->counter + 1]);
        }
        $lang = app()->getLocale();
        $data = app(SafeArrayByModelCastAction::class)->execute($record);
        $this->data['lang'] = $lang;
        $this->data['login_url'] = route('login');
        $this->data['site_url'] = url('/'.$lang);

        $this->data['logo_header'] = MetatagData::make()->getBrandLogo();
        $this->data['logo_header_base64'] = MetatagData::make()->getBrandLogoBase64();
        $this->data['logo_svg'] = MetatagData::make()->getBrandLogoSvg();

        $this->data = array_merge($this->data, $data);
        $this->setAdditionalData($this->data);

        $logoPath = MetatagData::make()->getBrandLogoPath();
        $this->embedLogo($logoPath, 'logo_header');
    }

    public function embedLogo(string $path, string $cid = 'logo_header'): self
    {
        if (! file_exists($path)) {
            return $this;
        }

        $mime = File::mimeType($path);
        if (! \is_string($mime)) {
            $mime = 'application/octet-stream';
        }
        $filename = basename($path);

        $attachment = Attachment::fromPath($path)->as($filename)->withMime($mime);

        $this->customAttachments[] = $attachment;

        return $this;
    }

    public function mergeData(array $data): self
    {
        $this->data = array_merge($this->data, $data);
        $this->setAdditionalData($this->data);
        $params = implode(',', array_keys($this->data));
        MailTemplate::where(['slug' => $this->slug, 'mailable' => self::class])->update(['params' => $params]);

        return $this;
    }

    /**
     * Set the email recipient.
     */
    public function setRecipient(string $email): self
    {
        $this->recipient = $email;

        return $this;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $envelope = new Envelope;

        // Set the recipient if available
        if ($this->recipient) {
            $envelope->to($this->recipient);
        }

        return $envelope;
    }

    public function getHtmlLayout(): string
    {
        /** @var MailTemplate $mailTemplate */
        $mailTemplate = $this->getMailTemplate();

        // Assicurarsi che html_layout_path sia una stringa prima di passarlo a base_path
        Assert::string($mailTemplate->html_layout_path);
        $html_layout_path = XotData::make()->getMailHtmlLayoutPath($mailTemplate->html_layout_path);

        return file_get_contents($html_layout_path);
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param  array{path: string, as?: string, mime?: string}  $attachment
     */
    public function getAttachmentFromPath(array $attachment): Attachment
    {
        /** @var string $path */
        $path = $attachment['path'];
        $res = Attachment::fromPath($path);
        /** @var array<string, string> $info */
        $info = pathinfo($path);
        /** @var string $filename */
        $filename = $attachment['as'] ?? ($info['basename'] ?? basename($path));
        /** @var string|null $mime */
        $mime = $attachment['mime'] ?? File::mimeType($path);
        if ($mime === null) {
            $mime = 'application/octet-stream';
        }

        return $res->as($filename)->withMime($mime);
    }

    public function getAttachmentFromData(array $attachment): Attachment
    {
        $res = Attachment::fromData(static fn () => $attachment['data']);
        /** @var string|null $asRaw */
        $asRaw = $attachment['as'] ?? null;
        $as = \is_string($asRaw) ? $asRaw : '';

        $mime = Arr::get($attachment, 'mime', null); // ?? File::mimeType($as);   file vuole un file esistente
        /** @var string $asForPathinfo */
        $asForPathinfo = \is_string($attachment['as']) ? $attachment['as'] : '';
        $info = pathinfo($asForPathinfo);
        if ($mime === null && isset($info['extension'])) {
            $mime = Arr::first(MimeTypes::getDefault()->getMimeTypes($info['extension']));
        }
        if ($mime === null) {
            $mime = 'application/octet-stream';
        }
        Assert::string($mime, __FILE__.':'.__LINE__.' - '.class_basename(self::class));

        /** @var string|null $asForMethod */
        $asForMethod = \is_string($asRaw) ? $asRaw : null;
        $res = $res->as($asForMethod)->withMime($mime);

        return $res;
    }

    /**
     * Add attachments to the email.
     *
     * @param  array<int, array<string, string>>  $attachments  Array of attachment data
     */
    public function addAttachments(array $attachments): self
    {
        $attachmentObjects = [];

        foreach ($attachments as $item) {
            $attachment = null;
            if (isset($item['path']) && file_exists($item['path'])) {
                $attachment = $this->getAttachmentFromPath($item);
            }

            if ($attachment === null && isset($item['data'])) {
                $attachment = $this->getAttachmentFromData($item);
            }

            if ($attachment) {
                $attachmentObjects[] = $attachment;
            }
        }

        $this->customAttachments = $attachmentObjects;

        return $this;
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return $this->customAttachments;
    }

    public function buildSms(): string
    {
        /* @phpstan-ignore method.notFound */
        /** @var MailTemplate $mailTemplate */
        $mailTemplate = $this->getMailTemplate();
        $sms_template = $mailTemplate->sms_template;
        /** @var string $smsTemplateString */
        $smsTemplateString = app(SafeStringCastAction::class)->execute($sms_template);
        $mustache = app(Mustache_Engine::class);

        return $mustache->render($smsTemplateString, $this->data);
    }
}
