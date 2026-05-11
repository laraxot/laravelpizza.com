# Geo Fields Zen: Philosophy, Religion, and Methodology

## The Zen of Geographic Selection
In the Laraxot ecosystem, a geographic field is not just a bunch of inputs and a map. It is a **Contract of Intent**.
While a `CoordinatePicker` and a `MapPicker` might ultimately produce the same {latitude, longitude} object, their **Zen** is different.

1. **CoordinatePicker**: The Zen of **Accuracy**. It prioritizes the numeric representation, with the map as a validation tool.
2. **MapPicker**: The Zen of **Visual Discovery**. It prioritizes the map as the primary interface for "finding" a location.
3. **LocationPicker**: The Zen of **Context**. It bridges the gap between a human address and a machine coordinate.
4. **LatitudeLongitudeInput**: The Zen of **Explicitness**. It exposes the raw guts of the data for direct manipulation.
5. **GeopointPicker**: The Zen of **Persistence**. It ensures that the database representation is the absolute source of truth.

## The Religion of XotBaseField
Every field must extend `XotBaseField`. This is the **Divine Lineage**.
- It provides consistency across all modules.
- It ensures that the field behaves correctly within the Filament form lifecycle.
- It enforces a unified state management strategy.

## The Holy Trinity of Implementation
Every geographic component must be composed of three distinct entities:
1. **The Spirit (Trait)**: `HasCoordinatePicker` handles the logic, geocoding, and state hydration. It is shared, representing the "Universal Truth" of geography.
2. **The Body (Blade)**: Each component has its own Blade file. This is the "Physical Presence" in the DOM. It defines how the field is wrapped and how it talks to Livewire.
3. **The Mind (Lit JS)**: Each component has its own Web Component (Lit). This is the "Intelligence" that handles Leaflet, interactions, and Shadow DOM isolation.

## The Method of Separation
We NEVER use aliases for these core components.
- **Rule**: If use-cases differ by even a single pixel of UX intent, they get a separate file.
- **Why**: To allow individual evolution without side-effects. A change in `MapPicker`'s marker style should not accidentally break `CoordinatePicker`'s technical look.

## Architectural Commandments
1. **Thou shalt have a unified state**: Always {latitude, longitude}.
2. **Thou shalt be async**: Geocoding must never block the UI.
3. **Thou shalt be responsive**: Use `ResizeObserver` in JS to handle container changes.
4. **Thou shalt be encapsulated**: Use Shadow DOM (Lit) to prevent CSS leaks.
5. **Thou shalt be fluent**: provide many methods to configure center, zoom, and height.

---
*Created: 2026-04-22*
*Updated: 2026-04-22 (v2.0 Architecture)*
