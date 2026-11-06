<?php

declare(strict_types=1);

return [
    'name' => 'Notify',
    'description' => 'Modulo per la gestione delle notifiche e comunicazioni',
    'icon' => 'heroicon-o-bell',
    'navigation' => [
        'enabled' => true,
        'sort' => 70],
    'routes' => [
        'enabled' => true,
        'middleware' => ['web', 'auth']],
    'providers' => [
        'Modules\\Notify\\Providers\\NotifyServiceProvider'],
    'logo_url' => null,
    'social_links' => [
        'facebook' => null,
        'twitter' => null,
        'instagram' => null,
        'linkedin' => null],
    'unsubscribe_url' => null,
    'default_layout' => 'notify::mail-layouts.base.default',
    'layouts' => [
        'default' => 'notify::mail-layouts.base.default'],
    'templates' => [
        'welcome' => 'notify::mail-layouts.templates.welcome']];
