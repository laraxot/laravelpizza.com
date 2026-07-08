<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Incentivi\Http\Controllers\PdfDownloadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('projects/{project}/pdf/download', [PdfDownloadController::class, 'download'])
    ->name('filament.projects.download');

Route::get('projects/{project}/liquidazione', [PdfDownloadController::class, 'liquidazione'])
    ->name('filament.liquidazione');
