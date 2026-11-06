<?php

declare(strict_types=1);
?>
<div class="relative bg-gray-50 px-6 pb-20 pt-16 lg:px-8 lg:pb-28 lg:pt-24">
    <div class="absolute inset-0">
      <div class="h-1/3 bg-white sm:h-2/3"></div>
    </div>
    <div class="relative mx-auto max-w-7xl">
      <div class="text-center">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ __('ui::blocks_blog.shared.from_the_blog.title') }}</h2>
        <p class="mx-auto mt-3 max-w-2xl text-xl text-gray-500 sm:mt-4">{{ __('ui::blocks_blog.archivied_3_column_cards.paragraph_1.description') }}</p>
      </div>
      <div class="mx-auto mt-12 grid max-w-lg gap-5 lg:max-w-none lg:grid-cols-3">
        <div class="flex flex-col overflow-hidden rounded-lg shadow-lg">
          <div class="flex-shrink-0">
            <img class="h-48 w-full object-cover" src="https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1679&q=80" alt="">
          </div>
          <div class="flex flex-1 flex-col justify-between bg-white p-6">
            <div class="flex-1">
              <p class="text-sm font-medium text-indigo-600">
                <a href="#" class="hover:underline">{{ __('ui::blocks_blog.shared.article.label') }}</a>
              </p>
              <a href="#" class="mt-2 block">
                <p class="text-xl font-semibold text-gray-900">{{ __('ui::blocks_demo_shared.labels.boost_your_conversion_rate.label') }}</p>
                <p class="mt-3 text-base text-gray-500">{{ __('ui::blocks_blog.archivied_3_column_cards.paragraph_2.description') }}</p>
              </a>
            </div>
            <div class="mt-6 flex items-center">
              <div class="flex-shrink-0">
                <a href="#">
                  <span class="sr-only">Roel Aufderehar</span>
                  <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                </a>
              </div>
              <div class="ml-3">
                <p class="text-sm font-medium text-gray-900">
                  <a href="#" class="hover:underline">Roel Aufderehar</a>
                </p>
                <div class="flex space-x-1 text-sm text-gray-500">
                  <time datetime="2020-03-16">{{ __('ui::blocks_blog.shared.date_1.label') }}</time>
                  <span aria-hidden="true">&middot;</span>
                  <span>{{ __('ui::blocks_blog.shared.6_min_read.label') }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="flex flex-col overflow-hidden rounded-lg shadow-lg">
          <div class="flex-shrink-0">
            <img class="h-48 w-full object-cover" src="https://images.unsplash.com/photo-1547586696-ea22b4d4235d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1679&q=80" alt="">
          </div>
          <div class="flex flex-1 flex-col justify-between bg-white p-6">
            <div class="flex-1">
              <p class="text-sm font-medium text-indigo-600">
                <a href="#" class="hover:underline">{{ __('ui::blocks_demo_shared.labels.video.label') }}</a>
              </p>
              <a href="#" class="mt-2 block">
                <p class="text-xl font-semibold text-gray-900">{{ __('ui::blocks_blog.shared.paragraph_3.description') }}</p>
                <p class="mt-3 text-base text-gray-500">{{ __('ui::blocks_blog.archivied_3_column_cards.paragraph_3.description') }}</p>
              </a>
            </div>
            <div class="mt-6 flex items-center">
              <div class="flex-shrink-0">
                <a href="#">
                  <span class="sr-only">Brenna Goyette</span>
                  <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                </a>
              </div>
              <div class="ml-3">
                <p class="text-sm font-medium text-gray-900">
                  <a href="#" class="hover:underline">Brenna Goyette</a>
                </p>
                <div class="flex space-x-1 text-sm text-gray-500">
                  <time datetime="2020-03-10">{{ __('ui::blocks_blog.shared.date_2.label') }}</time>
                  <span aria-hidden="true">&middot;</span>
                  <span>{{ __('ui::blocks_blog.shared.4_min_read.label') }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="flex flex-col overflow-hidden rounded-lg shadow-lg">
          <div class="flex-shrink-0">
            <img class="h-48 w-full object-cover" src="https://images.unsplash.com/photo-1492724441997-5dc865305da7?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1679&q=80" alt="">
          </div>
          <div class="flex flex-1 flex-col justify-between bg-white p-6">
            <div class="flex-1">
              <p class="text-sm font-medium text-indigo-600">
                <a href="#" class="hover:underline">{{ __('ui::blocks_blog.shared.case_study.label') }}</a>
              </p>
              <a href="#" class="mt-2 block">
                <p class="text-xl font-semibold text-gray-900">{{ __('ui::blocks_demo_shared.labels.improve_your_customer_experience.label') }}</p>
                <p class="mt-3 text-base text-gray-500">{{ __('ui::blocks_blog.archivied_3_column_cards.paragraph_4.description') }}</p>
              </a>
            </div>
            <div class="mt-6 flex items-center">
              <div class="flex-shrink-0">
                <a href="#">
                  <span class="sr-only">Daniela Metz</span>
                  <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                </a>
              </div>
              <div class="ml-3">
                <p class="text-sm font-medium text-gray-900">
                  <a href="#" class="hover:underline">Daniela Metz</a>
                </p>
                <div class="flex space-x-1 text-sm text-gray-500">
                  <time datetime="2020-02-12">{{ __('ui::blocks_blog.shared.date_3.label') }}</time>
                  <span aria-hidden="true">&middot;</span>
                  <span>{{ __('ui::blocks_blog.shared.11_min_read.label') }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
