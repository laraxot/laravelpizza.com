<?php

declare(strict_types=1);

?>
<x-layouts.app :title="__('gdpr::account.delete.heading.title')">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <div class="bg-white dark:bg-gray-900 shadow-xl rounded-lg p-8">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ __('gdpr::account.delete.heading.title') }}</h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ __('gdpr::account.delete.heading.help') }}</p>
                </div>

                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-md p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.78 1.37-.2 3.04-1.742 3.04H4.42c-1.542 0-2.522-1.67-1.742-3.04l5.58-9.92z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 dark:text-red-200">{{ __('gdpr::account.delete.warning.title') }}</h3>
                            <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                <p>{{ __('gdpr::account.delete.warning.message') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('account.delete') }}" class="space-y-6" x-data="{ confirm: '' }">
                    @csrf

                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('gdpr::account.delete.reason.label') }}</label>
                        <textarea id="reason" name="reason" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old('reason') }}</textarea>
                    </div>

                    <div>
                        <label for="confirm" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('gdpr::account.delete.confirm.label', ['word' => __('gdpr::account.delete.confirm_word.label')]) }}
                        </label>
                        <input id="confirm" name="confirm" type="text" required
                               x-model="confirm"
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                               placeholder="{{ __('gdpr::account.delete.confirm.placeholder') }}" />
                        <x-input-error :messages="$errors->get('confirm')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="{{ url()->previous() }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                            {{ __('gdpr::account.delete.cancel.label') }}
                        </a>
                        <x-primary-button class="bg-red-600 hover:bg-red-700 focus:ring-red-500" x-bind:disabled="confirm !== {{ \Illuminate\Support\Js::from(__('gdpr::account.delete.confirm_word.label')) }}">
                            {{ __('gdpr::account.delete.submit.label') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>