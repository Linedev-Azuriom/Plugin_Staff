@extends('admin.layouts.admin')

@section('title', trans('staff::admin.tag.title'))
@push('footer-scripts')
    <script src="{{ asset('vendor/sortablejs/Sortable.min.js') }}"></script>
    <script>
        const sortable = Sortable.create(document.getElementById('tags'), {
            group: {
                name: 'packages',
                put: function (to, sortable, drag) {
                    if (!drag.classList.contains('tag-parent')) {
                        return true;
                    }

                    return !drag.querySelector('.tag-parent .tag-parent')
                        && drag.parentNode.id === 'tags';
                },
            },
            animation: 150,
            handle: '.sortable-handle',
            onEnd: function (event) {
                axios.post('{{ route('staff.admin.tags.update-order') }}', {
                    'tags': serialize(sortable.el)
                })
                    .then(function (response) {
                        console.log(response)
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
            },
        });

        function serializeTag(tag, preventNested = false) {

            return {
                id: tag.dataset['tagId'],
            };
        }

        function serialize(tags) {
            return [].slice.call(tags.children).map(function (tag) {
                return serializeTag(tag);
            });
        }
    </script>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('staff.admin.tags.store') }}" method="POST">
                        <h3>{{ trans('staff::admin.tag.title') }}</h3>
                        @include('staff::admin.tags._form')
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ trans('messages.actions.save') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h3>{{ trans('staff::admin.tag.title-list') }}</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ trans('messages.fields.name') }}</th>
                                <th scope="col">{{ trans('messages.fields.action') }}</th>
                            </tr>
                            </thead>
                            <tbody class="sortable" id="tags">
                            @forelse($tags ?? [] as $tag)
                                <tr class="sortable-dropdown tag-parent" data-tag-id="{{ $tag->id }}">
                                    <th scope="row">
                                        <div class="col-1">
                                            <i class="fas fa-arrows-alt sortable-handle"></i>
                                        </div>
                                    </th>
                                    <td>
                                        <div class="badge" style="background-color: {{$tag->color}}; color: white">{{$tag->name}}</div>
                                    </td>
                                    <td>
                                        <a href="{{ route('staff.admin.tags.edit', $tag) }}" class="mx-1"
                                           title="{{ trans('messages.actions.edit') }}" data-toggle="tooltip"><i
                                                class="fas fa-edit"></i></a>
                                        <a href="{{ route('staff.admin.tags.destroy', $tag) }}" class="mx-1"
                                           title="{{ trans('messages.actions.delete') }}" data-toggle="tooltip"
                                           data-confirm="delete"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>Vous n'avez pas de tags</td>
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
