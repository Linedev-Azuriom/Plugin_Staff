@foreach($tags as $tag)
    @php $groupStaffs = $staffs->filter(fn($s) => $s->tags->contains('id', $tag->id))->values(); @endphp
    @if($groupStaffs->isNotEmpty())
        <div class="mt-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <span class="badge rounded-pill px-3 py-2 fs-6" style="background-color:{{ $tag->color }}">{{ $tag->name }}</span>
                <div class="border-top flex-grow-1 opacity-25"></div>
            </div>

            {{-- position-relative : ancrage pour les flèches Glide en position:absolute --}}
            <div class="glide_staff position-relative">
                <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides align-items-stretch">
                        @foreach($groupStaffs as $staff)
                            @php
                                $imgSrc = isset($staff->image) && $staff->image !== null
                                    ? image_url('../staff/'.$staff->image)
                                    : (game()->name() === 'Minecraft' ? 'https://mc-heads.net/avatar/'.urlencode($staff->name).'/100' : null);
                            @endphp
                            <li class="glide__slide h-auto">
                                <div class="card h-100 text-center border-0 shadow-sm">
                                    @if($imgSrc)
                                        <img src="{{ $imgSrc }}" alt="{{ $staff->name }}"
                                             class="card-img-top object-fit-cover"
                                             style="height:200px">
                                    @else
                                        <div class="bg-secondary-subtle d-flex align-items-center justify-content-center"
                                             style="height:200px">
                                            <i class="bi bi-person-fill fs-1 text-secondary"></i>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <h3 class="card-title h5">{{ $staff->name }}</h3>
                                        @if(isset($settings['description']) && $settings['description'])
                                            <div class="text-body-secondary small mb-2">{!! $staff->description !!}</div>
                                        @endif
                                        @if($staff->tags->isNotEmpty())
                                            <div class="d-flex flex-wrap gap-1 mb-2 justify-content-center">
                                                @foreach($staff->tags as $staffTag)
                                                    <span class="badge rounded-pill" style="background-color:{{ $staffTag->color }}">{{ $staffTag->name }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                        @if($staff->links->isNotEmpty())
                                            <div class="d-flex flex-wrap gap-2 justify-content-center mt-1">
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
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Bullets et arrows en dehors de glide__track, enfants directs du root Glide --}}
                <div class="glide__bullets" data-glide-el="controls[nav]">
                    @foreach($groupStaffs as $i => $staff)
                        <button class="glide__bullet" data-glide-dir="={{ $i }}"></button>
                    @endforeach
                </div>
                <div class="glide__arrows" data-glide-el="controls">
                    <button class="glide__arrow glide__arrow--left border-0 bg-transparent shadow-none p-1" data-glide-dir="<">
                        <i class="bi bi-chevron-left btn btn-primary"></i>
                    </button>
                    <button class="glide__arrow glide__arrow--right border-0 bg-transparent shadow-none p-1" data-glide-dir=">">
                        <i class="bi bi-chevron-right btn btn-primary"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif
@endforeach
