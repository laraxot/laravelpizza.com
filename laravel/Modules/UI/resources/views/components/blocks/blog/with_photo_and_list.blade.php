<?php

declare(strict_types=1);
?>
<div class="bg-white py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <div class="mx-auto flex max-w-2xl flex-col items-end justify-between gap-16 lg:mx-0 lg:max-w-none lg:flex-row">
        <div class="w-full lg:max-w-lg lg:flex-auto">
          <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ __('ui::blocks_blog.with_photo_and_list.heading_1.title') }}</h2>
          <p class="mt-6 text-xl leading-8 text-gray-600">{{ __('ui::blocks_blog.with_photo_and_list.paragraph_1.description') }}</p>
          <img src="https://images.unsplash.com/photo-1606857521015-7f9fcf423740?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1344&h=1104&q=80" alt="" class="mt-16 aspect-[6/5] w-full rounded-2xl bg-gray-50 object-cover lg:aspect-auto lg:h-[34.5rem]">
        </div>
        <div class="w-full lg:max-w-xl lg:flex-auto">
          <h3 class="sr-only">{{ __('ui::blocks_blog.with_photo_and_list.job_openings.title') }}</h3>
          <ul class="-my-8 divide-y divide-gray-100">
            <li class="py-8">
              <dl class="relative flex flex-wrap gap-x-3">
                <dt class="sr-only">{{ __('ui::blocks_blog.with_photo_and_list.role.label') }}</dt>
                <dd class="w-full flex-none text-lg font-semibold tracking-tight text-gray-900">
                  <a href="#">
                    {{ __('ui::blocks_blog.with_photo_and_list.full_time_designer.label') }}
                    <span class="absolute inset-0" aria-hidden="true"></span>
                  </a>
                </dd>
                <dt class="sr-only">{{ __('ui::blocks_blog.with_photo_and_list.description.label') }}</dt>
                <dd class="mt-2 w-full flex-none text-base leading-7 text-gray-600">{{ __('ui::blocks_blog.with_photo_and_list.paragraph_2.description') }}</dd>
                <dt class="sr-only">{{ __('ui::blocks_blog.with_photo_and_list.salary.label') }}</dt>
                <dd class="mt-4 text-base font-semibold leading-7 text-gray-900">$75,000 USD</dd>
                <dt class="sr-only">{{ __('ui::blocks_blog.with_photo_and_list.location.label') }}</dt>
                <dd class="mt-4 flex items-center gap-x-3 text-base leading-7 text-gray-500">
                  <svg viewBox="0 0 2 2" class="h-0.5 w-0.5 flex-none fill-gray-300" aria-hidden="true">
                    <circle cx="1" cy="1" r="1" />
                  </svg>
                  San Francisco, CA
                </dd>
              </dl>
            </li>
            <li class="py-8">
              <dl class="relative flex flex-wrap gap-x-3">
                <dt class="sr-only">{{ __('ui::blocks_blog.with_photo_and_list.role.label') }}</dt>
                <dd class="w-full flex-none text-lg font-semibold tracking-tight text-gray-900">
                  <a href="#">
                    {{ __('ui::blocks_blog.with_photo_and_list.laravel_developer.label') }}
                    <span class="absolute inset-0" aria-hidden="true"></span>
                  </a>
                </dd>
                <dt class="sr-only">{{ __('ui::blocks_blog.with_photo_and_list.description.label') }}</dt>
                <dd class="mt-2 w-full flex-none text-base leading-7 text-gray-600">{{ __('ui::blocks_blog.with_photo_and_list.paragraph_3.description') }}</dd>
                <dt class="sr-only">{{ __('ui::blocks_blog.with_photo_and_list.salary.label') }}</dt>
                <dd class="mt-4 text-base font-semibold leading-7 text-gray-900">$125,000 USD</dd>
                <dt class="sr-only">{{ __('ui::blocks_blog.with_photo_and_list.location.label') }}</dt>
                <dd class="mt-4 flex items-center gap-x-3 text-base leading-7 text-gray-500">
                  <svg viewBox="0 0 2 2" class="h-0.5 w-0.5 flex-none fill-gray-300" aria-hidden="true">
                    <circle cx="1" cy="1" r="1" />
                  </svg>
                  San Francisco, CA
                </dd>
              </dl>
            </li>
            <li class="py-8">
              <dl class="relative flex flex-wrap gap-x-3">
                <dt class="sr-only">{{ __('ui::blocks_blog.with_photo_and_list.role.label') }}</dt>
                <dd class="w-full flex-none text-lg font-semibold tracking-tight text-gray-900">
                  <a href="#">
                    {{ __('ui::blocks_blog.with_photo_and_list.react_native_developer.label') }}
                    <span class="absolute inset-0" aria-hidden="true"></span>
                  </a>
                </dd>
                <dt class="sr-only">{{ __('ui::blocks_blog.with_photo_and_list.description.label') }}</dt>
                <dd class="mt-2 w-full flex-none text-base leading-7 text-gray-600">{{ __('ui::blocks_blog.with_photo_and_list.paragraph_4.description') }}</dd>
                <dt class="sr-only">{{ __('ui::blocks_blog.with_photo_and_list.salary.label') }}</dt>
                <dd class="mt-4 text-base font-semibold leading-7 text-gray-900">$105,000 USD</dd>
                <dt class="sr-only">{{ __('ui::blocks_blog.with_photo_and_list.location.label') }}</dt>
                <dd class="mt-4 flex items-center gap-x-3 text-base leading-7 text-gray-500">
                  <svg viewBox="0 0 2 2" class="h-0.5 w-0.5 flex-none fill-gray-300" aria-hidden="true">
                    <circle cx="1" cy="1" r="1" />
                  </svg>
                  San Francisco, CA
                </dd>
              </dl>
            </li>
          </ul>
          <div class="mt-8 flex border-t border-gray-100 pt-8">
            <a href="#" class="text-sm font-semibold leading-6 text-indigo-600 hover:text-indigo-500">{{ __('ui::blocks_blog.with_photo_and_list.view_all_openings.label') }} <span aria-hidden="true">&rarr;</span></a>
          </div>
        </div>
      </div>
    </div>
  </div>
