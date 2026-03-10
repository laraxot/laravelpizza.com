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
@props([
    'title' => 'Data to enrich your online business',
    'description' => 'Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat fugiat aliqua ad ad non deserunt sunt.',
    'logoUrl' => 'https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500',
    'logoAlt' => 'Your Company',
    'navigation' => [
        ['text' => 'Product', 'url' => '#'],
        ['text' => 'Features', 'url' => '#'],
        ['text' => 'Marketplace', 'url' => '#'],
        ['text' => 'Company', 'url' => '#']
    ],
    'loginUrl' => '#',
    'announcement' => [
        'text' => "We're hiring",
        'link' => '#',
        'linkText' => 'Visit our careers page'
    ],
    'usedBy' => [
        ['name' => 'Tuple', 'logo' => 'https://tailwindui.com/img/logos/tuple-logo-gray-400.svg'],
        ['name' => 'Workcation', 'logo' => 'https://tailwindui.com/img/logos/workcation-logo-gray-400.svg'],
        ['name' => 'StaticKit', 'logo' => 'https://tailwindui.com/img/logos/statickit-logo-gray-400.svg']
    ],
    'socialProviders' => [
        ['name' => 'Facebook', 'url' => '#', 'icon' => 'facebook'],
        ['name' => 'X', 'url' => '#', 'icon' => 'x'],
        ['name' => 'GitHub', 'url' => '#', 'icon' => 'github']
    ],
    'formAction' => '#',
    'formMethod' => 'POST',
    'termsUrl' => '#',
    'dataPolicyUrl' => '#',
    'cookiesPolicyUrl' => '#'
])

<div class="relative overflow-hidden bg-gray-800">
    <div class="hidden sm:absolute sm:inset-0 sm:block" aria-hidden="true">
      <svg class="absolute bottom-0 right-0 mb-48 translate-x-1/2 transform text-gray-700 lg:top-0 lg:mb-0 lg:mt-28 xl:translate-x-0 xl:transform-none" width="364" height="384" viewBox="0 0 364 384" fill="none">
        <defs>
          <pattern id="eab71dd9-9d7a-47bd-8044-256344ee00d0" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
            <rect x="0" y="0" width="4" height="4" fill="currentColor" />
          </pattern>
        </defs>
        <rect width="364" height="384" fill="url(#eab71dd9-9d7a-47bd-8044-256344ee00d0)" />
      </svg>
    </div>
    <div class="relative pb-16 pt-6 sm:pb-24">
      <div>
        <nav class="relative mx-auto flex max-w-7xl items-center justify-between px-6" aria-label="Global">
          <div class="flex flex-1 items-center">
            <div class="flex w-full items-center justify-between md:w-auto">
              @if($logoUrl)
                <a href="#">
                  <span class="sr-only">{{ $logoAlt }}</span>
                  <img class="h-8 w-auto sm:h-10" src="{{ $logoUrl }}" alt="{{ $logoAlt }}">
                </a>
              @endif
              <div class="-mr-2 flex items-center md:hidden">
                <button type="button" class="focus-ring-inset relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-white" aria-expanded="false">
                  <span class="absolute -inset-0.5"></span>
                  <span class="sr-only">Open main menu</span>
                  <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                  </svg>
                </button>
              </div>
            </div>
            <div class="hidden space-x-10 md:ml-10 md:flex">
              @foreach($navigation as $item)
                <a href="{{ $item['url'] }}" class="font-medium text-white hover:text-gray-300">{{ $item['text'] }}</a>
              @endforeach
            </div>
          </div>
          <div class="hidden md:flex">
            <a href="{{ $loginUrl }}" class="inline-flex items-center rounded-md border border-transparent bg-gray-600 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">Log in</a>
          </div>
        </nav>

        <!--
          Mobile menu, show/hide based on menu open state.

          Entering: "duration-150 ease-out"
            From: "opacity-0 scale-95"
            To: "opacity-100 scale-100"
          Leaving: "duration-100 ease-in"
            From: "opacity-100 scale-100"
            To: "opacity-0 scale-95"
        -->
        <div class="absolute inset-x-0 top-0 z-10 origin-top-right transform p-2 transition md:hidden">
          <div class="overflow-hidden rounded-lg bg-white shadow-md ring-1 ring-black ring-opacity-5">
            <div class="flex items-center justify-between px-5 pt-4">
              <div>
                <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="">
              </div>
              <div class="-mr-2">
                <button type="button" class="relative inline-flex items-center justify-center rounded-md bg-white p-2 text-gray-400 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                  <span class="absolute -inset-0.5"></span>
                  <span class="sr-only">Close menu</span>
                  <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
            </div>
            <div class="space-y-1 px-2 pb-3 pt-2">
              <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">Product</a>
              <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">Features</a>
              <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">Marketplace</a>
              <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">Company</a>
            </div>
            <a href="#" class="block w-full bg-gray-50 px-5 py-3 text-center font-medium text-indigo-600 hover:bg-gray-100">Log in</a>
          </div>
        </div>
      </div>

      <main class="mt-16 sm:mt-24">
        <div class="mx-auto max-w-7xl">
          <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            <div class="px-6 sm:text-center md:mx-auto md:max-w-2xl lg:col-span-6 lg:flex lg:items-center lg:text-left">
              <div>
                @if($announcement)
                  <div class="hidden sm:mb-4 sm:flex sm:justify-center lg:justify-start">
                    <a href="{{ $announcement['link'] }}" class="flex items-center rounded-full bg-gray-900 p-1 pr-2 text-white hover:text-gray-200 sm:text-base lg:text-sm xl:text-base">
                      <span class="rounded-full bg-indigo-500 px-3 py-0.5 text-sm font-semibold leading-5 text-white">{{ $announcement['text'] }}</span>
                      <span class="ml-4 text-sm">{{ $announcement['linkText'] }}</span>
                      <svg class="ml-2 h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                      </svg>
                    </a>
                  </div>
                @endif
                <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl md:text-6xl">{{ $title }}</h1>
                <p class="mt-3 text-base text-gray-300 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">{{ $description }}</p>
                @if($usedBy)
                  <p class="mt-8 text-base font-semibold text-white sm:mt-10">Used by</p>
                  <div class="mt-5 w-full sm:mx-auto sm:max-w-lg lg:ml-0">
                    <div class="flex flex-wrap items-start justify-between">
                      @foreach($usedBy as $company)
                        <div class="flex justify-center px-1">
                          <img class="h-9 sm:h-10" src="{{ $company['logo'] }}" alt="{{ $company['name'] }}">
                        </div>
                      @endforeach
                    </div>
                  </div>
                @endif
              </div>
            </div>
            <div class="mt-16 sm:mt-24 lg:col-span-6 lg:mt-0">
              <div class="bg-white sm:mx-auto sm:w-full sm:max-w-md sm:overflow-hidden sm:rounded-lg">
                <div class="px-6 py-8 sm:px-10">
                  <div>
                    <p class="text-sm font-medium text-gray-700">Sign in with</p>

                    <div class="mt-1 grid grid-cols-3 gap-3">
                      @foreach($socialProviders as $provider)
                        <div>
                          <a href="{{ $provider['url'] }}" class="inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 shadow-sm hover:bg-gray-50">
                            <span class="sr-only">Sign in with {{ $provider['name'] }}</span>
                            @if($provider['icon'] === 'facebook')
                              <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M20 10c0-5.523-4.477-10-10-10S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z" clip-rule="evenodd" />
                              </svg>
                            @elseif($provider['icon'] === 'x')
                              <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path d="M11.4678 8.77491L17.2961 2H15.915L10.8543 7.88256L6.81232 2H2.15039L8.26263 10.8955L2.15039 18H3.53159L8.87581 11.7878L13.1444 18H17.8063L11.4675 8.77491H11.4678ZM9.57608 10.9738L8.95678 10.0881L4.02925 3.03974H6.15068L10.1273 8.72795L10.7466 9.61374L15.9156 17.0075H13.7942L9.57608 10.9742V10.9738Z" />
                              </svg>
                            @elseif($provider['icon'] === 'github')
                              <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z" clip-rule="evenodd" />
                              </svg>
                            @endif
                          </a>
                        </div>
                      @endforeach
                    </div>
                  </div>

                  <div class="relative mt-6">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                      <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                      <span class="bg-white px-2 text-gray-500">Or</span>
                    </div>
                  </div>

                  <div class="mt-6">
                    <form action="{{ $formAction }}" method="{{ $formMethod }}" class="space-y-6">
                      <div>
                        <label for="name" class="sr-only">Full name</label>
                        <input type="text" name="name" id="name" autocomplete="name" placeholder="Full name" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                      </div>

                      <div>
                        <label for="mobile-or-email" class="sr-only">Mobile number or email</label>
                        <input type="text" name="mobile-or-email" id="mobile-or-email" autocomplete="email" placeholder="Mobile number or email" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                      </div>

                      <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" placeholder="Password" autocomplete="current-password" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                      </div>

                      <div>
                        <button type="submit" class="flex w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Create your account</button>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="border-t-2 border-gray-200 bg-gray-50 px-6 py-6 sm:px-10">
                  <p class="text-xs leading-5 text-gray-500">By signing up, you agree to our 
                    <a href="{{ $termsUrl }}" class="font-medium text-gray-900 hover:underline">Terms</a>, 
                    <a href="{{ $dataPolicyUrl }}" class="font-medium text-gray-900 hover:underline">Data Policy</a> and 
                    <a href="{{ $cookiesPolicyUrl }}" class="font-medium text-gray-900 hover:underline">Cookies Policy</a>.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
