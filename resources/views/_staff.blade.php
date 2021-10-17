<li class="glide__slide">
    <div class="card shadow-sm">
        @if(!empty($staff->description))
            <div class="description">
                <p>{{$staff->description}}</p>
            </div>
        @endif
        <div class="text-center">
            <div class="img-hover-zoom img-hover-zoom--colorize">
                <img class="shadow"
                     src="{{isset($staff->image)?image_url('../staff/'.$staff->image) : 'https://minotar.net/helm/'.$staff->name.'/100.png'}}"
                     alt="Another Image zoom-on-hover effect">
            </div>
        </div>
        <div class="card-body">
            <div class="clearfix mb-3">
            </div>
            <div class="my-2 text-center">
                <h1>{{$staff->name}}</h1>
            </div>
            <div class="mb-3 d-flex justify-content-center">
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
                                    <a href="{{$link->url}}" title="{{$link->name}}">
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
