<?php

declare(strict_types=1);
?>
<div class="bg-white py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <div class="mx-auto max-w-4xl text-center">
        <h2 class="text-base font-semibold leading-7 text-indigo-600">{{ __('ui::blocks_pricing_plans.header.pricing.label') }}</h2>
        <p class="mt-2 text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">{!! __('ui::blocks_pricing_plans.header.plans_all_sizes_short.title') !!}</p>
      </div>
      <p class="mx-auto mt-6 max-w-2xl text-center text-lg leading-8 text-gray-600">{{ __('ui::blocks_pricing_plans.header.intro.description') }}</p>

      <!-- xs to lg -->
      <div class="mx-auto mt-12 max-w-md space-y-8 sm:mt-16 lg:hidden">
        <section class="p-8">
          <h3 id="tier-basic" class="text-sm font-semibold leading-6 text-gray-900">{{ __('ui::blocks_pricing_plans.tiers.basic.label') }}</h3>
          <p class="mt-2 flex items-baseline gap-x-1 text-gray-900">
            <span class="text-4xl font-bold">$9</span>
            <span class="text-sm font-semibold">{{ __('ui::blocks_pricing_plans.billing.per_month.label') }}</span>
          </p>
          <a href="#" aria-describedby="tier-basic" class="mt-8 block rounded-md py-2 px-3 text-center text-sm font-semibold leading-6 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 text-indigo-600 ring-1 ring-inset ring-indigo-200 hover:ring-indigo-300">{{ __('ui::blocks_pricing_plans.actions.buy_plan.label') }}</a>
          <ul role="list" class="mt-10 space-y-4 text-sm leading-6 text-gray-900">
            <li>
              <ul role="list" class="space-y-4">
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span> {{ __('ui::blocks_pricing_plans.features.integrations.label') }} </span>
                </li>
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span> {{ __('ui::blocks_pricing_plans.features.shared_links.label') }} </span>
                </li>
              </ul>
            </li>
            <li>
              <ul role="list" class="space-y-4">
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span> {{ __('ui::blocks_pricing_plans.features.advanced_analytics.label') }} </span>
                </li>
              </ul>
            </li>
            <li>
              <ul role="list" class="space-y-4">
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span> {{ __('ui::blocks_pricing_plans.features.online_support_24_7.label') }} </span>
                </li>
              </ul>
            </li>
          </ul>
        </section>
        <section class="p-8 rounded-xl bg-gray-400/5 ring-1 ring-inset ring-gray-200">
          <h3 id="tier-essential" class="text-sm font-semibold leading-6 text-gray-900">{{ __('ui::blocks_pricing_plans.tiers.essential.label') }}</h3>
          <p class="mt-2 flex items-baseline gap-x-1 text-gray-900">
            <span class="text-4xl font-bold">$29</span>
            <span class="text-sm font-semibold">{{ __('ui::blocks_pricing_plans.billing.per_month.label') }}</span>
          </p>
          <a href="#" aria-describedby="tier-essential" class="mt-8 block rounded-md py-2 px-3 text-center text-sm font-semibold leading-6 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 bg-indigo-600 text-white hover:bg-indigo-500">{{ __('ui::blocks_pricing_plans.actions.buy_plan.label') }}</a>
          <ul role="list" class="mt-10 space-y-4 text-sm leading-6 text-gray-900">
            <li>
              <ul role="list" class="space-y-4">
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span> {{ __('ui::blocks_pricing_plans.features.integrations.label') }} </span>
                </li>
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span> {{ __('ui::blocks_pricing_plans.features.shared_links.label') }} </span>
                </li>
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span> {{ __('ui::blocks_pricing_plans.features.import_export.label') }} </span>
                </li>
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span>
                    {{ __('ui::blocks_pricing_plans.features.team_members.label') }}
                    <span class="text-sm leading-6 text-gray-500">{{ __('ui::blocks_pricing_plans.table.up_to_users_paren.label', ['count' => 20]) }}</span>
                  </span>
                </li>
              </ul>
            </li>
            <li>
              <ul role="list" class="space-y-4">
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span> {{ __('ui::blocks_pricing_plans.features.advanced_analytics.label') }} </span>
                </li>
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span> {{ __('ui::blocks_pricing_plans.features.basic_reports.label') }} </span>
                </li>
              </ul>
            </li>
            <li>
              <ul role="list" class="space-y-4">
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span> {{ __('ui::blocks_pricing_plans.features.online_support_24_7.label') }} </span>
                </li>
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span> {{ __('ui::blocks_pricing_plans.features.quarterly_workshops.label') }} </span>
                </li>
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span> {{ __('ui::blocks_pricing_plans.features.priority_phone_support.label') }} </span>
                </li>
              </ul>
            </li>
          </ul>
        </section>
        <section class="p-8">
          <h3 id="tier-premium" class="text-sm font-semibold leading-6 text-gray-900">{{ __('ui::blocks_pricing_plans.tiers.premium.label') }}</h3>
          <p class="mt-2 flex items-baseline gap-x-1 text-gray-900">
            <span class="text-4xl font-bold">$59</span>
            <span class="text-sm font-semibold">{{ __('ui::blocks_pricing_plans.billing.per_month.label') }}</span>
          </p>
          <a href="#" aria-describedby="tier-premium" class="mt-8 block rounded-md py-2 px-3 text-center text-sm font-semibold leading-6 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 text-indigo-600 ring-1 ring-inset ring-indigo-200 hover:ring-indigo-300">{{ __('ui::blocks_pricing_plans.actions.buy_plan.label') }}</a>
          <ul role="list" class="mt-10 space-y-4 text-sm leading-6 text-gray-900">
            <li>
              <ul role="list" class="space-y-4">
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span> {{ __('ui::blocks_pricing_plans.features.integrations.label') }} </span>
                </li>
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span> {{ __('ui::blocks_pricing_plans.features.shared_links.label') }} </span>
                </li>
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span> {{ __('ui::blocks_pricing_plans.features.import_export.label') }} </span>
                </li>
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span>
                    {{ __('ui::blocks_pricing_plans.features.team_members.label') }}
                    <span class="text-sm leading-6 text-gray-500">{{ __('ui::blocks_pricing_plans.table.up_to_users_paren.label', ['count' => 50]) }}</span>
                  </span>
                </li>
              </ul>
            </li>
            <li>
              <ul role="list" class="space-y-4">
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span> {{ __('ui::blocks_pricing_plans.features.advanced_analytics.label') }} </span>
                </li>
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span> {{ __('ui::blocks_pricing_plans.features.basic_reports.label') }} </span>
                </li>
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span> {{ __('ui::blocks_pricing_plans.features.professional_reports.label') }} </span>
                </li>
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span> {{ __('ui::blocks_pricing_plans.features.custom_report_builder.label') }} </span>
                </li>
              </ul>
            </li>
            <li>
              <ul role="list" class="space-y-4">
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span> {{ __('ui::blocks_pricing_plans.features.online_support_24_7.label') }} </span>
                </li>
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span> {{ __('ui::blocks_pricing_plans.features.quarterly_workshops.label') }} </span>
                </li>
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span> {{ __('ui::blocks_pricing_plans.features.priority_phone_support.label') }} </span>
                </li>
                <li class="flex gap-x-3">
                  <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span> {{ __('ui::blocks_pricing_plans.features.onboarding_tour.label') }} </span>
                </li>
              </ul>
            </li>
          </ul>
        </section>
      </div>

      <!-- lg+ -->
      <div class="isolate mt-20 hidden lg:block">
        <div class="relative -mx-8">
          <div class="absolute inset-x-4 inset-y-0 -z-10 flex">
            <div class="flex w-1/4 px-4" style="margin-left: 50%" aria-hidden="true">
              <div class="w-full rounded-t-xl border-x border-t border-gray-900/10 bg-gray-400/5"></div>
            </div>
          </div>
          <table class="w-full table-fixed border-separate border-spacing-x-8 text-left">
            <caption class="sr-only">
              {{ __('ui::blocks_pricing_plans.table.caption.label') }}
            </caption>
            <colgroup>
              <col class="w-1/4">
              <col class="w-1/4">
              <col class="w-1/4">
              <col class="w-1/4">
            </colgroup>
            <thead>
              <tr>
                <td></td>
                <th scope="col" class="px-6 pt-6 xl:px-8 xl:pt-8">
                  <div class="text-sm font-semibold leading-7 text-gray-900">{{ __('ui::blocks_pricing_plans.tiers.basic.label') }}</div>
                </th>
                <th scope="col" class="px-6 pt-6 xl:px-8 xl:pt-8">
                  <div class="text-sm font-semibold leading-7 text-gray-900">{{ __('ui::blocks_pricing_plans.tiers.essential.label') }}</div>
                </th>
                <th scope="col" class="px-6 pt-6 xl:px-8 xl:pt-8">
                  <div class="text-sm font-semibold leading-7 text-gray-900">{{ __('ui::blocks_pricing_plans.tiers.premium.label') }}</div>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row"><span class="sr-only">{{ __('ui::blocks_pricing_plans.table.price.label') }}</span></th>
                <td class="px-6 pt-2 xl:px-8">
                  <div class="flex items-baseline gap-x-1 text-gray-900">
                    <span class="text-4xl font-bold">$9</span>
                    <span class="text-sm font-semibold leading-6">{{ __('ui::blocks_pricing_plans.billing.per_month.label') }}</span>
                  </div>
                  <a href="#" class="mt-8 block rounded-md py-2 px-3 text-center text-sm font-semibold leading-6 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 text-indigo-600 ring-1 ring-inset ring-indigo-200 hover:ring-indigo-300">{{ __('ui::blocks_pricing_plans.actions.buy_plan.label') }}</a>
                </td>
                <td class="px-6 pt-2 xl:px-8">
                  <div class="flex items-baseline gap-x-1 text-gray-900">
                    <span class="text-4xl font-bold">$29</span>
                    <span class="text-sm font-semibold leading-6">{{ __('ui::blocks_pricing_plans.billing.per_month.label') }}</span>
                  </div>
                  <a href="#" class="mt-8 block rounded-md py-2 px-3 text-center text-sm font-semibold leading-6 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 bg-indigo-600 text-white hover:bg-indigo-500">{{ __('ui::blocks_pricing_plans.actions.buy_plan.label') }}</a>
                </td>
                <td class="px-6 pt-2 xl:px-8">
                  <div class="flex items-baseline gap-x-1 text-gray-900">
                    <span class="text-4xl font-bold">$59</span>
                    <span class="text-sm font-semibold leading-6">{{ __('ui::blocks_pricing_plans.billing.per_month.label') }}</span>
                  </div>
                  <a href="#" class="mt-8 block rounded-md py-2 px-3 text-center text-sm font-semibold leading-6 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 text-indigo-600 ring-1 ring-inset ring-indigo-200 hover:ring-indigo-300">{{ __('ui::blocks_pricing_plans.actions.buy_plan.label') }}</a>
                </td>
              </tr>
              <tr>
                <th scope="colgroup" colspan="4" class="pb-4 text-sm font-semibold leading-6 text-gray-900 pt-8">
                  {{ __('ui::blocks_pricing_plans.table.features.label') }}
                  <div class="absolute inset-x-8 mt-4 h-px bg-gray-900/10"></div>
                </th>
              </tr>
              <tr>
                <th scope="row" class="py-4 text-sm font-normal leading-6 text-gray-900">
                  {{ __('ui::blocks_pricing_plans.features.integrations.label') }}
                  <div class="absolute inset-x-8 mt-4 h-px bg-gray-900/5"></div>
                </th>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.included_in.label', ['plan' => 'Basic']) }}</span>
                </td>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.included_in.label', ['plan' => 'Essential']) }}</span>
                </td>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.included_in.label', ['plan' => 'Premium']) }}</span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="py-4 text-sm font-normal leading-6 text-gray-900">
                  {{ __('ui::blocks_pricing_plans.features.shared_links.label') }}
                  <div class="absolute inset-x-8 mt-4 h-px bg-gray-900/5"></div>
                </th>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.included_in.label', ['plan' => 'Basic']) }}</span>
                </td>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.included_in.label', ['plan' => 'Essential']) }}</span>
                </td>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.included_in.label', ['plan' => 'Premium']) }}</span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="py-4 text-sm font-normal leading-6 text-gray-900">
                  {{ __('ui::blocks_pricing_plans.features.import_export.label') }}
                  <div class="absolute inset-x-8 mt-4 h-px bg-gray-900/5"></div>
                </th>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M4 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H4.75A.75.75 0 014 10z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.not_included_in.label', ['plan' => 'Basic']) }}</span>
                </td>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.included_in.label', ['plan' => 'Essential']) }}</span>
                </td>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.included_in.label', ['plan' => 'Premium']) }}</span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="py-4 text-sm font-normal leading-6 text-gray-900">
                  {{ __('ui::blocks_pricing_plans.features.team_members.label') }}
                  <div class="absolute inset-x-8 mt-4 h-px bg-gray-900/5"></div>
                </th>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M4 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H4.75A.75.75 0 014 10z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.not_included_in.label', ['plan' => 'Basic']) }}</span>
                </td>
                <td class="px-6 py-4 xl:px-8">
                  <div class="text-center text-sm leading-6 text-gray-500">{{ __('ui::blocks_pricing_plans.table.up_to_users.label', ['count' => 20]) }}</div>
                </td>
                <td class="px-6 py-4 xl:px-8">
                  <div class="text-center text-sm leading-6 text-gray-500">{{ __('ui::blocks_pricing_plans.table.up_to_users.label', ['count' => 50]) }}</div>
                </td>
              </tr>

              <tr>
                <th scope="colgroup" colspan="4" class="pb-4 text-sm font-semibold leading-6 text-gray-900 pt-16">
                  {{ __('ui::blocks_pricing_plans.table.reporting.label') }}
                  <div class="absolute inset-x-8 mt-4 h-px bg-gray-900/10"></div>
                </th>
              </tr>
              <tr>
                <th scope="row" class="py-4 text-sm font-normal leading-6 text-gray-900">
                  {{ __('ui::blocks_pricing_plans.features.advanced_analytics.label') }}
                  <div class="absolute inset-x-8 mt-4 h-px bg-gray-900/5"></div>
                </th>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.included_in.label', ['plan' => 'Basic']) }}</span>
                </td>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.included_in.label', ['plan' => 'Essential']) }}</span>
                </td>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.included_in.label', ['plan' => 'Premium']) }}</span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="py-4 text-sm font-normal leading-6 text-gray-900">
                  {{ __('ui::blocks_pricing_plans.features.basic_reports.label') }}
                  <div class="absolute inset-x-8 mt-4 h-px bg-gray-900/5"></div>
                </th>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M4 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H4.75A.75.75 0 014 10z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.not_included_in.label', ['plan' => 'Basic']) }}</span>
                </td>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.included_in.label', ['plan' => 'Essential']) }}</span>
                </td>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.included_in.label', ['plan' => 'Premium']) }}</span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="py-4 text-sm font-normal leading-6 text-gray-900">
                  {{ __('ui::blocks_pricing_plans.features.professional_reports.label') }}
                  <div class="absolute inset-x-8 mt-4 h-px bg-gray-900/5"></div>
                </th>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M4 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H4.75A.75.75 0 014 10z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.not_included_in.label', ['plan' => 'Basic']) }}</span>
                </td>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M4 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H4.75A.75.75 0 014 10z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.not_included_in.label', ['plan' => 'Essential']) }}</span>
                </td>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.included_in.label', ['plan' => 'Premium']) }}</span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="py-4 text-sm font-normal leading-6 text-gray-900">
                  {{ __('ui::blocks_pricing_plans.features.custom_report_builder.label') }}
                  <div class="absolute inset-x-8 mt-4 h-px bg-gray-900/5"></div>
                </th>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M4 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H4.75A.75.75 0 014 10z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.not_included_in.label', ['plan' => 'Basic']) }}</span>
                </td>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M4 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H4.75A.75.75 0 014 10z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.not_included_in.label', ['plan' => 'Essential']) }}</span>
                </td>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.included_in.label', ['plan' => 'Premium']) }}</span>
                </td>
              </tr>

              <tr>
                <th scope="colgroup" colspan="4" class="pb-4 text-sm font-semibold leading-6 text-gray-900 pt-16">
                  {{ __('ui::blocks_pricing_plans.table.support.label') }}
                  <div class="absolute inset-x-8 mt-4 h-px bg-gray-900/10"></div>
                </th>
              </tr>
              <tr>
                <th scope="row" class="py-4 text-sm font-normal leading-6 text-gray-900">
                  {{ __('ui::blocks_pricing_plans.features.online_support_24_7.label') }}
                  <div class="absolute inset-x-8 mt-4 h-px bg-gray-900/5"></div>
                </th>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.included_in.label', ['plan' => 'Basic']) }}</span>
                </td>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.included_in.label', ['plan' => 'Essential']) }}</span>
                </td>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.included_in.label', ['plan' => 'Premium']) }}</span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="py-4 text-sm font-normal leading-6 text-gray-900">
                  {{ __('ui::blocks_pricing_plans.features.quarterly_workshops.label') }}
                  <div class="absolute inset-x-8 mt-4 h-px bg-gray-900/5"></div>
                </th>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M4 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H4.75A.75.75 0 014 10z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.not_included_in.label', ['plan' => 'Basic']) }}</span>
                </td>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.included_in.label', ['plan' => 'Essential']) }}</span>
                </td>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.included_in.label', ['plan' => 'Premium']) }}</span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="py-4 text-sm font-normal leading-6 text-gray-900">
                  {{ __('ui::blocks_pricing_plans.features.priority_phone_support.label') }}
                  <div class="absolute inset-x-8 mt-4 h-px bg-gray-900/5"></div>
                </th>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M4 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H4.75A.75.75 0 014 10z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.not_included_in.label', ['plan' => 'Basic']) }}</span>
                </td>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.included_in.label', ['plan' => 'Essential']) }}</span>
                </td>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.included_in.label', ['plan' => 'Premium']) }}</span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="py-4 text-sm font-normal leading-6 text-gray-900">
                  {{ __('ui::blocks_pricing_plans.features.onboarding_tour.label') }}
                  <div class="absolute inset-x-8 mt-4 h-px bg-gray-900/5"></div>
                </th>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M4 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H4.75A.75.75 0 014 10z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.not_included_in.label', ['plan' => 'Basic']) }}</span>
                </td>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M4 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H4.75A.75.75 0 014 10z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.not_included_in.label', ['plan' => 'Essential']) }}</span>
                </td>
                <td class="px-6 py-4 xl:px-8">
                  <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                  </svg>
                  <span class="sr-only">{{ __('ui::blocks_pricing_plans.table.included_in.label', ['plan' => 'Premium']) }}</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
