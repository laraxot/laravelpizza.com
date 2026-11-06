<?php

declare(strict_types=1);

use Filament\Schemas\Schema;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\Repository;
use Illuminate\Container\Container;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\MessageBag;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Livewire\Mechanisms\DataStore;
use Modules\User\Filament\Widgets\Auth\LoginWidget;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

test('credenziali errate mostrano un errore tradotto sul campo email', function (string $locale, string $method): void {
    $previousContainer = Container::getInstance();
    $previousFacadeApplication = Facade::getFacadeApplication();
    $container = new Application;
    Container::setInstance($container);
    Facade::setFacadeApplication($container);
    Facade::clearResolvedInstances();

    try {
        $loader = new FileLoader(new Filesystem, []);
        $loader->addNamespace('user', dirname(__DIR__, 4).'/lang');
        $translator = new Translator($loader, $locale);
        $container->instance('translator', $translator);
        $container->instance('request', Request::create('/'));
        $container->instance('cache.store', new Repository(new ArrayStore));
        $container->singleton(DataStore::class);

        $credentials = [
            'email' => 'utente@example.test',
            'password' => 'password-errata',
        ];
        $guard = $this->createMock(StatefulGuard::class);
        $guard->expects($this->once())->method('attempt')->with($credentials, false)->willReturn(false);
        Auth::swap($guard);

        $schema = $this->createMock(Schema::class);
        $schema->method('getState')->willReturn($credentials);
        $widget = new class($schema) extends LoginWidget
        {
            public function __construct(public Schema $form) {}
        };
        $widget->setErrorBag([]);
        $widget->{$method}();

        $expected = $translator->get('user::login.actions.login.error');
        $errors = $widget->getErrorBag();
        $this->assertInstanceOf(MessageBag::class, $errors);
        expect($expected)->toBeString()->not->toBe('user::login.actions.login.error');
        expect($errors->get('data.email'))->toBe([$expected]);
        expect($errors->has('email'))->toBeFalse();
    } finally {
        Facade::clearResolvedInstances();
        Facade::setFacadeApplication($previousFacadeApplication);
        Container::setInstance($previousContainer);
    }
})->with(['it', 'en'])->with(['login', 'save']);
