<?php

declare(strict_types=1);

?>
@props(['text', 'level'])

<div class="py-4">
    {{-- {{ dddx($article->category_id) }} --}}
    {{-- <template x-if="true"> --}}
        <div class="flex flex-col gap-5">
            <article class="bg-white pt-6 lg:pl-6 pb-[18px] lg:pr-[18px] rounded-lg flex flex-col gap-6">
                <div class="pl-6 lg:pl-0">
                    <!-- Since there's no event_start_date, the related div is omitted -->
                    <a
                        href="#will-the-us-national-vacancies-rate-rise-above-66-in-q4"
                        class="mt-1 sm:max-w-[310px] text-xl font-semibold text-neutral-4 block"
                        >
                        {{ $text }}
                    </a>

                    <!-- categories -->
                    {{-- @include('pub_theme::article.show.content.title.categories') --}}

                </div>
                <div class="px-6 lg:px-0 flex items-center justify-between">
                    <!-- Placeholder for interactive elements such as tooltips -->
                </div>
            </article>
        </div>
    {{-- </template> --}}
</div>
