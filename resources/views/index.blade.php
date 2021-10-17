@extends('layouts.app')

@section('title', 'Staff')

@push('scripts')
    <script defer src="{{ plugin_asset('staff', 'js/glide.min.js') }} "></script>
    <script defer src="{{ plugin_asset('staff', 'js/script.js') }} "></script>
@endpush
@push('styles')
    <link href="{{ plugin_asset('staff', 'css/glide.core.min.css') }} " rel="stylesheet">
    <link href="{{ plugin_asset('staff', 'css/glide.theme.min.css') }} " rel="stylesheet">
    <link href="{{ plugin_asset('staff', 'css/style.css') }} " rel="stylesheet">
@endpush

@section('content')
    <div class="container content" id="staff">
        <div class="glide_staff">
            <div class="glide glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    @each('staff::_staff', $staffs, 'staff')
                </ul>
                <div class="glide__bullets" data-glide-el="controls[nav]">
                    <button class="glide__bullet" data-glide-dir="=0"></button>
                    <button class="glide__bullet" data-glide-dir="=1"></button>
                    <button class="glide__bullet" data-glide-dir="=2"></button>
                </div>
                <div class="glide__arrows" data-glide-el="controls">
                    <button class="glide__arrow glide__arrow--left" data-glide-dir="<">prev</button>
                    <button class="glide__arrow glide__arrow--right" data-glide-dir=">">next</button>
                </div>
            </div>
        </div>
    </div>
@endsection
