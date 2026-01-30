# Media Module - Nested Resource Implementation Guide

## Overview

The Media module provides comprehensive media file management with support for various file types, transformations, and relationships with other models. Nested resources in this module focus on organizing media assets in a hierarchical structure that reflects relationships between media collections, folders, and related content.

## Current Relationship Structure

### Media Model Relationships
- `Media` belongsTo `User` (author/owner)
- `Media` morphTo `Model` (can belong to any model that implements HasMedia trait)
- `Media` belongsTo `MediaFolder` (for organizational structure)
- `Media` hasMany `MediaConversion` (for file transformations)

### MediaFolder Model Relationships
- `MediaFolder` hasMany `Media` (files in folder)
- `MediaFolder` hasMany `MediaFolder` (subfolders)
- `MediaFolder` belongsTo `MediaFolder` (parent folder)
- `MediaFolder` belongsTo `User` (owner)

### MediaConversion Model Relationships
- `MediaConversion` belongsTo `Media`
- `MediaConversion` belongsTo `User` (creator)

## Potential Nested Resource Applications

### 1. Folder-File Organization
**Parent Resource:** MediaFolderResource
**Child Resource:** MediaResource
**Relationship:** MediaFolder hasMany Media
**Justification:** Organize media files within folders for better file management and organization.

### 2. Folder Hierarchy Management
**Parent Resource:** MediaFolderResource
**Child Resource:** MediaFolderResource (for subfolders)
**Relationship:** MediaFolder hasMany Child Folders
**Justification:** Create hierarchical folder structure for complex media organization.

### 3. Media-Conversion Management
**Parent Resource:** MediaResource
**Child Resource:** MediaConversionResource
**Relationship:** Media hasMany MediaConversions
**Justification:** Organize file conversions within their source media context for better asset management.

### 4. User Media Organization
**Parent Resource:** UserResource (from User module)
**Child Resource:** MediaResource
**Relationship:** User hasMany Media (as owner/author)
**Justification:** Organize media assets by user for better ownership management.

### 5. Model-Specific Media
**Parent Resource:** Any model resource (e.g., PageResource, SurveyPdfResource)
**Child Resource:** MediaResource
**Relationship:** Model hasMany Media (via morphTo relationship)
**Justification:** Organize media assets by their associated model for contextual management.

### 6. User Media Folders
**Parent Resource:** UserResource (from User module)
**Child Resource:** MediaFolderResource
**Relationship:** User hasMany MediaFolders (as owner)
**Justification:** Organize media folders by user for better ownership and access control.

### 7. Media-Tag Organization
**Parent Resource:** MediaTagResource (if implemented)
**Child Resource:** MediaResource
**Relationship:** MediaTag hasMany Media
**Justification:** Group media by tags for better categorization and search.

### 8. Conversion Template Management
**Parent Resource:** MediaConversionResource
**Child Resource:** ConversionSettingResource (if implemented)
**Relationship:** MediaConversion hasMany ConversionSettings
**Justification:** Organize conversion settings within the conversion context.

## Implementation Approach

### Using Filament Nested Resources Package
Following the documented approach in `Modules/UI/docs/filament/nested-resource.md`:

1. **Child Resource Implementation:**
   ```php
   use SevendaysDigital\FilamentNestedResources\NestedResource;
   use SevendaysDigital\FilamentNestedResources\ResourcePages\NestedPage;

   class MediaResource extends NestedResource
   {
       public static function getParent(): string
       {
           return MediaFolderResource::class;
       }
   }
   ```

2. **Parent Resource Enhancement:**
   ```php
   use SevendaysDigital\FilamentNestedResources\Columns\ChildResourceLink;
   
   public static function table(Table $table): Table
   {
       return $table->columns([
           TextColumn::make('name'),
           ChildResourceLink::make(MediaResource::class),
       ]);
   }
   ```

3. **Page Configuration:**
   Apply the `NestedPage` trait to all nested resource pages (List, Edit, Create).

4. **For morphTo relationships:**
   ```php
   // In the media model, add scope for parent filtering
   public function scopeOfModel($query, $modelId, $modelType)
   {
       return $query->where('model_id', $modelId)
                   ->where('model_type', $modelType);
   }
   
   // For self-referencing folder relationships
   public function scopeOfParentFolder($query, $folderId)
   {
       return $query->where('folder_id', $folderId);
   }
   ```

## Benefits of Nested Resource Implementation

### 1. Improved Media Organization
- Hierarchical representation of media relationships
- Context-aware media management
- Better organization of complex media structures

### 2. Enhanced File Management
- Intuitive folder structure navigation
- Organized file conversion management
- Better asset ownership tracking

### 3. Better User Experience
- Intuitive media hierarchy navigation
- Context-aware media operations
- Natural representation of media relationships

### 4. Scalability
- Modular approach to media management
- Easy to extend with additional nested resources
- Consistent user experience across media operations

## Considerations

### 1. Performance
- Media files can be large and numerous
- Ensure efficient queries for media operations
- Optimize for common media access patterns

### 2. Storage Management
- Handle different storage disks appropriately
- Consider file size limits and optimization
- Implement proper file validation

### 3. Self-referencing Relationships
- Handle Folder-Folder relationships carefully
- Ensure proper depth limits for folder hierarchies
- Consider performance implications for deep hierarchies

### 4. MorphTo Relationships
- Handle polymorphic relationships with different models
- Ensure proper authorization across different model types
- Consider performance implications for morphTo queries

## Implementation Roadmap

### Phase 1: Foundation Setup
- Install and configure filament-nested-resources package
- Create base nested resource classes extending XotBaseResource
- Implement basic Folder-Media relationship

### Phase 2: Core Functionality
- Implement Folder hierarchy management
- Add User-Media organization
- Create model-specific media management

### Phase 3: Advanced Features
- Implement media conversion management
- Add media tagging capabilities
- Create advanced media analytics

## Future Enhancements

### 1. Advanced Media Features
- AI-powered media organization and tagging
- Advanced media transformation capabilities
- Media content analysis and search

### 2. Cross-module Media Integration
- Unified media management across modules
- Media asset sharing between contexts
- Advanced media relationships

### 3. Performance Optimization
- Media asset caching strategies
- Optimized queries for large media datasets
- Efficient handling of media transformations