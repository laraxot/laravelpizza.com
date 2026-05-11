MapPicker: custom Filament field

Overview

MapPicker is a Filament field that binds two model attributes (latitude and longitude) to an interactive Leaflet map implemented inside a Lit web component. It integrates Livewire (entangle) and Alpine as orchestrator and follows module boundaries inside Modules/Geo.

Usage

In a Filament Resource form:

MapPicker::make('location')
    ->latitude('latitude')
    ->longitude('longitude');

Design notes
- Leaflet must attach via local classes (no global IDs)
- Field extends XotBaseField per project rules
- Web component avoids Shadow DOM to keep Leaflet working
- Component dispatches 'coords-changed' events
- Alpine watches and syncs with Livewire via explicit property names

Testing
- A minimal Pest test is provided to assert the class exists and the view renders.
