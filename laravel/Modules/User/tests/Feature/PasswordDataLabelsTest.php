<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature;

use Modules\User\Datas\PasswordData;
use Modules\User\Datas\PasswordData as PasswordDataClass;
use Tests\TestCase;

class PasswordDataLabelsTest extends TestCase
{
    /**
     * Test that PasswordData generates components with correct labels.
     */
    public function testPasswordDataLabelsAreTranslated(): void
    {
        // Arrange
        // We ensure we are in a known locale
        app()->setLocale('it');

        /** @var PasswordDataClass $passwordData */
        $passwordData = PasswordDataClass::make();
        $passwordData->setFieldName('password');

        // Act
        $passwordComponent = $passwordData->getPasswordFormComponent('password');
        $confirmationComponent = $passwordData->getPasswordConfirmationFormComponent();

        // Assert
        // The label should be fetched from translation 'user::password-data.fields.password.label'
        // Debug output to see what we are getting
        // dump($passwordComponent->getLabel());

        $this->assertEquals('Password', $passwordComponent->getLabel(), 'Label mismatch for password field. Got: '.$passwordComponent->getLabel());
        $this->assertEquals('Conferma Password', $confirmationComponent->getLabel(), 'Label mismatch for confirmation field. Got: '.$confirmationComponent->getLabel());
    }

    /**
     * Test that Login form components have correct labels.
     */
    public function testLoginFormLabelsAreTranslated(): void
    {
        // Assemble
        app()->setLocale('it');
        $component = new \Modules\User\Http\Livewire\Auth\Login();

        // Act
        // We simulate the form creation.
        // Since getFormSchema is protected, we use reflection or a Livewire test helper if possible.
        // But simpler: Login extends Component and implements HasForms.
        // We can check if we can access the schema.

        // Using Livewire test helper is better
        $livewire = \Livewire\Livewire::test(\Modules\User\Http\Livewire\Auth\Login::class);

        // We can inspect the form components via the testing interface if exposed,
        // but Livewire testing is mostly assertSee.
        // Let's rely on instance inspection which is safer for property checks.

        $instance = $livewire->instance();

        // We need to call form() to initialize components?
        // Filament forms are initialized on mount or when accessed.
        $instance->mount();

        $form = $instance->getForm('form');
        $components = $form->getComponents();

        // Find components
        $email = collect($components)->first(fn ($c) => 'email' === $c->getName());
        $password = collect($components)->first(fn ($c) => 'password' === $c->getName());
        $remember = collect($components)->first(fn ($c) => 'remember' === $c->getName());

        // Assert
        $this->assertNotNull($email);
        $this->assertEquals('Email', $email->getLabel());

        $this->assertNotNull($password);
        $this->assertEquals('Password', $password->getLabel());

        $this->assertNotNull($remember);
        $this->assertEquals('Ricordami', $remember->getLabel());
    }
}
