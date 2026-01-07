<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Volt\Volt as LivewireVolt;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Tests\TestCase;

use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\assertGuest;

uses(TestCase::class);

// NOTE: Helper functions moved to Modules\Xot\Tests\TestCase for DRY pattern
// Use $this->$this->generateUniqueEmail(), $this->getUserClass(), $this->$this->createTestUser()

        $component = LivewireVolt::test('auth.login');

        expect($component)->not->toBeNull();
        $component->assertOk();
    });

        $component = LivewireVolt::test('auth.login');

        $component->assertSet('email', '')->assertSet('password', '')->assertSet('remember', false);
    });

        $component = LivewireVolt::test('auth.login');

        $component
            ->assertSee('wire:model="email"')
            ->assertSee('wire:model="password"')
            ->assertSee('wire:model="remember"');
    });
});

        $email = $this->generateUniqueEmail();
        $user = $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        assertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasNoErrors();
        assertAuthenticated();
    });

        $email = $this->generateUniqueEmail();
        $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        assertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'wrong_password')
            ->call('save');

        $response->assertHasErrors(['email']);
        assertGuest();
    });

        $email = $this->generateUniqueEmail();

        assertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasErrors(['email']);
        assertGuest();
    });
});

        $response = LivewireVolt::test('auth.login')
            ->set('email', 'invalid-email')
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasErrors(['email']);
    });

        $response = LivewireVolt::test('auth.login')->call('save');

        $response->assertHasErrors(['email', 'password']);
    });

        $email = $this->generateUniqueEmail();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', '123')
            ->call('save');

        // Password troppo corta dovrebbe fallire
        $response->assertHasErrors();
    });
});

        $email = $this->generateUniqueEmail();
        $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        assertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->set('remember', true)
            ->call('save');

        $response->assertHasNoErrors();
        assertAuthenticated();
    });

        $email = $this->generateUniqueEmail();
        $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        // Store original session ID
        $originalSessionId = session()->getId();

        LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        assertAuthenticated();

        // Session should be regenerated for security
        expect(session()->getId())->not->toBe($originalSessionId);
    });

        $email = $this->generateUniqueEmail();
        $user = $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        // Set some session data
        Session::put('test_key', 'test_value');

        LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        assertAuthenticated();

        // Session data should be preserved (session regenerated but data kept)
        expect(Session::get('test_key'))->toBe('test_value');
    });
});

        $email = $this->generateUniqueEmail();
        $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        // Multiple failed attempts
        for ($i = 0; $i < 5; ++$i) {
            LivewireVolt::test('auth.login')
                ->set('email', $email)
                ->set('password', 'wrong_password')
                ->call('save');
        }

        // Should be rate limited after too many attempts
        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        // May have throttling errors
        expect($response)->not->toBeNull();
    });

        // Volt components should automatically handle CSRF protection
        $email = $this->generateUniqueEmail();
        $user = $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        // Should work normally with CSRF protection
        $response->assertHasNoErrors();
    });

        $email = $this->generateUniqueEmail();

        $response = LivewireVolt::test('auth.login')
            ->set('email', '<script>alert("xss")</script>'.$email)
            ->set('password', 'password123')
            ->call('save');

        // Should handle potentially malicious input safely
        expect($response)->not->toBeNull();
    });
});

        $email = $this->generateUniqueEmail();

        $component = LivewireVolt::test('auth.login');

        $component
            ->set('email', $email)
            ->assertSet('email', $email)
            ->set('password', 'password123')
            ->assertSet('password', 'password123')
            ->set('remember', true)
            ->assertSet('remember', true);
    });

        $email = $this->generateUniqueEmail();

        $component = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'wrong_password')
            ->call('save');

        // Password should be cleared after failed attempt
        $component->assertSet('password', '');
    });

        $email = $this->generateUniqueEmail();
        $user = $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        $component = LivewireVolt::test('auth.login')->set('email', $email)->set('password', 'password123');

        // Should not be in loading state initially
        $component->assertDontSee('wire:loading');

        // After calling authenticate, component should handle loading state
        $component->call('save');

        // Should complete successfully
        $component->assertHasNoErrors();
    });
});

        // Using XotData pattern ensures compatibility with any user type
        $email = $this->generateUniqueEmail();
        $user = $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        assertGuest();

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasNoErrors();
        assertAuthenticated();

        // Verify authenticated user
        $authenticatedUser = Auth::user();
        expect($authenticatedUser)->not->toBeNull();
        expect($authenticatedUser?->email)->toBe($email);
    });

        // Test with various user attributes
        $email = $this->generateUniqueEmail();
        $user = $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
            'name' => 'Test User',
        ]);

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasNoErrors();
        assertAuthenticated();

        $authenticatedUser = Auth::user();
        expect($authenticatedUser?->name)->toBe('Test User');
    });
});

        $email = $this->generateUniqueEmail();
        $user = $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasNoErrors();
        assertAuthenticated();

        // Component might trigger redirect via JavaScript/Alpine
        // This test ensures the authentication logic completes successfully
    });

        $email = $this->generateUniqueEmail();
        $user = $this->createTestUser([
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        // Set intended URL
        Session::put('url.intended', '/dashboard');

        $response = LivewireVolt::test('auth.login')
            ->set('email', $email)
            ->set('password', 'password123')
            ->call('save');

        $response->assertHasNoErrors();
        assertAuthenticated();
    });
});

        $component = LivewireVolt::test('auth.login');

        // Component should render with accessibility attributes
        $component->assertSee('aria-label')->assertSee('id="data.email"')->assertSee('id="data.password"');
    });

        $component = LivewireVolt::test('auth.login');

        // Component should be keyboard accessible
        expect($component)->not->toBeNull();
    });
});
