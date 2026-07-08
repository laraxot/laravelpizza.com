<?php

declare(strict_types=1);

?>
@php
'<?phpxml version="1.0" encoding="UTF-8"?>'.PHP_EOL
@endphp
<rss version="2.0">
    <channel>
        <title><![CDATA[ {{ config('metatag.title') }} ]]></title>
        <link><![CDATA[ {{ url('/') }} ]]></link>
        <description><![CDATA[ {{ config('metatag.description') }} ]]></description>
        <language>{{ $lang }}</language>
        <pubDate>{{ now() }}</pubDate>
        @foreach ($items as $item)
            <item>
                <title><![CDATA[{{ $item->title }}]]></title>
                <subtitle><![CDATA[{{ $item->subtitle }}]]></subtitle>
                {{-- guid o cosa? --}}
                <link> {{ url(Panel::make()->get($item)->url()) }} </link>
                <description><![CDATA[{!! $item->txt !!}]]></description>
                {{-- in category post_type? oppure togliamo il tag? oppure cosa?--}}
                <category>{{ $item->post_type }}</category>
                <author><![CDATA[{{ $item->created_by }}]]></author>
                {{-- guid o id?? --}}
                <guid>{{ $item-> }}</guid>
                <pubDate>{{ $item->created_at->toRssString() }}</pubDate>
            </item>
        @endforeach
    </channel>
</rss>