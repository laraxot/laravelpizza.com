<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo 'Default Connection: '.config('database.default')."\n";
echo 'MySQL Config: '.json_encode(config('database.connections.mysql'))."\n";
echo 'Notify Config (Before override): '.json_encode(config('database.connections.notify'))."\n";

// Emulate TestCase logic
config(['database.connections.notify' => config('database.connections.mysql')]);
echo 'Notify Config (After override): '.json_encode(config('database.connections.notify'))."\n";

Illuminate\Support\Facades\DB::purge('notify');
Illuminate\Support\Facades\DB::purge('mysql');

$notifyConn = Illuminate\Support\Facades\Schema::connection('notify');
$mysqlConn = Illuminate\Support\Facades\Schema::connection('mysql');

echo 'MySQL has mail_templates? '.($mysqlConn->hasTable('mail_templates') ? 'YES' : 'NO')."\n";
echo 'Notify has mail_templates? '.($notifyConn->hasTable('mail_templates') ? 'YES' : 'NO')."\n";

// Try creating using Notify connection
if (! $notifyConn->hasTable('mail_templates')) {
    echo "Creating table using Notify connection...\n";
    try {
        Illuminate\Support\Facades\Schema::connection('notify')->create('mail_templates', function ($table) {
            $table->increments('id');
            $table->string('name')->nullable();
        });
        echo "Table created.\n";
    } catch (Exception $e) {
        echo 'Creation failed: '.$e->getMessage()."\n";
    }
}

echo 'Notify has mail_templates after create? '.($notifyConn->hasTable('mail_templates') ? 'YES' : 'NO')."\n";

// Try altering
echo "Altering table...\n";
try {
    Illuminate\Support\Facades\Schema::connection('notify')->table('mail_templates', function ($table) {
        $table->string('test_col')->nullable();
    });
    echo "Alter successful.\n";
} catch (Exception $e) {
    echo 'Alter failed: '.$e->getMessage()."\n";
}
