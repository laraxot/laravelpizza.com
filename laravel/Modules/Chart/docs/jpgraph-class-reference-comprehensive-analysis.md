# JpGraph Class Reference - Comprehensive Analysis

## Overview
JpGraph is a comprehensive PHP library for creating server-side generated charts and graphs. It supports a wide variety of chart types including line plots, bar charts, pie charts, Gantt charts, and more. This document provides a comprehensive analysis of the main classes and their functionalities.

## Core Classes

### Graph Class
The main container class for all x,y-axis based plots.

**Location**: Defined in `jpgraph.php` around line 491

**Key Properties**:
- `xaxis`: X-axis instance
- `yaxis`: Y-axis instance 
- `xgrid`: Grid lines for X-axis
- `ygrid`: Grid lines for Y-axis
- `legend`: Properties for legend box
- `title`: Graph main title
- `subtitle`: Sub title
- `subsubtitle`: Sub title
- `tabtitle`: Option Tab title for graph
- `img`: RotImage instance (the image canvas)

**Key Methods**:
- `Add($aPlot)`: Add any plot object to the graph
- `AddY2($aPlot)`: Add plot to second Y-axis
- `SetScale($aAxisType, $aYMin, $aYMax, $aXMin, $aXMax)`: Specify scale to use for X and Y axis
- `SetMargin($lm, $rm, $tm, $bm)`: Specify side margins for graph
- `SetAngle($aAngle)`: Specify graph angle 0-360 degrees
- `Set90AndMargin($lm, $rm, $tm, $bm)`: Rotate the graph 90 degrees and set the margins
- `SetBackgroundImage($aFileName, $aBgType, $aImgFormat)`: Specify a background image for the plot
- `SetBackgroundGradient($aFrom, $aTo, $aGradType, $aStyle)`: Set a color gradient as the background
- `SetClipping($aFlg)`: Enable clipping of graph outside the plotarea
- `SetGridDepth($aDepth)`: Should the grid be in front or back of the plot?

### Plot Class (Abstract Base Class)
Abstract base class for all plots.

**Location**: Defined in `jpgraph.php` around line 5093

**Key Properties**:
- `value`: DisplayValue instance (control the data value displayed at each data point)

**Key Methods**:
- `SetLegend($aLegend, $aCSIM, $aCSIMAlt, $aCSIMWinTarget)`: Set legend string for this plot
- `SetColor($aColor)`: Specify color for plot
- `SetWeight($aWeight)`: Specify line weight for plot
- `SetCSIMTargets($aTargets, $aAlts, $aWinTargets)`: Set URL targets for CSIM
- `HideLegend($f)`: Hide legend for this plot

### LinePlot Class
Class for creating line graph plots.

**Location**: Defined in `jpgraph_line.php` around line 24

**Purpose**: Used to create line graph plots where datapoints are connected by lines. Each data point can also be marked by a plotmark.

**Key Methods**:
- `__construct($datay, $datax)`: Public Constructor for LinePlot
- `SetFilled($aMin, $aMax, $aFilled, $aColor, $aBorder)`: Create a colored area under part of the line graph
- `SetBarCenter($aFlag)`: Adjust the positioning of line plots when combined with a bar plot

### BarPlot Class
Class for creating vertical bar plots.

**Location**: Defined in `jpgraph_bar.php` around line 30

**Purpose**: Implements the standard vertical bar plot functionality.

**Key Methods**:
- `__construct($datay, $datax)`: Create a new bar plot
- `SetFillColor($aColor)`: Specify fill color for bars
- `SetFillGradient($aFromColor, $aToColor, $aStyle)`: Specify a gradient fill for the bars
- `SetPattern($aPattern, $aColor)`: Add one of the line patterns to the bar
- `SetWidth($aWidth)`: Specify width as fractions of the major step size
- `SetAbsWidth($aWidth)`: Specify width in absolute pixels
- `SetAlign($aAlign)`: Set the alignment between the major tick marks for the bars
- `SetYBase($aYStartValue)`: Specify the base value for the bars
- `SetShadow($aColor, $aHSize, $aVSize, $aShow)`: Set a drop shadow for the bar
- `SetNoFill()`: Don't paint the interior of the bars with any color
- `SetValuePos($aPos)`: Specify position for displayed values on bars

### PiePlot Class
Class for creating pie chart plots.

**Location**: Defined in `jpgraph_pie.php` around line 24

**Purpose**: Creates a new Pie plot from the supplied data.

**Key Methods**:
- `__construct($data)`: Constructor for PiePlots
- `SetCenter($x, $y)`: Set the center point for the PiePlot
- `SetSize($aSize)`: Size in percentage
- `Explode($aExplodeArr)`: Explode one or more slices as specified radius
- `ExplodeSlice($e, $radius)`: Explode a single slice a specified radius
- `ExplodeAll($radius)`: Explode all slices a specified amount
- `SetLabelType($aType)`: Should we display actual value or percentage?
- `SetLabels($aLabels, $aLblPosAdj)`: Specify individual text labels for all slices
- `SetLegends($aLegend)`: Set label arrays (legends for slices)
- `SetTheme($aTheme)`: Specify what color theme should be used for this pie
- `SetSliceColors($aColors)`: Override theme colors for slices
- `SetStartAngle($aStart)`: Specify start angle for first slice
- `SetShadow($aColor, $aDropWidth)`: Add a drop shadow to the pie slices
- `ShowBorder($exterior, $interior)`: Should the circle around a pie plot be displayed

### PieGraph Class
The canvas for use with PiePlots.

**Location**: Defined in `jpgraph_pie.php` around line 1210

**Purpose**: The canvas for use with PiePlots. You add pie plots by calling the Add() method.

**Key Methods**:
- `__construct($width, $height, $cachedName, $timeout, $inline)`: Constructor
- `Add($aObj)`: Add object to the pie graph
- `SetAntiAlias($aFlg)`: Enable/disable anti-alias for Pie Graphs
- `SetColor($c)`: Set the background color. Synonym to SetMarginColor()
- `Stroke($aStrokeFileName)`: Stroke graph to browser or file

### GanttGraph Class
Create a Gantt graph.

**Location**: Defined in `jpgraph_gantt.php` around line 331

**Purpose**: The Gantt graph can then be built up by adding activity bars and milestones.

**Related Classes**: GanttBar, GanttVLine and MileStone

**Key Methods**:
- `__construct($aWidth, $aHeight, $aCachedName, $aTimeOut, $aInline)`: Create a new GanttGraph
- `Add($aObject)`: Add a new Gantt object
- `SetDateRange($aStart, $aEnd)`: Specify date range for Gantt chart
- `ShowHeaders($aFlg)`: Determine what headers/scales to display
- `CreateSimple($data, $constrains, $progress)`: A utility function to help create the Gantt charts
- `SetSimpleFont($aFont, $aSize)`: Specify font for simplified Gantt graph
- `SetSimpleStyle($aBand, $aColor, $aBkgColor)`: Specify style parameters for graphs constructed with CreateSimple
- `SetVMarginFactor($aVal)`: Specify the margin factor for lines in the gantt graph

### GanttBar Class
Represents each activity bar in a Gantt chart.

**Location**: Defined in `jpgraph_gantt.php` around line 3192

**Purpose**: This class represents each activity bar. The activity bars can then be added to a GanttChart via the GanttGraph::Add()

**Key Methods**:
- `__construct($aPos, $aLabel, $aStart, $aEnd, $aCaption, $aHeightFactor)`: Create a new activity bar
- `SetPattern($aPattern, $aColor, $aDensity)`: Specify what pattern to use for the activity bars
- `SetFillColor($aColor)`: Specify fill color for activity bar
- `SetColor($aColor)`: Specify frame color for the activity bar
- `SetHeight($aHeight)`: Set height for the bar
- `SetShadow($aShadow, $aColor)`: Add a drop shadow to the bar

## Advanced Classes

### CanvasGraph Class
A blank canvas for custom drawing.

**Location**: Defined in `jpgraph_canvas.php` around line 20

**Purpose**: If you for some reason just want plain canvas to draw on using the direct drawing method you can create a new canvas with this class.

**Key Methods**:
- `__construct($aWidth, $aHeight, $aCachedName, $timeout, $inline)`: Construct a new Canvas graph
- `InitFrame()`: Strokes plot area and margin
- `Stroke($aStrokeFileName)`: Stroke graph to browser or file

### CanvasScale Class
Defines a scale for canvas graphs.

**Location**: Defined in `jpgraph_canvtools.php` around line 24

**Purpose**: This class defines a scale which is meant to be used with canvas graphs to make it possible to specify a more convenient scale compared to absolute pixel coordinates.

**Key Methods**:
- `__construct($graph, $xmin, $xmax, $ymin, $ymax)`: Define a scale for canvas graphs
- `Set($xmin, $xmax, $ymin, $ymax)`: Specify scale to use
- `Translate($x, $y)`: Translate a point to absolute screen coordinates
- `TranslateX($x)`: Translate X-coordinate
- `TranslateY($y)`: Translate Y-value to absolute screen coordinates

## Chart Types Support

JpGraph supports a wide range of chart types:

### Line Charts
- LinePlot: Standard line plots connecting data points
- Spline interpolation for smooth curves
- Area filling capabilities
- Support for multiple datasets

### Bar Charts
- BarPlot: Vertical bar charts
- Horizontal bar charts (by rotating the graph)
- Grouped and stacked bar charts
- Gradient and pattern fills
- Shadow effects

### Pie Charts
- PiePlot: Standard pie charts
- Exploded pie charts
- 3D pie charts (PiePlot3D)
- Multiple themes available ("earth", "pastel", "sand", "water")
- Value labels with percentage or absolute values

### Gantt Charts
- GanttGraph: Complete Gantt chart functionality
- GanttBar: Activity bars
- Milestone markers
- Vertical lines for deadlines
- Constrain lines showing dependencies
- Multiple time scales (year, month, week, day, hour, minute)

### Scatter Plots
- ScatterPlot: Scatter plot functionality
- Various marker styles
- Support for different scales

### Other Chart Types
- Radar charts
- Polar charts
- Contour plots
- Stock charts
- Box plots
- Error plots
- Windrose plots

## Special Features

### Client Side Image Maps (CSIM)
JpGraph supports CSIM (Client Side Image Maps) which allows for interactive charts that can link to other pages or display additional information when clicked.

### Anti-aliasing
Many chart types support anti-aliasing for higher quality output, though this comes with a performance cost.

### Background Images and Gradients
Charts can include background images, color gradients, and country flags.

### Multiple Y-Axes
Support for multiple Y-axes allows comparison of datasets with different scales.

### Caching
Built-in caching functionality to improve performance for frequently accessed charts.

### Rotation and Perspective
Charts can be rotated to any angle and include 3D perspective effects.

## Best Practices

1. **Memory Management**: For large or complex charts, monitor memory usage as JpGraph can be memory-intensive.
2. **Performance**: Use caching for frequently accessed charts.
3. **CSIM**: When using Client Side Image Maps, ensure proper implementation with StrokeCSIM() method.
4. **Scale Selection**: Choose appropriate scales (linear, logarithmic, text, integer) based on data characteristics.
5. **Color Themes**: Use consistent color themes across related charts for better visual coherence.
6. **Responsive Design**: Consider output size and resolution when generating charts for different devices.

## Integration with Web Applications

JpGraph integrates well with web applications by:
- Generating charts directly to browser or file
- Supporting URL parameters for dynamic chart generation
- Providing CSIM for interactive charts
- Working with session variables for secure chart access
- Supporting various image formats (PNG, JPEG, GIF)