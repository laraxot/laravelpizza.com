<?php

declare(strict_types=1);

?>
@extends('notify::mail-layouts.base.default')

@section('content')
    <h1>{{ __('notify::mail.welcome.title') }}</h1>

    <p>{{ __('notify::mail.welcome.greeting', ['name' => $user->name]) }}</p>

    <p>{{ __('notify::mail.welcome.description') }}</p>

    @if(isset($action_url))
        <div style="text-align: center;">
            <a href="{{ $action_url }}" class="button">
                {{ __('notify::mail.welcome.action') }}
            </a>
        </div>
    @endif

    <p>{{ __('notify::mail.welcome.help') }}</p>
@endsection
