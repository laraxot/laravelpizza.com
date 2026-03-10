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
<div class="bg-white">
    <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8 lg:py-16">
      <div class="rounded-lg bg-indigo-700 px-6 py-6 md:px-12 md:py-12 lg:px-16 lg:py-16 xl:flex xl:items-center">
        <div class="xl:w-0 xl:flex-1">
          <h2 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">Want product news and updates?</h2>
          <p class="mt-3 max-w-3xl text-lg leading-6 text-indigo-200">Sign up for our newsletter to stay up to date.</p>
        </div>
        <div class="mt-8 sm:w-full sm:max-w-md xl:ml-8 xl:mt-0">
          <form class="sm:flex">
            <label for="email-address" class="sr-only">Email address</label>
            <input id="email-address" name="email-address" type="email" autocomplete="email" required class="w-full rounded-md border-white px-5 py-3 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-700" placeholder="Enter your email">
            <button type="submit" class="mt-3 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-500 px-5 py-3 text-base font-medium text-white shadow hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-700 sm:ml-3 sm:mt-0 sm:w-auto sm:flex-shrink-0">Notify me</button>
          </form>
          <p class="mt-3 text-sm text-indigo-200">
            We care about the protection of your data. Read our
            <a href="#" class="font-medium text-white underline">Privacy Policy.</a>
          </p>
        </div>
      </div>
    </div>
  </div>
