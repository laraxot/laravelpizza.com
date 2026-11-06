<?php

declare(strict_types=1);
?>
<div class="relative bg-gray-900">
    <div class="absolute bottom-0 h-80 w-full xl:inset-0 xl:h-full">
      <div class="h-full w-full xl:grid xl:grid-cols-2">
        <div class="h-full xl:relative xl:col-start-2">
          <img class="h-full w-full object-cover opacity-25 xl:absolute xl:inset-0" src="https://images.unsplash.com/photo-1521737852567-6949f3f9f2b5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=2830&q=80&sat=-100" alt="{{ __('ui::blocks_stats.header.people_working_laptops.label') }}">
          <div aria-hidden="true" class="absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-gray-900 xl:inset-y-0 xl:left-0 xl:h-full xl:w-32 xl:bg-gradient-to-r"></div>
        </div>
      </div>
    </div>
    <div class="mx-auto max-w-4xl px-6 lg:max-w-7xl lg:px-8 xl:grid xl:grid-flow-col-dense xl:grid-cols-2 xl:gap-x-8">
      <div class="relative pb-64 pt-12 sm:pb-64 sm:pt-24 xl:col-start-1 xl:pb-24">
        <h2 class="text-base font-semibold text-indigo-300">{{ __('ui::blocks_stats.header.valuable_metrics.title') }}</h2>
        <p class="mt-3 text-3xl font-bold tracking-tight text-white">{{ __('ui::blocks_stats.header.actionable_data.title') }}</p>
        <p class="mt-5 text-lg text-gray-300">{{ __('ui::blocks_stats.header.actionable_data.description') }}</p>
        <div class="mt-12 grid grid-cols-1 gap-x-6 gap-y-12 sm:grid-cols-2">
          <p>
            <span class="block text-2xl font-bold text-white">8K+</span>
            <span class="mt-1 block text-base text-gray-300"><span class="font-medium text-white">{{ __('ui::blocks_stats.metrics.companies.label') }}</span> {{ __('ui::blocks_stats.metrics.companies.description') }}</span>
          </p>
          <p>
            <span class="block text-2xl font-bold text-white">25K+</span>
            <span class="mt-1 block text-base text-gray-300"><span class="font-medium text-white">{{ __('ui::blocks_stats.metrics.countries_globe.label') }}</span> {{ __('ui::blocks_stats.metrics.countries_globe.description') }}</span>
          </p>
          <p>
            <span class="block text-2xl font-bold text-white">98%</span>
            <span class="mt-1 block text-base text-gray-300"><span class="font-medium text-white">{{ __('ui::blocks_stats.metrics.customer_satisfaction.label') }}</span> {{ __('ui::blocks_stats.metrics.customer_satisfaction.description') }}</span>
          </p>
          <p>
            <span class="block text-2xl font-bold text-white">12M+</span>
            <span class="mt-1 block text-base text-gray-300"><span class="font-medium text-white">{{ __('ui::blocks_stats.metrics.issues_resolved.label') }}</span> {{ __('ui::blocks_stats.metrics.countries_globe.description') }}</span>
          </p>
        </div>
      </div>
    </div>
  </div>
