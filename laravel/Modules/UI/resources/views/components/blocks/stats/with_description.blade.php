<?php

declare(strict_types=1);
?>
<div class="bg-white py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ __('ui::blocks_stats.header.our_mission.title') }}</h2>
        <div class="mt-6 flex flex-col gap-x-8 gap-y-20 lg:flex-row">
          <div class="lg:w-full lg:max-w-2xl lg:flex-auto">
            <p class="text-xl leading-8 text-gray-600">{{ __('ui::blocks_stats.body.mission.description') }}</p>
            <p class="mt-10 max-w-xl text-base leading-7 text-gray-700">{{ __('ui::blocks_stats.body.paragraph_a.description') }}</p>
          </div>
          <div class="lg:flex lg:flex-auto lg:justify-center">
            <dl class="w-64 space-y-8 xl:w-80">
              <div class="flex flex-col-reverse gap-y-4">
                <dt class="text-base leading-7 text-gray-600">{{ __('ui::blocks_stats.metrics.transactions_24h.label') }}</dt>
                <dd class="text-5xl font-semibold tracking-tight text-gray-900">{{ __('ui::blocks_stats.metrics.transactions_24h_amount.label') }}</dd>
              </div>
              <div class="flex flex-col-reverse gap-y-4">
                <dt class="text-base leading-7 text-gray-600">{{ __('ui::blocks_stats.metrics.assets_under_holding.label') }}</dt>
                <dd class="text-5xl font-semibold tracking-tight text-gray-900">{{ __('ui::blocks_stats.metrics.assets_amount.label') }}</dd>
              </div>
              <div class="flex flex-col-reverse gap-y-4">
                <dt class="text-base leading-7 text-gray-600">{{ __('ui::blocks_stats.metrics.new_users_annually.label') }}</dt>
                <dd class="text-5xl font-semibold tracking-tight text-gray-900">46,000</dd>
              </div>
            </dl>
          </div>
        </div>
      </div>
    </div>
  </div>
