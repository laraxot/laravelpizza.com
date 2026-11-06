<?php

declare(strict_types=1);
?>
<!--
  This example requires some changes to your config:

  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
<div class="bg-white">
    <div class="mx-auto max-w-7xl px-6 py-16 sm:py-24 lg:flex lg:justify-between lg:px-8">
      <div class="max-w-xl">
        <h2 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl lg:text-6xl">{{ __('ui::blocks_header.shared.pricing_plans.title') }}</h2>
        <p class="mt-5 text-xl text-gray-500">{{ __('ui::blocks_header.shared.paragraph_1.description') }}</p>
      </div>
      <div class="mt-10 w-full max-w-xs">
        <label for="currency" class="block text-base font-medium text-gray-500">{{ __('ui::blocks_header.shared.currency.label') }}</label>
        <div class="relative mt-1.5">
          <select id="currency" name="currency" class="block w-full appearance-none rounded-md border border-gray-300 bg-white bg-none py-2 pl-3 pr-10 text-base text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
            <option>{{ __('ui::blocks_header.shared.argentina_ars.label') }}</option>
            <option>{{ __('ui::blocks_header.shared.australia_aud.label') }}</option>
            <option selected>{{ __('ui::blocks_header.shared.united_states_usd.label') }}</option>
            <option>{{ __('ui::blocks_header.shared.canada_cad.label') }}</option>
            <option>{{ __('ui::blocks_header.shared.france_eur.label') }}</option>
            <option>{{ __('ui::blocks_header.shared.japan_jpy.label') }}</option>
            <option>{{ __('ui::blocks_header.shared.nigeria_ngn.label') }}</option>
            <option>{{ __('ui::blocks_header.shared.switzerland_chf.label') }}</option>
            <option>{{ __('ui::blocks_header.shared.united_kingdom_gbp.label') }}</option>
          </select>
          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2">
            <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>
