<?php

declare(strict_types=1);
?>
@extends('media::layouts.master')

@section('content')
    <h1>{{ __('media::convert_page.sections.title.title') }}</h1>

    <p>{{ __('media::convert_page.sections.module.label') }} {{ config('media.name') }}</p>

    <p>{{ __('media::convert_page.sections.media.label') }} {{ $id }}</p>
@endsection
