<?php

declare(strict_types=1);
?>
<div class="isolate overflow-hidden bg-gray-900">
    <div class="mx-auto max-w-7xl px-6 pb-96 pt-24 text-center sm:pt-32 lg:px-8">
      <div class="mx-auto max-w-4xl">
        <h2 class="text-base font-semibold leading-7 text-indigo-400">{{ __('ui::blocks_pricing_plans.header.pricing.label') }}</h2>
        <p class="mt-2 text-4xl font-bold tracking-tight text-white sm:text-5xl">{{ __('ui::blocks_pricing_plans.header.right_price_lead.title') }} <br class="hidden sm:inline lg:hidden">{{ __('ui::blocks_pricing_plans.header.right_price_tail.title') }}</p>
      </div>
      <div class="relative mt-6">
        <p class="mx-auto max-w-2xl text-lg leading-8 text-white/60">{{ __('ui::blocks_pricing_plans.header.public_services.description') }}</p>
        <svg viewBox="0 0 1208 1024" class="absolute -top-10 left-1/2 -z-10 h-[64rem] -translate-x-1/2 [mask-image:radial-gradient(closest-side,white,transparent)] sm:-top-12 md:-top-20 lg:-top-12 xl:top-0">
          <ellipse cx="604" cy="512" fill="url(#6d1bd035-0dd1-437e-93fa-59d316231eb0)" rx="604" ry="512" />
          <defs>
            <radialGradient id="6d1bd035-0dd1-437e-93fa-59d316231eb0">
              <stop stop-color="#7775D6" />
              <stop offset="1" stop-color="#E935C1" />
            </radialGradient>
          </defs>
        </svg>
      </div>
    </div>
    <div class="flow-root bg-white pb-24 sm:pb-32">
      <div class="-mt-80">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
          <div class="mx-auto grid max-w-md grid-cols-1 gap-8 lg:max-w-4xl lg:grid-cols-2">
            <div class="flex flex-col justify-between rounded-3xl bg-white p-8 shadow-xl ring-1 ring-gray-900/10 sm:p-10">
              <div>
                <h3 id="tier-hobby" class="text-base font-semibold leading-7 text-indigo-600">{{ __('ui::blocks_pricing_plans.tiers.hobby.label') }}</h3>
                <div class="mt-4 flex items-baseline gap-x-2">
                  <span class="text-5xl font-bold tracking-tight text-gray-900">$49</span>
                  <span class="text-base font-semibold leading-7 text-gray-600">{{ __('ui::blocks_pricing_plans.billing.per_month.label') }}</span>
                </div>
                <p class="mt-6 text-base leading-7 text-gray-600">{{ __('ui::blocks_pricing_plans.tiers.hobby.description') }}</p>
                <ul role="list" class="mt-10 space-y-4 text-sm leading-6 text-gray-600">
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
              <a href="#" aria-describedby="tier-hobby" class="mt-8 block rounded-md bg-indigo-600 px-3.5 py-2 text-center text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{ __('ui::blocks_pricing_plans.actions.get_started_today.label') }}</a>
            </div>
            <div class="flex flex-col justify-between rounded-3xl bg-white p-8 shadow-xl ring-1 ring-gray-900/10 sm:p-10">
              <div>
                <h3 id="tier-team" class="text-base font-semibold leading-7 text-indigo-600">{{ __('ui::blocks_pricing_plans.tiers.team.label') }}</h3>
                <div class="mt-4 flex items-baseline gap-x-2">
                  <span class="text-5xl font-bold tracking-tight text-gray-900">$79</span>
                  <span class="text-base font-semibold leading-7 text-gray-600">{{ __('ui::blocks_pricing_plans.billing.per_month.label') }}</span>
                </div>
                <p class="mt-6 text-base leading-7 text-gray-600">{{ __('ui::blocks_pricing_plans.tiers.team.description') }}</p>
                <ul role="list" class="mt-10 space-y-4 text-sm leading-6 text-gray-600">
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
                </ul>
              </div>
              <a href="#" aria-describedby="tier-team" class="mt-8 block rounded-md bg-indigo-600 px-3.5 py-2 text-center text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{ __('ui::blocks_pricing_plans.actions.get_started_today.label') }}</a>
            </div>

            <div class="flex flex-col items-start gap-x-8 gap-y-6 rounded-3xl p-8 ring-1 ring-gray-900/10 sm:gap-y-10 sm:p-10 lg:col-span-2 lg:flex-row lg:items-center">
              <div class="lg:min-w-0 lg:flex-1">
                <h3 class="text-lg font-semibold leading-8 tracking-tight text-indigo-600">{{ __('ui::blocks_pricing_plans.tiers.discounted.label') }}</h3>
                <p class="mt-1 text-base leading-7 text-gray-600">{{ __('ui::blocks_pricing_plans.tiers.discounted.description') }}</p>
              </div>
              <a href="#" class="rounded-md px-3.5 py-2 text-sm font-semibold leading-6 text-indigo-600 ring-1 ring-inset ring-indigo-200 hover:ring-indigo-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{ __('ui::blocks_pricing_plans.actions.buy_discounted_license.label') }} <span aria-hidden="true">&rarr;</span></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
