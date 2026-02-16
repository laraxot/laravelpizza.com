<?php

declare(strict_types=1);

namespace Modules\Notify\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Notify\Actions\NotifyTheme\Get;
use Modules\Notify\Datas\AttachmentData;
use Spatie\LaravelData\DataCollection;
use Spatie\QueueableAction\QueueableAction;

use function Safe\mb_convert_encoding;

class BuildMailMessageAction
{
    use QueueableAction;

    /**
     * @param  DataCollection<AttachmentData>  $dataCollection
     */
    public function execute(
        string $name,
        Model $model,
        array $view_params = [],
        ?DataCollection $dataCollection = null,
    ): MailMessage {
        $view_params = array_merge($model->toArray(), $view_params);

        $type = 'email';

        $theme = app(Get::class)->execute($name, $type, $view_params);
        $view_html = 'notify::email';
        // dddx([$theme, $view_params]);
        $fromAddress = $theme->view_params['from_email'] ?? $theme->from_email;
        $fromName = $theme->view_params['from'] ?? $theme->from;
        $subject = $view_params['subject'] ?? $theme->subject;

        // Utilizziamo asserzioni per verificare che i valori siano stringhe
        if (! is_string($fromAddress)) {
            $fromAddress = '';
        }

        // Il nome del mittente può essere null
        if ($fromName !== null && ! is_string($fromName)) {
            $fromName = '';
        }

        if (! is_string($subject)) {
            $subject = 'Notifica';
        }

        $bodyHtml = $this->decodeRichText($theme->body_html);
        $subject = $this->decodeRichText($subject);
        $viewParams = $theme->view_params;
        $viewParams['body_html'] = $bodyHtml;
        $viewParams['subject'] = $subject;

        $email = (new MailMessage)
            ->from($fromAddress, $fromName)
            ->subject($subject)
            ->view($view_html, $viewParams);

        if ($dataCollection instanceof DataCollection) {
            foreach ($dataCollection as $attachment) {
                $email = $email->attach($attachment->path, ['as' => $attachment->as, 'mime' => $attachment->mime]);
            }
        }

        return $email;
    }

    private function decodeRichText(?string $content): string
    {
        if ($content === null) {
            return '';
        }

        $decoded = (string) html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        if (! mb_check_encoding($decoded, 'UTF-8') || str_contains($decoded, 'Ã') || str_contains($decoded, 'Â')) {
            $converted = mb_convert_encoding($decoded, 'UTF-8', 'ISO-8859-1');
            $decoded = is_string($converted) ? $converted : '';
        }

        return $decoded;
    }
}
