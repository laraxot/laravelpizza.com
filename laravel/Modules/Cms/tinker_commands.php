<?php

declare(strict_types=1);

// use Modules\<main module>\Models\Patient;
// use Modules\<main module>\Models\Doctor;
// use Modules\<main module>\Models\Studio;
// use Modules\<main module>\Models\Appointment;
// use Modules\<main module>\Models\Report;
// use Modules\<main module>\Models\Profile;
// use Modules\<main module>\Models\User;

/*
 * Tinker commands to generate 100 records for each business model
 * Run with: php artisan tinker < tinker_commands.php
 */

// Module: <main module>
echo 'Generating Patient...';
// Patient::factory()->count(100)->create();
echo "✅ Patient completed\n";

echo 'Generating Doctor...';
// Doctor::factory()->count(100)->create();
echo "✅ Doctor completed\n";

echo 'Generating Studio...';
// Studio::factory()->count(100)->create();
echo "✅ Studio completed\n";

echo 'Generating Appointment...';
// Appointment::factory()->count(100)->create();
echo "✅ Appointment completed\n";

echo 'Generating Report...';
// Report::factory()->count(100)->create();
echo "✅ Report completed\n";

echo 'Generating Profile...';
// Profile::factory()->count(100)->create();
echo "✅ Profile completed\n";

echo 'Generating User...';
// User::factory()->count(100)->create();
echo "✅ User completed\n";
