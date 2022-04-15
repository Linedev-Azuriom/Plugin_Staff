@php
    $arrayTags = [];
    if($staffs->count() >= 1){
        foreach ($staffs as $staff){
            if($staff->tags->count() >= 1){
                foreach ($staff->tags as $tag){
                    $arrayTags[] = $tag->pluck('id', 'name');
                }
            }
        }
    }
@endphp
<div class="row align-content-stretch gy-4">
    @foreach($arrayTags[0] as $key => $value)
        <div class="col-12">
            <h2 class="content-title py-2 px-3 rounded-3 border">{{$key}}</h2>
        </div>
        @foreach($staffs as $staff)
            @foreach($staff->tags as $tag)
                @if($tag->id == $value)
                    @includeIf('staff::styles.atoms._list')
                @endif
            @endforeach
        @endforeach
    @endforeach

</div>
