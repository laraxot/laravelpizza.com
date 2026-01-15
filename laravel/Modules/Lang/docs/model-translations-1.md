# Model Translations in `<nome progetto>`

## Overview
In a healthcare application like `<nome progetto>`, translating model data such as medical content, patient information, or service descriptions is critical for user accessibility across different languages. This document outlines how to implement model translations without packages and explores package-based solutions for more complex needs.
- **Primary Approach**: Start with **Spatie Laravel Translatable** for its simplicity and efficiency with JSON columns. This is ideal for most healthcare content models where quick setup and maintenance are priorities.
- **Fallback**: For complex models requiring detailed translation tracking or separate table structures (e.g., for audit purposes), consider the manual approach or **Astrotomic Laravel Translatable**.

This strategy ensures flexibility to adapt based on model complexity while maintaining ease of use for developers and translators in a healthcare setting.
