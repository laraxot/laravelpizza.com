<?php

declare(strict_types=1);
?>
<div class="overflow-hidden bg-white py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 sm:gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-2 lg:items-start">
        <div class="lg:pr-4 lg:pt-4">
          <div class="lg:max-w-lg">
            <h2 class="text-base font-semibold leading-7 text-indigo-600">{{ __('ui::blocks_feature_sections.shared.deploy_faster.title') }}</h2>
            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ __('ui::blocks_feature_sections.shared.a_better_workflow.label') }}</p>
            <p class="mt-6 text-lg leading-8 text-gray-600">{{ __('ui::blocks_feature_sections.shared.paragraph_2.description') }}</p>
            <div class="mt-8">
              <a href="#" class="inline-flex rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{ __('ui::blocks_demo_shared.labels.get_started.label') }}</a>
            </div>
            <figure class="mt-16 border-l border-gray-200 pl-8 text-gray-600">
              <blockquote class="text-base leading-7">
                <p>{{ __('ui::blocks_feature_sections.with_testimonial.paragraph_1.description') }}</p>
              </blockquote>
              <figcaption class="mt-6 flex gap-x-4 text-sm leading-6">
                <img src="https://images.unsplash.com/photo-1509783236416-c9ad59bae472?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=1024&h=1024&q=80" alt="" class="h-6 w-6 flex-none rounded-full">
                <div><span class="font-semibold text-gray-900">Maria Hill</span> {{ __('ui::blocks_feature_sections.with_testimonial.marketing_manager.label') }}</div>
              </figcaption>
            </figure>
          </div>
        </div>
        <img src="https://tailwindui.com/img/component-images/dark-project-app-screenshot.png" alt="{{ __('ui::blocks_feature_sections.shared.product_screenshot.alt') }}" class="w-[48rem] max-w-none rounded-xl shadow-xl ring-1 ring-gray-400/10 sm:w-[57rem] md:-ml-4 lg:ml-0" width="2432" height="1442">
      </div>
    </div>
  </div>
