<?php

declare(strict_types=1);
?>
<section class="bg-white py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <div class="mx-auto grid max-w-2xl grid-cols-1 lg:mx-0 lg:max-w-none lg:grid-cols-2">
        <div class="flex flex-col pb-10 sm:pb-16 lg:pb-0 lg:pr-8 xl:pr-20">
          <img class="h-12 self-start" src="https://tailwindui.com/img/logos/tuple-logo-gray-900.svg" alt="">
          <figure class="mt-10 flex flex-auto flex-col justify-between">
            <blockquote class="text-lg leading-8 text-gray-900">
              <p>{{ __('ui::blocks_testimonials.quotes.quote_09.description') }}</p>
            </blockquote>
            <figcaption class="mt-10 flex items-center gap-x-6">
              <img class="h-14 w-14 rounded-full bg-gray-50" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
              <div class="text-base">
                <div class="font-semibold text-gray-900">Judith Black</div>
                <div class="mt-1 text-gray-500">{{ __('ui::blocks_testimonials.roles.ceo_of.label', ['company' => 'Tuple']) }}</div>
              </div>
            </figcaption>
          </figure>
        </div>
        <div class="flex flex-col border-t border-gray-900/10 pt-10 sm:pt-16 lg:border-l lg:border-t-0 lg:pl-8 lg:pt-0 xl:pl-20">
          <img class="h-12 self-start" src="https://tailwindui.com/img/logos/reform-logo-gray-900.svg" alt="">
          <figure class="mt-10 flex flex-auto flex-col justify-between">
            <blockquote class="text-lg leading-8 text-gray-900">
              <p>{{ __('ui::blocks_testimonials.quotes.quote_10.description') }}</p>
            </blockquote>
            <figcaption class="mt-10 flex items-center gap-x-6">
              <img class="h-14 w-14 rounded-full bg-gray-50" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
              <div class="text-base">
                <div class="font-semibold text-gray-900">Joseph Rodriguez</div>
                <div class="mt-1 text-gray-500">{{ __('ui::blocks_testimonials.roles.ceo_of.label', ['company' => 'Reform']) }}</div>
              </div>
            </figcaption>
          </figure>
        </div>
      </div>
    </div>
  </section>
