<?php

declare(strict_types=1);

?>
@extends('adm_theme::layouts.app')
@section('content')
    <form action="{{ Request::fullUrl() }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="search" class="form-control">
        <button class="btn btn-primary">{{ __('cms::db_inspector.actions.search.label') }}</button>
    </form>

    <table class="table table-bordered">
        <tr>
            <th>{{ __('cms::db_inspector.sections.table_name.label') }}</th>
            <th>{{ __('cms::db_inspector.sections.fields.label') }}</th>
        </tr>
        @foreach ($rows as $row)
            <tr>
                <td>{{ $row['name'] }}
                    <br />{{ __('cms::db_inspector.sections.model_exists.label') }}
                    @if ($model_service->modelExistsByTableName($row['name']))
                        <b style="color:darkgreen">{{ __('cms::db_inspector.sections.yes.label') }}</b>
                    @else
                        <b style="color:darkred">{{ __('cms::db_inspector.messages.no.message') }}</b>
                    @endif

                </td>
                <td>
                    <table class="table table-bordered">
                        <tr>
                            <th>{{ __('cms::db_inspector.sections.field_name.label') }}</th>
                            <th>{{ __('cms::db_inspector.sections.field_type.label') }}</th>
                        </tr>
                        @foreach ($row['fields'] as $field)
                            <tr>
                                <td>{{ $field['name'] }}</td>
                                <td>{{ $field['type'] }}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
