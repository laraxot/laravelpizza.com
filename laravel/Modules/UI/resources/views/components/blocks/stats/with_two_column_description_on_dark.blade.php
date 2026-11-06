<?php

declare(strict_types=1);
?>
<div class="bg-gray-900 py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
        <p class="text-base font-semibold leading-7 text-indigo-400">{{ __('ui::blocks_stats.header.deploy_faster.label') }}</p>
        <h1 class="mt-2 text-3xl font-bold tracking-tight text-white sm:text-4xl">{{ __('ui::blocks_stats.header.better_workflow.title') }}</h1>
        <div class="mt-10 grid max-w-xl grid-cols-1 gap-8 text-base leading-7 text-gray-300 lg:max-w-none lg:grid-cols-2">
          <div>
            <p>{{ __('ui::blocks_stats.body.paragraph_a.description') }}</p>
            <p class="mt-8">{{ __('ui::blocks_stats.body.paragraph_b.description') }}</p>
          </div>
          <div>
            <p>{{ __('ui::blocks_stats.body.paragraph_c.description') }}</p>
            <p class="mt-8">{{ __('ui::blocks_stats.body.paragraph_d.description') }}</p>
          </div>
        </div>
        <dl class="mt-16 grid grid-cols-1 gap-x-8 gap-y-12 sm:mt-20 sm:grid-cols-2 sm:gap-y-16 lg:mt-28 lg:grid-cols-4">
          <div class="flex flex-col-reverse gap-y-3 border-l border-white/20 pl-6">
            <dt class="text-base leading-7 text-gray-300">{{ __('ui::blocks_stats.company.founded.label') }}</dt>
            <dd class="text-3xl font-semibold tracking-tight text-white">2021</dd>
          </div>
          <div class="flex flex-col-reverse gap-y-3 border-l border-white/20 pl-6">
            <dt class="text-base leading-7 text-gray-300">{{ __('ui::blocks_stats.company.employees.label') }}</dt>
            <dd class="text-3xl font-semibold tracking-tight text-white">37</dd>
          </div>
          <div class="flex flex-col-reverse gap-y-3 border-l border-white/20 pl-6">
            <dt class="text-base leading-7 text-gray-300">{{ __('ui::blocks_stats.company.countries.label') }}</dt>
            <dd class="text-3xl font-semibold tracking-tight text-white">12</dd>
          </div>
          <div class="flex flex-col-reverse gap-y-3 border-l border-white/20 pl-6">
            <dt class="text-base leading-7 text-gray-300">{{ __('ui::blocks_stats.company.raised.label') }}</dt>
            <dd class="text-3xl font-semibold tracking-tight text-white">$25M</dd>
          </div>
        </dl>
      </div>
    </div>
  </div>
