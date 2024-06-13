@php
    $arrayTags = [];
    if($staffs->count() >= 1){
        foreach ($staffs as $staff){
            if($staff->tags->count() >= 1){
                foreach ($staff->tags as $tag){
                    $arrayTags[] = $tag->pluck('id', 'name', 'position');
                }
            }
        }
    }
@endphp

@foreach($arrayTags[0] as $key => $value)
    <div class="glide_staff mt-4 position-relative">
        <div class="col-12">
            <h2 class="content-title py-2 px-3 rounded-3 border">{{$key}}</h2>
        </div>
        <div class="glide__track" data-glide-el="track">
            <ul class="glide__slides align-items-stretch">
                @foreach($staffs as $staff)
                    @foreach($staff->tags as $tag)
                        @if($tag->id == $value)
                            <li class="glide__slide h-auto">
                                <div class="card h-100">
                                    @if(!empty($staff->description && !$settings->settings()->settings->description))
                                        <div class="description bg-white position-absolute top-0 left-0 p-3 rounded-2">
                                            <p>{!! $staff->description !!}</p>
                                        </div>
                                    @endif
                                    <div class="text-center">
                                        <div
                                            class="img-hover-zoom img-hover-zoom--colorize w-100 {{ $settings->settings()->settings->effect ?'hover': '' }}">
                                            <img class="shadow" style="height: 210px"
                                                 src="{{isset($staff->image) && $staff->image != null ? image_url('../staff/'.$staff->image) :  (game()->name() === 'Minecraft' ? 'https://mc-heads.net/avatar/'.$staff->name.'/100' : '') }}"
                                                 alt="{{$staff->name}}">
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="clearfix mb-3"></div>
                                        <div class="my-2 text-center">
                                            <h2>{{$staff->name}}</h2>
                                        </div>
                                        @if($settings->settings()->settings->description)
                                            <div class="mt-3">
                                                {!! $staff->description !!}
                                            </div>
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
                                        <ul class="list-inline d-flex align-items-center justify-content-center">
                                            @if($staff->links->count() >= 1)
                                                @foreach($staff->links as $link)
                                                    <li class="list-inline-item">
                                                        <a href="{{$link->url}}" title="{{$link->name}}" target="_blank">
                                                            @if(\Illuminate\Support\Str::contains($link->icon,'<i'))
                                                                {!! $link->icon !!}
                                                            @else
                                                                <i class="{{$link->icon}}"></i>
                                                            @endif
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                @endforeach
            </ul>
            <div class="glide__bullets bottom-0" data-glide-el="controls[nav]">
                @foreach($staffs as $staff)
                    @foreach($staff->tags as $tag)
                        @if($tag->id == $value)
                            <button class="glide__bullet" data-glide-dir="={{$loop->index}}"></button>
                        @endif
                    @endforeach
                @endforeach
            </div>
            <div class="glide__arrows w-100" data-glide-el="controls">
                <button class="glide__arrow glide__arrow--left border-0 p-0" data-glide-dir="<"><i
                        class="bi bi-chevron-left btn btn-outline-primary"></i></button>
                <button class="glide__arrow glide__arrow--right border-0 p-0" data-glide-dir=">"><i
                        class="bi bi-chevron-right btn btn-outline-primary"></i></button>
            </div>
        </div>
    </div>
@endforeach
