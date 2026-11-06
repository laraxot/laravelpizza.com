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
<div class="bg-gray-800">
    <div class="mx-auto max-w-7xl px-6 py-16 sm:py-24 lg:flex lg:justify-between lg:px-8">
      <div class="max-w-xl">
        <h2 class="text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">{{ __('ui::blocks_header.shared.pricing_plans.title') }}</h2>
        <p class="mt-5 text-xl text-gray-400">{{ __('ui::blocks_header.shared.paragraph_1.description') }}</p>
      </div>
      <div class="mt-10 w-full max-w-xs">
        <label for="currency" class="block text-base font-medium text-gray-300">{{ __('ui::blocks_header.shared.currency.label') }}</label>
        <div class="relative mt-1.5">
          <select id="currency" name="currency" class="block w-full appearance-none rounded-md border border-transparent bg-gray-700 bg-none py-2 pl-3 pr-10 text-base text-white focus:border-white focus:outline-none focus:ring-1 focus:ring-white sm:text-sm">
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
            <svg class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>
