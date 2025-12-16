<?php

declare(strict_types=1);

echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($rows as $item)
        <url>
            <loc>{{ url(Panel::make()->get($item->linkable)->url()) }}</loc>
            <lastmod>{{ $item->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
    @endforeach
</urlset>
