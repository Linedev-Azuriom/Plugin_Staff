<div class="col-md-{{$column}} list-inline">
    <div class="card flex-md-nowrap flex-row position-relative rounded-3 overflow-hidden h-100">
        @if(!empty($staff->description && !$settings->settings()->settings->description))
            <div class="description bg-white position-absolute top-0 left-0 p-3 rounded-2">
                <p>{!! $staff->description !!}</p>
            </div>
        @endif
        <div class="w-25 d-flex align-items-center justify-content-center mx-3 position-relative ">
            <div
                class="w-100 img-hover-zoom img-hover-zoom--colorize {{ $settings->settings()->settings->effect ?'hover': '' }}">
                <img class="w-100 h-100"
                     src="{{isset($staff->image) && $staff->image != null ? image_url('../staff/'.$staff->image) :  (game()->name() === 'Minecraft' ? 'https://mc-heads.net/avatar/'.$staff->name.'/100' : '') }}"
                     alt="{{$staff->name}}">
            </div>
        </div>
        <div class="w-75">
            <div class="card-body">
                <{{$title}} class="text-{{$alignment}} bg-transparent">{{$staff->name}}</{{$title}}>
                @if($settings->settings()->settings->description)
                    <p>{!! $staff->description !!}</p>
                @endif
                <div class="mb-1 d-flex flex-wrap justify-content-{{$alignment}}">
                    @if($staff->tags->count() >= 1)
                        @foreach($staff->tags as $tag)
                            <span class="m-1"><span class="badge"
                                                    style="background-color: {{$tag->color}}">{{$tag->name}}</span></span>
                        @endforeach
                    @endif
                </div>
                <ul class="list-inline d-flex align-items-center justify-content-{{$alignment}}">
                    @if($staff->links->count() >= 1)
                        @foreach($staff->links as $link)
                            <li class="list-inline-item">
                                <a href="{{$link->url}}" title="{{$link->name}}"
                                   target="_blank">
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
    </div>
</div>
