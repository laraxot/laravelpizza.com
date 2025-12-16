<?php

declare(strict_types=1);

?>
@extends('notify::mail-layouts.base.default')

@section('content')
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="text-align: center; padding-bottom: 30px;">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 16.17L4.83 12L3.41 13.41L9 19L21 7L19.59 5.59L9 16.17Z" fill="#48BB78"/>
                </svg>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                <h1 style="color: #2D3748; font-size: 24px; margin: 0 0 20px 0;">
                    {{ __('notify::mail.order.confirmation_title') }}
                </h1>
                <p style="color: #4A5568; font-size: 16px; margin: 0 0 30px 0;">
                    {{ __('notify::mail.order.confirmation_message', ['order_id' => $order->id]) }}
                </p>
            </td>
        </tr>
    </table>

    <!-- Order Details -->
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px; background-color: #F7FAFC; border-radius: 8px;">
        <tr>
            <td style="padding: 20px;">
                <h2 style="color: #2D3748; font-size: 18px; margin: 0 0 15px 0;">
                    {{ __('notify::mail.order.details') }}
                </h2>

                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="padding: 10px 0; border-bottom: 1px solid #E2E8F0;">
                            <span style="color: #4A5568;">{{ __('notify::mail.order.order_number') }}:</span>
                            <span style="color: #2D3748; font-weight: bold;">{{ $order->id }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; border-bottom: 1px solid #E2E8F0;">
                            <span style="color: #4A5568;">{{ __('notify::mail.order.date') }}:</span>
                            <span style="color: #2D3748;">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; border-bottom: 1px solid #E2E8F0;">
                            <span style="color: #4A5568;">{{ __('notify::mail.order.total') }}:</span>
                            <span style="color: #2D3748; font-weight: bold;">{{ number_format($order->total, 2) }} €</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Order Items -->
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px;">
        <tr>
            <td>
                <h2 style="color: #2D3748; font-size: 18px; margin: 0 0 15px 0;">
                    {{ __('notify::mail.order.items') }}
                </h2>
            </td>
        </tr>
        @foreach($order->items as $item)
            <tr>
                <td style="padding: 15px; background-color: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 8px; margin-bottom: 10px;">
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="80" style="padding-right: 15px;">
                                @if($item->product->image)
                                    <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" width="80" style="max-width: 80px; height: auto; border-radius: 4px;">
                                @endif
                            </td>
                            <td>
                                <h3 style="color: #2D3748; font-size: 16px; margin: 0 0 5px 0;">
                                    {{ $item->product->name }}
                                </h3>
                                <p style="color: #4A5568; font-size: 14px; margin: 0;">
                                    {{ __('notify::mail.order.quantity') }}: {{ $item->quantity }}
                                </p>
                            </td>
                            <td align="right" style="color: #2D3748; font-weight: bold;">
                                {{ number_format($item->price * $item->quantity, 2) }} €
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        @endforeach
    </table>

    <!-- Shipping Address -->
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px;">
        <tr>
            <td>
                <h2 style="color: #2D3748; font-size: 18px; margin: 0 0 15px 0;">
                    {{ __('notify::mail.order.shipping_address') }}
                </h2>
                <div style="background-color: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 8px; padding: 20px;">
                    <p style="color: #4A5568; margin: 0 0 5px 0;">
                        {{ $order->shipping_address->name }}<br>
                        {{ $order->shipping_address->street }}<br>
                        {{ $order->shipping_address->city }}, {{ $order->shipping_address->postal_code }}<br>
                        {{ $order->shipping_address->country }}
                    </p>
                </div>
            </td>
        </tr>
    </table>

    <!-- Tracking -->
    @if($order->tracking_number)
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px;">
            <tr>
                <td style="text-align: center;">
                    <a href="{{ $order->tracking_url }}" class="button" style="background-color: #4299E1; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold; display: inline-block;">
                        {{ __('notify::mail.order.track_order') }}
                    </a>
                </td>
            </tr>
        </table>
    @endif

    <!-- Support -->
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="text-align: center; padding-top: 30px; border-top: 1px solid #E2E8F0;">
                <p style="color: #718096; font-size: 14px; margin: 0 0 10px 0;">
                    {{ __('notify::mail.order.questions') }}
                </p>
                <a href="{{ config('notify.support_url') }}" style="color: #4299E1; text-decoration: none;">
                    {{ __('notify::mail.order.contact_support') }}
                </a>
            </td>
        </tr>
    </table>
@endsection
