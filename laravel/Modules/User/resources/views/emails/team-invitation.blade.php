<?php

declare(strict_types=1);
?>
@component('mail::message')
{{ __('user::team_invitation_email.invitation.heading.title', ['team' => $invitation->team->name]) }}

@if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
{{ __('user::team_invitation_email.register.invitation.text') }}

@component('mail::button', ['url' => route('register')])
{{ __('user::team_invitation_email.register.cta.label') }}
@endcomponent

{{ __('user::team_invitation_email.login.invitation.text') }}

@else
{{ __('user::team_invitation_email.accept.invitation.text') }}
@endif


@component('mail::button', ['url' => $acceptUrl])
{{ __('user::team_invitation_email.accept.cta.label') }}
@endcomponent

{{ __('user::team_invitation_email.ignore.notice.text') }}
@endcomponent
