<?php

declare(strict_types=1);


namespace Modules\Notify\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\MailTemplates\Models\MailTemplate;

class MailTemplatesSeeder extends Seeder
{
    public function run(): void
    {
        // Template Welcome
        MailTemplate::create([
            'mailable' => 'Modules\Notify\Mail\WelcomeMail',
            'subject' => 'Welcome to {{ app_name }}',
            'html_template' => '
                <h1 style="color: #2D3748; font-size: 24px; margin: 0 0 20px 0;">Welcome to {{ app_name }}!</h1>
                <p style="color: #4A5568; font-size: 16px; margin: 0 0 20px 0;">Hello {{ name }},</p>
                <p style="color: #4A5568; font-size: 16px; margin: 0 0 20px 0;">Thank you for joining us. We\'re excited to have you on board!</p>
                {{#if action_url}}
                <div style="text-align: center; margin: 30px 0;">
                    <a href="{{ action_url }}" style="background-color: #4299E1; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold; display: inline-block;">Get Started</a>
                </div>
                {{/if}}
                <p style="color: #718096; font-size: 14px; margin: 0;">If you have any questions, feel free to contact our support team.</p>
            ',
            'text_template' => 'Welcome to {{ app_name }}! Hello {{ name }}, Thank you for joining us. We\'re excited to have you on board!',
        ]);

        // Template Order Confirmation
        MailTemplate::create([
            'mailable' => 'Modules\Notify\Mail\OrderConfirmationMail',
            'subject' => 'Order #{{ order_id }} Confirmed',
            'html_template' => '
                <h1 style="color: #2D3748; font-size: 24px; margin: 0 0 20px 0;">Order Confirmed!</h1>
                <p style="color: #4A5568; font-size: 16px; margin: 0 0 30px 0;">Thank you for your order #{{ order_id }}. We\'re preparing it for shipment.</p>

                <div style="background-color: #F7FAFC; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
                    <h2 style="color: #2D3748; font-size: 18px; margin: 0 0 15px 0;">Order Details</h2>
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="padding: 10px 0; border-bottom: 1px solid #E2E8F0;">
                                <span style="color: #4A5568;">Order Number:</span>
                                <span style="color: #2D3748; font-weight: bold;">{{ order_id }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0; border-bottom: 1px solid #E2E8F0;">
                                <span style="color: #4A5568;">Order Date:</span>
                                <span style="color: #2D3748;">{{ order_date }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0;">
                                <span style="color: #4A5568;">Total Amount:</span>
                                <span style="color: #2D3748; font-weight: bold;">{{ total_amount }}</span>
                            </td>
                        </tr>
                    </table>
                </div>

                {{#if tracking_url}}
                <div style="text-align: center; margin: 30px 0;">
                    <a href="{{ tracking_url }}" style="background-color: #4299E1; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold; display: inline-block;">Track Your Order</a>
                </div>
                {{/if}}

                <p style="color: #718096; font-size: 14px; margin: 0;">Have questions about your order? <a href="{{ support_url }}" style="color: #4299E1; text-decoration: none;">Contact Support</a></p>
            ',
            'text_template' => 'Order #{{ order_id }} Confirmed. Thank you for your order. We\'re preparing it for shipment. Total: {{ total_amount }}',
        ]);
    }
}
