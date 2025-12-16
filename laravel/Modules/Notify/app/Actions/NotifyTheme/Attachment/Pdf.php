<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\NotifyTheme\Attachment;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Notify\Actions\NotifyTheme\Get;
use Modules\Notify\Datas\AttachmentData;
use Modules\Xot\Services\HtmlService;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * -- buildmailmessage ha troppi pezzi simili ..
 */
class Pdf
{
    use QueueableAction;

    public function execute(string $post_type, array $view_params): AttachmentData
    {
        $notify_theme_data = app(Get::class)->execute($post_type, 'pdf', $view_params);
        $html = $notify_theme_data->body_html;

        $file_name = Str::slug($notify_theme_data->subject) . '.pdf';
        if (isset($view_params[$file_name])) {
            $file_name = $view_params[$file_name];
        }
        Assert::string($file_name, __FILE__ . ':' . __LINE__ . ' - ' . class_basename(__CLASS__));
        $file_path = Storage::disk('cache')->path($file_name);

        HtmlService::toPdf(
            filename: $file_path,
            html: $html,
            out: 'file',
            pdforientation: 'P',
        );

        return AttachmentData::from([
            'path' => $file_path,
            'as' => $file_name,
            'mime' => 'application/pdf',
        ]);
    }
}
