# Italian Text in Non-Italian Translation Files - Audit Report

**Data**: 2025-08-08 11:19:40

## Problemi Identificati

### File: `auth.php` (English)

**Path completo**: `/var/www/html/_bases/base_saluteora/laravel/resources/lang/en/auth.php`

- **Linea 8**: Pattern italiano `email` trovato
  ```php
  'email' => 'Email',
  ```

- **Linea 20**: Pattern italiano `email` trovato
  ```php
  'email' => 'Email',
  ```

- **Linea 43**: Pattern italiano `email` trovato
  ```php
  'email' => 'Email',
  ```

- **Linea 49**: Pattern italiano `email` trovato
  ```php
  'email' => 'Email',
  ```

- **Linea 9**: Pattern italiano `password` trovato
  ```php
  'password' => 'Password',
  ```

- **Linea 11**: Pattern italiano `password` trovato
  ```php
  'forgot_password' => 'Forgot your password?',
  ```

- **Linea 21**: Pattern italiano `password` trovato
  ```php
  'password' => 'Password',
  ```

- **Linea 22**: Pattern italiano `password` trovato
  ```php
  'password_confirmation' => 'Confirm password',
  ```

- **Linea 41**: Pattern italiano `password` trovato
  ```php
  'forgot_password' => [
  ```

- **Linea 42**: Pattern italiano `password` trovato
  ```php
  'title' => 'Forgot password',
  ```

- **Linea 47**: Pattern italiano `password` trovato
  ```php
  'reset_password' => [
  ```

- **Linea 48**: Pattern italiano `password` trovato
  ```php
  'title' => 'Reset password',
  ```

- **Linea 50**: Pattern italiano `password` trovato
  ```php
  'password' => 'New password',
  ```

- **Linea 51**: Pattern italiano `password` trovato
  ```php
  'password_confirmation' => 'Confirm password',
  ```

- **Linea 52**: Pattern italiano `password` trovato
  ```php
  'submit' => 'Reset password',
  ```

- **Linea 7**: Pattern italiano `crea` trovato
  ```php
  'create_account' => 'create an account',
  ```

- **Linea 55**: Pattern italiano ` in ` trovato
  ```php
  'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
  ```

## Riepilogo

- **File con problemi**: 1
- **Problemi totali**: 17

## Regola Applicata

**I file di traduzione non italiani NON devono contenere testi in italiano.**

Ogni testo deve essere tradotto nella lingua appropriata del file.

