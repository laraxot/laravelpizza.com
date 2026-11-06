<?php

declare(strict_types=1);
?>
{{-- Requires js --}}
<div class="bg-white py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <div class="mx-auto max-w-4xl text-center">
        <h2 class="text-base font-semibold leading-7 text-indigo-600">{{ __('ui::blocks_pricing_plans.header.pricing.label') }}</h2>
        <p class="mt-2 text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">{!! __('ui::blocks_pricing_plans.header.plans_all_sizes.title') !!}</p>
      </div>
      <p class="mx-auto mt-6 max-w-2xl text-center text-lg leading-8 text-gray-600">{{ __('ui::blocks_pricing_plans.header.affordable_plan.description') }}</p>
      <div class="mt-16 flex justify-center">
        <fieldset class="grid grid-cols-2 gap-x-1 rounded-full p-1 text-center text-xs font-semibold leading-5 ring-1 ring-inset ring-gray-200">
          <legend class="sr-only">{{ __('ui::blocks_pricing_plans.billing.payment_frequency.label') }}</legend>
          <!-- Checked: "bg-indigo-600 text-white", Not Checked: "text-gray-500" -->
          <label class="cursor-pointer rounded-full px-2.5 py-1">
            <input type="radio" name="frequency" value="monthly" class="sr-only">
            <span>{{ __('ui::blocks_pricing_plans.billing.monthly.label') }}</span>
          </label>
          <!-- Checked: "bg-indigo-600 text-white", Not Checked: "text-gray-500" -->
          <label class="cursor-pointer rounded-full px-2.5 py-1">
            <input type="radio" name="frequency" value="annually" class="sr-only">
            <span>{{ __('ui::blocks_pricing_plans.billing.annually.label') }}</span>
          </label>
        </fieldset>
      </div>
      <div class="isolate mx-auto mt-10 grid max-w-md grid-cols-1 gap-8 lg:mx-0 lg:max-w-none lg:grid-cols-3">
        <div class="rounded-3xl p-8 xl:p-10 ring-1 ring-gray-200">
          <div class="flex items-center justify-between gap-x-4">
            <h3 id="tier-freelancer" class="text-lg font-semibold leading-8 text-gray-900">{{ __('ui::blocks_pricing_plans.tiers.freelancer.label') }}</h3>
          </div>
          <p class="mt-4 text-sm leading-6 text-gray-600">{{ __('ui::blocks_pricing_plans.tiers.freelancer.description') }}</p>
          <p class="mt-6 flex items-baseline gap-x-1">
            <!-- Price, update based on frequency toggle state -->
            <span class="text-4xl font-bold tracking-tight text-gray-900">$15</span>
            <!-- Payment frequency, update based on frequency toggle state -->
            <span class="text-sm font-semibold leading-6 text-gray-600">{{ __('ui::blocks_pricing_plans.billing.per_month.label') }}</span>
          </p>
          <a href="#" aria-describedby="tier-freelancer" class="mt-6 block rounded-md py-2 px-3 text-center text-sm font-semibold leading-6 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 text-indigo-600 ring-1 ring-inset ring-indigo-200 hover:ring-indigo-300">{{ __('ui::blocks_pricing_plans.actions.buy_plan.label') }}</a>
          <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-gray-600 xl:mt-10">
            <li class="flex gap-x-3">
              <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
              </svg>
              {{ __('ui::blocks_pricing_plans.features.products_5.label') }}
            </li>
            <li class="flex gap-x-3">
              <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
              </svg>
              {{ __('ui::blocks_pricing_plans.features.subscribers_1000.label') }}
            </li>
            <li class="flex gap-x-3">
              <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
              </svg>
              {{ __('ui::blocks_pricing_plans.features.basic_analytics.label') }}
            </li>
            <li class="flex gap-x-3">
              <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
              </svg>
              {{ __('ui::blocks_pricing_plans.features.support_48h.label') }}
            </li>
          </ul>
        </div>
        <div class="rounded-3xl p-8 xl:p-10 ring-2 ring-indigo-600">
          <div class="flex items-center justify-between gap-x-4">
            <h3 id="tier-startup" class="text-lg font-semibold leading-8 text-indigo-600">{{ __('ui::blocks_pricing_plans.tiers.startup.label') }}</h3>
            <p class="rounded-full bg-indigo-600/10 px-2.5 py-1 text-xs font-semibold leading-5 text-indigo-600">{{ __('ui::blocks_pricing_plans.tiers.most_popular.label') }}</p>
          </div>
          <p class="mt-4 text-sm leading-6 text-gray-600">{{ __('ui::blocks_pricing_plans.tiers.startup.description') }}</p>
          <p class="mt-6 flex items-baseline gap-x-1">
            <!-- Price, update based on frequency toggle state -->
            <span class="text-4xl font-bold tracking-tight text-gray-900">$30</span>
            <!-- Payment frequency, update based on frequency toggle state -->
            <span class="text-sm font-semibold leading-6 text-gray-600">{{ __('ui::blocks_pricing_plans.billing.per_month.label') }}</span>
          </p>
          <a href="#" aria-describedby="tier-startup" class="mt-6 block rounded-md py-2 px-3 text-center text-sm font-semibold leading-6 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 bg-indigo-600 text-white shadow-sm hover:bg-indigo-500">{{ __('ui::blocks_pricing_plans.actions.buy_plan.label') }}</a>
          <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-gray-600 xl:mt-10">
            <li class="flex gap-x-3">
              <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
              </svg>
              {{ __('ui::blocks_pricing_plans.features.products_25.label') }}
            </li>
            <li class="flex gap-x-3">
              <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
              </svg>
              {{ __('ui::blocks_pricing_plans.features.subscribers_10000.label') }}
            </li>
            <li class="flex gap-x-3">
              <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
              </svg>
              {{ __('ui::blocks_pricing_plans.features.advanced_analytics.label') }}
            </li>
            <li class="flex gap-x-3">
              <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
              </svg>
              {{ __('ui::blocks_pricing_plans.features.support_24h.label') }}
            </li>
            <li class="flex gap-x-3">
              <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
              </svg>
              {{ __('ui::blocks_pricing_plans.features.marketing_automations.label') }}
            </li>
          </ul>
        </div>
        <div class="rounded-3xl p-8 xl:p-10 ring-1 ring-gray-200">
          <div class="flex items-center justify-between gap-x-4">
            <h3 id="tier-enterprise" class="text-lg font-semibold leading-8 text-gray-900">{{ __('ui::blocks_pricing_plans.tiers.enterprise.label') }}</h3>
          </div>
          <p class="mt-4 text-sm leading-6 text-gray-600">{{ __('ui::blocks_pricing_plans.tiers.enterprise.description') }}</p>
          <p class="mt-6 flex items-baseline gap-x-1">
            <!-- Price, update based on frequency toggle state -->
            <span class="text-4xl font-bold tracking-tight text-gray-900">$60</span>
            <!-- Payment frequency, update based on frequency toggle state -->
            <span class="text-sm font-semibold leading-6 text-gray-600">{{ __('ui::blocks_pricing_plans.billing.per_month.label') }}</span>
          </p>
          <a href="#" aria-describedby="tier-enterprise" class="mt-6 block rounded-md py-2 px-3 text-center text-sm font-semibold leading-6 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 text-indigo-600 ring-1 ring-inset ring-indigo-200 hover:ring-indigo-300">{{ __('ui::blocks_pricing_plans.actions.buy_plan.label') }}</a>
          <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-gray-600 xl:mt-10">
            <li class="flex gap-x-3">
              <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
              </svg>
              {{ __('ui::blocks_pricing_plans.features.products_unlimited.label') }}
            </li>
            <li class="flex gap-x-3">
              <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
              </svg>
              {{ __('ui::blocks_pricing_plans.features.subscribers_unlimited.label') }}
            </li>
            <li class="flex gap-x-3">
              <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
              </svg>
              {{ __('ui::blocks_pricing_plans.features.advanced_analytics.label') }}
            </li>
            <li class="flex gap-x-3">
              <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
              </svg>
              {{ __('ui::blocks_pricing_plans.features.support_1h_dedicated.label') }}
            </li>
            <li class="flex gap-x-3">
              <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
              </svg>
              {{ __('ui::blocks_pricing_plans.features.marketing_automations.label') }}
            </li>
            <li class="flex gap-x-3">
              <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
              </svg>
              {{ __('ui::blocks_pricing_plans.features.custom_reporting_tools.label') }}
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
