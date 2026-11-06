<?php

declare(strict_types=1);
?>
<div class="bg-gray-50">
    <div class="relative bg-indigo-600">
      <!-- Overlapping background -->
      <div aria-hidden="true" class="absolute bottom-0 hidden h-6 w-full bg-gray-50 lg:block"></div>

      <div class="relative mx-auto max-w-2xl px-6 pt-16 text-center sm:pt-32 lg:max-w-7xl lg:px-8">
        <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">
          <span class="block lg:inline">{{ __('ui::blocks_pricing.section.simple_pricing_first_line.title') }}</span>
          <span class="block lg:inline">{{ __('ui::blocks_pricing.section.simple_pricing_second_line.title') }}</span>
        </h1>
        <p class="mt-4 text-xl text-indigo-100">{{ __('ui::blocks_pricing.section.pick_plan.help') }}</p>
      </div>

      <h2 class="sr-only">{{ __('ui::blocks_pricing.section.plans.label') }}</h2>

      <!-- Toggle -->
      <div class="relative mt-12 flex justify-center sm:mt-16">
        <div class="flex rounded-lg bg-indigo-700 p-0.5">
          <button type="button" class="relative whitespace-nowrap rounded-md border-indigo-700 bg-white px-6 py-2 text-sm font-medium text-indigo-700 shadow-sm hover:bg-indigo-50 focus:z-10 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-700">{{ __('ui::blocks_pricing.billing.monthly_billing.label') }}</button>
          <button type="button" class="relative ml-0.5 whitespace-nowrap rounded-md border border-transparent px-6 py-2 text-sm font-medium text-indigo-200 hover:bg-indigo-800 focus:z-10 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-700">{{ __('ui::blocks_pricing.billing.yearly_billing.label') }}</button>
        </div>
      </div>

      <!-- Cards -->
      <div class="relative mx-auto mt-8 max-w-2xl px-6 pb-8 sm:mt-12 lg:max-w-7xl lg:px-8 lg:pb-0">
        <!-- Decorative background -->
        <div aria-hidden="true" class="absolute inset-0 bottom-6 left-8 right-8 top-4 hidden rounded-tl-lg rounded-tr-lg bg-indigo-700 lg:block"></div>

        <div class="relative space-y-6 lg:grid lg:grid-cols-3 lg:space-y-0">
          <div class="bg-indigo-700 lg:bg-transparent rounded-lg px-6 pt-6 pb-3 lg:px-8 lg:pt-12">
            <div>
              <h3 class="text-white text-base font-semibold">{{ __('ui::blocks_pricing.tiers.starter.label') }}</h3>
              <div class="flex flex-col items-start sm:flex-row sm:items-center sm:justify-between lg:flex-col lg:items-start">
                <div class="mt-3 flex items-center">
                  <p class="text-white text-4xl font-bold tracking-tight">$5</p>
                  <div class="ml-4">
                    <p class="text-white text-sm">{{ __('ui::blocks_pricing.units.usd_per_month.text') }}</p>
                    <p class="text-indigo-200 text-sm">{{ __('ui::blocks_pricing.billing.billed_yearly.text', ['price' => '$56']) }}</p>
                  </div>
                </div>
                <a href="#" class="bg-white text-indigo-600 hover:bg-indigo-50 mt-6 inline-block w-full rounded-md border border-transparent py-2 px-8 text-center text-sm font-medium shadow-sm sm:mt-0 sm:w-auto lg:mt-6 lg:w-full">{{ __('ui::blocks_pricing.actions.buy_named_plan.label', ['plan' => __('ui::blocks_pricing.tiers.starter.label')]) }}</a>
              </div>
            </div>
            <h4 class="sr-only">{{ __('ui::blocks_pricing.comparison.features.label') }}</h4>
            <ul role="list" class="divide-indigo-500 divide-opacity-75 border-indigo-500 mt-7 divide-y border-t lg:border-t-0">
              <li class="flex items-center py-3">
                <svg class="text-indigo-200 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                </svg>
                <span class="text-white ml-3 text-sm font-medium">{{ __('ui::blocks_pricing.features.invoicing_basic.label') }}</span>
              </li>
              <li class="flex items-center py-3">
                <svg class="text-indigo-200 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                </svg>
                <span class="text-white ml-3 text-sm font-medium">{{ __('ui::blocks_pricing.features.accounting_easy.label') }}</span>
              </li>
              <li class="flex items-center py-3">
                <svg class="text-indigo-200 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                </svg>
                <span class="text-white ml-3 text-sm font-medium">{{ __('ui::blocks_pricing.comparison.multi_accounts.label') }}</span>
              </li>
            </ul>
          </div>
          <div class="bg-white shadow-md ring-2 ring-indigo-700 rounded-lg px-6 pt-6 pb-3 lg:px-8 lg:pt-12">
            <div>
              <h3 class="text-indigo-600 text-base font-semibold">{{ __('ui::blocks_pricing.tiers.scale.label') }}</h3>
              <div class="flex flex-col items-start sm:flex-row sm:items-center sm:justify-between lg:flex-col lg:items-start">
                <div class="mt-3 flex items-center">
                  <p class="text-indigo-600 text-4xl font-bold tracking-tight">$19</p>
                  <div class="ml-4">
                    <p class="text-gray-700 text-sm">{{ __('ui::blocks_pricing.units.usd_per_month.text') }}</p>
                    <p class="text-gray-500 text-sm">{{ __('ui::blocks_pricing.billing.billed_yearly.text', ['price' => '$220']) }}</p>
                  </div>
                </div>
                <a href="#" class="bg-indigo-600 text-white hover:bg-indigo-700 mt-6 inline-block w-full rounded-md border border-transparent py-2 px-8 text-center text-sm font-medium shadow-sm sm:mt-0 sm:w-auto lg:mt-6 lg:w-full">{{ __('ui::blocks_pricing.actions.buy_named_plan.label', ['plan' => __('ui::blocks_pricing.tiers.scale.label')]) }}</a>
              </div>
            </div>
            <h4 class="sr-only">{{ __('ui::blocks_pricing.comparison.features.label') }}</h4>
            <ul role="list" class="divide-gray-200 border-gray-200 mt-7 divide-y border-t lg:border-t-0">
              <li class="flex items-center py-3">
                <svg class="text-indigo-500 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                </svg>
                <span class="text-gray-600 ml-3 text-sm font-medium">{{ __('ui::blocks_pricing.features.invoicing_advanced.label') }}</span>
              </li>
              <li class="flex items-center py-3">
                <svg class="text-indigo-500 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                </svg>
                <span class="text-gray-600 ml-3 text-sm font-medium">{{ __('ui::blocks_pricing.features.accounting_easy.label') }}</span>
              </li>
              <li class="flex items-center py-3">
                <svg class="text-indigo-500 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                </svg>
                <span class="text-gray-600 ml-3 text-sm font-medium">{{ __('ui::blocks_pricing.comparison.multi_accounts.label') }}</span>
              </li>
              <li class="flex items-center py-3">
                <svg class="text-indigo-500 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                </svg>
                <span class="text-gray-600 ml-3 text-sm font-medium">{{ __('ui::blocks_pricing.features.tax_planning_toolkit.label') }}</span>
              </li>
              <li class="flex items-center py-3">
                <svg class="text-indigo-500 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                </svg>
                <span class="text-gray-600 ml-3 text-sm font-medium">{{ __('ui::blocks_pricing.features.vat_filing.label') }}</span>
              </li>
              <li class="flex items-center py-3">
                <svg class="text-indigo-500 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                </svg>
                <span class="text-gray-600 ml-3 text-sm font-medium">{{ __('ui::blocks_pricing.features.free_bank_transfers.label') }}</span>
              </li>
            </ul>
          </div>
          <div class="bg-indigo-700 lg:bg-transparent rounded-lg px-6 pt-6 pb-3 lg:px-8 lg:pt-12">
            <div>
              <h3 class="text-white text-base font-semibold">{{ __('ui::blocks_pricing.tiers.growth.label') }}</h3>
              <div class="flex flex-col items-start sm:flex-row sm:items-center sm:justify-between lg:flex-col lg:items-start">
                <div class="mt-3 flex items-center">
                  <p class="text-white text-4xl font-bold tracking-tight">$12</p>
                  <div class="ml-4">
                    <p class="text-white text-sm">{{ __('ui::blocks_pricing.units.usd_per_month.text') }}</p>
                    <p class="text-indigo-200 text-sm">{{ __('ui::blocks_pricing.billing.billed_yearly.text', ['price' => '$140']) }}</p>
                  </div>
                </div>
                <a href="#" class="bg-white text-indigo-600 hover:bg-indigo-50 mt-6 inline-block w-full rounded-md border border-transparent py-2 px-8 text-center text-sm font-medium shadow-sm sm:mt-0 sm:w-auto lg:mt-6 lg:w-full">{{ __('ui::blocks_pricing.actions.buy_named_plan.label', ['plan' => __('ui::blocks_pricing.tiers.growth.label')]) }}</a>
              </div>
            </div>
            <h4 class="sr-only">{{ __('ui::blocks_pricing.comparison.features.label') }}</h4>
            <ul role="list" class="divide-indigo-500 divide-opacity-75 border-indigo-500 mt-7 divide-y border-t lg:border-t-0">
              <li class="flex items-center py-3">
                <svg class="text-indigo-200 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                </svg>
                <span class="text-white ml-3 text-sm font-medium">{{ __('ui::blocks_pricing.features.invoicing_basic.label') }}</span>
              </li>
              <li class="flex items-center py-3">
                <svg class="text-indigo-200 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                </svg>
                <span class="text-white ml-3 text-sm font-medium">{{ __('ui::blocks_pricing.features.accounting_easy.label') }}</span>
              </li>
              <li class="flex items-center py-3">
                <svg class="text-indigo-200 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                </svg>
                <span class="text-white ml-3 text-sm font-medium">{{ __('ui::blocks_pricing.comparison.multi_accounts.label') }}</span>
              </li>
              <li class="flex items-center py-3">
                <svg class="text-indigo-200 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                </svg>
                <span class="text-white ml-3 text-sm font-medium">{{ __('ui::blocks_pricing.features.tax_planning_toolkit.label') }}</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Feature comparison (up to lg) -->
    <section aria-labelledby="mobile-comparison-heading" class="lg:hidden">
      <h2 id="mobile-comparison-heading" class="sr-only">{{ __('ui::blocks_pricing.comparison.feature_comparison.title') }}</h2>

      <div class="mx-auto max-w-2xl space-y-16 px-6 py-16">
        <div class="border-t border-gray-200" key="plan.title">
          <div class="border-transparent -mt-px border-t-2 pt-6 sm:w-1/2">
            <h3 class="text-gray-900 text-sm font-bold">{{ __('ui::blocks_pricing.tiers.starter.label') }}</h3>
            <p class="mt-2 text-sm text-gray-500">{{ __('ui::blocks_pricing.taglines.financial_essentials.help') }}</p>
          </div>
          <h4 class="mt-10 text-sm font-bold text-gray-900">{{ __('ui::blocks_pricing.comparison.catered_for_business.label') }}</h4>

          <div class="relative mt-6">
            <!-- Fake card background -->
            <div aria-hidden="true" class="pointer-events-none absolute inset-0 hidden sm:block">
              <div class="shadow absolute right-0 h-full w-1/2 rounded-lg bg-white"></div>
            </div>

            <div class="shadow ring-1 ring-black ring-opacity-5 relative rounded-lg bg-white py-3 px-4 sm:rounded-none sm:bg-transparent sm:p-0 sm:shadow-none sm:ring-0">
              <dl class="divide-y divide-gray-200">
                <div class="flex items-center justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="pr-4 text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.comparison.tax_savings.label') }}</dt>
                  <dd class="flex items-center justify-end sm:justify-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex items-center justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="pr-4 text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.features.accounting_easy.label') }}</dt>
                  <dd class="flex items-center justify-end sm:justify-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex items-center justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="pr-4 text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.comparison.multi_accounts.label') }}</dt>
                  <dd class="flex items-center justify-end sm:justify-center sm:px-4">
                    <span class="text-gray-900 text-sm font-medium">{{ __('ui::blocks_pricing.features.accounts_3.label') }}</span>
                  </dd>
                </div>
                <div class="flex items-center justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="pr-4 text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.comparison.invoicing.label') }}</dt>
                  <dd class="flex items-center justify-end sm:justify-center sm:px-4">
                    <span class="text-gray-900 text-sm font-medium">{{ __('ui::blocks_pricing.features.invoices_3.label') }}</span>
                  </dd>
                </div>
                <div class="flex items-center justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="pr-4 text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.comparison.exclusive_offers.label') }}</dt>
                  <dd class="flex items-center justify-end sm:justify-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.no.label') }}</span>
                  </dd>
                </div>
                <div class="flex items-center justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="pr-4 text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.features.advisor_6_months.label') }}</dt>
                  <dd class="flex items-center justify-end sm:justify-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.no.label') }}</span>
                  </dd>
                </div>
                <div class="flex items-center justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="pr-4 text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.comparison.mobile_web_access.label') }}</dt>
                  <dd class="flex items-center justify-end sm:justify-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.no.label') }}</span>
                  </dd>
                </div>
              </dl>
            </div>

            <!-- Fake card border -->
            <div aria-hidden="true" class="pointer-events-none absolute inset-0 hidden sm:block">
              <div class="ring-1 ring-black ring-opacity-5 absolute right-0 h-full w-1/2 rounded-lg"></div>
            </div>
          </div>

          <h4 class="mt-10 text-sm font-bold text-gray-900">{{ __('ui::blocks_pricing.comparison.other_perks.label') }}</h4>

          <div class="relative mt-6">
            <!-- Fake card background -->
            <div aria-hidden="true" class="pointer-events-none absolute inset-0 hidden sm:block">
              <div class="shadow absolute right-0 h-full w-1/2 rounded-lg bg-white"></div>
            </div>

            <div class="shadow ring-1 ring-black ring-opacity-5 relative rounded-lg bg-white py-3 px-4 sm:rounded-none sm:bg-transparent sm:p-0 sm:shadow-none sm:ring-0">
              <dl class="divide-y divide-gray-200">
                <div class="flex justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="text-sm font-medium text-gray-600 sm:pr-4">{{ __('ui::blocks_pricing.features.customer_support_24_7.label') }}</dt>
                  <dd class="text-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="text-sm font-medium text-gray-600 sm:pr-4">{{ __('ui::blocks_pricing.features.instant_notifications.label') }}</dt>
                  <dd class="text-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="text-sm font-medium text-gray-600 sm:pr-4">{{ __('ui::blocks_pricing.features.budgeting_tools.label') }}</dt>
                  <dd class="text-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="text-sm font-medium text-gray-600 sm:pr-4">{{ __('ui::blocks_pricing.features.digital_receipts.label') }}</dt>
                  <dd class="text-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="text-sm font-medium text-gray-600 sm:pr-4">{{ __('ui::blocks_pricing.features.pots_to_separate_money.label') }}</dt>
                  <dd class="text-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.no.label') }}</span>
                  </dd>
                </div>
                <div class="flex justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="text-sm font-medium text-gray-600 sm:pr-4">{{ __('ui::blocks_pricing.features.free_bank_transfers.label') }}</dt>
                  <dd class="text-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.no.label') }}</span>
                  </dd>
                </div>
                <div class="flex justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="text-sm font-medium text-gray-600 sm:pr-4">{{ __('ui::blocks_pricing.features.business_debit_card.label') }}</dt>
                  <dd class="text-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.no.label') }}</span>
                  </dd>
                </div>
              </dl>
            </div>

            <!-- Fake card border -->
            <div aria-hidden="true" class="pointer-events-none absolute inset-0 hidden sm:block">
              <div class="ring-1 ring-black ring-opacity-5 absolute right-0 h-full w-1/2 rounded-lg"></div>
            </div>
          </div>
        </div>
        <div class="border-t border-gray-200" key="plan.title">
          <div class="border-indigo-600 -mt-px border-t-2 pt-6 sm:w-1/2">
            <h3 class="text-indigo-600 text-sm font-bold">{{ __('ui::blocks_pricing.tiers.scale.label') }}</h3>
            <p class="mt-2 text-sm text-gray-500">{{ __('ui::blocks_pricing.taglines.best_financial_services.help') }}</p>
          </div>
          <h4 class="mt-10 text-sm font-bold text-gray-900">{{ __('ui::blocks_pricing.comparison.catered_for_business.label') }}</h4>

          <div class="relative mt-6">
            <!-- Fake card background -->
            <div aria-hidden="true" class="pointer-events-none absolute inset-0 hidden sm:block">
              <div class="shadow-md absolute right-0 h-full w-1/2 rounded-lg bg-white"></div>
            </div>

            <div class="shadow-md ring-2 ring-indigo-600 relative rounded-lg bg-white py-3 px-4 sm:rounded-none sm:bg-transparent sm:p-0 sm:shadow-none sm:ring-0">
              <dl class="divide-y divide-gray-200">
                <div class="flex items-center justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="pr-4 text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.comparison.tax_savings.label') }}</dt>
                  <dd class="flex items-center justify-end sm:justify-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex items-center justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="pr-4 text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.features.accounting_easy.label') }}</dt>
                  <dd class="flex items-center justify-end sm:justify-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex items-center justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="pr-4 text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.comparison.multi_accounts.label') }}</dt>
                  <dd class="flex items-center justify-end sm:justify-center sm:px-4">
                    <span class="text-indigo-600 text-sm font-medium">{{ __('ui::blocks_pricing.features.accounts_unlimited.label') }}</span>
                  </dd>
                </div>
                <div class="flex items-center justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="pr-4 text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.comparison.invoicing.label') }}</dt>
                  <dd class="flex items-center justify-end sm:justify-center sm:px-4">
                    <span class="text-indigo-600 text-sm font-medium">{{ __('ui::blocks_pricing.features.invoices_unlimited.label') }}</span>
                  </dd>
                </div>
                <div class="flex items-center justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="pr-4 text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.comparison.exclusive_offers.label') }}</dt>
                  <dd class="flex items-center justify-end sm:justify-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex items-center justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="pr-4 text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.features.advisor_6_months.label') }}</dt>
                  <dd class="flex items-center justify-end sm:justify-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex items-center justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="pr-4 text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.comparison.mobile_web_access.label') }}</dt>
                  <dd class="flex items-center justify-end sm:justify-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
              </dl>
            </div>

            <!-- Fake card border -->
            <div aria-hidden="true" class="pointer-events-none absolute inset-0 hidden sm:block">
              <div class="ring-2 ring-indigo-600 absolute right-0 h-full w-1/2 rounded-lg"></div>
            </div>
          </div>

          <h4 class="mt-10 text-sm font-bold text-gray-900">{{ __('ui::blocks_pricing.comparison.other_perks.label') }}</h4>

          <div class="relative mt-6">
            <!-- Fake card background -->
            <div aria-hidden="true" class="pointer-events-none absolute inset-0 hidden sm:block">
              <div class="shadow-md absolute right-0 h-full w-1/2 rounded-lg bg-white"></div>
            </div>

            <div class="shadow-md ring-2 ring-indigo-600 relative rounded-lg bg-white py-3 px-4 sm:rounded-none sm:bg-transparent sm:p-0 sm:shadow-none sm:ring-0">
              <dl class="divide-y divide-gray-200">
                <div class="flex justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="text-sm font-medium text-gray-600 sm:pr-4">{{ __('ui::blocks_pricing.features.customer_support_24_7.label') }}</dt>
                  <dd class="text-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="text-sm font-medium text-gray-600 sm:pr-4">{{ __('ui::blocks_pricing.features.instant_notifications.label') }}</dt>
                  <dd class="text-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="text-sm font-medium text-gray-600 sm:pr-4">{{ __('ui::blocks_pricing.features.budgeting_tools.label') }}</dt>
                  <dd class="text-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="text-sm font-medium text-gray-600 sm:pr-4">{{ __('ui::blocks_pricing.features.digital_receipts.label') }}</dt>
                  <dd class="text-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="text-sm font-medium text-gray-600 sm:pr-4">{{ __('ui::blocks_pricing.features.pots_to_separate_money.label') }}</dt>
                  <dd class="text-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="text-sm font-medium text-gray-600 sm:pr-4">{{ __('ui::blocks_pricing.features.free_bank_transfers.label') }}</dt>
                  <dd class="text-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="text-sm font-medium text-gray-600 sm:pr-4">{{ __('ui::blocks_pricing.features.business_debit_card.label') }}</dt>
                  <dd class="text-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
              </dl>
            </div>

            <!-- Fake card border -->
            <div aria-hidden="true" class="pointer-events-none absolute inset-0 hidden sm:block">
              <div class="ring-2 ring-indigo-600 absolute right-0 h-full w-1/2 rounded-lg"></div>
            </div>
          </div>
        </div>
        <div class="border-t border-gray-200" key="plan.title">
          <div class="border-transparent -mt-px border-t-2 pt-6 sm:w-1/2">
            <h3 class="text-gray-900 text-sm font-bold">{{ __('ui::blocks_pricing.tiers.growth.label') }}</h3>
            <p class="mt-2 text-sm text-gray-500">{{ __('ui::blocks_pricing.taglines.next_level.help') }}</p>
          </div>
          <h4 class="mt-10 text-sm font-bold text-gray-900">{{ __('ui::blocks_pricing.comparison.catered_for_business.label') }}</h4>

          <div class="relative mt-6">
            <!-- Fake card background -->
            <div aria-hidden="true" class="pointer-events-none absolute inset-0 hidden sm:block">
              <div class="shadow absolute right-0 h-full w-1/2 rounded-lg bg-white"></div>
            </div>

            <div class="shadow ring-1 ring-black ring-opacity-5 relative rounded-lg bg-white py-3 px-4 sm:rounded-none sm:bg-transparent sm:p-0 sm:shadow-none sm:ring-0">
              <dl class="divide-y divide-gray-200">
                <div class="flex items-center justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="pr-4 text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.comparison.tax_savings.label') }}</dt>
                  <dd class="flex items-center justify-end sm:justify-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex items-center justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="pr-4 text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.features.accounting_easy.label') }}</dt>
                  <dd class="flex items-center justify-end sm:justify-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex items-center justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="pr-4 text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.comparison.multi_accounts.label') }}</dt>
                  <dd class="flex items-center justify-end sm:justify-center sm:px-4">
                    <span class="text-gray-900 text-sm font-medium">{{ __('ui::blocks_pricing.features.accounts_7.label') }}</span>
                  </dd>
                </div>
                <div class="flex items-center justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="pr-4 text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.comparison.invoicing.label') }}</dt>
                  <dd class="flex items-center justify-end sm:justify-center sm:px-4">
                    <span class="text-gray-900 text-sm font-medium">{{ __('ui::blocks_pricing.features.invoices_10.label') }}</span>
                  </dd>
                </div>
                <div class="flex items-center justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="pr-4 text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.comparison.exclusive_offers.label') }}</dt>
                  <dd class="flex items-center justify-end sm:justify-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex items-center justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="pr-4 text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.features.advisor_6_months.label') }}</dt>
                  <dd class="flex items-center justify-end sm:justify-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex items-center justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="pr-4 text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.comparison.mobile_web_access.label') }}</dt>
                  <dd class="flex items-center justify-end sm:justify-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.no.label') }}</span>
                  </dd>
                </div>
              </dl>
            </div>

            <!-- Fake card border -->
            <div aria-hidden="true" class="pointer-events-none absolute inset-0 hidden sm:block">
              <div class="ring-1 ring-black ring-opacity-5 absolute right-0 h-full w-1/2 rounded-lg"></div>
            </div>
          </div>

          <h4 class="mt-10 text-sm font-bold text-gray-900">{{ __('ui::blocks_pricing.comparison.other_perks.label') }}</h4>

          <div class="relative mt-6">
            <!-- Fake card background -->
            <div aria-hidden="true" class="pointer-events-none absolute inset-0 hidden sm:block">
              <div class="shadow absolute right-0 h-full w-1/2 rounded-lg bg-white"></div>
            </div>

            <div class="shadow ring-1 ring-black ring-opacity-5 relative rounded-lg bg-white py-3 px-4 sm:rounded-none sm:bg-transparent sm:p-0 sm:shadow-none sm:ring-0">
              <dl class="divide-y divide-gray-200">
                <div class="flex justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="text-sm font-medium text-gray-600 sm:pr-4">{{ __('ui::blocks_pricing.features.customer_support_24_7.label') }}</dt>
                  <dd class="text-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="text-sm font-medium text-gray-600 sm:pr-4">{{ __('ui::blocks_pricing.features.instant_notifications.label') }}</dt>
                  <dd class="text-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="text-sm font-medium text-gray-600 sm:pr-4">{{ __('ui::blocks_pricing.features.budgeting_tools.label') }}</dt>
                  <dd class="text-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="text-sm font-medium text-gray-600 sm:pr-4">{{ __('ui::blocks_pricing.features.digital_receipts.label') }}</dt>
                  <dd class="text-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="text-sm font-medium text-gray-600 sm:pr-4">{{ __('ui::blocks_pricing.features.pots_to_separate_money.label') }}</dt>
                  <dd class="text-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </dd>
                </div>
                <div class="flex justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="text-sm font-medium text-gray-600 sm:pr-4">{{ __('ui::blocks_pricing.features.free_bank_transfers.label') }}</dt>
                  <dd class="text-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.no.label') }}</span>
                  </dd>
                </div>
                <div class="flex justify-between py-3 sm:grid sm:grid-cols-2">
                  <dt class="text-sm font-medium text-gray-600 sm:pr-4">{{ __('ui::blocks_pricing.features.business_debit_card.label') }}</dt>
                  <dd class="text-center sm:px-4">
                    <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.no.label') }}</span>
                  </dd>
                </div>
              </dl>
            </div>

            <!-- Fake card border -->
            <div aria-hidden="true" class="pointer-events-none absolute inset-0 hidden sm:block">
              <div class="ring-1 ring-black ring-opacity-5 absolute right-0 h-full w-1/2 rounded-lg"></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Feature comparison (lg+) -->
    <section aria-labelledby="comparison-heading" class="hidden lg:block">
      <h2 id="comparison-heading" class="sr-only">{{ __('ui::blocks_pricing.comparison.feature_comparison.title') }}</h2>

      <div class="mx-auto max-w-7xl px-8 py-24">
        <div class="flex w-full items-stretch border-t border-gray-200">
          <div class="-mt-px flex w-1/4 items-end py-6 pr-4">
            <h3 class="mt-auto text-sm font-bold text-gray-900">{{ __('ui::blocks_pricing.comparison.catered_for_business.label') }}</h3>
          </div>
          <div aria-hidden="true" class="pr-4 -mt-px w-1/4 pl-4">
            <div class="border-transparent border-t-2 py-6">
              <p class="text-gray-900 text-sm font-bold">{{ __('ui::blocks_pricing.tiers.starter.label') }}</p>
              <p class="mt-2 text-sm text-gray-500">{{ __('ui::blocks_pricing.taglines.financial_essentials.help') }}</p>
            </div>
          </div>
          <div aria-hidden="true" class="pr-4 -mt-px w-1/4 pl-4">
            <div class="border-indigo-600 border-t-2 py-6">
              <p class="text-indigo-600 text-sm font-bold">{{ __('ui::blocks_pricing.tiers.scale.label') }}</p>
              <p class="mt-2 text-sm text-gray-500">{{ __('ui::blocks_pricing.taglines.best_financial_services.help') }}</p>
            </div>
          </div>
          <div aria-hidden="true" class="-mt-px w-1/4 pl-4">
            <div class="border-transparent border-t-2 py-6">
              <p class="text-gray-900 text-sm font-bold">{{ __('ui::blocks_pricing.tiers.growth.label') }}</p>
              <p class="mt-2 text-sm text-gray-500">{{ __('ui::blocks_pricing.taglines.next_level.help') }}</p>
            </div>
          </div>
        </div>

        <div class="relative">
          <!-- Fake card backgrounds -->
          <div class="pointer-events-none absolute inset-0 flex items-stretch" aria-hidden="true">
            <div class="w-1/4 pr-4"></div>
            <div class="w-1/4 px-4">
              <div class="h-full w-full rounded-lg bg-white shadow"></div>
            </div>
            <div class="w-1/4 px-4">
              <div class="h-full w-full rounded-lg bg-white shadow-md"></div>
            </div>
            <div class="w-1/4 pl-4">
              <div class="h-full w-full rounded-lg bg-white shadow"></div>
            </div>
          </div>

          <table class="relative w-full">
            <caption class="sr-only">
              {{ __('ui::blocks_pricing.comparison.business_feature_comparison.title') }}
            </caption>
            <thead>
              <tr class="text-left">
                <th scope="col">
                  <span class="sr-only">{{ __('ui::blocks_pricing.comparison.feature.label') }}</span>
                </th>
                <th scope="col">
                  <span class="sr-only">{{ __('ui::blocks_pricing.comparison.plan_name.label', ['plan' => __('ui::blocks_pricing.tiers.starter.label')]) }}</span>
                </th>
                <th scope="col">
                  <span class="sr-only">{{ __('ui::blocks_pricing.comparison.plan_name.label', ['plan' => __('ui::blocks_pricing.tiers.scale.label')]) }}</span>
                </th>
                <th scope="col">
                  <span class="sr-only">{{ __('ui::blocks_pricing.comparison.plan_name.label', ['plan' => __('ui::blocks_pricing.tiers.growth.label')]) }}</span>
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <tr>
                <th scope="row" class="w-1/4 py-3 pr-4 text-left text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.comparison.tax_savings.label') }}</th>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
                <td class="pl-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="w-1/4 py-3 pr-4 text-left text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.features.accounting_easy.label') }}</th>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
                <td class="pl-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="w-1/4 py-3 pr-4 text-left text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.comparison.multi_accounts.label') }}</th>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <span class="text-gray-900 text-sm font-medium">{{ __('ui::blocks_pricing.features.accounts_3.label') }}</span>
                  </span>
                </td>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <span class="text-indigo-600 text-sm font-medium">{{ __('ui::blocks_pricing.features.accounts_unlimited.label') }}</span>
                  </span>
                </td>
                <td class="pl-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <span class="text-gray-900 text-sm font-medium">{{ __('ui::blocks_pricing.features.accounts_7.label') }}</span>
                  </span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="w-1/4 py-3 pr-4 text-left text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.comparison.invoicing.label') }}</th>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <span class="text-gray-900 text-sm font-medium">{{ __('ui::blocks_pricing.features.invoices_3.label') }}</span>
                  </span>
                </td>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <span class="text-indigo-600 text-sm font-medium">{{ __('ui::blocks_pricing.features.invoices_unlimited.label') }}</span>
                  </span>
                </td>
                <td class="pl-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <span class="text-gray-900 text-sm font-medium">{{ __('ui::blocks_pricing.features.invoices_10.label') }}</span>
                  </span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="w-1/4 py-3 pr-4 text-left text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.comparison.exclusive_offers.label') }}</th>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.no.label') }}</span>
                  </span>
                </td>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
                <td class="pl-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="w-1/4 py-3 pr-4 text-left text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.features.advisor_6_months.label') }}</th>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.no.label') }}</span>
                  </span>
                </td>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
                <td class="pl-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="w-1/4 py-3 pr-4 text-left text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.comparison.mobile_web_access.label') }}</th>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.no.label') }}</span>
                  </span>
                </td>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
                <td class="pl-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.no.label') }}</span>
                  </span>
                </td>
              </tr>
            </tbody>
          </table>

          <!-- Fake card borders -->
          <div class="pointer-events-none absolute inset-0 flex items-stretch" aria-hidden="true">
            <div class="w-1/4 pr-4"></div>
            <div class="w-1/4 px-4">
              <div class="h-full w-full rounded-lg ring-1 ring-black ring-opacity-5"></div>
            </div>
            <div class="w-1/4 px-4">
              <div class="h-full w-full rounded-lg ring-2 ring-indigo-600 ring-opacity-100"></div>
            </div>
            <div class="w-1/4 pl-4">
              <div class="h-full w-full rounded-lg ring-1 ring-black ring-opacity-5"></div>
            </div>
          </div>
        </div>

        <h3 class="mt-10 text-sm font-bold text-gray-900">{{ __('ui::blocks_pricing.comparison.other_perks.label') }}</h3>

        <div class="relative mt-6">
          <!-- Fake card backgrounds -->
          <div class="pointer-events-none absolute inset-0 flex items-stretch" aria-hidden="true">
            <div class="w-1/4 pr-4"></div>
            <div class="w-1/4 px-4">
              <div class="h-full w-full rounded-lg bg-white shadow"></div>
            </div>
            <div class="w-1/4 px-4">
              <div class="h-full w-full rounded-lg bg-white shadow-md"></div>
            </div>
            <div class="w-1/4 pl-4">
              <div class="h-full w-full rounded-lg bg-white shadow"></div>
            </div>
          </div>

          <table class="relative w-full">
            <caption class="sr-only">
              {{ __('ui::blocks_pricing.comparison.perk_comparison.title') }}
            </caption>
            <thead>
              <tr class="text-left">
                <th scope="col">
                  <span class="sr-only">{{ __('ui::blocks_pricing.comparison.perk.label') }}</span>
                </th>
                <th scope="col">
                  <span class="sr-only">{{ __('ui::blocks_pricing.comparison.plan_name.label', ['plan' => __('ui::blocks_pricing.tiers.starter.label')]) }}</span>
                </th>
                <th scope="col">
                  <span class="sr-only">{{ __('ui::blocks_pricing.comparison.plan_name.label', ['plan' => __('ui::blocks_pricing.tiers.scale.label')]) }}</span>
                </th>
                <th scope="col">
                  <span class="sr-only">{{ __('ui::blocks_pricing.comparison.plan_name.label', ['plan' => __('ui::blocks_pricing.tiers.growth.label')]) }}</span>
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <tr>
                <th scope="row" class="w-1/4 py-3 pr-4 text-left text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.features.customer_support_24_7.label') }}</th>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
                <td class="pl-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="w-1/4 py-3 pr-4 text-left text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.features.instant_notifications.label') }}</th>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
                <td class="pl-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="w-1/4 py-3 pr-4 text-left text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.features.budgeting_tools.label') }}</th>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
                <td class="pl-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="w-1/4 py-3 pr-4 text-left text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.features.digital_receipts.label') }}</th>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
                <td class="pl-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="w-1/4 py-3 pr-4 text-left text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.features.pots_to_separate_money.label') }}</th>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.no.label') }}</span>
                  </span>
                </td>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
                <td class="pl-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="w-1/4 py-3 pr-4 text-left text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.features.free_bank_transfers.label') }}</th>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.no.label') }}</span>
                  </span>
                </td>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
                <td class="pl-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.no.label') }}</span>
                  </span>
                </td>
              </tr>
              <tr>
                <th scope="row" class="w-1/4 py-3 pr-4 text-left text-sm font-medium text-gray-600">{{ __('ui::blocks_pricing.features.business_debit_card.label') }}</th>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.no.label') }}</span>
                  </span>
                </td>
                <td class="px-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.yes.label') }}</span>
                  </span>
                </td>
                <td class="pl-4 relative w-1/4 py-0 text-center">
                  <span class="relative h-full w-full py-3">
                    <svg class="mx-auto h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                    <span class="sr-only">{{ __('ui::blocks_pricing.states.no.label') }}</span>
                  </span>
                </td>
              </tr>
            </tbody>
          </table>

          <!-- Fake card borders -->
          <div class="pointer-events-none absolute inset-0 flex items-stretch" aria-hidden="true">
            <div class="w-1/4 pr-4"></div>
            <div class="w-1/4 px-4">
              <div class="h-full w-full rounded-lg ring-1 ring-black ring-opacity-5"></div>
            </div>
            <div class="w-1/4 px-4">
              <div class="h-full w-full rounded-lg ring-2 ring-indigo-600 ring-opacity-100"></div>
            </div>
            <div class="w-1/4 pl-4">
              <div class="h-full w-full rounded-lg ring-1 ring-black ring-opacity-5"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
