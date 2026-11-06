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
<div class="bg-white px-6 pb-20 pt-16 lg:px-8 lg:pb-28 lg:pt-24">
    <div class="relative mx-auto max-w-lg divide-y-2 divide-gray-200 lg:max-w-7xl">
      <div>
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ __('ui::blocks_blog.archivied_2_column_with_sign_up.press.title') }}</h2>
        <div class="mt-3 sm:mt-4 lg:grid lg:grid-cols-2 lg:items-center lg:gap-5">
          <p class="text-xl text-gray-500">{{ __('ui::blocks_blog.shared.paragraph_1.description') }}</p>
          <form class="mt-6 flex flex-col sm:flex-row lg:mt-0 lg:justify-end">
            <div>
              <label for="email-address" class="sr-only">{{ __('ui::blocks_demo_shared.labels.email_address.label') }}</label>
              <input id="email-address" name="email-address" type="email" autocomplete="email" required class="w-full appearance-none rounded-md border border-gray-300 bg-white px-4 py-2 text-base text-gray-900 placeholder-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 lg:max-w-xs" placeholder="{{ __('ui::blocks_demo_shared.fields.enter_your_email.placeholder') }}">
            </div>
            <div class="mt-2 flex w-full flex-shrink-0 rounded-md shadow-sm sm:ml-3 sm:mt-0 sm:inline-flex sm:w-auto">
              <button type="button" class="flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:inline-flex sm:w-auto">{{ __('ui::blocks_demo_shared.labels.notify_me.label') }}</button>
            </div>
          </form>
        </div>
      </div>
      <div class="mt-6 grid gap-16 pt-10 lg:grid-cols-2 lg:gap-x-5 lg:gap-y-12">
        <div>
          <p class="text-sm text-gray-500">
            <time datetime="2020-03-16">{{ __('ui::blocks_blog.shared.date_1.label') }}</time>
          </p>
          <a href="#" class="mt-2 block">
            <p class="text-xl font-semibold text-gray-900">{{ __('ui::blocks_demo_shared.labels.boost_your_conversion_rate.label') }}</p>
            <p class="mt-3 text-base text-gray-500">{{ __('ui::blocks_blog.shared.paragraph_2.description') }}</p>
          </a>
          <div class="mt-3">
            <a href="#" class="text-base font-semibold text-indigo-600 hover:text-indigo-500">{{ __('ui::blocks_blog.archivied_2_column_with_sign_up.read_full_story.label') }}</a>
          </div>
        </div>
        <div>
          <p class="text-sm text-gray-500">
            <time datetime="2020-03-10">{{ __('ui::blocks_blog.shared.date_2.label') }}</time>
          </p>
          <a href="#" class="mt-2 block">
            <p class="text-xl font-semibold text-gray-900">{{ __('ui::blocks_blog.shared.paragraph_3.description') }}</p>
            <p class="mt-3 text-base text-gray-500">{{ __('ui::blocks_blog.archivied_2_column_with_sign_up.paragraph_1.description') }}</p>
          </a>
          <div class="mt-3">
            <a href="#" class="text-base font-semibold text-indigo-600 hover:text-indigo-500">{{ __('ui::blocks_blog.archivied_2_column_with_sign_up.read_full_story.label') }}</a>
          </div>
        </div>
        <div>
          <p class="text-sm text-gray-500">
            <time datetime="2020-02-12">{{ __('ui::blocks_blog.shared.date_3.label') }}</time>
          </p>
          <a href="#" class="mt-2 block">
            <p class="text-xl font-semibold text-gray-900">{{ __('ui::blocks_demo_shared.labels.improve_your_customer_experience.label') }}</p>
            <p class="mt-3 text-base text-gray-500">{{ __('ui::blocks_blog.archivied_2_column_with_sign_up.paragraph_2.description') }}</p>
          </a>
          <div class="mt-3">
            <a href="#" class="text-base font-semibold text-indigo-600 hover:text-indigo-500">{{ __('ui::blocks_blog.archivied_2_column_with_sign_up.read_full_story.label') }}</a>
          </div>
        </div>
        <div>
          <p class="text-sm text-gray-500">
            <time datetime="2020-01-29">{{ __('ui::blocks_blog.archivied_2_column_with_sign_up.date_1.label') }}</time>
          </p>
          <a href="#" class="mt-2 block">
            <p class="text-xl font-semibold text-gray-900">{{ __('ui::blocks_blog.archivied_2_column_with_sign_up.text_1.label') }}</p>
            <p class="mt-3 text-base text-gray-500">{{ __('ui::blocks_blog.archivied_2_column_with_sign_up.paragraph_3.description') }}</p>
          </a>
          <div class="mt-3">
            <a href="#" class="text-base font-semibold text-indigo-600 hover:text-indigo-500">{{ __('ui::blocks_blog.archivied_2_column_with_sign_up.read_full_story.label') }}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
