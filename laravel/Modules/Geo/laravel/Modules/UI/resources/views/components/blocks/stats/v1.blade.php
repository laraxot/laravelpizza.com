<?php

declare(strict_types=1);

?>
@props(['title', 'stats'])

<section class="bg-indigo-700">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:px-8 lg:py-20">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                {{ $title }}
            </h2>
        </div>
        <dl class="mt-10 text-center sm:max-w-3xl sm:mx-auto sm:grid sm:grid-cols-3 sm:gap-8">
            @foreach($stats as $stat)
                <div class="flex flex-col">
                    <dt class="order-2 mt-2 text-lg leading-6 font-medium text-indigo-200">
                        {{ $stat['label'] }}
                    </dt>
                    <dd class="order-1 text-5xl font-extrabold text-white">
                        {{ $stat['number'] }}
                    </dd>
                </div>
            @endforeach
        </dl>
    </div>
</section>
