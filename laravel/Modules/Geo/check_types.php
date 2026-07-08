<?php
require 'laravel/vendor/autoload.php';
$app = require_once 'laravel/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

function checkProperty($class, $prop) {
    try {
        $reflection = new ReflectionClass($class);
        if ($reflection->hasProperty($prop)) {
            $property = $reflection->getProperty($prop);
            $type = $property->getType();
            echo "Class: $class\n";
            echo "Property: $prop\n";
            echo "Type: " . ($type ? $type->getName() : 'none') . "\n";
            echo "Declaring Class: " . $property->getDeclaringClass()->getName() . "\n";
            echo "------------------\n";
        } else {
            echo "Class: $class - Property $prop not found\n";
            echo "------------------\n";
        }
    } catch (Exception $e) {
        echo "Error checking $class: " . $e->getMessage() . "\n";
    }
}

checkProperty('Modules\Xot\Filament\Resources\Pages\XotBasePage', 'data');
checkProperty('Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages\CompilaIndennitaResponsabilita', 'data');
checkProperty('Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages\SendMailIndennitaResponsabilita', 'data');
