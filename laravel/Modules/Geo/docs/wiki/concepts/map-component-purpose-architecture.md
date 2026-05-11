# Map Component Purpose — Architecture & Business Outcome

## Business Purpose and Outcome

The map component in the ticket creation wizard (`http://127.0.0.1:8000/fixcity/admin/tickets/create`) serves as a critical visualization and data entry tool that enables users to:

- Visually locate ticket origins or destinations on a map
- Select precise geographic coordinates through an intuitive interface
- Reduce ambiguity in location data entry for administrative tickets
- Improve data quality by avoiding manual coordinate entry errors
- Provide visual context that helps users understand spatial relationships

This component directly supports the core business process of ticket management by ensuring accurate location data is captured at the point of creation, which is essential for:
- Geographic reporting and analytics
- Route optimization for field staff
- Location-based filtering and search functionality
- Spatial analysis for operational planning

## Technical Implementation Overview

The map functionality is implemented through a layered architecture that respects module boundaries:

### Module Ownership
- **Business Logic**: Fixcity module (`laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`)
- **Map Runtime**: Geo module (`laravel/Modules/Geo/resources/js/components/coordinate-picker-lit.js`, `map-picker-lit.js`)
- **UI Styling**: Sixteen theme (`laravel/Themes/Sixteen/resources/css/app.css`)

### Component Integration Flow
1. **Widget Level**: `CreateTicketWizardWidget` incorporates `CoordinatePicker::make('location')` in its form schema
2. **Livewire Bridge**: `coordinate-picker-field.js` connects the Lit component to Livewire
3. **Map Initialization**: `map-picker-lit.js` initializes Leaflet with proper resize handling
4. **Data Flow**: Selected coordinates flow through `PrepareTicketData` action to the database

### Key Technical Details
- **Leaflet Management**: Proper `invalidateSize()` calls on step visibility changes
- **Resize Handling**: MutationObserver with 12-depth targeting for Filament wizard steps
- **SVG Assets**: Custom marker icons stored in `laravel/Modules/Geo/resources/svg/`
- **Coordinate Fallback**: Defaults to (41.9028, 12.4964) when geolocation unavailable

## Quality Verification Protocol

Per the project's architectural discipline, any modification to this component must undergo strict verification:

### Static Analysis
- `phpstan analyse Modules/Geo --level=max`
- `phpmd Modules/Geo/text unusedcode,design,codesize`
- `php artisan insights Modules\\Geo --fix`

### Visual Parity Checks
- Manual browser verification at `http://127.0.0.1:8000/it/tests/segnalazione-crea?step=form.data%3A%3Adata%3A%3Awizard-step`
- Screenshot comparison against reference design (`graduatoria-area-personale.html`)
- Playwright MCP snapshot validation

### Visual Design Requirements
- Guest view: Single "Accedi all'area personale" button
- Authenticated view: Avatar + name dropdown with proper z-index and pointer-events
- Mobile-first responsive behavior with uniform spacing
- Icon consistency using `icon-white` for dark backgrounds

## Story Reference
- BMAD Story: `_bmad-output/implementation-artifacts/9-01-map-component-purpose.md`
- Related stories: 8-63 (admin ticket map purpose), 8-40 (segnalazione-dati-map-header-parity)
