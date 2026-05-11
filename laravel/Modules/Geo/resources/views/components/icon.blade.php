@props(['name', 'class' => 'w-4 h-4'])

@php
    $svgPath = module_path('Geo', 'resources/svg/'.$name.'.svg');
    if (file_exists($svgPath)) {
        $svg = file_get_contents($svgPath);
        // Add class to SVG
        $svg = preg_replace('/<svg/i', '<svg class="'.$class.'"', $svg, 1);
        echo $svg;
    }
@endphp
