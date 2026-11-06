<?php

declare(strict_types=1);
?>
<div class="bg-white py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <div class="mx-auto max-w-2xl lg:max-w-none">
        <div class="text-center">
          <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ __('ui::blocks_stats.header.trusted_by_creators.title') }}</h2>
          <p class="mt-4 text-lg leading-8 text-gray-600">{{ __('ui::blocks_stats.header.trusted_by_creators.description') }}</p>
        </div>
        <dl class="mt-16 grid grid-cols-1 gap-0.5 overflow-hidden rounded-2xl text-center sm:grid-cols-2 lg:grid-cols-4">
          <div class="flex flex-col bg-gray-400/5 p-8">
            <dt class="text-sm font-semibold leading-6 text-gray-600">{{ __('ui::blocks_stats.metrics.creators.label') }}</dt>
            <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900">8,000+</dd>
          </div>
          <div class="flex flex-col bg-gray-400/5 p-8">
            <dt class="text-sm font-semibold leading-6 text-gray-600">{{ __('ui::blocks_stats.metrics.platform_fee.label') }}</dt>
            <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900">3%</dd>
          </div>
          <div class="flex flex-col bg-gray-400/5 p-8">
            <dt class="text-sm font-semibold leading-6 text-gray-600">{{ __('ui::blocks_stats.metrics.uptime.label') }}</dt>
            <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900">99.9%</dd>
          </div>
          <div class="flex flex-col bg-gray-400/5 p-8">
            <dt class="text-sm font-semibold leading-6 text-gray-600">{{ __('ui::blocks_stats.metrics.paid_out.label') }}</dt>
            <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900">$70M</dd>
          </div>
        </dl>
      </div>
    </div>
  </div>
