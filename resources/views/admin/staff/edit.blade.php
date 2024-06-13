@extends('admin.layouts.admin')

@section('title', trans('staff::admin.staff.title-edit') .': '.$staff->name)

@push('footer-scripts')
    <script src="{{ asset('vendor/sortablejs/Sortable.min.js') }}"></script>
    <script>
        const sortable = Sortable.create(document.getElementById('links'), {
            group: {
                name: 'packages',
                put: function (to, sortable, drag) {
                    if (!drag.classList.contains('staff-parent')) {
                        return true;
                    }

                    return !drag.querySelector('.link-parent .link-parent')
                        && drag.parentNode.id === 'links';
                },
            },
            animation: 150,
            handle: '.sortable-handle',
            onEnd: function (event) {
                axios.post('{{ route('staff.admin.links.update-order') }}', {
                    'links': serialize(sortable.el),
                })
                    .then(function (response) {
                        console.log(serialize(sortable.el))
                        console.log(response)
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
            },
        });

        function serializeLink(link, preventNested = false) {
            return {
                id: link.dataset['linkId'],
            };
        }

        function serialize(links) {
            return [].slice.call(links.children).map(function (link) {
                return serializeLink(link);
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


        document.querySelectorAll('.link-remove').forEach(function (el) {
            addLinkListener(el);
        });

        document.getElementById('addLinkButton').addEventListener('click', function () {
            let input = '<div class="row g-1 sortable-dropdown  align-items-center link-parent"><div class="col-auto"> <i class="bi bi-arrows-move sortable-handle"></i> </div>';
            input += '<div class="col-md-4">';
            input += '<input type="text" class="form-control" name="link[{index}][icon]" placeholder="{{ trans('messages.fields.icon') }}"></div>';
            input += '<div class="col-md-3"><div class="input-group">';
            input += '<input type="text" class="form-control" name="link[{index}][name]" placeholder="{{ trans('messages.fields.name') }}"></div></div>';
            input += '<div class="col-md-4"><div class="input-group">';
            input += '<input type="text" class="form-control" name="link[{index}][url]" placeholder="{{ trans('messages.fields.url') }}">';
            input += '<div class="input-group-append"><button class="btn btn-outline-danger link-remove" type="button">';
            input += '<i class="bi bi-x-lg"></i></button></div></div></div></div>';

            const newElement = document.createElement('div');
            newElement.classList.add('link-parent')
            newElement.classList.add('sortable-dropdown')
            newElement.classList.add('link-parent')
            newElement.innerHTML = input;

            addLinkListener(newElement.querySelector('.link-remove'));

            document.getElementById('links').appendChild(newElement);
        });

        function addLinkListener(el) {
            el.addEventListener('click', function () {
                const element = el.parentNode.parentNode.parentNode.parentNode;
                element.parentNode.removeChild(element);
            });
        }

    </script>
@endpush

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h3 class="mb-0">{{ trans('staff::admin.staff.title-edit') }}</h3>

            <a href="{{ route('staff.admin.staff.destroy', $staff) }}" class="btn btn-danger"
               data-confirm="delete">
                <i class="bi bi-trash-fill"></i> {{ trans('messages.actions.delete') }}
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('staff.admin.staff.update',$staff)}}" method="POST" id="staffForm"
                  enctype="multipart/form-data">
                @method('PUT')

                @include('admin.elements.editor', ['imagesUploadUrl' => route('admin.posts.attachments.store', $staff)])

                @include('staff::admin.staff._form')

                <a href="{{ route('staff.admin.index') }}" class="btn btn-success float-right mr-3">
                    <i class="bi bi-arrow-left"></i> {{ trans('messages.actions.back') }}
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>

            </form>
        </div>
    </div>
@endsection
