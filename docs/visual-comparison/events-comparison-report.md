# Events Page Comparison Report

## Overview
This report documents the visual and functional differences between the local Events page (`http://127.0.0.1:8000/it/events`) and the production site (`https://laravelpizza.com/events`).

## Visual Evidence
- **Production (Target)**:
    - ![Production 1](file:///var/www/_bases/base_laravelpizza/laravel/Themes/Meetup/docs/visual-comparison/screenshot_laravelpizza_com_2026-02-02T17-07-52-435Z_frame1.png)
- **Local (Current)**:
    - ![Local 1](file:///var/www/_bases/base_laravelpizza/laravel/Themes/Meetup/docs/visual-comparison/screenshot_127_0_0_1_2026-02-02T17-07-51-094Z_frame1.png)

## Main Differences Identified

### 1. Typography & Header Scaling
- **Production**: Uses a bolder, tighter typography for the "Upcoming Events" header. The header spacing is more compact.
- **Local**: Currently uses standard Tailwind `text-4xl` or `text-5xl` without specific weight adjustments that match the "premium" look of production.

### 2. Event Cards & Images
- **Production**: Displays 5 events. Images are rich and context-aware.
- **Local**: Uses SVG placeholders for all events. Data in `events.json` includes 6 events (some past).

### 3. Filter Buttons (Alpine.js)
- **Production**: Buttons have a specific hover state and active state (red background).
- **Local**: Implementation is functional but requires color-parity check (specifically the red-shade to match the new 'Symbolic Minimalism' standard).

### 4. Categorization & Metadata
- **Production**: Includes "Attendees" (e.g. "5 / 30 attendees") with a specific people icon.
- **Local**: Metadata is present but formatting/spacing needs to be tightened.

## Alignment Plan
1. **Sync `events.json`**: Reduce events to the 5 production samples for exact parity. Translate all sample data for multi-language support.
2. **Style Component**: Update `list.blade.php` to match the exact spacing and typography of production.
3. **Icons**: Use `x-filament::icon` for calendar, clock, pin, and users icons to adhere to the icon management standard.
4. **Docs Update**: Update module and theme documentation to reflect these changes.

## Verification
- Once implemented, new screenshots will be captured (after browser service restoration) to confirm 1:1 parity ("Pixel Parity").
