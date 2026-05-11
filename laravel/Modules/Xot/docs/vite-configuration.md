# Vite Configuration For Theme Builds

## Purpose
This document explains the canonical Vite output rule for Laraxot public themes.

Related documents:
- [Theme Assets Workflow](./theme-assets-workflow.md)
- [Xot Documentation Index](./index.md)
- [Sixteen Theme Layout Hierarchy](../../../Themes/Sixteen/docs/layout-hierarchy.md)

## Rule
For theme-local builds, `vite.config.js` must emit compiled assets to the theme-local public directory:

```js
build: {
    outDir: './public',
}
```

## Why
- `@vite([...])` without a second parameter uses Laravel's default build location and therefore looks for `public/build/manifest.json`
- theme layouts must call `@vite([...], 'themes/<Theme>')` so Laravel resolves the theme manifest instead of the root application manifest
- the theme owns its compiled frontend artifacts locally before publication
- `npm run copy` expects build outputs inside the theme-local `public/` directory
- `manifest.json` must be generated in `Themes/<Theme>/public/manifest.json` before it is copied to `public_html/themes/<Theme>/manifest.json`
- writing elsewhere breaks the theme pipeline and causes runtime errors such as `Vite manifest not found`
- this keeps source, build output, and publish step clearly separated

## Operational flow
1. edit theme sources in `Themes/<Theme>/resources/`
2. build with `npm run build`
3. verify `Themes/<Theme>/public/manifest.json`
4. publish with `npm run copy`
5. verify `public_html/themes/<Theme>/manifest.json`

## Notes
- `outDir: './public'` is a build concern, not a Laravel root-public concern
- the second parameter of `@vite()` is a manifest lookup selector, not a cosmetic theme label
- the public web path is reached through the explicit copy step, not by building directly into `public_html`

## Backlinks
- [Theme Assets Workflow](./theme-assets-workflow.md)
- [Xot Documentation Index](./index.md)
