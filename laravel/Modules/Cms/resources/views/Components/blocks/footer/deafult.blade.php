<?php

declare(strict_types=1);

?>
<footer class="bg-white rounded-lg shadow m-4 dark:bg-gray-800">
    <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
      <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a href="https://flowbite.com/" class="hover:underline">Flowbite™</a>. {{ __('cms::block_footer.copyright.rights_reserved.message') }}
    </span>
    <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
        <li>
            <a href="#" class="hover:underline me-4 md:me-6">{{ __('cms::block_footer.links.about.label') }}</a>
        </li>
        <li>
            <a href="#" class="hover:underline me-4 md:me-6">{{ __('cms::block_footer.links.privacy.label') }}</a>
        </li>
        <li>
            <a href="#" class="hover:underline me-4 md:me-6">{{ __('cms::block_footer.links.licensing.label') }}</a>
        </li>
        <li>
            <a href="#" class="hover:underline">{{ __('cms::block_footer.links.contact.label') }}</a>
        </li>
    </ul>
    </div>
</footer>
