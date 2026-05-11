@php
    $statePath = $getStatePath();
    $latPath = $statePath.'.latitude';
    $lngPath = $statePath.'.longitude';
    $lw = $field->getLivewire();
    /** @var array<string, mixed>|null $root */
    $root = $lw->data ?? null;
    $scopeKey = Str::after($statePath, 'data.');
    $initialLat = $root !== null ? data_get($root, $scopeKey.'.latitude') : null;
    $initialLng = $root !== null ? data_get($root, $scopeKey.'.longitude') : null;
    $mapId = 'latitude-longitude-map-lit-'.$getId();
    $fieldId = 'latitude-longitude-lit-field-'.$getId();
    $defaultLat = $field->getDefaultLatitude();
    $defaultLng = $field->getDefaultLongitude();
    $defaultZoom = $field->getDefaultZoom();
    $height = $field->getMapHeight();
    $mapLat = is_numeric($initialLat) ? (float) $initialLat : $defaultLat;
    $mapLng = is_numeric($initialLng) ? (float) $initialLng : $defaultLng;
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        class="space-y-3 geo-latlng-field geo-latlng-field--lit"
        data-latlng-lit-field
        id="{{ $fieldId }}"
        data-map-id="{{ $mapId }}"
    >
        <div wire:ignore class="w-full">
            <geo-latlng-input
                lat="{{ $mapLat }}"
                lng="{{ $mapLng }}"
                zoom="{{ $defaultZoom }}"
                height="{{ $height }}"
                state-path="{{ $statePath }}"
            ></geo-latlng-input>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label for="{{ $statePath }}_latitude" class="sr-only">
                    {{ __('geo::coordinates.fields.latitude.label') }}
                </label>
                <input
                    type="number"
                    step="0.000001"
                    min="-90"
                    max="90"
                    wire:model.change="{{ $statePath }}.latitude"
                    id="{{ $statePath }}_latitude"
                    data-lat-input
                    class="block w-full rounded border border-gray-300 px-2 py-1.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    placeholder="{{ __('geo::coordinates.fields.latitude.placeholder') }}"
                    value="{{ $mapLat }}"
                    required
                >
            </div>
            <div>
                <label for="{{ $statePath }}_longitude" class="sr-only">
                    {{ __('geo::coordinates.fields.longitude.label') }}
                </label>
                <input
                    type="number"
                    step="0.000001"
                    min="-180"
                    max="180"
                    wire:model.change="{{ $statePath }}.longitude"
                    id="{{ $statePath }}_longitude"
                    data-lng-input
                    class="block w-full rounded border border-gray-300 px-2 py-1.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    placeholder="{{ __('geo::coordinates.fields.longitude.placeholder') }}"
                    value="{{ $mapLng }}"
                    required
                >
            </div>
        </div>
    </div>
</x-dynamic-component>

@once
    <script>
        (() => {
            if (window.initLatitudeLongitudeLitField) {
                return;
            }

            window.initLatitudeLongitudeLitField = (root) => {
                if (!(root instanceof HTMLElement) || root.dataset.litBound === 'true') {
                    return;
                }

                const geoInput = root.querySelector('geo-latlng-input');
                const latInput = root.querySelector('[data-lat-input]');
                const lngInput = root.querySelector('[data-lng-input]');

                if (!(latInput instanceof HTMLInputElement) || !(lngInput instanceof HTMLInputElement)) {
                    return;
                }

                let isProgrammaticUpdate = false;

                // Listen to geo-latlng-change events from the Web Component
                if (geoInput instanceof HTMLElement) {
                    geoInput.addEventListener('geo-latlng-change', (event) => {
                        const detail = event.detail ?? {};

                        if (typeof detail.lat !== 'number' || typeof detail.lng !== 'number') {
                            return;
                        }

                        isProgrammaticUpdate = true;
                        latInput.value = detail.lat.toFixed(6);
                        lngInput.value = detail.lng.toFixed(6);
                        latInput.dispatchEvent(new Event('change', { bubbles: true }));
                        lngInput.dispatchEvent(new Event('change', { bubbles: true }));
                        isProgrammaticUpdate = false;
                    });
                }

                const handleInputChange = () => {
                    if (isProgrammaticUpdate || !geoInput) {
                        return;
                    }

                    const latitude = Number.parseFloat(latInput.value);
                    const longitude = Number.parseFloat(lngInput.value);

                    if (Number.isNaN(latitude) || Number.isNaN(longitude)) {
                        return;
                    }

                    geoInput.setAttribute('lat', String(latitude));
                    geoInput.setAttribute('lng', String(longitude));
                };

                latInput.addEventListener('change', handleInputChange);
                lngInput.addEventListener('change', handleInputChange);
                latInput.addEventListener('input', handleInputChange);
                lngInput.addEventListener('input', handleInputChange);

                root.dataset.litBound = 'true';
            };

            const bootAllLatitudeLongitudeLitFields = () => {
                document.querySelectorAll('[data-latlng-lit-field]').forEach((root) => {
                    window.initLatitudeLongitudeLitField(root);
                });
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', bootAllLatitudeLongitudeLitFields, { once: true });
            } else {
                bootAllLatitudeLongitudeLitFields();
            }

            document.addEventListener('livewire:navigated', bootAllLatitudeLongitudeLitFields);
        })();
    </script>
@endonce
