# Block Components

This document provides guidelines and documentation for theme block components used in the frontend architecture.

## Overview

Block components are modular UI elements used to build sections in the frontend. They're typically rendered through JSON configuration data and integrated into the theme's template system.

## Key Concepts

1. **Data Passing**: Block data is passed from JSON configurations to blade templates
2. **Props Definition**: Components must define all expected props using `@props` directive
3. **Modularity**: Each block handles a specific UI concern
4. **Reusability**: Blocks are designed to be reused across different sections

## Common Block Types

| Block Type | Description | Documentation |
|------------|-------------|---------------|
| Logo | Site logo with optional text | [Logo Component](./logo.md) |
| Navigation | Site navigation menu | [Navigation Component](./navigation.md) |
| User Dropdown | User authentication UI | [User Dropdown Component](./user-dropdown.md) |

## Related Documentation

- [Section Architecture](../sections/README.md)
- [Theme Components](../components/README.md)
- [Data Handling in Blade](../blade-data-handling.md)
