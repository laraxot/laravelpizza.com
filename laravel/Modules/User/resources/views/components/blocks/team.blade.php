<?php

declare(strict_types=1);

?>
@props(['title', 'description', 'members'])

<div class="py-16 bg-base-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-base text-primary font-semibold tracking-wide uppercase font-inter">{{ $title }}</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-base-content sm:text-4xl font-inter">
                {{ $description }}
            </p>
        </div>

        <div class="mt-16">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($members as $member)
                    <div class="card bg-base-200 shadow-xl hover:shadow-2xl transition-all duration-300">
                        <figure class="px-10 pt-10">
                            <div class="avatar">
                                <div class="w-32 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                                    <img src="{{ $member['image'] }}" alt="{{ $member['name'] }}" />
                                </div>
                            </div>
                        </figure>
                        <div class="card-body items-center text-center">
                            <h3 class="card-title text-xl font-inter">{{ $member['name'] }}</h3>
                            <p class="text-primary font-medium font-inter">{{ $member['role'] }}</p>
                            <p class="text-base-content/80 font-inter">{{ $member['description'] }}</p>
                            @if(isset($member['social']))
                                <div class="card-actions justify-center mt-4">
                                    @foreach($member['social'] as $platform => $url)
                                        <a href="{{ $url }}" class="btn btn-ghost btn-circle" target="_blank">
                                            @if($platform === 'twitter')
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                                </svg>
                                            @elseif($platform === 'linkedin')
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                                </svg>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
