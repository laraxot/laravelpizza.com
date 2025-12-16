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
        <h2 class="text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">Pricing Plans</h2>
        <p class="mt-5 text-xl text-gray-400">Start building for free, then add a site plan to go live. Account plans unlock additional features.</p>
      </div>
      <div class="mt-10 w-full max-w-xs">
        <label for="currency" class="block text-base font-medium text-gray-300">Currency</label>
        <div class="relative mt-1.5">
          <select id="currency" name="currency" class="block w-full appearance-none rounded-md border border-transparent bg-gray-700 bg-none py-2 pl-3 pr-10 text-base text-white focus:border-white focus:outline-none focus:ring-1 focus:ring-white sm:text-sm">
            <option>Argentina (ARS)</option>
            <option>Australia (AUD)</option>
            <option selected>United States (USD)</option>
            <option>Canada (CAD)</option>
            <option>France (EUR)</option>
            <option>Japan (JPY)</option>
            <option>Nigeria (NGN)</option>
            <option>Switzerland (CHF)</option>
            <option>United Kingdom (GBP)</option>
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
