<div class="row gy-4 justify-content-{{ $alignment }}">
    @foreach($staffs as $staff)
        @includeIf('staff::styles.atoms._rounded')
    @endforeach
</div>
