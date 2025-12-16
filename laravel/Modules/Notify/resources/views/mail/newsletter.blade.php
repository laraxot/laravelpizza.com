<?php

declare(strict_types=1);

?>
@extends('notify::mail-layouts.base.default')

@section('content')
    <div style="text-align: center; margin-bottom: 30px;">
        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 4H4C2.9 4 2.01 4.9 2.01 6L2 18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6C22 4.9 21.1 4 20 4ZM19.6 8.25L12.53 12.67C12.21 12.87 11.79 12.87 11.47 12.67L4.4 8.25C4.15 8.09 4 7.82 4 7.53C4 6.86 4.73 6.46 5.3 6.81L12 11L18.7 6.81C19.27 6.46 20 6.86 20 7.53C20 7.82 19.85 8.09 19.6 8.25Z" fill="#4299E1"/>
        </svg>
    </div>

    <h1 style="color: #2D3748; font-size: 28px; text-align: center; margin-bottom: 20px;">
        {{ $title ?? __('notify::mail.newsletter.title') }}
    </h1>

    @if(isset($summary))
        <div style="background-color: #F7FAFC; border-radius: 8px; padding: 20px; margin: 20px 0;">
            <p style="color: #4A5568; font-size: 16px; line-height: 1.6;">
                {{ $summary }}
            </p>
        </div>
    @endif

    @if(isset($articles))
        <div style="margin: 30px 0;">
            @foreach($articles as $article)
                <div style="background-color: white; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    @if(isset($article['image']))
                        <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" style="width: 100%; border-radius: 4px; margin-bottom: 15px;">
                    @endif

                    <h3 style="color: #2D3748; font-size: 20px; margin-bottom: 10px;">
                        {{ $article['title'] }}
                    </h3>

                    <p style="color: #4A5568; font-size: 16px; line-height: 1.6; margin-bottom: 15px;">
                        {{ $article['excerpt'] }}
                    </p>

                    @if(isset($article['url']))
                        <a href="{{ $article['url'] }}" style="color: #4299E1; text-decoration: none; font-weight: 500;">
                            {{ __('notify::mail.newsletter.read_more') }} →
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    @if(isset($cta))
        <div style="text-align: center; margin: 30px 0; padding: 30px; background-color: #EBF8FF; border-radius: 8px;">
            <h2 style="color: #2B6CB0; font-size: 24px; margin-bottom: 15px;">
                {{ $cta['title'] }}
            </h2>
            <p style="color: #4A5568; font-size: 16px; margin-bottom: 20px;">
                {{ $cta['description'] }}
            </p>
            @if(isset($cta['url']))
                <a href="{{ $cta['url'] }}" class="button" style="background-color: #4299E1; color: white; padding: 15px 30px; border-radius: 6px; text-decoration: none; font-weight: bold; display: inline-block;">
                    {{ $cta['button_text'] }}
                </a>
            @endif
        </div>
    @endif

    <div style="border-top: 1px solid #E2E8F0; margin-top: 30px; padding-top: 20px;">
        <p style="color: #718096; font-size: 14px; text-align: center;">
            {{ __('notify::mail.newsletter.preferences') }}
            <a href="{{ config('notify.preferences_url') }}" style="color: #4299E1; text-decoration: none;">
                {{ __('notify::mail.newsletter.update_preferences') }}
            </a>
        </p>
    </div>
@endsection
