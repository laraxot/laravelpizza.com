<?php

declare(strict_types=1);
?>
<div class="bg-white py-24 sm:py-32">
    <div class="mx-auto grid max-w-7xl grid-cols-1 gap-x-8 gap-y-12 px-6 sm:gap-y-16 lg:grid-cols-2 lg:px-8">
      <article class="mx-auto w-full max-w-2xl lg:mx-0 lg:max-w-lg">
        <time datetime="2020-03-16" class="block text-sm leading-6 text-gray-600">{{ __('ui::blocks_blog.shared.date_1.label') }}</time>
        <h2 id="featured-post" class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">We’re incredibly proud to announce we have secured $75m in Series B</h2>
        <p class="mt-4 text-lg leading-8 text-gray-600">{{ __('ui::blocks_blog.with_featured_post.paragraph_1.description') }}</p>
        <div class="mt-4 flex flex-col justify-between gap-6 sm:mt-8 sm:flex-row-reverse sm:gap-8 lg:mt-4 lg:flex-col">
          <div class="flex">
            <a href="#" class="text-sm font-semibold leading-6 text-indigo-600" aria-describedby="featured-post">{{ __('ui::blocks_blog.with_featured_post.continue_reading.label') }} <span aria-hidden="true">&rarr;</span></a>
          </div>
          <div class="flex lg:border-t lg:border-gray-900/10 lg:pt-8">
            <a href="#" class="flex gap-x-2.5 text-sm font-semibold leading-6 text-gray-900">
              <img src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="h-6 w-6 flex-none rounded-full bg-gray-50">
              Michael Foster
            </a>
          </div>
        </div>
      </article>
      <div class="mx-auto w-full max-w-2xl border-t border-gray-900/10 pt-12 sm:pt-16 lg:mx-0 lg:max-w-none lg:border-t-0 lg:pt-0">
        <div class="-my-12 divide-y divide-gray-900/10">
          <article class="py-12">
            <div class="group relative max-w-xl">
              <time datetime="2020-03-16" class="block text-sm leading-6 text-gray-600">{{ __('ui::blocks_blog.shared.date_2.label') }}</time>
              <h2 class="mt-2 text-lg font-semibold text-gray-900 group-hover:text-gray-600">
                <a href="#">
                  <span class="absolute inset-0"></span>
                  {{ __('ui::blocks_demo_shared.labels.boost_your_conversion_rate.label') }}
                </a>
              </h2>
              <p class="mt-4 text-sm leading-6 text-gray-600">{{ __('ui::blocks_blog.shared.paragraph_4.description') }}</p>
            </div>
            <div class="mt-4 flex">
              <a href="#" class="relative flex gap-x-2.5 text-sm font-semibold leading-6 text-gray-900">
                <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="h-6 w-6 flex-none rounded-full bg-gray-50">
                Lindsay Walton
              </a>
            </div>
          </article>

          <!-- More posts... -->
        </div>
      </div>
    </div>
  </div>
