@extends('admin.layouts.admin')

@section('title', trans('staff::admin.title'))

@push('footer-scripts')
    <script src="{{ asset('vendor/sortablejs/Sortable.min.js') }}"></script>
    <script>
        const sortable = Sortable.create(document.getElementById('staffs'), {
            group: {
                name: 'packages',
                put: function (to, sortable, drag) {
                    if (!drag.classList.contains('staff-parent')) {
                        return true;
                    }

                    return !drag.querySelector('.staff-parent .staff-parent')
                        && drag.parentNode.id === 'staffs';
                },
            },
            animation: 150,
            handle: '.sortable-handle',
            onEnd: function (event) {
                axios.post('{{ route('staff.admin.staff.update-order') }}', {
                    'staffs': serialize(sortable.el)
                })
                    .then(function (response) {
                        console.log(response)
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
            },
        });

        function serializeStaff(staff, preventNested = false) {

            return {
                id: staff.dataset['staffId'],
            };
        }

        function serialize(staffs) {
            return [].slice.call(staffs.children).map(function (staff) {
                return serializeStaff(staff);
            });
        }

        document.getElementById('staffForm').addEventListener('submit', function () {
            let i = 0;
            document.getElementById('links').querySelectorAll('.link-parent').forEach(function (el) {
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
            let input = '<div class="row g-0"><div class="col-md-4">';
            input += '<input type="text" class="form-control" name="link[{index}][icon]" placeholder="{{ trans('messages.fields.icon') }}"></div>';
            input += '<div class="col-md-4"><div class="input-group">';
            input += '<input type="text" class="form-control" name="link[{index}][name]" placeholder="{{ trans('messages.fields.name') }}"></div></div>';
            input += '<div class="col-md-4"><div class="input-group">';
            input += '<input type="text" class="form-control" name="link[{index}][url]" placeholder="{{ trans('messages.fields.url') }}">';
            input += '<div class="input-group-append"><button class="btn btn-outline-danger link-remove" type="button">';
            input += '<i class="bi bi-trash-fill"></i></button></div></div></div></div></div>';

            const newElement = document.createElement('div');
            newElement.classList.add('link-parent')
            newElement.classList.add('sortable-dropdown')
            newElement.classList.add('link-parent')
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
                            <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
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
                            <tbody class="sortable" id="staffs">
                            @forelse($staffs ?? [] as $staff)
                                <tr class="sortable-dropdown staff-parent" data-staff-id="{{ $staff->id }}">
                                    <th scope="row">
                                        <div class="col-1">
                                            <i class="bi bi-arrows-move sortable-handle"></i>
                                        </div>
                                    </th>
                                    <td>{{$staff->name}}</td>
                                    <td>
                                        <a href="{{ route('staff.admin.staff.edit', $staff) }}" class="mx-1"
                                           title="{{ trans('messages.actions.edit') }}" data-toggle="tooltip"><i
                                                class="bi bi-pen-fill"></i></a>
                                        <a href="{{ route('staff.admin.staff.destroy', $staff) }}" class="mx-1"
                                           title="{{ trans('messages.actions.delete') }}" data-toggle="tooltip"
                                           data-confirm="delete"><i class="bi bi-trash-fill"></i></a>
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
