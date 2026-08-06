@php
    $imgSrc = isset($staff->image) && $staff->image !== null
        ? image_url('../staff/'.$staff->image)
        : (game()->name() === 'Minecraft' ? 'https://mc-heads.net/avatar/'.urlencode($staff->name).'/100' : null);
    $imgHeight = $settings['avatar_size'] ?? 180;
@endphp
<div class="col-12 col-md-6 col-lg-{{ $column }}">
    <div class="card h-100 border-0 shadow-sm">
        @if($imgSrc)
            <img src="{{ $imgSrc }}" alt="{{ $staff->name }}"
                 class="card-img-top object-fit-cover"
                 style="height:{{ $imgHeight }}px">
        @else
            <div class="bg-secondary-subtle d-flex align-items-center justify-content-center"
                 style="height:{{ $imgHeight }}px">
                <i class="bi bi-person-fill fs-1 text-secondary"></i>
            </div>
        @endif
        <div class="card-body text-{{ $alignment }}">
            <{{ $title }} class="card-title h6 mb-1">{{ $staff->name }}</{{ $title }}>
            @if($settings['description'] ?? false)
                <div class="text-body-secondary small mb-2">{!! $staff->description !!}</div>
            @endif
            @if($staff->tags->isNotEmpty())
                <div class="d-flex flex-wrap gap-1 mb-2 justify-content-{{ $alignment }}">
                    @foreach($staff->tags as $tag)
                        <span class="badge rounded-pill" style="background-color:{{ $tag->color }}">{{ $tag->name }}</span>
                    @endforeach
                </div>
            @endif
            @if($staff->links->isNotEmpty())
                <div class="d-flex flex-wrap gap-2 justify-content-{{ $alignment }}">
                    @foreach($staff->links as $link)
                        <a href="{{ $link->url }}" title="{{ $link->name }}" target="_blank" rel="noopener"
                           class="link-secondary">
                            @if(\Illuminate\Support\Str::contains($link->icon, '<i'))
                                {!! $link->icon !!}
                            @else
                                <i class="{{ $link->icon }}"></i>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
