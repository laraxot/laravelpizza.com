---
title: "CHANGELOG"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "CHANGELOG"
issues: []
discussions: []
---

## [1.0.0-dev.3](https://github.com/laraxot/module_ai_fila5/compare/v1.0.0-dev.2...v1.0.0-dev.3) (2026-08-25)
---
title: "CHANGELOG"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "CHANGELOG"
issues: []
discussions: []
## [1.0.0-dev.8](https://github.com/laraxot/module_ai_fila5/compare/v1.0.0-dev.7...v1.0.0-dev.8) (2026-09-25)

### Features

* **tables:** aggiunge $model esplicito a XotBaseResourceTable subclasses (fase 1 audit) ([903af7b](https://github.com/laraxot/module_ai_fila5/commit/903af7b70d53072c21ad21eaf78dac2bc96b14dd))

### Bug Fixes

* AI BaseModel missing $connection, matches sibling modules ([509a595](https://github.com/laraxot/module_ai_fila5/commit/509a5955e838de1b20a576101e8f8222b48ca36f))
* AI BaseModel/BasePivot loop correction, bmad story, docs/stories, second brain ([b6b017f](https://github.com/laraxot/module_ai_fila5/commit/b6b017f4a6f5913819a9e60b6900bfc65cd3983a))
* **AI:** add proper return type to getFormSchema() ([9bd1650](https://github.com/laraxot/module_ai_fila5/commit/9bd1650a1d2cd4b9fce0ab863690663cb13b5d95))
* **ai:** extend module BaseModel instead of XotBaseModel directly ([8d7d06c](https://github.com/laraxot/module_ai_fila5/commit/8d7d06ce688d786187018cdc85416df451a45114))
* **AI:** PHPStan Modules a 0 errori dopo il sync delle 16:10 (regressioni ripristinate) ([dd61045](https://github.com/laraxot/module_ai_fila5/commit/dd61045ffc4268266dbe54dd9b77e2e79ee87f77))
* **AI:** PHPStan Modules a 0 errori, consolidati i fix dopo il sync ([662f6d8](https://github.com/laraxot/module_ai_fila5/commit/662f6d856194382434168592faef9cff46addab9))
* **AI:** risolti i marker di conflitto reimmessi dal sync con laraxot/dev ([f94d141](https://github.com/laraxot/module_ai_fila5/commit/f94d14119453776b5d0638e9f2b3eaadd0808e5c))
* **AI:** risolti marker di conflitto in fine_tuning.py ([6d04de3](https://github.com/laraxot/module_ai_fila5/commit/6d04de302bbf5ab265ba523a58dde70e61d807df))
* PHPStan AI missing BaseModel/BasePivot, bmad story, docs/stories, second brain ([4a79df3](https://github.com/laraxot/module_ai_fila5/commit/4a79df31498b24ba1c79cd01b11e7ca1747dab22))
* PHPStan AI module, docs updated, second brain updated ([5434791](https://github.com/laraxot/module_ai_fila5/commit/54347911d0b169276ec84b7ac100b5503e5b50b2))
* PHPStan AI sync final, bmad story, docs/stories, second brain ([3d48b44](https://github.com/laraxot/module_ai_fila5/commit/3d48b4410475a0001dbee3828e05710ca60ae5be))
* PHPStan AI, bmad story, docs ([9f0687e](https://github.com/laraxot/module_ai_fila5/commit/9f0687e8703440706b51bb5b9e5e6af0d27b11f9))
* PHPStan AI, bmad story, docs/stories, second brain ([cca7272](https://github.com/laraxot/module_ai_fila5/commit/cca727270cfe946e946f28c97d4bd4152d059b5b))
* PHPStan AI, bmad story, docs/stories, second brain ([209aac9](https://github.com/laraxot/module_ai_fila5/commit/209aac918b1f669c1924a8f7249dbf49100d62f2))
* PHPStan AI, bmad story, docs/stories, second brain ([cac5274](https://github.com/laraxot/module_ai_fila5/commit/cac52748f67f9907616a8777d159763cc5d71204))

# Changelog

### Bug Fixes

* **phpstan:** analyse Modules a zero errori ([3136941](https://github.com/laraxot/module_ai_fila5/commit/313694102f2672bf0da710591736bf8e6c1193c6))

## [1.0.0-dev.2](https://github.com/laraxot/module_ai_fila5/compare/v1.0.0-dev.1...v1.0.0-dev.2) (2026-08-24)

### Features

* add ContextCompressorAction (moved from Xot) ([0ce6909](https://github.com/laraxot/module_ai_fila5/commit/0ce6909eb61d8e2756eb7ce6f23672d26190dc91))
* **AI:** add Ollama actions moved from Modules/Xot ([50b6350](https://github.com/laraxot/module_ai_fila5/commit/50b6350c8d4b864ce8c3879509917376758793a0))

### Bug Fixes

* **Ollama:** restore array-shape PHPDoc lost when Action moved from Xot ([f32b9e9](https://github.com/laraxot/module_ai_fila5/commit/f32b9e9400c2ff79093ff65fdc23d2340b7f6a0f))
