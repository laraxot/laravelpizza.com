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
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Press</h2>
        <div class="mt-3 sm:mt-4 lg:grid lg:grid-cols-2 lg:items-center lg:gap-5">
          <p class="text-xl text-gray-500">Learn how to grow your business with our expert advice.</p>
          <form class="mt-6 flex flex-col sm:flex-row lg:mt-0 lg:justify-end">
            <div>
              <label for="email-address" class="sr-only">Email address</label>
              <input id="email-address" name="email-address" type="email" autocomplete="email" required class="w-full appearance-none rounded-md border border-gray-300 bg-white px-4 py-2 text-base text-gray-900 placeholder-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 lg:max-w-xs" placeholder="Enter your email">
            </div>
            <div class="mt-2 flex w-full flex-shrink-0 rounded-md shadow-sm sm:ml-3 sm:mt-0 sm:inline-flex sm:w-auto">
              <button type="button" class="flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:inline-flex sm:w-auto">Notify me</button>
            </div>
          </form>
        </div>
      </div>
      <div class="mt-6 grid gap-16 pt-10 lg:grid-cols-2 lg:gap-x-5 lg:gap-y-12">
        <div>
          <p class="text-sm text-gray-500">
            <time datetime="2020-03-16">Mar 16, 2020</time>
          </p>
          <a href="#" class="mt-2 block">
            <p class="text-xl font-semibold text-gray-900">Boost your conversion rate</p>
            <p class="mt-3 text-base text-gray-500">Illo sint voluptas. Error voluptates culpa eligendi. Hic vel totam vitae illo. Non aliquid explicabo necessitatibus unde. Sed exercitationem placeat consectetur nulla deserunt vel. Iusto corrupti dicta.</p>
          </a>
          <div class="mt-3">
            <a href="#" class="text-base font-semibold text-indigo-600 hover:text-indigo-500">Read full story</a>
          </div>
        </div>
        <div>
          <p class="text-sm text-gray-500">
            <time datetime="2020-03-10">Mar 10, 2020</time>
          </p>
          <a href="#" class="mt-2 block">
            <p class="text-xl font-semibold text-gray-900">How to use search engine optimization to drive sales</p>
            <p class="mt-3 text-base text-gray-500">Optio cum necessitatibus dolor voluptatum provident commodi et. Qui aperiam fugiat nemo cumque.</p>
          </a>
          <div class="mt-3">
            <a href="#" class="text-base font-semibold text-indigo-600 hover:text-indigo-500">Read full story</a>
          </div>
        </div>
        <div>
          <p class="text-sm text-gray-500">
            <time datetime="2020-02-12">Feb 12, 2020</time>
          </p>
          <a href="#" class="mt-2 block">
            <p class="text-xl font-semibold text-gray-900">Improve your customer experience</p>
            <p class="mt-3 text-base text-gray-500">Cupiditate maiores ullam eveniet adipisci in doloribus nulla minus. Voluptas iusto libero adipisci rem et corporis.</p>
          </a>
          <div class="mt-3">
            <a href="#" class="text-base font-semibold text-indigo-600 hover:text-indigo-500">Read full story</a>
          </div>
        </div>
        <div>
          <p class="text-sm text-gray-500">
            <time datetime="2020-01-29">Jan 29, 2020</time>
          </p>
          <a href="#" class="mt-2 block">
            <p class="text-xl font-semibold text-gray-900">Writing effective landing page copy</p>
            <p class="mt-3 text-base text-gray-500">Ipsum voluptates quia doloremque culpa qui eius. Id qui id officia molestias quaerat deleniti. Qui facere numquam autem libero quae cupiditate asperiores vitae cupiditate. Cumque id deleniti explicabo.</p>
          </a>
          <div class="mt-3">
            <a href="#" class="text-base font-semibold text-indigo-600 hover:text-indigo-500">Read full story</a>
          </div>
        </div>
      </div>
    </div>
  </div>
