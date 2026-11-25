<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Datas;

use Modules\Xot\Datas\MetatagData;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * Identita' del sito per i motori di ricerca: sameAs del JSON-LD e meta di verifica.
 *
 * @see Modules/Seo/docs/adr/search-engine-presence.md
 */

it('keeps only https profiles in sameAs, without placeholders or duplicates', function (): void {
    $meta = MetatagData::from([
        'facebook_href' => 'aa',
        'twitter_href' => 'http://twitter.com/example',
        'youtube_href' => 'https://www.youtube.com/@example',
        'same_as' => ['https://www.linkedin.com/company/example', 'https://www.youtube.com/@example', 'not a url'],
    ]);

    Assert::assertSame(['https://www.youtube.com/@example', 'https://www.linkedin.com/company/example'], $meta->getSameAs());
});

it('prints only the configured search engine verification tokens', function (): void {
    Assert::assertSame([], MetatagData::from([])->getSiteVerifications());

    $meta = MetatagData::from(['google_site_verification' => ' g-token ', 'bing_site_verification' => '', 'yandex_verification' => 'y-token']);

    Assert::assertSame(['google-site-verification' => 'g-token', 'yandex-verification' => 'y-token'], $meta->getSiteVerifications());
});
