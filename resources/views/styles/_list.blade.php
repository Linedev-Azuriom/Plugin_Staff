<div class="row gy-3 justify-content-{{ $alignment }}">
    @foreach($staffs as $staff)
        @includeIf('staff::styles.atoms._list')
    @endforeach
</div>
