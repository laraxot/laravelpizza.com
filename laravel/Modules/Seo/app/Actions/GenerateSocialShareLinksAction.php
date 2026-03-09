<?php

declare(strict_types=1);

namespace Modules\Seo\Actions;

use Modules\Seo\Data\SocialShareData;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action to generate localized and encoded social media sharing links.
 */
class GenerateSocialShareLinksAction
{
    use QueueableAction;

    /**
     * Execute the action to construct sharing URLs.
     *
     * @param SocialShareData $data The sharing data.
     * @return array<string, string> Keyed by platform name, value is the sharing URL.
     */
    public function execute(SocialShareData $data): array
    {
        $text = $data->text ?? $data->title ?? '';

        return [
            'facebook' => "https://www.facebook.com/sharer/sharer.php?u=".urlencode($data->url),
            'twitter' => "https://twitter.com/intent/tweet?url=".urlencode($data->url)
                ."&text=".urlencode($text)
                .($data->via ? "&via=".urlencode($data->via) : "")
                .($data->hashtags ? "&hashtags=".urlencode($data->hashtags) : ""),
            'linkedin' => "https://www.linkedin.com/sharing/share-offsite/?url=".urlencode($data->url),
            'whatsapp' => "https://api.whatsapp.com/send?text=".urlencode($text." ".$data->url),
            'telegram' => "https://t.me/share/url?url=".urlencode($data->url)."&text=".urlencode($text),
            'copy' => $data->url,
        ];
    }
}
