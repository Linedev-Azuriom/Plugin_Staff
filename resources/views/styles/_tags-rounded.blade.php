<div class="row gy-4 justify-content-{{ $alignment }}">
    @foreach($tags as $tag)
        @php $groupStaffs = $staffs->filter(fn($s) => $s->tags->contains('id', $tag->id)); @endphp
        @if($groupStaffs->isNotEmpty())
            <div class="col-12 mt-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge rounded-pill px-3 py-2 fs-6" style="background-color:{{ $tag->color }}">{{ $tag->name }}</span>
                    <div class="border-top flex-grow-1 opacity-25"></div>
                </div>
            </div>
            @foreach($groupStaffs as $staff)
                @includeIf('staff::styles.atoms._rounded')
            @endforeach
        @endif
    @endforeach
</div>
