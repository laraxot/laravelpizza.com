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
<div class="bg-indigo-700 py-16 sm:py-24 lg:py-32">
    <div class="mx-auto grid max-w-7xl grid-cols-1 gap-10 px-6 lg:grid-cols-12 lg:gap-8 lg:px-8">
      <div class="max-w-xl text-3xl font-bold tracking-tight text-white sm:text-4xl lg:col-span-7">
        <h2 class="inline sm:block lg:inline xl:block">{{ __('ui::blocks_newsletter.intro.product_news.title') }}</h2>
        <p class="inline sm:block lg:inline xl:block">{{ __('ui::blocks_newsletter.intro.sign_up.help') }}</p>
      </div>
      <form class="w-full max-w-md lg:col-span-5 lg:pt-2">
        <div class="flex gap-x-4">
          <label for="email-address" class="sr-only">{{ __('ui::blocks_newsletter.form.email_address.label') }}</label>
          <input id="email-address" name="email" type="email" autocomplete="email" required class="min-w-0 flex-auto rounded-md border-0 bg-white/10 px-3.5 py-2 text-white shadow-sm ring-1 ring-inset ring-white/10 placeholder:text-white/75 focus:ring-2 focus:ring-inset focus:ring-white sm:text-sm sm:leading-6" placeholder="{{ __('ui::blocks_newsletter.form.email_address.placeholder') }}">
          <button type="submit" class="flex-none rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-indigo-600 shadow-sm hover:bg-indigo-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">{{ __('ui::blocks_newsletter.form.subscribe.label') }}</button>
        </div>
        <p class="mt-4 text-sm leading-6 text-gray-300">{{ __('ui::blocks_newsletter.privacy.care_about_data.text') }} <a href="#" class="font-semibold text-white hover:text-indigo-50">{{ __('ui::blocks_newsletter.privacy.policy_link.label') }}</a>.</p>
      </form>
    </div>
  </div>
