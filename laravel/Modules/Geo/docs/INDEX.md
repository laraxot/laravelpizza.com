# Geo Module Documentation Index

## Documentation Structure

### 📚 Core Documentation

- [**Architecture Overview**](./architecture.md) - Technical architecture and system design
- [**Component Analysis**](./story-map-component-analysis.md) - Deep dive on map component philosophy and best practices
- [**Project Strategy**](./PRODUCT_STRATEGY.md) - Strategic vision and roadmap
- [**Technical Implementation**](./TECHNICAL.md) - Technical guidelines and patterns

### 🚀 Features & Capabilities

- [**Address Implementation**](./address-implementation.md) - Address handling and validation
- [**Address Autocomplete**](./address-autocomplete.md) - Smart address suggestions
- [**Map Components**](./leaflet_marker_map_input.md) - Interactive map components
- [**Advanced Features**](./ADVANCED_FEATURES.md) - Power user features
- [**Product Roadmap**](./PRODUCT_ROADMAP.md) - Future development plans

### 🔧 Integration & Usage

- [**Coordinate Picker Purpose & Architecture**](./coordinate-picker-purpose.md) - Scopo, utilità e implementazione del componente mappa per wizard ticket
- [**SVG Icon Architecture**](./coordinate-picker-purpose.md#-svg-icon-architecture-no-hardcoded-svg) - Regola DRY: SVG separati in `resources/svg/`, no inline hardcoded
- [**Filament Components**](./filament-forms-components.md) - Filament forms components, web components (Lit.dev), and integration patterns
- [**Filament Integration**](./FILAMENT_EXTENSION_RULES.md) - Filament PHP integration patterns

### 🎨 Assets & Icons

**SVG Icons (resources/svg/)**:
- `magnifying-glass.svg` - Search icon for address input
- `location.svg` - Geolocation button
- `layer.svg` - Layer switcher (street/satellite/topo)
- `crosshair.svg` - Center map crosshair
- `arrows-pointing-out.svg` / `arrows-pointing-in.svg` - Fullscreen toggle
- `map-icon-plus.svg` / `map-icon-minus.svg` - Zoom controls
- [**Web Components & Build Architecture**](./filament-forms-components.md#web-components--litdev) - Lit.dev web component pattern, module vs theme asset separation
- [**MCP Servers**](./MCP_SERVER_RECOMMENDED.md) - Recommended Model Context Protocol servers
- [**App Integration**](./app-integration.md) - Integration with main application
- [**Address Migration**](./address_migration_guide.md) - Migration guides and patterns

### 📊 Analysis & Research

- [**Model Analysis**](./analisi-modelli-doppi.md) - Duplicate models analysis and recommendations
- [**Code Quality Analysis**](./analysis/code-quality-analysis.md) - Code quality metrics and improvements
- [**User Research**](./USER_RESEARCH.md) - User experience research findings
- [**Domain Research**](./_integration/archive/here-com.md) - Geographic domain research

### 🛠️ Development & Tools

- [**Sprint Planning**](./SPRINT_PLANNING.md) - Sprint planning and tracking
- [**Project Management**](./PROJECT.md) - Project management documentation
- [**PHPStan Fixes**](./PHPSTAN_FIXES.md) - Code quality fixes and improvements
- [**Vite Build Configuration**](./vite-build-configuration.md) - Vite 7.x + Tailwind 4.x setup per moduli
- [**Configuration**](./config/config.php) - Module configuration

### 📁 Stories & Tasks

- [**Map Component Enhancement Story**](../../_bmad/bmm/4-implementation/bmad-create-story/story-map-ticket-wizard.md) - Enhanced map component for ticket wizard
- [**Address Input Story**](../../_bmad/bmm/4-implementation/bmad-create-story/discover-inputs.md) - Address input implementation

### 📋 Guidelines & Best Practices

- [**Design Rules**](./FILAMENT_EXTENSION_RULES.md) - Filament component design rules
- [**Consolidation Analysis**](./analisi-moduli-ottimizzazioni.md) - Module consolidation guidelines
- [**Performance Guidelines**](./TECHNICAL.md#performance) - Performance optimization patterns

### 🔗 Related Modules

- **Fixcity Module** - Main application module using Geo components
  - [Ticket Wizard Implementation](../../Fixcity/docs/ticket-wizard-frontoffice.md)
  - [Address Integration](../../Fixcity/docs/address-implementation.md)

## Quick Reference

| Topic | File | Status |
|-------|------|--------|
| **AddressInput Component** | [address-input-component.md](./address-input-component.md) | ✅ Active |
| **Location Spinner UX** | [location-spinner-ux.md](./location-spinner-ux.md) | ✅ Active |
| AddressField Component (legacy) | [address-field-component.md](./address-field-component.md) | ⚠️ Legacy |
| AddressResource | [address-resource.md](./filament/address-resource.md) | ✅ Active |
| Module Boundary Philosophy | [../Fixcity/docs/MODULE-BOUNDARY-PHILOSOPHY.md](../Fixcity/docs/MODULE-BOUNDARY-PHILOSOPHY.md) | ✅ Active |
| README / Overview | [README.md](./README.md) | ✅ Active |

## Filament Components

### Forms
- **AddressInput** — Single address input with geolocation → [address-input-component.md](./address-input-component.md)
- **AddressField** (Forms/Components) — Full address section with cascading selects
- **AddressesField** — Repeater for multiple addresses
- **LeafletMarkerMapInput** — Interactive map with draggable marker → [story-map-component-analysis.md](./story-map-component-analysis.md)

### Resources
- **AddressResource** — CRUD for addresses → `./filament/address-resource.md`
- **LocationResource** — CRUD for locations

### Widgets
- **LocationWidget** — Map display widget
- **LocationMapTableWidget** — Table with map integration

## Architecture

- [README.md](./README.md) — Module overview
- [architectural-philosophy.md](./architectural-philosophy.md) — Architecture patterns
- [00-index.md](./00-index.md) — Legacy index

## Actions (Geocoding)

| Action | File |
|--------|------|
| GetCoordinatesFromAddressAction | `app/Actions/GetCoordinatesByAddressAction.php` |
| GetAddressFromNominatimAction | `app/Actions/Nominatim/GetAddressFromNominatimAction.php` |
| GetAddressFromGoogleMapsAction | `app/Actions/GoogleMaps/GetAddressFromGoogleMapsAction.php` |
| GetAddressFromMapboxAction | `app/Actions/Mapbox/GetAddressFromMapboxAction.php` |
| CalculateDistanceAction | `app/Actions/CalculateDistanceAction.php` |

## Models

- **Address** — `app/Models/Address.php`
- **Location** — `app/Models/Location.php`
- **Locality** — `app/Models/Locality.php`
- **Province** — `app/Models/Province.php`
- **Region** — `app/Models/Region.php`
- **ComuneJson** — `app/Models/ComuneJson.php` (preferred over Comune)
- **Place** — `app/Models/Place.php` (enhanced with geolocation)

## Translations

- Italian: `lang/it/address.php`
- English: `lang/en/address.php`

---

## 📋 DEDUPLICATION NOTICE

This module has many duplicate files in docs/. Key actions taken:

### Consolidated Documents
- ✅ **Model Analysis** - [analisi-modelli-doppi.md](./analisi-modelli-doppi.md) - Single source of truth
- ✅ **Map Component Analysis** - [story-map-component-analysis.md](./story-map-component-analysis.md) - Comprehensive guide
- ✅ **Technical Guidelines** - [TECHNICAL.md](./TECHNICAL.md) - Single reference

### Categories to Clean Up
| Pattern | Count | Action |
|---------|-------|--------|
| `*sumy.md`, `*-summary.md`, `*summary.md` | ~20 | Consolidated into main docs |
| `*backup.md`, `*-backup.md`, `*_BACKUP.md` | ~15 | Delete (git preserves) |
| `*--*.md`, `*.md` (empty name) | ~5 | Delete |
| Multiple address-resource-*.md | ~30 | Consolidated into one |
| Multiple address-implementation*.md | ~15 | Consolidated into one |

### 📖 Quick Start

1. **Architecture**: Start with [architecture overview](./architecture.md)
2. **Components**: Learn about [address components](./address-implementation.md) and [map components](./story-map-component-analysis.md)
3. **Integration**: Follow [Filament integration guide](./FILAMENT_EXTENSION_RULES.md)
4. **Examples**: Check [app integration](./app-integration.md)

### 🤝 Contributing

- Follow the [BMad methodology](../../../_bmad/README.md) for development
- Maintain [design system compliance](../../DesignComuni/README.md)
- Ensure [accessibility standards](./USER_RESEARCH.md#accessibility) are met
- Run quality checks with [PHPStan](./PHPSTAN_FIXES.md)

### 📞 Support

- For technical questions: Check [architecture](./architecture.md) and [technical docs](./TECHNICAL.md)
- For implementation issues: Review [code quality analysis](./analysis/code-quality-analysis.md)
- For integration help: See [app integration](./app-integration.md) and [Filament rules](./FILAMENT_EXTENSION_RULES.md)