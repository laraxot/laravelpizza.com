<?php

declare(strict_types=1);

return [
    'inbound_token' => env('MAIL_INBOUND_TOKEN'),
    // Records the mail provider asks for; read as config('notify.notify.mail_dns'), checked by `php artisan notify:check-dns` (CheckMailDnsAction).
    'mail_dns' => [
        'domain' => env('MAIL_DNS_DOMAIN', 'fixcity.eu'),
        'cnames' => [
            'mt78' => 'smtp.mailtrap.live',
            'rwmt1._domainkey' => 'rwmt1.dkim.smtp.mailtrap.live',
            'rwmt2._domainkey' => 'rwmt2.dkim.smtp.mailtrap.live',
            'mt-link' => 't.mailtrap.live',
        ],
    ],
    'company' => [
        'name' => 'Default Company',
        'team' => 'Default Team',
        'webhook_base' => 'https://api.example.com',
        'clinic_name' => 'Default Clinic',
        'repository_url' => 'https://github.com/example/repo'],
    'test_data' => [
        'default_subject' => 'Benvenuto su {{company_name}}',
        'default_content' => 'Grazie per esserti registrato al nostro servizio.',
        'default_welcome_content' => 'Ciao {{user_name}}, benvenuto su {{company_name}}!',
        'default_clinic_name' => '{{clinic_name}}',
        'default_team_name' => '{{team_name}}',
        'default_theme_name' => '{{company_name}} Professional',
        'default_theme_description' => 'Tema professionale per {{company_name}}',
        'default_author' => '{{team_name}}',
        'default_repository' => '{{repository_url}}'],
    'webhooks' => [
        'notification_delivered' => '{{webhook_base}}/webhooks/notification-delivered',
        'notification_bounced' => '{{webhook_base}}/webhooks/notification-bounced',
        'notification_clicked' => '{{webhook_base}}/webhooks/notification-clicked'],
    'email' => [
        'default_from_address' => 'noreply@fixcity.eu',
        'default_from_name' => '{{company_name}}',
        'default_admin_email' => 'admin@{{company_name}}.com',
        'default_developer_email' => 'developer@{{company_name}}.com'],
    'paths' => [
        'default_avatar_path' => '/images/avatars/default.svg',
        'default_image_path' => '/images/default.jpg'],
    'template_variables' => [
        'company_name' => '{{company_name}}',
        'team_name' => '{{team_name}}',
        'clinic_name' => '{{clinic_name}}',
        'webhook_base' => '{{webhook_base}}',
        'repository_url' => '{{repository_url}}',
        'user_name' => '{{user_name}}',
        'appointment_date' => '{{appointment_date}}',
        'appointment_time' => '{{appointment_time}}']];
