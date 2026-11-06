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

    /** @var array<string, mixed> */
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
                'slug' => $this->slug],
            [
                'subject' => 'Benvenuto, {{ first_name }}',
                // Difetto 16: senza layout getHtmlLayout() non ha un file da leggere
                'html_layout_path' => 'base.html',
                'html_template' => '<p>Gentile {{ first_name }} {{ last_name }},</p><p>La tua registrazione è in attesa di approvazione. Ti contatteremo presto.</p>',
                'text_template' => 'Gentile {{ first_name }} {{ last_name }}, la tua registrazione è in attesa di approvazione. Ti contatteremo presto.',
                'sms_template' => 'Gentile {{ first_name }} {{ last_name }}, la tua registrazione è in attesa di approvazione. Ti contatteremo presto.'],
        );

        if ($tpl !== null) {
            $tpl->update(['counter' => $tpl->counter + 1]);
        }
        if ($this->slug === 'verify-email') {
            $this->syncVerifyEmailTemplate($tpl, app()->getLocale());
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

    /**
     * @param  array<string, mixed>  $data
     */
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

    /**
     * Il template `verify-email` creato di default era un testo generico senza link: lo sostituisce
     * (solo se non e' stato personalizzato) con il testo di user::verification_email e il link firmato.
     */
    private function syncVerifyEmailTemplate(MailTemplate $tpl, string $lang): void
    {
        $current = SafeStringCastAction::cast($tpl->getTranslation('html_template', $lang, false));
        if ($current !== '' && str_contains($current, '{{ verification_url }}')) {
            return;
        }
        if ($current !== '' && ! str_contains($current, 'in attesa di approvazione')) {
            return; // personalizzato dall'admin
        }

        $t = static fn (string $key): string => (string) __('user::verification_email.'.$key, [], $lang);
        $button = 'display:inline-block;padding:12px 24px;background:#007a52;color:#ffffff;text-decoration:none;font-weight:600;border-radius:6px';
        $tpl->setTranslation('subject', $lang, $t('subject'));
        $tpl->setTranslation('html_template', $lang, '<p>'.$t('greeting').'</p><p>'.$t('intro').'</p>'
            .'<p><a href="{{ verification_url }}" style="'.$button.'">'.$t('action').'</a></p>'
            .'<p style="font-size:13px;color:#4b5563">'.$t('fallback').'<br>{{ verification_url }}</p>'
            .'<p style="font-size:13px;color:#4b5563">'.$t('ignore').'</p>');
        $tpl->setTranslation('text_template', $lang, $t('greeting').' '.$t('intro')."\n\n{{ verification_url }}\n\n".$t('ignore'));
        $tpl->save();
    }

    public function getHtmlLayout(): string
    {
        /** @var MailTemplate $mailTemplate */
        $mailTemplate = $this->getMailTemplate();

        // Template senza layout scelto (es. verify-email appena creato): layout base del tema
        $layout = is_string($mailTemplate->html_layout_path) && $mailTemplate->html_layout_path !== ''
            ? $mailTemplate->html_layout_path
            : 'base.html';
        $html_layout_path = XotData::make()->getMailHtmlLayoutPath($layout);

        return file_get_contents($html_layout_path);
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param  array<string, string>  $attachment
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

    /**
     * @param  array<string, mixed>  $attachment
     */
    public function getAttachmentFromData(array $attachment): Attachment
    {
        $res = Attachment::fromData(static fn () => $attachment['data']);
        /** @var string|null $asRaw */
        $asRaw = $attachment['as'] ?? null;

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
     * @param  array<int, array{path?: string, data?: mixed, as?: string|null, mime?: string|null}>  $attachments
     */
    public function addAttachments(array $attachments): self
    {
        $attachmentObjects = [];

        foreach ($attachments as $item) {
            $attachment = null;
            $path = $item['path'] ?? null;
            if (is_string($path) && $path !== '' && file_exists($path)) {
                /** @var array{path: string, as?: string, mime?: string} $pathAttachment */
                $pathAttachment = [
                    'path' => $path,
                    'as' => $item['as'] ?? null,
                    'mime' => $item['mime'] ?? null];
                $attachment = $this->getAttachmentFromPath($pathAttachment);
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
        /** @var MailTemplate $mailTemplate */
        $mailTemplate = $this->getMailTemplate();
        $sms_template = $mailTemplate->sms_template;
        /** @var string $smsTemplateString */
        $smsTemplateString = app(SafeStringCastAction::class)->execute($sms_template);
        $mustache = app(Mustache_Engine::class);

        return $mustache->render($smsTemplateString, $this->data);
    }

    /**
     * Mittente dell'SMS per questo template.
     *
     * Story quaeris-send-invite-migrate-to-record-notification.md, Difetto 9:
     * prima `RecordNotification::toSms()` scriveva il letterale 'Xot'. Catena:
     * `MailTemplate.sms_from` (per-survey, es. "VIVASERVIZI") → `config('sms.from')`
     * (globale) → `null` (il gateway usa il default del suo account).
     */
    public function buildSmsFrom(): ?string
    {
        /** @var MailTemplate $mailTemplate */
        $mailTemplate = $this->getMailTemplate();

        $smsFrom = $mailTemplate->sms_from;
        if (\is_string($smsFrom) && $smsFrom !== '') {
            return $smsFrom;
        }

        $configFrom = config('sms.from');

        return \is_string($configFrom) && $configFrom !== '' ? $configFrom : null;
    }
}
