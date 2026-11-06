<?php

declare(strict_types=1);
?>
<div class="bg-gray-900">
    <div class="pt-12 sm:pt-16 lg:pt-24">
      <div class="mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
        <div class="mx-auto max-w-3xl space-y-2 lg:max-w-none">
          <h2 class="text-xl font-semibold leading-6 text-gray-300">{{ __('ui::blocks_pricing.section.pricing.label') }}</h2>
          <p class="text-3xl font-bold tracking-tight text-white sm:text-4xl lg:text-5xl">{{ __('ui::blocks_pricing.section.right_price.title') }}</p>
          <p class="text-xl text-gray-300">{{ __('ui::blocks_pricing.section.municipal_portal.help') }}</p>
        </div>
      </div>
    </div>
    <div class="mt-8 bg-gray-50 pb-12 sm:mt-12 sm:pb-16 lg:mt-16 lg:pb-24">
      <div class="relative">
        <div class="absolute inset-0 h-3/4 bg-gray-900"></div>
        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="mx-auto max-w-md space-y-4 lg:grid lg:max-w-5xl lg:grid-cols-2 lg:gap-5 lg:space-y-0">
            <div class="flex flex-col overflow-hidden rounded-lg shadow-lg">
              <div class="bg-white px-6 py-8 sm:p-10 sm:pb-6">
                <div>
                  <h3 class="inline-flex rounded-full bg-indigo-100 px-4 py-1 text-base font-semibold text-indigo-600" id="tier-standard">{{ __('ui::blocks_pricing.tiers.standard.label') }}</h3>
                </div>
                <div class="mt-4 flex items-baseline text-6xl font-bold tracking-tight">
                  $49
                  <span class="ml-1 text-2xl font-medium tracking-normal text-gray-500">{{ __('ui::blocks_pricing.units.per_month_abbr.text') }}</span>
                </div>
                <p class="mt-5 text-lg text-gray-500">{{ __('ui::blocks_pricing.taglines.municipal_modern_city.help') }}</p>
              </div>
              <div class="flex flex-1 flex-col justify-between space-y-6 bg-gray-50 px-6 pb-8 pt-6 sm:p-10 sm:pt-6">
                <ul role="list" class="space-y-4">
                  <li class="flex items-start">
                    <div class="flex-shrink-0">
                      <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                      </svg>
                    </div>
                    <p class="ml-3 text-base text-gray-700">Pariatur quod similique</p>
                  </li>
                  <li class="flex items-start">
                    <div class="flex-shrink-0">
                      <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                      </svg>
                    </div>
                    <p class="ml-3 text-base text-gray-700">Sapiente libero doloribus modi nostrum</p>
                  </li>
                  <li class="flex items-start">
                    <div class="flex-shrink-0">
                      <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                      </svg>
                    </div>
                    <p class="ml-3 text-base text-gray-700">Vel ipsa esse repudiandae excepturi</p>
                  </li>
                  <li class="flex items-start">
                    <div class="flex-shrink-0">
                      <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                      </svg>
                    </div>
                    <p class="ml-3 text-base text-gray-700">Itaque cupiditate adipisci quibusdam</p>
                  </li>
                </ul>
                <div class="rounded-md shadow">
                  <a href="#" class="flex items-center justify-center rounded-md border border-transparent bg-gray-800 px-5 py-3 text-base font-medium text-white hover:bg-gray-900" aria-describedby="tier-standard">{{ __('ui::blocks_pricing.actions.get_started.label') }}</a>
                </div>
              </div>
            </div>
            <div class="flex flex-col overflow-hidden rounded-lg shadow-lg">
              <div class="bg-white px-6 py-8 sm:p-10 sm:pb-6">
                <div>
                  <h3 class="inline-flex rounded-full bg-indigo-100 px-4 py-1 text-base font-semibold text-indigo-600" id="tier-standard">{{ __('ui::blocks_pricing.tiers.enterprise.label') }}</h3>
                </div>
                <div class="mt-4 flex items-baseline text-6xl font-bold tracking-tight">
                  $79
                  <span class="ml-1 text-2xl font-medium tracking-normal text-gray-500">{{ __('ui::blocks_pricing.units.per_month_abbr.text') }}</span>
                </div>
                <p class="mt-5 text-lg text-gray-500">{{ __('ui::blocks_pricing.taglines.municipal_modern_city.help') }}</p>
              </div>
              <div class="flex flex-1 flex-col justify-between space-y-6 bg-gray-50 px-6 pb-8 pt-6 sm:p-10 sm:pt-6">
                <ul role="list" class="space-y-4">
                  <li class="flex items-start">
                    <div class="flex-shrink-0">
                      <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                      </svg>
                    </div>
                    <p class="ml-3 text-base text-gray-700">Pariatur quod similique</p>
                  </li>
                  <li class="flex items-start">
                    <div class="flex-shrink-0">
                      <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                      </svg>
                    </div>
                    <p class="ml-3 text-base text-gray-700">Sapiente libero doloribus modi nostrum</p>
                  </li>
                  <li class="flex items-start">
                    <div class="flex-shrink-0">
                      <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                      </svg>
                    </div>
                    <p class="ml-3 text-base text-gray-700">Vel ipsa esse repudiandae excepturi</p>
                  </li>
                  <li class="flex items-start">
                    <div class="flex-shrink-0">
                      <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                      </svg>
                    </div>
                    <p class="ml-3 text-base text-gray-700">Itaque cupiditate adipisci quibusdam</p>
                  </li>
                </ul>
                <div class="rounded-md shadow">
                  <a href="#" class="flex items-center justify-center rounded-md border border-transparent bg-gray-800 px-5 py-3 text-base font-medium text-white hover:bg-gray-900" aria-describedby="tier-standard">{{ __('ui::blocks_pricing.actions.get_started.label') }}</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="relative mx-auto mt-4 max-w-7xl px-4 sm:px-6 lg:mt-5 lg:px-8">
        <div class="mx-auto max-w-md lg:max-w-5xl">
          <div class="rounded-lg bg-gray-100 px-6 py-8 sm:p-10 lg:flex lg:items-center">
            <div class="flex-1">
              <div>
                <h3 class="inline-flex rounded-full bg-white px-4 py-1 text-base font-semibold text-gray-800">{{ __('ui::blocks_pricing.tiers.discounted.label') }}</h3>
              </div>
              <div class="mt-4 text-lg text-gray-600">{{ __('ui::blocks_pricing.section.get_full_access.help') }} <span class="font-semibold text-gray-900">$29</span>.</div>
            </div>
            <div class="mt-6 rounded-md shadow lg:ml-10 lg:mt-0 lg:flex-shrink-0">
              <a href="#" class="flex items-center justify-center rounded-md border border-transparent bg-white px-5 py-3 text-base font-medium text-gray-900 hover:bg-gray-50">{{ __('ui::blocks_pricing.actions.buy_discounted_license.label') }}</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
