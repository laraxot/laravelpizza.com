<?php

declare(strict_types=1);

namespace Modules\Gdpr\Actions;

use Illuminate\Support\Facades\Log;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Treatment;
use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action per validare e trasformare dati utente in modo sicuro.
 * 
 * Estende QueueableAction per separazione responsabilità.
 */
class ValidateUserDataAction extends QueueableAction
{
    /**
     * Validate and sanitize user data.
     *
     * @param array<string, mixed> $data
     * @throws \Illuminate\Validation\ValidationException
     */
    public function execute(array $data): array
    {
        $validator = validator($data, [
            'first_name' => 'required|string|min:2|max:255',
            'last_name' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'first_name.required' => __('user::validation.first_name_required'),
            'first_name.min' => __('user::validation.first_name_min'),
            'first_name.max' => __('user::validation.first_name_max'),
            'last_name.required' => __('user::validation.last_name_required'),
            'last_name.min' => __('user::validation.last_name_min'),
            'last_name.max' => __('user::validation.last_name_max'),
            'email.required' => __('user::validation.email_required'),
            'email.email' => __('user::validation.email_email'),
            'email.unique' => __('user::validation.email_unique'),
            'email.max' => __('user::validation.email_max'),
            'password.required' => __('user::validation.password_required'),
            'password.min' => __('user::validation.password_min'),
            'password.confirmed' => __('user::validation.password_confirmed'),
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator->errors()->toArray());
        }

        // Preparazione dati sicuri per User model
        return [
            'first_name' => strip_tags($data['first_name']),
            'last_name' => strip_tags($data['last_name']),
            'email' => filter_var($data['email'], FILTER_SANITIZE_EMAIL),
            'password' => $data['password'], // Sarà hashato nel CreateUserAction
            'password_confirmation' => $data['password_confirmation'],
        ];
    }

    /**
     * Get tags for the action.
     *
     * @return array<string>
     */
    public function tags(): array
    {
        return ['user', 'validation', 'security'];
    }

    /**
     * Get the display name for the action.
     *
     * @return string
     */
    public function displayName(): string
    {
        return 'Validate User Data Action';
    }

    /**
     * Get the description for the action.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Validates and sanitizes user registration data with security best practices.';
    }
}