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
    <div class="container content mt-5" id="staff">
        @if($staffs->count() >= 1)
            <div class="glide_staff">
                <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides">
                        @foreach($staffs as $staff)
                            <li class="glide__slide">
                                <div class="card shadow-sm h-100">
                                    @if(!empty($staff->description && !$settings->settings()->settings->description))
                                        <div class="description">
                                            <p>{{$staff->description}}</p>
                                        </div>
                                    @endif
                                    <div class="text-center">
                                        <div
                                            class="img-hover-zoom img-hover-zoom--colorize {{ $settings->settings()->settings->effect ?'hover': '' }}">
                                            <img class="shadow"
                                                 src="{{isset($staff->image) && $staff->image != null ? image_url('../staff/'.$staff->image) :  (game()->name() === 'Minecraft' ? 'https://crafthead.net/helm/'.$staff->name.'/100.png' : '') }}"
                                                 alt="{{$staff->name}}">

                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="clearfix mb-3"></div>
                                        <div class="my-2 text-center">
                                            <h1>{{$staff->name}}</h1>
                                        </div>
                                        @if($settings->settings()->settings->description)
                                        <p class="mt-3">{{$staff->description}}</p>
                                        @endif
                                        <div class="mb-1 d-flex flex-wrap justify-content-center">
                                            @if($staff->tags->count() >= 1)
                                                @foreach($staff->tags as $tag)
                                                    <span class="m-1">
                        <span class="badge" style="background-color: {{$tag->color}}">{{$tag->name}}</span>
                        </span>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="box">
                                            <div>
                                                <ul class="list-inline">
                                                    @if($staff->links->count() >= 1)
                                                        @foreach($staff->links as $link)
                                                            <li class="list-inline-item">
                                                                <a href="{{$link->url}}" title="{{$link->name}}" target="_blank">
                                                                    {!! $link->icon !!}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="glide__bullets" data-glide-el="controls[nav]">
                        <button class="glide__bullet" data-glide-dir="=0"></button>
                        <button class="glide__bullet" data-glide-dir="=1"></button>
                        <button class="glide__bullet" data-glide-dir="=2"></button>
                    </div>
                    <div class="glide__arrows" data-glide-el="controls">
                        <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i
                                class="fas fa-chevron-left"></i></button>
                        <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i
                                class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning" role="alert">
                {{ trans('staff::messages.staff-empty') }}
            </div>
        @endif
    </div>
@endsection
