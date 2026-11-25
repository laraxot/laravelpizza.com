<?php

declare(strict_types=1);
?>
@extends('pub_theme::layouts.app')
@section('title', __('xot::error_log.sections.title.title'))
@section('content')
<div class="text-center">
    <h3>{{ __('xot::error_log.sections.title.title') }}</h3>
</div>

<ul>
    @foreach ($files as $file)
    <li><a href="{{ request()->fullUrlWithQuery(['log' => $file->getFilename()]) }}">{{ $file->getFilename() }}</a></li>
    @endforeach
</ul>

@if ($urls !== [])
<h4>{{ __('xot::error_log.sections.urls.label') }}</h4>
<ul>
    @foreach ($urls as $url)
    <li>{{ stripslashes($url) }}</li>
    @endforeach
</ul>
@endif

@if ($content !== '')
<pre style="white-space: pre-wrap;">{{ $content }}</pre>
@endif
@endsection
