<?php

declare(strict_types=1);
?>
@extends('notify::mail-layouts.base.default')

@section('content')
    <h1>{{ __('notify::mail_welcome.sections.header.title') }}</h1>

    <p>{{ __('notify::mail_welcome.messages.greeting.message', ['name' => $user->name]) }}</p>

    <p>{{ __('notify::mail_welcome.messages.description.description') }}</p>

    @if(isset($action_url))
        <div style="text-align: center;">
            <a href="{{ $action_url }}" class="button">
                {{ __('notify::mail_welcome.actions.start.label') }}
            </a>
        </div>
    @endif

    <p>{{ __('notify::mail_welcome.messages.help.message') }}</p>
@endsection
