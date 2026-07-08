<div>
    <form wire:submit="save">
        {{ $this->form }}

        <div class="flex items-center justify-between mt-4">
            <div class="text-sm">
                <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-500">
                    {{ __('user::auth.register.login.text') }}
                </a>
            </div>

            <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('user::auth.register.submit.text') }}
            </button>
        </div>
    </form>
</div>