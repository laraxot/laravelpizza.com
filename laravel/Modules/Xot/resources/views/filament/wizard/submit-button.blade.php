@if (\Illuminate\Support\Facades\View::exists('pub_theme::filament.wizard.submit-button'))
    @include('pub_theme::filament.wizard.submit-button')
@else
    <button
        type="submit"
        class="fi-btn fi-btn-color-primary fi-color-primary fi-btn-size-md rounded-lg px-3 py-2 text-sm font-semibold shadow-sm"
    >
        {{ __('xot::xot_base_resource_form.actions.submit.label') }}
    </button>
@endif
