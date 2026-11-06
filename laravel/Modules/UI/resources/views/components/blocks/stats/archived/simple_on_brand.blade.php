<?php

declare(strict_types=1);
?>
<div class="bg-indigo-800">
    <div class="mx-auto max-w-7xl px-6 py-12 sm:py-16 lg:px-8 lg:py-20">
      <div class="mx-auto max-w-4xl text-center">
        <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">{{ __('ui::blocks_stats.header.trusted_by_developers.title') }}</h2>
        <p class="mt-3 text-xl text-indigo-200 sm:mt-4">{{ __('ui::blocks_stats.header.trusted_by_developers.description') }}</p>
      </div>
      <dl class="mt-10 text-center sm:mx-auto sm:grid sm:max-w-3xl sm:grid-cols-3 sm:gap-8">
        <div class="flex flex-col">
          <dt class="order-2 mt-2 text-lg font-medium leading-6 text-indigo-200">{{ __('ui::blocks_stats.metrics.pepperoni.label') }}</dt>
          <dd class="order-1 text-5xl font-bold tracking-tight text-white">100%</dd>
        </div>
        <div class="mt-10 flex flex-col sm:mt-0">
          <dt class="order-2 mt-2 text-lg font-medium leading-6 text-indigo-200">{{ __('ui::blocks_stats.metrics.delivery.label') }}</dt>
          <dd class="order-1 text-5xl font-bold tracking-tight text-white">24/7</dd>
        </div>
        <div class="mt-10 flex flex-col sm:mt-0">
          <dt class="order-2 mt-2 text-lg font-medium leading-6 text-indigo-200">{{ __('ui::blocks_stats.metrics.calories.label') }}</dt>
          <dd class="order-1 text-5xl font-bold tracking-tight text-white">100k+</dd>
        </div>
      </dl>
    </div>
  </div>
