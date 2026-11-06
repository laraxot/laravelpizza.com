<?php

declare(strict_types=1);
?>
<div class="relative bg-white">
    <div class="absolute inset-0" aria-hidden="true">
      <div class="absolute inset-y-0 right-0 w-1/2 bg-indigo-700"></div>
    </div>
    <div class="relative mx-auto max-w-7xl lg:grid lg:grid-cols-2 lg:px-8">
      <div class="bg-white px-6 py-16 sm:py-24 lg:px-0 lg:pr-8">
        <div class="mx-auto max-w-lg lg:mx-0">
          <h2 class="text-lg font-semibold text-indigo-600">{{ __('ui::blocks_pricing.section.full_featured.label') }}</h2>
          <p class="mt-2 text-2xl font-bold text-gray-900 sm:text-3xl sm:tracking-tight">{{ __('ui::blocks_pricing.section.talk_with_customers.title') }}</p>
          <dl class="mt-12 space-y-10">
            <div class="relative">
              <dt>
                <div class="absolute flex h-12 w-12 items-center justify-center rounded-md bg-indigo-500">
                  <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
                  </svg>
                </div>
                <p class="ml-16 text-lg font-medium leading-6 text-gray-900">{{ __('ui::blocks_pricing.features.view_list.label') }}</p>
              </dt>
              <dd class="ml-16 mt-2 text-base text-gray-500">Nunc a, lacinia sed risus neque, arcu, rhoncus. Id mauris justo facilisis aliquam platea vestibulum condimentum morbi.</dd>
            </div>
            <div class="relative">
              <dt>
                <div class="absolute flex h-12 w-12 items-center justify-center rounded-md bg-indigo-500">
                  <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 4.5v15m6-15v15m-10.875 0h15.75c.621 0 1.125-.504 1.125-1.125V5.625c0-.621-.504-1.125-1.125-1.125H4.125C3.504 4.5 3 5.004 3 5.625v12.75c0 .621.504 1.125 1.125 1.125z" />
                  </svg>
                </div>
                <p class="ml-16 text-lg font-medium leading-6 text-gray-900">{{ __('ui::blocks_pricing.features.view_boards.label') }}</p>
              </dt>
              <dd class="ml-16 mt-2 text-base text-gray-500">Purus lobortis volutpat posuere id integer nunc tellus. Non mauris malesuada feugiat massa mi pellentesque cum est. Pharetra a varius urna rhoncus, tempor rutrum.</dd>
            </div>
            <div class="relative">
              <dt>
                <div class="absolute flex h-12 w-12 items-center justify-center rounded-md bg-indigo-500">
                  <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                  </svg>
                </div>
                <p class="ml-16 text-lg font-medium leading-6 text-gray-900">{{ __('ui::blocks_pricing.features.view_calendar.label') }}</p>
              </dt>
              <dd class="ml-16 mt-2 text-base text-gray-500">Purus lobortis volutpat posuere id integer nunc tellus. Non mauris malesuada feugiat massa mi pellentesque cum est. Pharetra a varius urna rhoncus, tempor rutrum.</dd>
            </div>
            <div class="relative">
              <dt>
                <div class="absolute flex h-12 w-12 items-center justify-center rounded-md bg-indigo-500">
                  <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                  </svg>
                </div>
                <p class="ml-16 text-lg font-medium leading-6 text-gray-900">{{ __('ui::blocks_pricing.features.view_teams.label') }}</p>
              </dt>
              <dd class="ml-16 mt-2 text-base text-gray-500">Tincidunt sollicitudin interdum nunc sit risus at bibendum vitae. Urna, quam ut sit justo non, consectetur et varius.</dd>
            </div>
          </dl>
        </div>
      </div>
      <div class="bg-indigo-700 px-6 py-16 sm:py-24 lg:flex lg:items-center lg:justify-end lg:bg-none lg:px-0 lg:pl-8">
        <div class="mx-auto w-full max-w-lg space-y-8 lg:mx-0">
          <div>
            <h2 class="sr-only">{{ __('ui::blocks_pricing.section.price.label') }}</h2>
            <p class="relative grid grid-cols-2">
              <span class="flex flex-col text-center">
                <span class="text-5xl font-bold tracking-tight text-white">$99</span>
                <span class="mt-2 text-base font-medium text-indigo-200">{{ __('ui::blocks_pricing.units.setup_fee.label') }}</span>
                <span class="sr-only">{{ __('ui::blocks_pricing.units.plus.text') }}</span>
              </span>
              <span class="pointer-events-none absolute flex h-12 w-full items-center justify-center" aria-hidden="true">
                <svg class="h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
              </span>
              <span>
                <span class="flex flex-col text-center">
                  <span class="text-5xl font-bold tracking-tight text-white">$4</span>
                  <span class="mt-2 text-base font-medium text-indigo-200">{{ __('ui::blocks_pricing.units.per_month.text') }}</span>
                </span>
              </span>
            </p>
          </div>
          <ul role="list" class="grid gap-px overflow-hidden rounded sm:grid-cols-2">
            <li class="flex items-center space-x-3 bg-indigo-800 bg-opacity-50 px-4 py-4 text-base text-white">
              <svg class="h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
              </svg>
              <span>{{ __('ui::blocks_pricing.features.projects_unlimited.label') }}</span>
            </li>
            <li class="flex items-center space-x-3 bg-indigo-800 bg-opacity-50 px-4 py-4 text-base text-white">
              <svg class="h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
              </svg>
              <span>{{ __('ui::blocks_pricing.features.no_per_user_fees.label') }}</span>
            </li>
            <li class="flex items-center space-x-3 bg-indigo-800 bg-opacity-50 px-4 py-4 text-base text-white">
              <svg class="h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
              </svg>
              <span>{{ __('ui::blocks_pricing.features.storage_unlimited.label') }}</span>
            </li>
            <li class="flex items-center space-x-3 bg-indigo-800 bg-opacity-50 px-4 py-4 text-base text-white">
              <svg class="h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
              </svg>
              <span>{{ __('ui::blocks_pricing.features.support_24_7.label') }}</span>
            </li>
            <li class="flex items-center space-x-3 bg-indigo-800 bg-opacity-50 px-4 py-4 text-base text-white">
              <svg class="h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
              </svg>
              <span>{{ __('ui::blocks_pricing.features.cancel_any_time.label') }}</span>
            </li>
            <li class="flex items-center space-x-3 bg-indigo-800 bg-opacity-50 px-4 py-4 text-base text-white">
              <svg class="h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
              </svg>
              <span>{{ __('ui::blocks_pricing.features.free_14_days.label') }}</span>
            </li>
          </ul>
          <a href="#" class="flex w-full items-center justify-center rounded-md border border-transparent bg-white px-8 py-4 text-lg font-medium leading-6 text-indigo-600 hover:bg-indigo-50 md:px-10">{{ __('ui::blocks_pricing.actions.get_started_today.label') }}</a>
          <a href="#" class="block text-center text-base font-medium text-indigo-200 hover:text-white">{{ __('ui::blocks_pricing.section.try_lite.label') }}</a>
        </div>
      </div>
    </div>
  </div>
