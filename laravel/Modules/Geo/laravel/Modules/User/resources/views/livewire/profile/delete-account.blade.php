<?php

declare(strict_types=1);

?>
<div>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('user::profile.delete_account.title') }}
        </x-slot>

        <x-slot name="description">
            {{ __('user::profile.delete_account.description') }}
        </x-slot>

        <form wire:submit="destroy" class="space-y-6">
            <div>
                <x-filament::input.wrapper>
                    <x-filament::input
                        type="password"
                        wire:model="delete_confirm_password"
                        :label="__('user::profile.delete_account.password_confirmation')"
                        required
                    />
                </x-filament::input.wrapper>
            </div>

            <div class="flex justify-start">
                <x-filament::button
                    type="submit"
                    color="danger"
                    :label="__('user::profile.delete_account.button')"
                />
            </div>
        </form>
    </x-filament::section>
</div>
