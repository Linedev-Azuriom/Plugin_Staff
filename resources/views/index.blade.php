@extends('layouts.app')

@section('title', 'Staff')

@if($settings->settings()->settings->style ?? 1 == 1)
    @push('scripts')
        <script defer data-cfasync="false" src="{{ plugin_asset('staff', 'js/glide.min.js') }} "></script>
        <script defer data-cfasync="false" src="{{ plugin_asset('staff', 'js/script.js') }} "></script>
    @endpush
@endif
@push('styles')
    @if($settings->settings()->settings->style ?? 1  == 1)
        <link href="{{ plugin_asset('staff', 'css/glide.core.min.css') }} " rel="stylesheet">
        <link href="{{ plugin_asset('staff', 'css/glide.theme.min.css') }} " rel="stylesheet">
    @endif
    <link href="{{ plugin_asset('staff', 'css/style.css') }} " rel="stylesheet">
@endpush

@section('content')
    <div class="row g-0 mt-5" id="staff">
        @if($staffs->count() >= 1)
            @php
                $alignment = '';
                switch ($settings->settings()->settings->alignment ?? 'start'){
                    case 'start':
                        $alignment = 'start';
                        break;
                    case 'center':
                        $alignment = 'center';
                        break;
                    case 'end':
                        $alignment = 'end';
                        break;
                    default:
                    $alignment = 'start';
                }
                    $column = isset($settings->settings()->settings->column) ? intdiv(12,intval($settings->settings()->settings->column)) : intdiv(12,1)
            @endphp

            @switch($settings->settings()->settings->style ?? '1')
                @case('1')
                @include('staff::styles._slider')
                @break
                @case('2')
                @include('staff::styles._list')
                @break
                @case('3')
                @include('staff::styles._rounded')
                @break
                @case('4')
                @include('staff::styles._tags-list')
                @break
                @case('5')
                @include('staff::styles._tags-rounded')
                @break
            @endswitch

        @else
            <div class="alert alert-warning" role="alert">
                {{ trans('staff::messages.staff-empty') }}
            </div>
        @endif
    </div>
@endsection
