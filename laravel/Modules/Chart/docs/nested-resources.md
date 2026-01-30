# Chart Module - Nested Resource Implementation Guide

## Overview

The Chart module provides data visualization and charting capabilities for the Laraxot system, integrating with survey data and other data sources. Nested resources in this module focus on organizing chart-related data in a hierarchical structure that connects charts with their data sources, configurations, and related analytics.

## Current Relationship Structure

### ChartData Model Relationships
- `ChartData` morphTo `Chartable` (can belong to different entities like surveys, questions)
- `ChartData` belongsTo `User` (creator/owner)
- `ChartData` hasMany `ChartConfiguration` (for different chart settings)

### ChartConfiguration Model Relationships
- `ChartConfiguration` belongsTo `ChartData`
- `ChartConfiguration` belongsTo `User` (creator)

### ChartStyle Model Relationships
- `ChartStyle` belongsTo `ChartData` (or other chart entities)
- `ChartStyle` belongsTo `User` (creator)

## Potential Nested Resource Applications

### 1. Chart-Configuration Management
**Parent Resource:** ChartDataResource
**Child Resource:** ChartConfigurationResource
**Relationship:** ChartData hasMany ChartConfigurations
**Justification:** Organize different chart configurations within their respective charts for better visualization management.

### 2. Survey-Chart Integration
**Parent Resource:** SurveyPdfResource (from Quaeris module)
**Child Resource:** ChartDataResource
**Relationship:** SurveyPdf hasMany ChartData (via survey relationship)
**Justification:** Organize charts within their respective surveys for better survey analytics.

### 3. Question-Chart Hierarchy
**Parent Resource:** LimeQuestionResource (from Limesurvey module)
**Child Resource:** ChartDataResource
**Relationship:** LimeQuestion hasMany ChartData (for question-specific charts)
**Justification:** Create charts specific to survey questions for detailed analysis.

### 4. Chart-Style Management
**Parent Resource:** ChartDataResource
**Child Resource:** ChartStyleResource
**Relationship:** ChartData hasMany ChartStyles
**Justification:** Organize different styling options within chart context for better visualization.

### 5. User Chart Management
**Parent Resource:** UserResource (from User module)
**Child Resource:** ChartDataResource
**Relationship:** User hasMany ChartData (as creator/owner)
**Justification:** Organize charts by user for better ownership and access management.

### 6. Chart Data Sources
**Parent Resource:** ChartDataResource
**Child Resource:** ChartDataSourceResource (if implemented)
**Relationship:** ChartData hasMany ChartDataSources
**Justification:** Manage multiple data sources for complex charts.

### 7. Chart Conversion/Export Options
**Parent Resource:** ChartDataResource
**Child Resource:** ChartExportOptionResource (if implemented)
**Relationship:** ChartData hasMany ChartExportOptions
**Justification:** Organize different export formats and options within chart context.

### 8. Chart Analytics
**Parent Resource:** ChartDataResource
**Child Resource:** ChartAnalyticsResource (if implemented)
**Relationship:** ChartData hasMany ChartAnalytics
**Justification:** Track chart usage and analytics within the chart context.

## Implementation Approach

### Using Filament Nested Resources Package
Following the documented approach in `Modules/UI/docs/filament/nested-resource.md`:

1. **Child Resource Implementation:**
   ```php
   use SevendaysDigital\FilamentNestedResources\NestedResource;
   use SevendaysDigital\FilamentNestedResources\ResourcePages\NestedPage;

   class ChartConfigurationResource extends NestedResource
   {
       public static function getParent(): string
       {
           return ChartDataResource::class;
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
           ChildResourceLink::make(ChartConfigurationResource::class),
       ]);
   }
   ```

3. **Page Configuration:**
   Apply the `NestedPage` trait to all nested resource pages (List, Edit, Create).

4. **For morphTo relationships:**
   ```php
   // In the chart model, add scope for parent filtering
   public function scopeOfChartable($query, $chartableId, $chartableType)
   {
       return $query->where('chartable_id', $chartableId)
                   ->where('chartable_type', $chartableType);
   }
   
   // For user-specific charts
   public function scopeOfUser($query, $userId)
   {
       return $query->where('user_id', $userId);
   }
   ```

## Benefits of Nested Resource Implementation

### 1. Improved Chart Organization
- Hierarchical representation of chart relationships
- Context-aware chart management
- Better organization of complex chart configurations

### 2. Enhanced Data Visualization
- Intuitive chart structure navigation
- Organized chart configuration management
- Better analytics and reporting capabilities

### 3. Better User Experience
- Context-aware chart operations
- Natural representation of chart relationships
- Improved chart customization workflows

### 4. Scalability
- Modular approach to chart management
- Easy to extend with additional nested resources
- Consistent user experience across chart operations

## Considerations

### 1. Performance
- Chart generation can be computationally intensive
- Ensure efficient queries for chart data retrieval
- Optimize for common chart access patterns

### 2. Data Integration
- Handle relationships with survey data from Quaeris/Limesurvey modules
- Ensure proper data synchronization for dynamic charts
- Consider real-time data refresh requirements

### 3. Cross-module Integration
- Coordinate with Quaeris module for survey charts
- Handle relationships with Limesurvey question data
- Consider integration with other analytics modules

### 4. User Experience
- Complex chart configurations should be intuitive to navigate
- Consider performance implications for chart rendering
- Provide efficient search and filtering for chart configurations

## Implementation Roadmap

### Phase 1: Foundation Setup
- Install and configure filament-nested-resources package
- Create base nested resource classes extending XotBaseResource
- Implement basic Chart-Configuration relationship

### Phase 2: Core Functionality
- Implement Survey-Chart relationships
- Add Question-Chart organization
- Create user-specific chart management

### Phase 3: Advanced Features
- Implement chart analytics and tracking
- Add advanced chart customization options
- Create cross-module chart integration

## Future Enhancements

### 1. Advanced Chart Features
- AI-powered chart recommendations
- Advanced data analysis and insights
- Real-time chart updates and streaming

### 2. Cross-module Chart Integration
- Unified chart management across modules
- Advanced chart relationships and dependencies
- Comprehensive analytics dashboard

### 3. Performance Optimization
- Chart data caching strategies
- Optimized queries for large datasets
- Efficient handling of complex chart calculations