@extends('admin.layouts.admin')

@section('title', trans('staff::admin.title'))

@push('footer-scripts')
    <script>
        document.getElementById('staffForm').addEventListener('submit', function () {
            let i = 0;
            document.getElementById('links').querySelectorAll('.form-row').forEach(function (el) {
                el.querySelectorAll('input').forEach(function (input) {
                    input.name = input.name.replace('{index}', i.toString());
                });
                i++;
            });
        });

        function addLinkListener(el) {
            el.addEventListener('click', function () {
                const element = el.parentNode.parentNode.parentNode.parentNode;

                element.parentNode.removeChild(element);
            });
        }

        document.querySelectorAll('.link-remove').forEach(function (el) {
            addLinkListener(el);
        });

        document.getElementById('addLinkButton').addEventListener('click', function () {
            let input = '<div class="form-row"><div class="form-group col-md-4">';
            input += '<input type="text" class="form-control" name="link[{index}][icon]" placeholder="icon"></div>';
            input += '<div class="form-group col-md-3"><div class="input-group">';
            input += '<input type="text" class="form-control" name="link[{index}][name]" placeholder="name"></div></div>';
            input += '<div class="form-group col-md-4"><div class="input-group">';
            input += '<input type="text" class="form-control" name="link[{index}][url]" placeholder="Link">';
            input += '<div class="input-group-append"><button class="btn btn-outline-danger link-remove" type="button">';
            input += '<i class="fas fa-times"></i></button></div></div></div></div></div>';

            const newElement = document.createElement('div');
            newElement.innerHTML = input;

            addLinkListener(newElement.querySelector('.link-remove'));

            document.getElementById('links').appendChild(newElement);
        });

    </script>
@endpush

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <h3>Création d'un staff</h3>
            <form action="{{ route('staff.admin.staff.update',$staff)}}" method="POST" id="staffForm">
                @include('staff::admin.staff._form')
                @method('PUT')

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ trans('messages.actions.save') }}
                </button>

                <a href="{{ route('staff.admin.staff.destroy', $staff) }}" class="btn btn-danger" data-confirm="delete">
                    <i class="fas fa-trash"></i> {{ trans('messages.actions.delete') }}
                </a>
            </form>
        </div>
    </div>
@endsection
