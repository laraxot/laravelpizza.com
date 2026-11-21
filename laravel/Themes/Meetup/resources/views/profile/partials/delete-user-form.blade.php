<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('pub_theme::account.delete.title.title') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('pub_theme::account.delete.description.message') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('pub_theme::account.delete.submit.label') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('pub_theme::account.delete.confirm_title.title') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('pub_theme::account.delete.confirm_message.message') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('pub_theme::common.fields.password.label') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('pub_theme::common.fields.password.label') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('pub_theme::common.actions.cancel.label') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('pub_theme::account.delete.submit.label') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
