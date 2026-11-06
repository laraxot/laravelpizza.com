<?php

declare(strict_types=1);
?>
<div class="bg-gray-900 py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <dl class="grid grid-cols-1 gap-x-8 gap-y-16 text-center lg:grid-cols-3">
        <div class="mx-auto flex max-w-xs flex-col gap-y-4">
          <dt class="text-base leading-7 text-gray-400">{{ __('ui::blocks_stats.metrics.transactions_24h.label') }}</dt>
          <dd class="order-first text-3xl font-semibold tracking-tight text-white sm:text-5xl">{{ __('ui::blocks_stats.metrics.transactions_24h_amount.label') }}</dd>
        </div>
        <div class="mx-auto flex max-w-xs flex-col gap-y-4">
          <dt class="text-base leading-7 text-gray-400">{{ __('ui::blocks_stats.metrics.assets_under_holding.label') }}</dt>
          <dd class="order-first text-3xl font-semibold tracking-tight text-white sm:text-5xl">{{ __('ui::blocks_stats.metrics.assets_amount.label') }}</dd>
        </div>
        <div class="mx-auto flex max-w-xs flex-col gap-y-4">
          <dt class="text-base leading-7 text-gray-400">{{ __('ui::blocks_stats.metrics.new_users_annually.label') }}</dt>
          <dd class="order-first text-3xl font-semibold tracking-tight text-white sm:text-5xl">46,000</dd>
        </div>
      </dl>
    </div>
  </div>
