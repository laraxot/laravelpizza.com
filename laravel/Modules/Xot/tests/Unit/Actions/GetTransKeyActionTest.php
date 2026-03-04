<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions;

use Modules\Xot\Actions\GetTransKeyAction;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

it('generates translation keys correctly from various class patterns', function (): void {
    $action = app(GetTransKeyAction::class);
    
    // Direct resource
    expect($action->execute('Modules\User\Filament\Resources\UserResource'))->toBe('user::user');
    
    // Pages
    expect($action->execute('Modules\User\Filament\Resources\UserResource\Pages\ListUsers'))->toBe('user::user');
    expect($action->execute('Modules\User\Filament\Resources\UserResource\Pages\CreateUser'))->toBe('user::user');
    
    // Relation Managers
    expect($action->execute('Modules\User\Filament\Resources\UserResource\RelationManagers\ProfilesRelationManager'))->toBe('user::profile');
    
    // Actions
    expect($action->execute('Modules\Activity\Actions\LogActivityAction'))->toBe('activity::log_activity');
    
    // Dashboard
    expect($action->execute('Modules\Xot\Filament\Pages\Dashboard'))->toBe('xot::dashboard');
});

it('can auto-detect class from backtrace', function (): void {
    $action = new class extends GetTransKeyAction {
        public function test(): string {
            return $this->execute('');
        }
    };
    
    // Calling from anonymous class in Unit namespace
    // It will try to find a Modules namespace in backtrace or fallback to main module
    $result = $action->test();
    expect($result)->toBeString()->toContain('::');
});
