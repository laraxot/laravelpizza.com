<?php

declare(strict_types=1);
?>
@extends('adm_theme::layouts.app')
@section('content')
    @livewire(\Modules\Job\Filament\Widgets\ScheduleCrudWidget::class)
@endsection
