<?php

declare(strict_types=1);

?>
@extends('notify::mail-layouts.base.default')

@section('content')
    <div style="text-align: center; margin-bottom: 30px;">
        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="#4299E1"/>
        </svg>
    </div>

    <h1 style="color: #2D3748; font-size: 28px; text-align: center; margin-bottom: 20px;">
        {{ $title ?? __('notify::mail.promotion.title') }}
    </h1>

    @if(isset($subtitle))
        <p style="color: #4A5568; font-size: 18px; text-align: center; margin-bottom: 30px;">
            {{ $subtitle }}
        </p>
    @endif

    <div style="background-color: #EBF8FF; border-radius: 8px; padding: 20px; margin: 20px 0;">
        <h2 style="color: #2B6CB0; font-size: 24px; margin-bottom: 15px;">
            {{ $highlight_title ?? __('notify::mail.promotion.highlight') }}
        </h2>
        <p style="color: #4A5568; font-size: 16px; line-height: 1.6;">
            {{ $highlight_text }}
        </p>
    </div>

    @if(isset($features))
        <div style="margin: 30px 0;">
            @foreach($features as $feature)
                <div style="display: flex; align-items: center; margin-bottom: 15px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 10px;">
                        <path d="M9 16.17L4.83 12L3.41 13.41L9 19L21 7L19.59 5.59L9 16.17Z" fill="#48BB78"/>
                    </svg>
                    <span style="color: #2D3748;">{{ $feature }}</span>
                </div>
            @endforeach
        </div>
    @endif

    @if(isset($action_url))
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $action_url }}" class="button" style="background-color: #4299E1; color: white; padding: 15px 30px; border-radius: 6px; text-decoration: none; font-weight: bold; display: inline-block;">
                {{ $action_text ?? __('notify::mail.promotion.action') }}
            </a>
        </div>
    @endif

    @if(isset($disclaimer))
        <p style="color: #718096; font-size: 14px; text-align: center; margin-top: 30px;">
            {{ $disclaimer }}
        </p>
    @endif

    <div style="border-top: 1px solid #E2E8F0; margin-top: 30px; padding-top: 20px;">
        <p style="color: #718096; font-size: 14px; text-align: center;">
            {{ __('notify::mail.promotion.terms') }}
        </p>
    </div>
@endsection
