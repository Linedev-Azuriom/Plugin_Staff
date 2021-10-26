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
    <div class="row">
        <div class="col-12 my-3">
            @include('staff::admin.settings.index')
        </div>
        <div class="col-xl-6 my-3">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h3>{{ trans('staff::admin.staff.title') }}</h3>
                    <form action="{{ route('staff.admin.staff.store') }}" method="POST" id="staffForm"  enctype="multipart/form-data">
                        <input type="hidden" name="pending_id" value="{{ $pendingId }}">

                        @include('admin.elements.editor', ['imagesUploadUrl' => route('admin.posts.attachments.pending', $pendingId)])

                        @include('staff::admin.staff._form')

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ trans('messages.actions.save') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-6 my-3">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h3>{{ trans('staff::admin.staff.title-list') }}</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ trans('messages.fields.name') }}</th>
                                <th scope="col">{{ trans('messages.fields.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($staffs ?? [] as $staff)
                                <tr>
                                    <th scope="row">{{$staff->id}}</th>
                                    <td>{{$staff->name}}</td>
                                    <td>
                                        <a href="{{ route('staff.admin.staff.edit', $staff) }}" class="mx-1"
                                           title="{{ trans('messages.actions.edit') }}" data-toggle="tooltip"><i
                                                class="fas fa-edit"></i></a>
                                        <a href="{{ route('staff.admin.staff.destroy', $staff) }}" class="mx-1"
                                           title="{{ trans('messages.actions.delete') }}" data-toggle="tooltip"
                                           data-confirm="delete"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>Vous n'avez crée personne</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
