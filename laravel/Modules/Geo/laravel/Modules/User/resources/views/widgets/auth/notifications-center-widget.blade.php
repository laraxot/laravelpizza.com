<?php

declare(strict_types=1);

?>
<div class="cmp-notifications-center">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <p class="mb-0 text-muted">
            {{ __('user::notifications_center.summary.unread.text', ['count' => $unreadCount]) }}
        </p>
        @if ($unreadCount > 0)
            <x-filament::button
                type="button"
                color="gray"
                wire:click="markAllAsRead"
            >
                {{ __('user::notifications_center.actions.mark_all_read.label') }}
            </x-filament::button>
        @endif
    </div>

    <div class="cmp-list">
        <ul class="list-unstyled mb-0">
            @forelse ($notifications as $notification)
                @php
                    $payload = is_array($notification->data) ? $notification->data : [];
                    $title = (string) ($payload['title'] ?? $payload['subject'] ?? class_basename((string) $notification->type));
                    $body = (string) ($payload['body'] ?? $payload['message'] ?? '');
                    $actionUrl = $payload['action_url'] ?? $payload['url'] ?? null;
                    $isUnread = $notification->read_at === null;
                @endphp
                <li
                    class="cmp-list__item border-bottom py-3 {{ $isUnread ? 'bg-light' : '' }}"
                    wire:key="notification-{{ $notification->id }}"
                >
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div class="flex-grow-1">
                            <h3 class="title-small-semi-bold mb-1">{{ $title }}</h3>
                            @if ($body !== '')
                                <p class="text-paragraph-small mb-2">{{ $body }}</p>
                            @endif
                            <p class="text-paragraph-small text-muted mb-0">
                                {{ $notification->created_at?->diffForHumans() }}
                            </p>
                            @if (is_string($actionUrl) && $actionUrl !== '')
                                <a href="{{ $actionUrl }}" class="text-paragraph-small fw-semibold mt-2 d-inline-block">
                                    {{ __('user::notifications_center.actions.open_link.label') }}
                                </a>
                            @endif
                        </div>
                        <div class="d-flex flex-column align-items-end gap-2">
                            @if ($isUnread)
                                <span class="badge bg-primary">
                                    {{ __('user::notifications_center.badge.unread.label') }}
                                </span>
                                <x-filament::button
                                    type="button"
                                    size="sm"
                                    color="gray"
                                    wire:click="markAsRead('{{ $notification->id }}')"
                                >
                                    {{ __('user::notifications_center.actions.mark_read.label') }}
                                </x-filament::button>
                            @endif
                        </div>
                    </div>
                </li>
            @empty
                <li class="py-5 text-center text-muted">
                    <p class="mb-0">{{ __('user::notifications_center.empty.text.label') }}</p>
                </li>
            @endforelse
        </ul>
    </div>
</div>
