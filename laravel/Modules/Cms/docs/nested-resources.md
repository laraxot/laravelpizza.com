# Cms Module - Nested Resource Implementation Guide

## Overview

The Cms module provides content management capabilities including pages, blocks, menus, and media management. Nested resources in this module focus on organizing content hierarchically to reflect the natural relationships between pages, content blocks, and navigation structures.

## Current Relationship Structure

### Page Model Relationships
- `Page` hasMany `Block` (content blocks)
- `Page` belongsTo `Page` (parent page for hierarchical pages)
- `Page` hasMany `Page` (child pages)
- `Page` belongsTo `User` (author)

### Block Model Relationships
- `Block` belongsTo `Page`
- `Block` belongsTo `User` (author)
- `Block` morphTo `Blockable` (can belong to different entities)

### MenuItem Model Relationships
- `MenuItem` belongsTo `MenuItem` (parent menu item)
- `MenuItem` hasMany `MenuItem` (child menu items)
- `MenuItem` morphTo `Linkable` (can link to different entities like pages)

### Menu Model Relationships
- `Menu` hasMany `MenuItem`

## Potential Nested Resource Applications

### 1. Page Hierarchy Management
**Parent Resource:** PageResource
**Child Resource:** PageResource (for child pages)
**Relationship:** Page hasMany Child Pages
**Justification:** Organize pages in a hierarchical structure for better content organization and navigation.

### 2. Page-Block Content Management
**Parent Resource:** PageResource
**Child Resource:** BlockResource
**Relationship:** Page hasMany Blocks
**Justification:** Organize content blocks within their respective pages for better content management.

### 3. Menu-MenuItem Structure
**Parent Resource:** MenuResource
**Child Resource:** MenuItemResource
**Relationship:** Menu hasMany MenuItems
**Justification:** Organize menu items within their respective menus for better navigation management.

### 4. Menu Item Hierarchy
**Parent Resource:** MenuItemResource
**Child Resource:** MenuItemResource (for child menu items)
**Relationship:** MenuItem hasMany Child MenuItems
**Justification:** Create hierarchical menu structures for complex navigation systems.

### 5. Page Media Management
**Parent Resource:** PageResource
**Child Resource:** MediaResource (from Media module)
**Relationship:** Page hasMany Media (via morphTo relationship)
**Justification:** Manage media assets associated with specific pages for better content organization.

### 6. Block Media Assets
**Parent Resource:** BlockResource
**Child Resource:** MediaResource (from Media module)
**Relationship:** Block hasMany Media (via morphTo relationship)
**Justification:** Organize media assets within content blocks for better content management.

### 7. Page Revision History
**Parent Resource:** PageResource
**Child Resource:** PageRevisionResource (if implemented)
**Relationship:** Page hasMany PageRevisions
**Justification:** Track and manage page revision history within the page context.

### 8. Page Comments/Feedback
**Parent Resource:** PageResource
**Child Resource:** CommentResource (if implemented)
**Relationship:** Page hasMany Comments
**Justification:** Manage user feedback and comments for specific pages.

### 9. Page SEO Settings
**Parent Resource:** PageResource
**Child Resource:** SeoSettingResource (if implemented)
**Relationship:** Page hasOne/hasMany SeoSettings
**Justification:** Manage SEO-specific settings within the page context.

### 10. Menu Localization
**Parent Resource:** MenuResource
**Child Resource:** MenuTranslationResource (if implemented)
**Relationship:** Menu hasMany MenuTranslations
**Justification:** Organize menu translations within the menu context for multi-language support.

## Implementation Approach

### Using Filament Nested Resources Package
Following the documented approach in `Modules/UI/docs/filament/nested-resource.md`:

1. **Child Resource Implementation:**
   ```php
   use SevendaysDigital\FilamentNestedResources\NestedResource;
   use SevendaysDigital\FilamentNestedResources\ResourcePages\NestedPage;

   class BlockResource extends NestedResource
   {
       public static function getParent(): string
       {
           return PageResource::class;
       }
   }
   ```

2. **Parent Resource Enhancement:**
   ```php
   use SevendaysDigital\FilamentNestedResources\Columns\ChildResourceLink;
   
   public static function table(Table $table): Table
   {
       return $table->columns([
           TextColumn::make('title'),
           ChildResourceLink::make(BlockResource::class),
       ]);
   }
   ```

3. **Page Configuration:**
   Apply the `NestedPage` trait to all nested resource pages (List, Edit, Create).

4. **For self-referencing relationships (Page-Page, MenuItem-MenuItem):**
   ```php
   // In the child model, add scope for parent filtering
   public function scopeOfParent($query, $parentId)
   {
       return $query->where('parent_id', $parentId);
   }
   ```

## Benefits of Nested Resource Implementation

### 1. Improved Content Organization
- Hierarchical representation of content relationships
- Context-aware content management
- Better organization of complex page structures

### 2. Enhanced Navigation Management
- Intuitive menu structure organization
- Hierarchical menu item management
- Better navigation architecture

### 3. Better User Experience
- Intuitive content hierarchy navigation
- Context-aware content operations
- Natural representation of content relationships

### 4. Scalability
- Modular approach to content management
- Easy to extend with additional nested resources
- Consistent user experience across content operations

## Considerations

### 1. Performance
- Hierarchical structures can become complex
- Ensure efficient queries for nested content
- Optimize for common content access patterns

### 2. Self-referencing Relationships
- Handle Page-Page and MenuItem-MenuItem relationships carefully
- Ensure proper depth limits for hierarchical structures
- Consider performance implications for deep hierarchies

### 3. Cross-module Integration
- Coordinate with Media module for asset management
- Handle relationships with other content modules
- Consider integration with SEO modules

### 4. User Experience
- Deep hierarchies should be intuitive to navigate
- Provide efficient search and filtering for content
- Consider breadcrumbs for nested contexts

## Implementation Roadmap

### Phase 1: Foundation Setup
- Install and configure filament-nested-resources package
- Create base nested resource classes extending XotBaseResource
- Implement basic Page-Block relationship

### Phase 2: Core Functionality
- Implement Menu-MenuItem relationships
- Add hierarchical page management
- Create content media organization

### Phase 3: Advanced Features
- Implement content revision history
- Add SEO settings within content contexts
- Create advanced content analytics

## Future Enhancements

### 1. Advanced Content Features
- Content workflow management
- Advanced content personalization
- Content A/B testing capabilities

### 2. Multi-channel Content
- Cross-platform content management
- Content syndication capabilities
- Multi-language content organization

### 3. Performance Optimization
- Content caching strategies
- Optimized queries for hierarchical content
- Efficient handling of large content datasets